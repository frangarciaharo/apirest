<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\ResponseJson;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Teacher\Teacher;
use App\Infrastructure\Persistence\Doctrine\DoctrineTeacherRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineSubjectRepository;
use App\Domain\Subject\Subject;

class TeacherController{
    protected Request $request;
    protected DoctrineTeacherRepository $br;
    protected DoctrineUserRepository $userRepository;
    protected DoctrineCourseRepository $courseRepository;
    protected DoctrineSubjectRepository $subjectRepository;
    public function __construct(Request $request, EntityManagerInterface $em){
        $this->request = $request;
        $this->br = new DoctrineTeacherRepository($em);
        $this->userRepository = new DoctrineUserRepository($em);
        $this->courseRepository = new DoctrineCourseRepository($em);
        $this->subjectRepository = new DoctrineSubjectRepository($em);
    }
    function index(){
        $teacherrepo = $this->br;
        $teachers=$teacherrepo->findAll();
        $response= new ResponseJson(200, $teachers);
        $response->send();
    }
    function create() {
        $data = $this->request->getBody();

        if (!isset($data['code_teacher'], $data['user_id'])) {
            return (new ResponseJson(400, ["msg" => "Datos incompletos"]))->send();
        }

        $user = $this->userRepository->find($data['user_id']);
        if (!$user) {
            return (new ResponseJson(404, ["msg" => "Usuario no encontrado"]))->send();
        }

        $existingTeacher = $this->br->findByCode($data['code_teacher']);
        if ($existingTeacher !== null) {
            return (new ResponseJson(409, ["msg" => "Este profesor existe"]))->send();
        }
        $existingCourse = $this->courseRepository->findByCode($data['course_code']);
        if ($existingCourse == null) {
            return (new ResponseJson(409, ["msg" => "Este curso no existe"]))->send();
        }

        try {
            $user->setRole('teacher');
            $user->enroll($existingCourse);
            $this->userRepository->update($data['user_id'], $user);

            $teacher = new Teacher($data['code_teacher'], $user);
            $this->br->save($teacher);

            return (new ResponseJson(200, ["msg" => "Profesor creado correctamente"]))->send();

        } catch (\Exception $e) {
            return (new ResponseJson(500, ["msg" => "Error interno"]))->send();
        }
    }
    public function update($code_teacher)
{
    $data = $this->request->getBody();

    if (!isset($data['code_teacher'], $data['user_id'], $data['course_code'])) {
        return (new ResponseJson(400, ["msg" => "Datos incompletos"]))->send();
    }
    $teacher = $this->br->findByCode($code_teacher);
    if (!$teacher) {
        return (new ResponseJson(404, ["msg" => "Profesor no encontrado"]))->send();
    }
    $user = $this->userRepository->find($data['user_id']);
    if (!$user) {
        return (new ResponseJson(404, ["msg" => "Usuario no encontrado"]))->send();
    }
    $course = $this->courseRepository->findByCode($data['course_code']);
    if ($course == null) {
        return (new ResponseJson(404, ["msg" => "Curso no existe"]))->send();
    }

    try {
        $existingTeacher = $this->br->findByCode($data['code_teacher']);
        if ($existingTeacher !== null && $existingTeacher->code() !== $teacher->code()) {
            return (new ResponseJson(409, ["msg" => "Este código de profesor ya existe"]))->send();
        }
        $user->setRole('teacher');
        $user->enroll($course);

        $this->userRepository->update($data['user_id'], $user);

        return (new ResponseJson(200, ["msg" => "Profesor actualizado correctamente"]))->send();

    } catch (\Exception $e) {
        return (new ResponseJson(500, ["msg" => "Error interno"]))->send();
    }
}
    function show(String $code_teacher){
        $teacherrepo = $this->br;
        $teacher = $teacherrepo->findByCode($code_teacher);
        if($teacher == null){
            return new ResponseJson(404, ["msg" => "Profesor no encontrado"])->send();
        }
        $response= new ResponseJson(200, $teacher->toArray());
        $response->send();
    }
    function delete(String $code_teacher){

        $teacher = $this->br->findByCode($code_teacher);

        if ($teacher == null) {
            return new ResponseJson(404, [
                "msg" => "Profesor no encontrado"
            ])->send();
        }

        $id = $teacher->userid();

        $user = $this->userRepository->find($id);

        try {

            $user->setRole('guest');
            $user->unroll();

            $this->userRepository->update($id, $user);
            $subjects = $this->subjectRepository->findAll();
            foreach ($subjects as $subject) {
                if (
                    isset($subject['teacher']) &&
                    $subject['teacher']['code'] === $code_teacher
                ) {

                    $subjectEntity = $this->subjectRepository
                        ->findByCode($subject['code_subject']);

                    $subjectEntity->unAssignTeacher();

                    $this->subjectRepository->update(
                        $subjectEntity->getCode(),
                        $subjectEntity
                    );
                }
            }
            $this->br->delete($code_teacher);

            return (new ResponseJson(200, [
                "msg" => "Profesor eliminado correctamente"
            ]))->send();
            

        } catch (\Exception $e) {

            return (new ResponseJson(500, [
                "msg" => $e->getMessage()
            ]))->send();
        }
    }
}