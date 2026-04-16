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
    public function findDni(String $dni): ?User
    {
        $repository = $this->em->getRepository(User::class);
        return $repository->findOneBy(['dni' => $dni]);
    }
    public function find(int $id): ?User
    {
        return $this->em->find(User::class, $id);
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
    public function update(int $id, User $user): void{
        $this->em->persist($user);
        $this->em->flush();
    }
    public function deleteUser(int $id): void{
        $user = $this->find($id);
        if ($user) {
            $this->em->remove($user);
        }
        $this->em->flush();
    }
}
