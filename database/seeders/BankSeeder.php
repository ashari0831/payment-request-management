<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bank::insert([
            [
                'sheba_prefix' => '11',
                'api_endpoint' => 'https://test1.ir/api/pay',
                'name' => 'test1'
            ],
            [
                'sheba_prefix' => '12',
                'api_endpoint' => 'https://test2.ir/api/pay',
                'name' => 'test2',
            ],
            [
                'sheba_prefix' => '13',
                'api_endpoint' => 'https://test3.ir/api/pay',
                'name' => 'test3',
            ]
        ]);
    }
}
