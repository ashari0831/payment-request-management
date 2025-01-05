<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'sheba_prefix',
        'api_endpoint',
    ];
}
