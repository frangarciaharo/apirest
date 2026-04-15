<?php

namespace App\Domain\Teacher;

use App\Domain\Teacher\Teacher;

interface ITeacherRepository{
    public function save(Teacher $teacher):void;
    public function findByCode(string $code):?Teacher;
    public function findAll():array;
    public function delete(string $code):void;
}