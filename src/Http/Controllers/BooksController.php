<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Response;

class BooksController{
    function index(){
        $books=[
            ['title'=>'Lo que el bitcoin se llevo'],
            ['title'=>'Yo de ti lo de-java']
        ];
        $response= new Response(200, ['Content-Type:application/json'], $books);
        $response->send();
    }
    function create(Request $request){
        
    }
    function show(String $id){
        echo $id;

    }
    function update(Request $request){

    }
    function delete(String $id){

    }
}