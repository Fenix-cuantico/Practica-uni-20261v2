<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = \App\Models\Teacher::find(1);

        if ($teacher) {
            $teacher->update([
                'university_code' => '10115533',
                'academic_department' => 'Sistemas y Telemática',
                'dedication' => 'Tiempo Parcial',
                'condition' => 'Nombrado',
                'dni' => '12345678',
                'phone' => '987654321',
                'gender' => 'Masculino',
                'birthdate' => '1980-05-15',
                'ruc' => '10123456789',
                'military_lib' => 'A1-987654',
                'license_category' => 'A-IIB',
                'vehicle_info' => 'Toyota Yaris, ABC-123, 2020, Rojo',
                'marital_status' => 'Casado(a)',
                'marriage_date' => '2010-12-20',
                'blood_type' => 'O+',
                'personal_email' => 'profesor.prueba@gmail.com',
                'birthplace' => 'Lima, Perú',
                'address' => 'Av. Universitaria 1234, Lima',
            ]);

            // Clear existing family to prevent duplicates on re-run
            $teacher->familyMembers()->delete();

            // Create a sample family member
            $teacher->familyMembers()->create([
                'name' => 'María Pérez',
                'relationship' => 'Cónyuge',
                'birth_date' => '1982-08-25',
                'civil_status' => 'Casado(a)',
                'education_level' => 'Universitario',
                'occupation' => 'Arquitecta',
                'is_dependent' => false,
            ]);
        }
    }
}
