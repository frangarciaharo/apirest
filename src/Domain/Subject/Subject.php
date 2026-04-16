<?php

namespace App\Domain\Subject;

use Doctrine\ORM\Mapping as Orm;
use App\Domain\Course\Course;


#[Orm\Entity]
#[Orm\Table(name: 'subjects')]
class Subject{
    #[Orm\Id, Orm\Column(type: 'string', length: 5)]
    private string $code;
    #[Orm\Column(type: 'string')]
    private string $namesubject;
    #[Orm\Column(type: 'string', nullable: true)]
    private ?string $teachercode = null;
    #[Orm\Column(type: 'integer')]
    private int $duration;
    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'subjects')]
    #[ORM\JoinColumn(
        name: 'code_course',
        referencedColumnName: 'code_course',
        onDelete: 'CASCADE'
    )]
    private ?Course $course = null;

    public function __construct(string $code, string $namesubject, int $duration)
    {
        $this->setCode($code);
        $this->setNamesubject($namesubject);
        $this->setDuration($duration);
    }

    
    public function getCode()
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    } 

    public function getNamesubject()
    {
        return $this->namesubject;
    }

    public function setNamesubject(String $namesubject): void
    {   
          if (empty(trim($namesubject))) {
            throw new \InvalidArgumentException("Subject cannot be empty");
        }
        if(strlen($namesubject) < 4){
            throw new \InvalidArgumentException("Subject must be at least 4 characters long");
        }
        $this->namesubject = $namesubject;
    }
    public function getDuration()
    {
        return $this->duration;
    }
    public function setDuration(int $duration): void
    {
        if($duration < 2){
            throw new \InvalidArgumentException("Duration min 2 valors: ex 10");
        }
        $this->duration = $duration;
    }
    public function setCourse(?Course $course): void
    {
        $this->course = $course;
    }
    public function getCourseCode(): ?string
    {
        return $this->course ? $this->course->getCodeCourse() : null;
    }

    public function getTeachercode(){
        return $this->teachercode ? $this->teachercode: null;
    }

    public function AssignTeacher(string $teachercode):void{
        $this->teachercode = $teachercode;
    }
    public function UnassignTeacher(): void{
        $this->teachercode = null;
    }

    public function toArray(): array
    {
        return [
            'code_subject' => $this->code,
            'namesubject' => $this->namesubject,
            'duration' => $this->duration,
            'teachercode' => $this->teachercode,
            'course' => $this->course ? $this->course->toArray() : null
        ];
    }
}