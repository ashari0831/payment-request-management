<?php

namespace App\Repositories;

use App\Interfaces\BankRepositoryInterface;
use App\Models\Bank;

class BankRepository implements BankRepositoryInterface
{
    public function findByField($field, $value)
    {
        return Bank::where($field, $value)->firstOrFail();
    }
}
