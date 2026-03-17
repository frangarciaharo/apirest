<?php

namespace App\Domain\Loan;

use App\Domain\Loan\Loan;
use App\Domain\Loan\LoanId;

interface ILoanRepository{
    public function save(Loan $loan):void;
    public function findById(LoanId $id):?Loan;    
}