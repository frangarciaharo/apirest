<?php

namespace App\Domain\Book;

use App\Domain\Book\Book;
use App\Domain\Book\BookId;


interface IBookRepository{
    public function save(Book $book):void;
    public function find(BookId $id):?Book;
    public function findAll(): array;
    public function update(BookId $id);
    public function delete(Book $book);
}