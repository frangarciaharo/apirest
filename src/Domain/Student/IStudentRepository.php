<?php

namespace App\Domain\Student;
use App\Domain\Student\Student;

interface IStudentRepository{
    public function save(Student $teacher):void;
    public function findByCode(string $code):?Student;
    public function findAll():array;
    public function delete(string $code):void;
}