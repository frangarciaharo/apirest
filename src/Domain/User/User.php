<?php

namespace App\Domain\User;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Course\Course;
use App\Domain\Teacher\Teacher;
use App\Domain\Student\Student;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User {

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $lastname;

    #[ORM\Column(type: 'string')]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', unique: true)]
    private string $dni;

    #[ORM\Column(type: 'string')]
    private string $role;

    #[ORM\Column(type: 'string')]
    private string $birthdate;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'users')]
    #[ORM\JoinColumn(name: 'code_course', referencedColumnName: 'code_course', nullable: true)]
    private ?Course $course = null;

    #[Orm\OneToOne(
        mappedBy: 'user',
        targetEntity: Teacher::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private ?Teacher $teacher = null;
    #[ORM\OneToOne(
        mappedBy: 'user',
        targetEntity: Student::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private ?Student $student = null;

    public function __construct(
        string $name,
        string $lastname,
        string $email,
        string $password,
        string $dni,
        string $role,
        string $birthdate
    ) {
        $this->setName($name);
        $this->setLastname($lastname);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setDni($dni);
        $this->setRole($role);
        $this->setBirthdate($birthdate);
    }

    public function setName(string $name): void {
        if (empty(trim($name)) || strlen($name) < 3) {
            throw new \InvalidArgumentException("Invalid name");
        }
        $this->name = $name;
    }

    public function setLastname(string $lastname): void {
        if (empty(trim($lastname)) || strlen($lastname) < 4) {
            throw new \InvalidArgumentException("Invalid lastname");
        }
        $this->lastname = $lastname;
    }

    public function setEmail(string $email): void {
        $email = trim($email);
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email");
        }
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        if (strlen(trim($password)) < 6) {
            throw new \InvalidArgumentException("Password too short");
        }
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setDni(string $dni): void {
        if (!preg_match('/^[0-9]{8}[A-Za-z]$/', $dni)) {
            throw new \InvalidArgumentException("Invalid DNI");
        }
        $this->dni = $dni;
    }

    public function setRole(string $role): void {
        $validRoles = ['admin', 'teacher', 'student', 'user'];
        if (!in_array($role, $validRoles)) {
            throw new \InvalidArgumentException("Invalid role");
        }
        $this->role = $role;
    }

    public function setBirthdate(string $birthdate): void {
        if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $birthdate)) {
            throw new \InvalidArgumentException("Invalid birthdate");
        }
        $this->birthdate = $birthdate;
    }

    public function id(): ?int {
        return $this->id;
    }

    public function enrollStudent(Course $course): void {
        if ($this->role === 'teacher') {
            throw new \DomainException("Teacher cannot have a course");
        }
        $this->course = $course;
    }

    public function unrollStudent(): void {
        $this->course = null;
    }

    public function course(): ?Course {
        return $this->course;
    }

    public function toArray(): array {
        return [
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'dni' => $this->dni,
            'role' => $this->role,
            'birthdate' => $this->birthdate,
            'course' => $this->course?->getCodeCourse()
        ];
    }
}