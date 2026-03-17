<?php
 namespace App\Application\Services\BorrowBook;

use RuntimeException;
use App\Domain\Book\BookId;
use App\Domain\Book\IBookRepository;
use App\Domain\Loan\ILoanRepository;
use App\Domain\User\IUserRepository;

    final class BorrowBookHandler{
        public function __construct(
            private IBookRepository $bookRepository,
            private IUserRepository $userRepository,
            private ILoanRepository $loanRepository            
            )
        {

        }
        
        public function handle(BorrowBookCommand $command){
            //buscar book en repositorio
            // marcar que está prestado
            $book=$this->bookRepository->find(
                new BookId($command->bookId)
            );
            
            if($book===null){
                throw new RuntimeException("Book not found");
            }
            $book->borrow();
            $this->bookRepository->save($book);
            
        }

    }