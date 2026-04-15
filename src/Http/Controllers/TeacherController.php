<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\ResponseJson;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Teacher\Teacher;
use App\Infrastructure\Persistence\Doctrine\DoctrineTeacherRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

class TeacherController{
    protected Request $request;
    protected DoctrineTeacherRepository $br;
    protected DoctrineUserRepository $userRepository;

    public function __construct(Request $request, EntityManagerInterface $em){
        $this->request = $request;
        $this->br = new DoctrineTeacherRepository($em);
        $this->userRepository = new DoctrineUserRepository($em);
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

        try {
            $user->setRole('teacher');
            $this->userRepository->updateWithId($data['user_id'], $user);

            $teacher = new Teacher($data['code_teacher'], $user);
            $this->br->save($teacher);

            return (new ResponseJson(200, ["msg" => "Profesor creado correctamente"]))->send();

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
        $id = $teacher->userid();
        if ($teacher == null) {
            return new ResponseJson(404, ["msg" => "Profesor no encontrado"])->send();
        }
        $user = $this->userRepository->find($id);
        try {
            $user->setRole('student');
            $this->userRepository->update($id, $user);

            $this->br->delete($code_teacher);
            (new ResponseJson(200, ["msg" => "Profesor eliminado correctamente"]))->send();

        } catch (\Exception $e) {
            return (new ResponseJson(500, ["msg" => "Error interno"]))->send();
        }

    }
}