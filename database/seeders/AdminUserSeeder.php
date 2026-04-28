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
            ['email' => 'elly@gmail.com'],
            [
                'name' => 'Admin ELLYPESA',
                'phone' => '0626549262',
                'password' => Hash::make('elly@123'),
                'is_admin' => true,
            ]
        );
    }
}
