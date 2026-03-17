<?php
    namespace App\Application\Services\BorrowBook;

    final class BorrowBookCommand{
        public function __construct(public readonly string $bookId){

        }
        
    }