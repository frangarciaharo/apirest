<?php

namespace App\Http\Controllers;

use App\Domain\User\User;
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
    function show(String $id){
        $userrepo = $this->br;
        $user = $userrepo->find($id);
        (new ResponseJson(200,$user->toArray()))->send();
    }

    function create()
    {
        $data = $this->request->getBody();
        $existingUser = $this->br->findDni($data['dni']);

        if ($existingUser !== null) {
            return new ResponseJson(404, ["msg" => "Este usuario existe"])->send();;
        }

        $user = new User(
            $data['name'],
            $data['lastname'],
            $data['email'],
            $data['password'],
            $data['dni'],
            $data['role'],
            $data['birthdate']
        );

        $this->br->save($user);
        (new ResponseJson(200, ["msg" => "Usuario creado correctamente"]))->send();
    }

    public function update(int $id): void {
        $data = $this->request->getBody();
        $user = $this->br->find($id);

        if ($user === null) {
            (new ResponseJson(404, ["msg" => "Usuario no encontrado"]))->send();
            return;
        }
        try {
                if (isset($data['name'])) {
                    $user->setName($data['name']);
                }

                if (isset($data['lastname'])) {
                    $user->setLastname($data['lastname']);
                }

                if (isset($data['email'])) {
                    $user->setEmail($data['email']);
                }

                if (isset($data['password'])) {
                    $user->setPassword($data['password']);
                }

                if (isset($data['role'])) {
                    $user->setRole($data['role']);
                }

                if (isset($data['birthdate'])) {
                    $user->setBirthdate($data['birthdate']);
                }
                $this->br->save($user);

                (new ResponseJson(200, ["msg" => "Usuario actualizado correctamente"]))->send();

            } catch (\InvalidArgumentException $e) {
                (new ResponseJson(400, ["msg" => $e->getMessage()]))->send();
            }
    }
    function delete(int $id){
        $user = $this->br->find($id);
        if ($user == null) {
            new ResponseJson(404, ["msg" => "Usuario no encontrado"])->send();
            return;
        }
        $this->br->deleteUser($id); 
        (new ResponseJson(200, ["msg" => "Usuario eliminado correctamente"]))->send();
    }
}