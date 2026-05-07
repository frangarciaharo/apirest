<?php

namespace App\Domain\Subject;

use Doctrine\ORM\Mapping as Orm;
use App\Domain\Course\Course;
use App\Domain\Teacher\Teacher;

#[Orm\Entity]
#[Orm\Table(name: 'subjects')]
class Subject
{
    #[Orm\Id, Orm\Column(type: 'string', length: 5)]
    private string $code;

    #[Orm\Column(type: 'string')]
    private string $namesubject;

    #[Orm\Column(type: 'integer')]
    private int $duration;

    #[Orm\ManyToOne(targetEntity: Course::class, inversedBy: 'subjects')]
    #[Orm\JoinColumn(
        name: 'code_course',
        referencedColumnName: 'code_course',
        onDelete: 'CASCADE'
    )]
    private ?Course $course = null;

    #[Orm\ManyToOne(targetEntity: Teacher::class)]
    #[Orm\JoinColumn(
        name: 'code_teacher',
        referencedColumnName: 'code',
        nullable: true
    )]
    private ?Teacher $teacher = null;

    public function __construct(string $code, string $namesubject, int $duration)
    {
        $this->setCode($code);
        $this->setNamesubject($namesubject);
        $this->setDuration($duration);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getNamesubject(): string
    {
        return $this->namesubject;
    }

    public function setNamesubject(string $namesubject): void
    {
        if (empty(trim($namesubject))) {
            throw new \InvalidArgumentException("Subject cannot be empty");
        }

        if (strlen($namesubject) < 4) {
            throw new \InvalidArgumentException("Subject must be at least 4 characters long");
        }

        $this->namesubject = $namesubject;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        if ($duration < 2) {
            throw new \InvalidArgumentException("Duration min 2");
        }

        $this->duration = $duration;
    }

    public function setCourse(?Course $course): void
    {
        $this->course = $course;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function getCourseCode(): ?string
    {
        return $this->course?->getCodeCourse();
    }


    public function assignTeacher(?Teacher $teacher): void
    {
        $this->teacher = $teacher;
    }

    public function unassignTeacher(): void
    {
        $this->teacher = null;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function getTeacherCode(): ?string
    {
        return $this->teacher?->Code();
    }

    public function toArray(): array
    {
        return [
            'code_subject' => $this->code,
            'namesubject' => $this->namesubject,
            'duration' => $this->duration,
            'teacher' => $this->teacher ? $this->teacher->toArray() : null,
            'course' => $this->course ? $this->course->toArray() : null
        ];
    }
}