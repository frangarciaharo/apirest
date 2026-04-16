<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Subject\Subject;
use App\Domain\Subject\ISubjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineSubjectRepository implements ISubjectRepository{
    public function __construct(
        private EntityManagerInterface $em
    ){
        
    }  

    public function findByCode(string $code): ?Subject
    {
        return $this->em->find(
            Subject::class,
            $code
        );
    }
    public function findAll(): array{
        $repository = $this->em->getRepository(Subject::class);
        $subjects = $repository->findAll();
        $data = array_map(fn($subject) => $subject->toArray(), $subjects);
        return $data;
    } 
    public function save(Subject $subject): void
    {
        $this->em->persist($subject);
        $this->em->flush();
    }
    public function update(string $code, Subject $subject): void{
        $this->em->persist($subject);
        $this->em->flush();
    }
    public function delete(string $code): void{
        $subject = $this->findByCode($code);
        if ($subject) {
            $this->em->remove($subject);
        }
        $this->em->flush();
    }
}
