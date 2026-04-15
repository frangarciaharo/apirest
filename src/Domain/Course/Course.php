<?php


namespace App\Domain\Course;

class Course{
    private CourseCode $codeCourse;
    private string $namecourse, $acronym;
    private int $duration;

    public function __construct(CourseCode $codeCourse, String $namecourse, String $acronym, int $duration){
        $this->setCode($codeCourse);
        $this->setNameCourse($namecourse);
        $this->setAcronym($acronym);    
        $this->setDuration($duration);
    }

    public function setCode(CourseCode $codeCourse){
        $this->codeCourse= $codeCourse;
    }
    public function getCodeCourse(): CourseCode{
        return $this->codeCourse;
    }

    public function setNameCourse(String $namecourse){
        if (empty(trim($namecourse))) {
            throw new \InvalidArgumentException("NameCourse cannot be empty");
        }
        if(strlen($namecourse) < 3){
            throw new \InvalidArgumentException("NameCourse must be at least 3 characters long");
        }
        $this->namecourse=$namecourse;
    }

    public function getNameCourse(){
        return $this->namecourse;
    }
    public function setAcronym(String $acronym){
        if (empty(trim($acronym))) {
            throw new \InvalidArgumentException("Acronym cannot be empty");
        }
        if(strlen($acronym) < 3 || strlen($acronym) > 4){
            throw new \InvalidArgumentException("Acronym must be at least 3 characters long and max 4 characters");
        }
        $this->acronym=$acronym;
    }

     public function getAcronym(){
        return $this->acronym;
    }

    public function setDuration(int $duration){
        if (empty(trim($duration))) {
            throw new \InvalidArgumentException("Duration cannot be empty");
        }
        if(strlen($duration) < 1){
            throw new \InvalidArgumentException("Duration min 1");
        }
        $this->duration=$duration;
    }

    public function getDuration(){
        return $this->duration;
    }

}