<?php

namespace App\Domain\Subject;

use App\Domain\Subject\Subject;
use App\Domain\Subject\SubjectCode;

interface ISubjectRepository{
    public function save(Subject $subject):void;
    public function findByCode(string $code_subject):?Subject;
    public function findAll():array;
    public function update(string $code_subject, Subject $subject): void;
    public function delete(string $code_subject): void;
}