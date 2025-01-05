<?php

namespace App\Interfaces;

interface BankRepositoryInterface
{
    public function findByField($field, $value);
}
