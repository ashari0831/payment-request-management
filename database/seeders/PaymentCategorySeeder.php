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
        $categories = collect([
            ['title' => 'حمل و نقل'],
            ['title' => 'خرید تجهیزات'],
        ]);

        $categories->each(function ($category) {
            PaymentCategory::create($category);
        });
    }
}
