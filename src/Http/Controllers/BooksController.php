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
    function create(Request $request){
        dd($request->getBody());
    }
    function show(String $id){
        $bookrepo = $this->br;
        $bookId=new BookId($id);
        $book = $bookrepo->find($bookId, $bookrepo);
        $response= new ResponseJson(200, $book->toArray());
        $response->send();

    }
    function update(Request $request){

    }
    function delete(String $id){

    }
}