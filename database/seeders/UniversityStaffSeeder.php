<?php

namespace Database\Seeders;

use App\Enums\RegistrationStatusEnum;
use App\Models\UniversityStaff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UniversityStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $created = UniversityStaff::factory(2)
            ->create();

        foreach ($created as $universityStaff) {
            $universityStaff = $universityStaff->user;
            $universityStaff->assignRole('lecturer');
        }

        $user = User::factory()->has(
            UniversityStaff::factory(1),
        )->create([
            'name' => "staff",
            'email' => 'staff@gmail.com',
            'registration_status' => RegistrationStatusEnum::Approved(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('lecturer');
    }
}
