<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Book\BookId;
use App\Domain\Book\Book;
use App\Domain\Book\IBookRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineBookRepository implements IBookRepository{
    public function __construct(
        private EntityManagerInterface $em
    ){
        
    }  

    public function find(BookId $id): ?Book
    {
        return $this->em->find(Book::class, $id);
    } 
    public function findAll(): array{
        $repository = $this->em->getRepository(Book::class);
        $books = $repository->findAll();
        $data = array_map(fn($book) => $book->toArray(), $books);
        return $data;
    } 
    public function save(Book $book): void
    {
        $this->em->persist($book);
        $this->em->flush();
    }
    public function update(BookId $id): void{
        $this->em->persist($id);
        $this->em->flush();
    }
    public function delete(Book $book): void{
        $this->em->remove($book);
        $this->em->flush();
    }
}