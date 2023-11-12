<?php

namespace Database\Seeders;

use App\Enums\RegistrationStatusEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = User::factory()
            ->create([
                'name' => "Administrator",
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin'),
                'registration_status' => RegistrationStatusEnum::Approved(),
            ]);

        $user->assignRole('super-admin');
    }
}
