<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Student\Student;
use App\Domain\Student\IStudentRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineStudentRepository implements IStudentRepository{
    public function __construct(
        private EntityManagerInterface $em
    ){
        
    }  

    public function findByCode(string $code): ?Student
    {
        return $this->em->find(Student::class, $code);
    } 
    public function findAll(): array{
        $repository = $this->em->getRepository(Student::class);
        $students = $repository->findAll();
        $data = array_map(fn($student) => $student->toArray(), $students);
        return $data;
    } 
    public function save(Student $student): void
    {
        $this->em->persist($student);
        $this->em->flush();
    }
    public function update(Student $student): void
    {
        $this->em->persist($student);
        $this->em->flush();
    }
    public function delete(string $code): void{
        $student = $this->findByCode($code);
        if ($student) {
            $this->em->remove($student);
            $this->em->flush();
        }
    }
}