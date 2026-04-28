<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'ellypesa@gmail.com'],
            [
                'name' => 'Admin ELLYPESA',
                'phone' => '0748631268',
                'password' => Hash::make('ellypes@'),
                'is_admin' => true,
            ]
        );
    }
}