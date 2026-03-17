<?php

    namespace App\Domain\Loan;

use InvalidArgumentException;

    final class LoanId{
        public function __construct( private string $value)
        {
            if(trim($value)===''){
                throw new InvalidArgumentException('LoanId cannot be empty');
            }
        }
        public function __toString():string
        {
            return $this->value;
        }
    }