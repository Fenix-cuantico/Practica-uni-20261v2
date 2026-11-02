<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentAttendance;

class StudentAttendanceController extends Controller
{
    public function getStudents(Request $request, $schedule_id)
    {
        // For prototyping, we fetch all students to simulate the class roster.
        // In a real app, we'd join with enrollments table.
        $students = Student::all();
        $date = $request->query('date', date('Y-m-d'));

        // Load attendances for this schedule and date
        $attendances = StudentAttendance::where('schedule_id', $schedule_id)
            ->where('session_date', $date)
            ->get()
            ->keyBy('student_id');

        $result = $students->map(function ($student) use ($attendances) {
            $attendance = $attendances->get($student->id);
            return [
                'id' => $student->id,
                'code' => $student->student_code ?? 'N/A',
                'ape_pat' => $student->ape_pat,
                'ape_mat' => $student->ape_mat,
                'name' => $student->name,
                'section' => 'C', // Placeholder section
                'ult_responsable' => $attendance->ult_responsable ?? 'No establecido',
                'act_fis' => $attendance->act_fis ?? false,
                'act_vir' => $attendance->act_vir ?? false,
            ];
        });

        return response()->json($result);
    }

    public function saveAttendances(Request $request, $schedule_id)
    {
        $date = $request->input('date');
        $attendances = $request->input('attendances', []);

        foreach ($attendances as $attend) {
            StudentAttendance::updateOrCreate(
                [
                    'student_id' => $attend['student_id'],
                    'schedule_id' => $schedule_id,
                    'session_date' => $date,
                ],
                [
                    'act_fis' => $attend['act_fis'],
                    'act_vir' => $attend['act_vir'],
                    'ult_responsable' => 'Sistema', // or Auth user Name
                ]
            );
        }

        return response()->json(['message' => 'Guardado exitosamente']);
    }
}
