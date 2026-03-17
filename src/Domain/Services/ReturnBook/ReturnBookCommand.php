<?php
namespace App\Application\Services\ReturnBook;

use App\Domain\Book\BookId;

final class ReturnBookCommand{
    function __construct(public readonly string $bookId )
    {
        
    }
    
   
}