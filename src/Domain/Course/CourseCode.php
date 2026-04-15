<?php 

namespace App\Domain\Course;

class CourseCode{
    private String $coursecode;
    function __construct(String $coursecode){
        $this->coursecode=$coursecode;
    }
    function value(){
        return $this->coursecode;
    }
    function __toString(): string{
        return (string)$this->coursecode;
    }
}