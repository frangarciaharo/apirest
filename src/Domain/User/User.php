<?php


    namespace App\Domain\User;
    
    use Doctrine\ORM\Mapping\Column;
    use Doctrine\ORM\Mapping\Entity;
    use Doctrine\ORM\Mapping\Id;
    use App\Domain\Loan\Loan;
    use Doctrine\ORM\Mapping\OneToMany;
    use Doctrine\ORM\Mapping\Table;

    #[Entity]
    #[Table(name:'users')]
    class User{
        
        #[OneToMany(
            mappedBy:'user',
            targetEntity:Loan::class,
            cascade: ['persist'],
            orphanRemoval:true
        )]
        private iterable $loans;
        #[Id]
        #[Column(type:'string',length:36)]
        private string $id;
        #[Column(type:'string')]
        private string $name;
         #[Column(type:'string')]
        private string $email;

        
        public function __construct(
             UserId $id,
             $name,
             $email)
        {
            $this->id=$id->value();
            $this->name=$name;
            $this->email=$email;
            $this->loans=[];
        }

        public function id():UserId{
            return new UserId($this->id);
        }
        public function name():string{
            return $this->name;
        }
        public function email():string{
            return $this->email;
        }
        private function validateEmail($email){
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                return true;
            }
            return false;
            
        }
    }