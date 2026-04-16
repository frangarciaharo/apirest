<?php

namespace App\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserId;

interface IUserRepository{
    public function save(User $user):void;
    public function find(int $id):?User;
    public function findAll():?Array;
    public function update(int $id, User $user): void;
    public function deleteUser(int $id): void;
}