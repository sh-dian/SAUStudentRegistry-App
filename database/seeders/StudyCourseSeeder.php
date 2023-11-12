<?php

namespace Database\Seeders;

use App\Models\StudyCourse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudyCourse::create([
            'name' => "Bachelor of Business",
        ]);
        StudyCourse::create([
            'name' => "Bachelor of Nursing",
        ]);
        StudyCourse::create([
            'name' => "Bachelor of Engineering (Honours)",
        ]);
        StudyCourse::create([
            'name' => "Bachelor of Education (Early Childhood)",
        ]);
        StudyCourse::create([
            'name' => "Master of Data Science",
        ]);

    }
}
