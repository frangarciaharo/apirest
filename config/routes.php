<?php

use App\Http\Controllers\BooksController;

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

];