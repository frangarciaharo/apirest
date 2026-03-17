<?php
namespace App\Application\Services\ReturnBook;

use App\Domain\Book\BookId;
use App\Domain\Book\IBookRepository;

final class ReturnBookHandler{
    public function __construct(private IBookRepository $repository)
    {
        
    }
    public function handle(ReturnBookCommand $command){
        $book=$this->repository->find(
            new BookId($command->bookId)
        );
        
    }
}