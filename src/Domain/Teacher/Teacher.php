<?php

namespace App\Domain\Teacher;
use Doctrine\ORM\Mapping as Orm;
use App\Domain\User\User;

#[Orm\Entity]
#[Orm\Table(name: 'teachers')]
class Teacher{
   #[Orm\Id]
    #[Orm\Column(type: 'string', length: 5)]
    private string $code;

    #[Orm\OneToOne(inversedBy: 'teacher', targetEntity: User::class)]
    #[Orm\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?User $user = null;

    public function __construct(string $code, User $user) {
        $this->code = $code;
        $this->user = $user;
    }
    public function setCode(string $code): void
    {

        if (empty(trim($code))) {
            throw new \InvalidArgumentException("TeacherCode cannot be empty");
        }
        if (strlen($code) < 1) {
            throw new \InvalidArgumentException("TeacherCode min 1");
        }

        $this->code = $code;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function userid(): ?int
    {   
        return $this->user->id();
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'user' => $this->user->toArray(),
        ];
    }
}