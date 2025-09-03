<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Denis Djodian Ardika',
            'email' => 'admin@dev.id',
            'password' => Hash::make('admin123'),
            'phone' => '628123456789',
            'address' => 'Jakarta, Indonesia',
            'is_admin' => true,
            'is_online' => false,
            'email_verified_at' => now(),
        ]);
    }
}
