<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\ResponseJson;

class BooksController{
    function index(){
        $books=[
            [
                'id'=>'boo-1',
                'title'=>'Lo que el bitcoin se llevo'
            ],
            [
                'id'=>'boo-2',
                'title'=>'Yo de ti lo de-java'
            ]
        ];
        $response= new ResponseJson(200, $books);
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