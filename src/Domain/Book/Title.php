<?php

    namespace App\Domain\Book;

    use InvalidArgumentException;

    final class Title{
        private string $value;
        function __construct(string $value)
        {
            $value=trim($value);
            if($value===''){
                throw new InvalidArgumentException("Title can not be empty");
            }
            if(strlen($value)>200){
                throw new InvalidArgumentException("Title too long");
            }
            $this->value=$value;
        }
        function value(){
            return $this->value;
        }
        public function __toString():string
        {
            return $this->value;
        }
        
    }