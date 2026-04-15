<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\UserController;

return [
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
        [
        'method'=> 'GET',
        'path'=> '/api/users',
        'handler'=>[UserController::class, 'index']
    ],
    [
        'method'=> 'GET',
        'path'=> '/api/users/{dni}',
        'handler'=>[UserController::class, 'show']
    ],
    [
        'method'=> 'POST',
        'path'=> '/api/users',
        'handler'=>[UserController::class, 'create']
    ],
    [
        'method'=> 'PUT',
        'path'=> '/api/users/{dni}',
        'handler'=>[UserController::class, 'update']
    ],
        [
        'method'=> 'DELETE',
        'path'=> '/api/users/{dni}',
        'handler'=>[UserController::class, 'delete']
    ],
    

];