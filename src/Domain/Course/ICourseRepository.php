<?php

namespace App\Domain\Course;
use App\Domain\Course\CourseCode;

interface ICourseRepository
{
    public function save(Course $course): void;

    public function findByCode(string $course_code): ?Course;

    public function findAll(): array;

    public function update(string $course_code, Course $course): void;

    public function deleteCourse(string $course_code): void;
}