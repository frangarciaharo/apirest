<?php

namespace App\Domain\Course;

use App\Domain\User\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Subject\Subject;

#[ORM\Entity]
#[ORM\Table(name: 'courses')]
class Course
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 5)]
    private string $code_course;

    #[ORM\Column(type: 'string')]
    private string $name_course;

    #[ORM\Column(type: 'string')]
    private string $acronym;

    #[ORM\Column(type: 'integer')]
    private int $duration;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: Subject::class)]
    private Collection $subjects;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: User::class)]
    private Collection $users;

    public function __construct(
        string $code_course,
        string $name_course,
        string $acronym,
        int $duration
    ) {
        $this->setCode($code_course);
        $this->setNameCourse($name_course);
        $this->setAcronym($acronym);
        $this->setDuration($duration);
    }

    public function setCode(string $code): void
    {
        $this->code_course = $code;
    }

    public function getCodeCourse(): String
    {
        return $this->code_course;
    }

    public function setNameCourse(string $name): void
    {
        if (strlen(trim($name)) < 3) {
            throw new \InvalidArgumentException("Invalid name");
        }
        $this->name_course = $name;
    }

    public function setAcronym(string $acronym): void
    {
        if (strlen($acronym) < 3 || strlen($acronym) > 4) {
            throw new \InvalidArgumentException("Invalid acronym");
        }
        $this->acronym = $acronym;
    }

    public function setDuration(int $duration): void
    {
        if ($duration < 1) {
            throw new \InvalidArgumentException("Invalid duration");
        }
        $this->duration = $duration;
    }

    public function toArray(): array
    {
        return [
            "codeCourse" => $this->code_course,
            "namecourse" => $this->name_course,
            "acronym" => $this->acronym,
            "duration" => $this->duration
        ];
    }
}