<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => '123',
            'national_code' => '0123456789',
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $user->assignRole($adminRole);
    }
}
