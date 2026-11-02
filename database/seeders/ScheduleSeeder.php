<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Teacher;
use App\Models\AcademicSemester;
use App\Models\StudyPlan;
use App\Models\Classroom;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear o encontrar el Semestre Académico (Sacado de tabla_normalizacion.md)
        $semester = AcademicSemester::updateOrCreate(
            ['semester_name' => '20251'],
            [
                'start_date' => '2025-03-24',
                'end_date' => '2025-07-19',
                'is_active' => true,
                'curriculum_version' => 'v1',
            ]
        );

        // 2. Crear las Aulas necesarias
        $classroom1 = Classroom::updateOrCreate(
            ['room_code' => 'CCLAB-1D'],
            [
                'capacity' => 40,
                'chair_type' => 'Standard',
                'entrance_type' => 'Principal',
                'has_projector' => true,
                'has_teacher_pc' => true,
                'door_count' => 1,
            ]
        );

        $classroom2 = Classroom::updateOrCreate(
            ['room_code' => 'CCLAB-1E'],
            [
                'capacity' => 40,
                'chair_type' => 'Standard',
                'entrance_type' => 'Principal',
                'has_projector' => true,
                'has_teacher_pc' => true,
                'door_count' => 1,
            ]
        );

        $classroom3 = Classroom::updateOrCreate(
            ['room_code' => 'CCLAB-2A'],
            [
                'capacity' => 30,
                'chair_type' => 'Standard',
                'entrance_type' => 'Principal',
                'has_projector' => true,
                'has_teacher_pc' => true,
                'door_count' => 1,
            ]
        );

        // 3. Crear el Curso (StudyPlan)
        $course = StudyPlan::updateOrCreate(
            ['course_code' => 'MB545'],
            [
                'name' => 'Sistemas Distribuidos',
                'specialty' => 'Ingeniería de Sistemas',
                'evaluation_system' => 'F',
                'theory_hours' => 2,
                'practice_hours' => 2,
                'lab_hours' => 2,
                'credits' => 4,
                'cycle' => 8,
            ]
        );

        // 4. Crear o buscar al Profesor (el usuario 1 que suele ser admin patata@gmail.com)
        $user = User::find(1);
        if (!$user) {
            $user = User::create([
                'email' => 'patata@gmail.com',
                'password' => bcrypt('patata123'),
                'role' => 'admin',
                'status' => true,
            ]);
        }

        $teacher = Teacher::updateOrCreate(
            ['user_id' => $user->id],
            [
                'university_code' => '10115533', // Código del markdown
                'academic_department' => 'Sistemas y Telemática',
                'dedication' => 'Tiempo Parcial',
                'condition' => 'Nombrado',
                'ape_pat' => 'Perez',
                'ape_mat' => 'Cardenas',
                'name' => 'Carlos',
                'dni' => '10115533',
                'phone' => '999999999',
            ]
        );

        // 5. Asignar el Curso al Profesor (CourseTeacher)
        DB::table('course_teacher')->updateOrInsert(
            [
                'study_plan_id' => $course->id,
                'teacher_id' => $teacher->id,
                'academic_semester_id' => $semester->id,
            ],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // 6. Crear los Horarios (Schedules) basados en los idHorario del markdown y mockups
        $schedulesData = [
            [
                'id' => 34272, // MB545-C Teoría
                'study_plan_id' => $course->id,
                'classroom_id' => $classroom1->id,
                'academic_semester_id' => $semester->id,
                'section' => 'C',
                'type' => 'T',
                'time_range' => '09-12', // 9am a 12pm
                'day' => 'Martes',
            ],
            [
                'id' => 34454, // MB545-C Práctica
                'study_plan_id' => $course->id,
                'classroom_id' => $classroom1->id,
                'academic_semester_id' => $semester->id,
                'section' => 'C',
                'type' => 'P',
                'time_range' => '13-16', // 1pm a 4pm
                'day' => 'Martes',
            ],
            [
                'id' => 34455, // MB545-D
                'study_plan_id' => $course->id,
                'classroom_id' => $classroom2->id,
                'academic_semester_id' => $semester->id,
                'section' => 'D',
                'type' => 'P',
                'time_range' => '09-12', // 9am a 12pm
                'day' => 'Viernes',
            ],
            [
                'id' => 37288, // MB545-F
                'study_plan_id' => $course->id,
                'classroom_id' => $classroom3->id,
                'academic_semester_id' => $semester->id,
                'section' => 'F',
                'type' => 'P',
                'time_range' => '12-15', // 12pm a 3pm
                'day' => 'Martes',
            ]
        ];

        foreach ($schedulesData as $scheduleData) {
            DB::table('schedules')->updateOrInsert(
                ['id' => $scheduleData['id']], // Use exact IDs from tabla_normalizacion
                array_merge($scheduleData, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        echo "✅ Datos académicos y horarios sembrados correctamente.\n";
    }
}
