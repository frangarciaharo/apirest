<?php

namespace App\Http\Controllers;
use App\Http\Request;
use App\Http\ResponseJson;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Student\Student;
use App\Infrastructure\Persistence\Doctrine\DoctrineStudentRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;

class StudentController{
    protected Request $request;
    protected DoctrineStudentRepository $br;
    protected DoctrineUserRepository $userRepository;
    protected DoctrineCourseRepository $courseRepository;

    public function __construct(Request $request, EntityManagerInterface $em){
        $this->request = $request;
        $this->br = new DoctrineStudentRepository($em);
        $this->userRepository = new DoctrineUserRepository($em);
        $this->courseRepository = new DoctrineCourseRepository($em);
    }
    function index(){
        $studentrepo = $this->br;
        $students=$studentrepo->findAll();
        $response= new ResponseJson(200, $students);
        $response->send();
    }
    function create() {
        $data = $this->request->getBody();

        if (!isset($data['code_student'], $data['user_id'])) {
            return (new ResponseJson(400, ["msg" => "Datos incompletos"]))->send();
        }

        $user = $this->userRepository->find($data['user_id']);
        if (!$user) {
            return (new ResponseJson(404, ["msg" => "Usuario no encontrado"]))->send();
        }

        $existingStudent = $this->br->findByCode($data['code_student']);
        if ($existingStudent !== null) {
            return (new ResponseJson(409, ["msg" => "Este Alumno existe"]))->send();
        }
        $existingCourse = $this->courseRepository->findByCode($data['course_id']);
        if (!$existingCourse) {
            return (new ResponseJson(404, ["msg" => "Curso no encontrado"]))->send();
        }

        try {
            $user->setRole('student');
            $this->userRepository->update($data['user_id'], $user);

            $student = new Student($data['code_student'], $user);
            $user->enroll($existingCourse);
            $this->br->save($student);

            return (new ResponseJson(200, ["msg" => "Estudiante creado correctamente"]))->send();

        } catch (\Exception $e) {
            return (new ResponseJson(500, ["msg" => "Error interno"]))->send();
        }
    }
    function show(String $code_student){
        $studentrepo = $this->br;
        $student= $studentrepo->findByCode($code_student);
        if($student == null){
            return new ResponseJson(404, ["msg" => "Estudiante no encontrado"])->send();
        }
        $response= new ResponseJson(200, $student->toArray());
        $response->send();
    }
    function update($code_student)
    {
        $data = $this->request->getBody();

        if (!isset($data['user_id'], $data['course_code'])) {
            return (new ResponseJson(400, ["msg" => "Datos incompletos"]))->send();
        }

        $student = $this->br->findByCode($code_student);
        if (!$student) {
            return (new ResponseJson(404, ["msg" => "Student not found"]))->send();
        }

        $user = $this->userRepository->find($data['user_id']);
        if (!$user) {
            return (new ResponseJson(404, ["msg" => "Usuario no encontrado"]))->send();
        }

        $course = $this->courseRepository->findByCode($data['course_code']);
        if (!$course) {
            return (new ResponseJson(404, ["msg" => "Curso no encontrado"]))->send();
        }

        $user->enroll($course);
        $this->userRepository->update($data['user_id'], $user);
        $this->br->update($student);
        return (new ResponseJson(200, ["msg" => "Actualizado"]))->send();
    }
    function delete(String $code_student){
        $student = $this->br->findByCode($code_student);
        if ($student == null) {
            return new ResponseJson(404, ["msg" => "Estudiante no encontrado"])->send();
        }
        $id = $student->userid();
        $user = $this->userRepository->find($id);
        try {
            $user->setRole('guest');
            $user->unroll();
            $this->userRepository->update($id, $user);
    
            $this->br->delete($code_student);
            (new ResponseJson(200, ["msg" => "Estuidante eliminado correctamente"]))->send();

        } catch (\Exception $e) {
            return (new ResponseJson(500, ["msg" => "Error interno"]))->send();
        }

    }
}