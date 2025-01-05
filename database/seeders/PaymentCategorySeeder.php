<?php

namespace Database\Seeders;

use App\Models\PaymentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentCategory::insert([
            ['title' => 'حمل و نقل'],
            ['title' => 'خرید تجهیزات '],
        ]);
    }
}
