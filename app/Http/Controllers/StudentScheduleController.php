<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentScheduleController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        
        // Fallback for dev environment if the admin doesn't have a student relation properly linked in session
        if (!$student) {
            $student = Student::first();
        }

        $schedules = collect();
        if ($student) {
            $schedules = DB::table('schedules')
                ->join('schedule_student', function($join) use ($student) {
                    $join->on('schedules.id', '=', 'schedule_student.schedule_id')
                         ->where('schedule_student.student_id', '=', $student->id);
                })
                ->join('study_plans', 'schedules.study_plan_id', '=', 'study_plans.id')
                ->join('classrooms', 'schedules.classroom_id', '=', 'classrooms.id')
                ->join('academic_semesters', 'schedules.academic_semester_id', '=', 'academic_semesters.id')
                ->select(
                    'schedules.id',
                    'study_plans.course_code',
                    'study_plans.name as course_name',
                    'classrooms.room_code',
                    'schedules.section',
                    'schedules.type',
                    'schedules.time_range',
                    'schedules.day',
                    'academic_semesters.semester_name as semester'
                )
                ->get();
        }

        return view('student.schedule.index', compact('schedules', 'student'));
    }
}
