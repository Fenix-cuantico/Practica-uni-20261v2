<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('es_PE');

        for ($i = 0; $i < 5; $i++) {
            $user = \App\Models\User::create([
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('password123'),
                'role' => 'student',
                'status' => true,
            ]);

            $student = \App\Models\Student::create([
                'user_id' => $user->id,
                'student_code' => $faker->numberBetween(20210000, 20259999) . 'A',
                'specialty' => 'Ingeniería de Sistemas',
                'previous_specialty' => null,
                'admission_year' => $faker->year(),
                'ape_pat' => $faker->lastName(),
                'ape_mat' => $faker->lastName(),
                'name' => $faker->firstName(),
                'dni' => $faker->unique()->numerify('########'),
            ]);

            // Attach to all existing schedules for testing purposes
            $schedules = \App\Models\Schedule::all();
            foreach ($schedules as $schedule) {
                \Illuminate\Support\Facades\DB::table('schedule_student')->insert([
                    'schedule_id' => $schedule->id,
                    'student_id' => $student->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
