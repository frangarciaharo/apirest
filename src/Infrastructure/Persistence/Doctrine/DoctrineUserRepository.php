<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\User\User;
use App\Domain\User\IUserRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineUserRepository implements IUserRepository{
    public function __construct(
        private EntityManagerInterface $em
    ){
        
    }  
    
    public function find(String $dni): ?User
    {
        return $this->em->find(User::class, $dni);
    } 
    public function findAll(): array{
        $repository = $this->em->getRepository(User::class);
        $users = $repository->findAll();
        $data = array_map(fn($user) => $user->toArray(), $users);
        return $data;
    } 
    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
    public function update(String $dni, User $user): void{
        $this->em->persist($user);
        $this->em->flush();
    }
    public function deleteUser(String $dni): void{
        $user = $this->find($dni);
        if ($user) {
            $this->em->remove($user);
        }
        $this->em->flush();
    }
}
