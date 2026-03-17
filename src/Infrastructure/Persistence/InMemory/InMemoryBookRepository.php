<?php

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Book\Book;
use App\Domain\Book\BookId;
use App\Domain\Book\IBookRepository;

class InMemoryBookRepository implements IBookRepository{
    private array $books = [];



    function save(Book $book):void{
        $this->books[(string)$book->id()] = $book;
    }
    function find(BookId $id): ?Book{
        return $this->books[(string)$id] ?? null;
    }
    function findAll(): array{
        return array_values($this->books);
    }
}