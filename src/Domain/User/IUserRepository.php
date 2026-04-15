<?php

namespace App\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserId;

interface IUserRepository{
    public function save(User $user):void;
    public function find(String $dni):?User;
    public function findAll():?Array;
    public function update(String $dni, User $user): void;
    public function deleteUser(String $dni): void;
}