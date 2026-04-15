<?php

namespace App\Http\Controllers;

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Http\Request;
use App\Http\ResponseJson;
use Doctrine\ORM\EntityManagerInterface;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

class UserController{
    protected Request $request;
    protected DoctrineUserRepository $br;

    public function __construct(Request $request, EntityManagerInterface $em){
        $this->request = $request;
        $this->br = new DoctrineUserRepository($em);
    }
    function index(){
        $userrepo = $this->br;
        $users=$userrepo->findAll();
        $response= new ResponseJson(200, $users);
        $response->send();
    }
    function show(String $dni) {
        $userrepo = $this->br;

        $data = $this->request->getBody();

        $user = $userrepo->find($dni);

        $response = new ResponseJson(200, $user->toArray());
        $response->send();
    }

    function create()
    {
        $data = $this->request->getBody();
        $existingUser = $this->br->find($data['dni']);

        if ($existingUser !== null) {
            return print("User with DNI " . $data['dni'] . " already exists.");
        }

        $user = new User(
            $data['name'],
            $data['lastname'],
            $data['email'],
            $data['password'],
            $data['dni'],
            $data['role'],
            $data['birthdate'],
            $data['coursecode']
        );

        $this->br->save($user);
    }

    public function update(string $dni): void {
        $data = $this->request->getBody();
        $user = $this->br->find($dni);
        if ($user == null) {
            new ResponseJson(404, ["msg" => "Usuario no encontrado"])->send();
            return;
        }
        $errors = [];

        if (!isset($data['name'])) {
            $errors[] = "Falta el nombre";
        }

        if (!isset($data['lastname'])) {
            $errors[] = "Falta el apellido";
        }

       if (!isset($data['email'])) {
            $errors[] = "Falta el email";
        }
        if (!isset($data['password'])) {
            $errors[] = "Falta la contraseña";
        }
        if (!isset($data['dni'])) {
            $errors[] = "Falta el DNI";
        }
        if (!isset($data['role'])) {
            $errors[] = "Falta el rol";
        }
        if (!isset($data['birthdate'])) {
            $errors[] = "Falta la fecha de nacimiento";
        }
        if (!empty($errors)) {
            (new ResponseJson(400, ["msg" => $errors]))->send();
            return;
        }
        $user->setName($data['name']);
        $user->setLastname($data['lastname']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setDni($data['dni']);
        $user->setRole($data['role']);
        $user->setBirthdate($data['birthdate']);
        $this->br->save($user);
    }
    function delete(String $dni){
        $user = $this->br->find($dni);
        if ($user == null) {
            new ResponseJson(404, ["msg" => "Usuario no encontrado"])->send();
            return;
        }
        $this->br->deleteUser($dni); 
    }
}