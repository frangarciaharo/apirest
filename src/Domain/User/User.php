<?php

namespace App\Domain\User;

use App\Domain\Course\CourseCode;
use Doctrine\ORM\Mapping as Orm;
use Doctrine\ORM\Query\Expr\Func;

#[Orm\Entity]
#[Orm\Table(name: 'users')]
class User{
    #[Orm\Column(type: 'string')]
    private string $name;
    #[Orm\Column(type: 'string')]
    private string $lastname;
    #[Orm\Column(type: 'string')]
    private string $email;
    #[Orm\Column(type: 'string')]
    private string $password;
    #[Orm\Id, Orm\Column(type: 'string', unique: true)]
    private string $dni;
    #[Orm\Column(type: 'string')]
    private string $role;
    #[Orm\Column(type: 'string')]
    private string $birthdate;
    #[Orm\Column(type: 'string', nullable: true)]
    private ?CourseCode $coursecode = null;
    
    public function __construct(string $name, string $lastname, string $email, string $password, string $dni, string $role, string $birthdate)
    {
        $this->setName($name);
        $this->setLastname($lastname);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setDni($dni);
        $this->setRole($role);
        $this->setBirthdate($birthdate);
    }

    public function setName(string $name): void
    {

        if (empty(trim($name))) {
            throw new \InvalidArgumentException("Name cannot be empty");
        }
        if(strlen($name) < 3){
            throw new \InvalidArgumentException("Name must be at least 3 characters long");
        }
        $this->name = $name;
    }

    public function setLastname(string $lastname): void
    {
        if (empty(trim($lastname))) {
            throw new \InvalidArgumentException("Lastname cannot be empty");
        }
        if(strlen($lastname) < 4){
            throw new \InvalidArgumentException("Lastname must be at least 4 characters long");
        }
        $this->lastname = $lastname;
    }

    public function setPassword(string $password): void
    {
        if (empty(trim($password))) {
            throw new \InvalidArgumentException("Password cannot be empty");
        }else{
            if(strlen($password) < 6){
                throw new \InvalidArgumentException("Password must be at least 6 characters long");
            }else{
                $password = password_hash($password, PASSWORD_DEFAULT);
                $this->password = $password;
            }
        }
    }

   public function setEmail(string $email): string
    {
        $email = trim($email);

        if ($email === '') {
            throw new \InvalidArgumentException("Email cannot be empty");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email");
        }

        return $this->email = $email;
    }


    public function setDni(string $dni): void{
        $dni = trim($dni);
        if ($dni === '') {
            throw new \InvalidArgumentException("DNI cannot be empty");
        }
        if (!preg_match('/^[0-9]{8}[A-Za-z]$/', $dni)) {
            throw new \InvalidArgumentException("Invalid DNI format");
        }
        $this->dni = $dni;
    }

    public function setRole(string $role): void{
        $validRoles = ['admin', 'teacher', 'student'];
        $role = trim($role);
        if ($role === '') {
            throw new \InvalidArgumentException("Role Empty");
        }
        if (!in_array($role, $validRoles)) {
            throw new \InvalidArgumentException("Invalid role specified");
        }
        $this->role = $role;
    }

    public function setBirthdate(string $birthdate): void{
        if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $birthdate)) {
            throw new \InvalidArgumentException("Birthdate must be in DD-MM-YYYY format");
        }
        $this->birthdate = $birthdate;
    }

    public function enrollStudent(CourseCode $coursecode):void{
        $this->coursecode = $coursecode;
    }
     public function UnrollStudent(): void{
        $this->coursecode = null;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function lastname(): string
    {
        return $this->lastname;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function dni(): string
    {
        return $this->dni;
    }

    public function role(): string
    {
        return $this->role;
    }

    public function birthdate(): string
    {
        return $this->birthdate;
    }

      public function coursecode(): ?CourseCode
    {
        return $this->coursecode;
    }
    


    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
            'dni' => $this->dni,
            'role' => $this->role,
            'birthdate' => $this->birthdate,
            'coursecode' => $this->coursecode
        ];
    }
}
