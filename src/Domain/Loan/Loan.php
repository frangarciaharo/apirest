<?php
    namespace App\Domain\Loan;

use DomainException;
use DateTimeImmutable;
use App\Domain\Book\Book;
use App\Domain\User\User;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name:'loans')]
final class Loan{

        #[Column(type:'datetime_immutable')]
        private ?DateTimeImmutable $returnedAt=null;
        
        #[Id]
        #[Column(type:'string',length:36)]
        private string $id;

        #[ManyToOne(targetEntity:Book::class)]
        #[JoinColumn(nullable:false)]
        private Book $book;
        
        #[ManyToOne(targetEntity:User::class,inversedBy:'loans')]
        #[JoinColumn(nullable:false)]
        private User $user;
         #[Column(type:'datetime_immutable')]
        private DateTimeImmutable $borrowedAt;

        public function __construct(
            LoanId $id,
            Book $book,
            User $user,
            DateTimeImmutable $borrowedAt
        )
        {
            $this->id=(string)$id;
            $this->book=$book;
            $this->user=$user;
            $this->borrowedAt=$borrowedAt;
        }

        public function return():void{
            if ($this->returnedAt!== null){
                throw new DomainException('Loan already returned');
            }
        }

    }