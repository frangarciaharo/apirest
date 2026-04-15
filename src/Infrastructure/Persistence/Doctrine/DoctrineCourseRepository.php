<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Course\Course;
use App\Domain\Course\CourseCode;
use App\Domain\Course\ICourseRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineCourseRepository implements ICourseRepository{
    public function __construct(
        private EntityManagerInterface $em
    ){
        
    }  

    public function findByCode(string $code): ?Course
    {
        return $this->em->find(
            Course::class,
            $code
        );
    }
    public function findAll(): array{
        $repository = $this->em->getRepository(Course::class);
        $courses = $repository->findAll();
        $data = array_map(fn($course) => $course->toArray(), $courses);
        return $data;
    } 
    public function save(Course $course): void
    {
        $this->em->persist($course);
        $this->em->flush();
    }
    public function update(string $code, Course $course): void{
        $this->em->persist($course);
        $this->em->flush();
    }
    public function deleteCourse(string $code): void{
        $course = $this->findByCode($code);
        if ($course) {
            $this->em->remove($course);
        }
        $this->em->flush();
    }
}
