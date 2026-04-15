<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\ResponseJson;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Course\Course;
use App\Domain\Course\CourseCode;
use App\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;

class CoursesController{
    protected Request $request;
    protected DoctrineCourseRepository $br;

    public function __construct(Request $request, EntityManagerInterface $em){
        $this->request = $request;
        $this->br = new DoctrineCourseRepository($em);
    }
    function index(){
        $courserepo = $this->br;
        $courses=$courserepo->findAll();
        $response= new ResponseJson(200, $courses);
        $response->send();
    }
    function create(){
        $data = $this->request->getBody();
        $existingCourse = $this->br->findByCode($data['code_course']);
        if ($existingCourse !== null) {
            return new ResponseJson(409, ["msg" => "Este curso existe"])->send();;
        }
        $course = new Course($data['code_course'], $data['name_course'], $data['acronym_course'], $data['duration']);
        $this->br->save($course);
        (new ResponseJson(200, ["msg" => "Curso creado correctamente"]))->send();
    }
    function show(String $code_course){
        $courserepo = $this->br;
        $course = $courserepo->findByCode($code_course);
        if($course == null){
            return new ResponseJson(404, ["msg" => "Curso no encontrado"])->send();
        }
        $response= new ResponseJson(200, $course->toArray());
        $response->send();
    }
    public function update(string $code_course): void {
        $data = $this->request->getBody();
        $course = $this->br->findByCode($code_course);
        if ($course == null) {
            new ResponseJson(404, ["msg" => "Curso no encontrado"])->send();
            return;
        }
        $errors = [];

        if (!isset($data['name_course'])) {
            $errors[] = "Falta el nombre";
        }

        if (!isset($data['acronym_course'])) {
            $errors[] = "Falta el acrónimo";
        }

        if (!isset($data['duration'])) {
            $errors[] = "Falta la duración";
        }

        if (!empty($errors)) {
            (new ResponseJson(400, ["msg" => $errors]))->send();
            return;
        }
        $course->setNameCourse($data['name_course']);
        $course->setAcronym($data['acronym_course']);
        $course->setDuration($data['duration']);
        $this->br->save($course);
        (new ResponseJson(200, ["msg" => "Curso actualizado correctamente"]))->send();
    }
    function delete(String $code_course){
        $course = $this->br->findByCode($code_course);
        if ($course == null) {
            return new ResponseJson(404, ["msg" => "Curso no encontrado"])->send();
        }
        $this->br->deleteCourse($code_course);
        (new ResponseJson(200, ["msg" => "Curso eliminado correctamente"]))->send();

    }
}