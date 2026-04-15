<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\ResponseJson;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Book\Book;
use App\Domain\Book\BookId;
use App\Infrastructure\Persistence\Doctrine\DoctrineBookRepository;

class BooksController{
    protected Request $request;
    protected DoctrineBookRepository $br;

    public function __construct(Request $request, EntityManagerInterface $em){
        $this->request = $request;
        $this->br = new DoctrineBookRepository($em);
    }
    function index(){
        $bookrepo = $this->br;
        $books=$bookrepo->findAll();
        $response= new ResponseJson(200, $books);
        $response->send();
    }
    function create(){
        $data = $this->request->getBody();
        $book = new Book(new BookId($data['id']), $data['title'], $data['author'] ?? '' , $data['available'] ?? true);
        $this->br->save($book);
    }
    function show(String $id){
        $bookrepo = $this->br;
        $book = $bookrepo->find(new BookId($id), $bookrepo);
        if ($book == null) {
            new ResponseJson(404, ["msg" => "Libro no encontrado"])->send();
            return;
        }
        $response= new ResponseJson(200, $book->toArray());
        $response->send();
    }
    public function update(string $id): void {
        $data = $this->request->getBody();
        $book = $this->br->find(new BookId($id));
        if ($book == null) {
            new ResponseJson(404, ["msg" => "Libro no encontrado"])->send();
            return;
        }
        $errors = [];

        if (!isset($data['title'])) {
            $errors[] = "Falta el titulo";
        }

        if (!isset($data['author'])) {
            $errors[] = "Falta el autor";
        }

        if (!isset($data['available'])) {
            $errors[] = "Falta el estado";
        }

        if (!empty($errors)) {
            (new ResponseJson(400, ["msg" => $errors]))->send();
            return;
        }
        $book->setTitle($data['title']);
        $book->setAuthor($data['author']);
        $book->SetStatus($data['available']);
        $this->br->save($book);
    }
    function delete(String $id){
        $bookId = new BookId($id);
        $book = $this->br->find($bookId);
        if ($book == null) {
            new ResponseJson(404, ["msg" => "Libro no encontrado"])->send();
            return;
        }
        $this->br->delete($book); 
    }
}