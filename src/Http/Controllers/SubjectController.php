<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\ResponseJson;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Subject\Subject;
use App\Infrastructure\Persistence\Doctrine\DoctrineSubjectRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineTeacherRepository;
class SubjectController{
    protected Request $request;
    protected DoctrineSubjectRepository $sr;
    protected DoctrineCourseRepository $cr;
    protected DoctrineTeacherRepository $tr;

    public function __construct(Request $request, EntityManagerInterface $em){
        $this->request = $request;
        $this->sr = new DoctrineSubjectRepository($em);
        $this->cr = new DoctrineCourseRepository($em);
        $this->tr = new DoctrineTeacherRepository($em);
    }
    function index(){
        $subjectrepo = $this->sr;
        $subjects=$subjectrepo->findAll();
        $response= new ResponseJson(200, $subjects);
        $response->send();
    }
     function create(){
        $data = $this->request->getBody();
        $existingSubject = $this->sr->findByCode($data['code_subject']);
        if ($existingSubject !== null) {
            return new ResponseJson(409, ["msg" => "Esta materia existe"])->send();;
        }
        $existingCourse = $this->cr->findByCode($data['code_course']);
        if ($existingCourse === null) {
            return new ResponseJson(404, ["msg" => "Curso no encontrado"])->send();
        }
        $existingTeacher = $this->tr->findByCode($data['code_teacher']);
        if ($existingTeacher === null) {
            return new ResponseJson(404, ["msg" => "Profesor no encontrado"])->send();
        }
        $subject = new Subject($data['code_subject'], $data['name_subject'], $data['duration']);
        $subject->setCourse($existingCourse);
        $subject->assignTeacher($existingTeacher);
        $this->sr->save($subject);
        (new ResponseJson(200, ["msg" => "Materia creada correctamente"]))->send();
    }
    function show(String $code){
        $subjectrepo = $this->sr;
        $subject = $subjectrepo->findByCode($code);
        if ($subject == null) {
            new ResponseJson(404, ["msg" => "Subject not found"])->send();
            return;
        }
        $response= new ResponseJson(200, $subject->toArray());
        $response->send();
    }
    public function update(string $code): void {
        $data = $this->request->getBody();
        $subject = $this->sr->findByCode($code);
        if ($subject == null) {
            new ResponseJson(404, ["msg" => "Subject not found"])->send();
            return;
        }
        $errors = [];

        if (!isset($data['code_subject'])) {
            $errors[] = "Falta el codigo de la materia";
        }

        if (!isset($data['name_subject'])) {
            $errors[] = "Falta el nombre de la materia";
        }

        if (!isset($data['duration'])) {
            $errors[] = "Falta la duración";
        }

        if (!empty($errors)) {
            (new ResponseJson(400, ["msg" => $errors]))->send();
            return;
        }
        $subject->setCode($data['code_subject']);
        $subject->setNamesubject($data['name_subject']);
        $subject->setDuration($data['duration']);
        $this->sr->save($subject);
        (new ResponseJson(200, ["msg" => "Materia actualizada correctamente"]))->send();
    }
    function delete(String $code){
        $subject = $this->sr->findByCode($code);
        if ($subject == null) {
            new ResponseJson(404, ["msg" => "Subject not found"])->send();
            return;
        }
        $this->sr->delete($code); 
        (new ResponseJson(200, ["msg" => "Materia eliminada correctamente"]))->send();
    }
}