<?php

use App\Domain\Student\Student;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;

return [
    // BOOK
    [
        'method'=> 'GET',
        'path'=> '/api/books',
        'handler'=>[BooksController::class, 'index']
    ],
    [
        'method'=> 'GET',
        'path'=> '/api/books/{id}',
        'handler'=>[BooksController::class, 'show']
    ],
    [
        'method'=> 'POST',
        'path'=> '/api/books',
        'handler'=>[BooksController::class, 'create']
    ],
    [
        'method'=> 'PUT',
        'path'=> '/api/books/{id}',
        'handler'=>[BooksController::class, 'update']
    ],
        [
        'method'=> 'DELETE',
        'path'=> '/api/books/{id}',
        'handler'=>[BooksController::class, 'delete']
    ],
     // USER
    [
        'method'=> 'GET',
        'path'=> '/api/users',
        'handler'=>[UserController::class, 'index']
    ],
    [
        'method'=> 'GET',
        'path'=> '/api/users/{id}',
        'handler'=>[UserController::class, 'show']
    ],
    [
        'method'=> 'POST',
        'path'=> '/api/users',
        'handler'=>[UserController::class, 'create']
    ],
    [
        'method'=> 'PUT',
        'path'=> '/api/users/{id}',
        'handler'=>[UserController::class, 'update']
    ],
    [
        'method'=> 'DELETE',
        'path'=> '/api/users/{id}',
        'handler'=>[UserController::class, 'delete']
    ],
    // COURSE
    [
        'method'=> 'GET',
        'path'=> '/api/courses',
        'handler'=>[CoursesController::class, 'index']
    ],
    [
        'method'=> 'GET',
        'path'=> '/api/courses/{code_course}',
        'handler'=>[CoursesController::class, 'show']
    ],
    [
        'method'=> 'POST',
        'path'=> '/api/courses',
        'handler'=>[CoursesController::class, 'create']
    ],
    [
        'method'=> 'PUT',
        'path'=> '/api/courses/{code_course}',
        'handler'=>[CoursesController::class, 'update']
    ],
        [
        'method'=> 'DELETE',
        'path'=> '/api/courses/{code_course}',
        'handler'=>[CoursesController::class, 'delete']
    ],
    // TEACHER
    [
        'method'=> 'GET',
        'path'=> '/api/teachers',
        'handler'=>[TeacherController::class, 'index']
    ],
    [
        'method'=> 'GET',
        'path'=> '/api/teachers/{code_teacher}',
        'handler'=>[TeacherController::class, 'show']
    ],
    [
        'method'=> 'POST',
        'path'=> '/api/teachers',
        'handler'=>[TeacherController::class, 'create']
    ],
    [
        'method'=> 'DELETE',
        'path'=> '/api/teachers/{code_teacher}',
        'handler'=>[TeacherController::class, 'delete']
    ], // SUBJECT
    [
        'method'=> 'GET',
        'path'=> '/api/subjects',
        'handler'=>[SubjectController::class, 'index']
    ],
    [
        'method'=> 'GET',
        'path'=> '/api/subjects/{code}',
        'handler'=>[SubjectController::class, 'show']
    ],
    [
        'method'=> 'POST',
        'path'=> '/api/subjects',
        'handler'=>[SubjectController::class, 'create']
    ],
    [
        'method'=> 'PUT',
        'path'=> '/api/subjects/{code}',
        'handler'=>[SubjectController::class, 'update']
    ],
        [
        'method'=> 'DELETE',
        'path'=> '/api/subjects/{code}',
        'handler'=>[SubjectController::class, 'delete']
    ],  
    // STUDENT
    [
        'method'=> 'GET',
        'path'=> '/api/students',
        'handler'=>[StudentController::class, 'index']
    ],
    [
        'method'=> 'GET',
        'path'=> '/api/students/{code_student}',
        'handler'=>[StudentController::class, 'show']
    ],
    [
        'method'=> 'POST',
        'path'=> '/api/students',
        'handler'=>[StudentController::class, 'create']
    ],
    [
        'method'=> 'DELETE',
        'path'=> '/api/students/{code_student}',
        'handler'=>[StudentController::class, 'delete']
    ]

];