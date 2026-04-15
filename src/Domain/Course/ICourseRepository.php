<?php

namespace App\Domain\Course;

use App\Domain\Course\Course;
use App\Domain\Course\CourseCode;

interface ICourseRepository{
    public function save(Course $course):void;
    public function findByCode(CourseCode $code):?Course;
    public function findAll():array;
    public function update(CourseCode $code, Course $course): void;
    public function deleteCourse(CourseCode $code): void;
    
}