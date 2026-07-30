<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@arven.com'],
            [
                'full_name'      => 'Admin Arven',
                'email'          => 'admin@arven.com',
                'password'       => Hash::make('admin123'),
                'role'           => 'admin',
                'is_active'      => true,
                'email_verified' => true,
            ]
        );

        $this->command->info('✅ Admin user created: admin@arven.com / admin123');
    }
}
