<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class TeacherScheduleController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;
        
        // Fallback for dev environment if the admin doesn't have a teacher relation properly linked in session
        if (!$teacher) {
            $teacher = Teacher::first();
        }

        $schedules = collect();
        if ($teacher) {
            $schedules = DB::table('schedules')
                ->join('course_teacher', function($join) use ($teacher) {
                    $join->on('schedules.study_plan_id', '=', 'course_teacher.study_plan_id')
                         ->on('schedules.academic_semester_id', '=', 'course_teacher.academic_semester_id')
                         ->where('course_teacher.teacher_id', '=', $teacher->id);
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

        return view('schedule.index', compact('schedules', 'teacher'));
    }

    public function getStudents($scheduleId)
    {
        $students = DB::table('schedule_student')
            ->join('students', 'schedule_student.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('schedule_student.schedule_id', $scheduleId)
            ->select(
                'students.id',
                'students.student_code',
                'students.ape_pat',
                'students.ape_mat',
                'students.name',
                'users.email'
            )
            ->get();

        return response()->json($students);
    }

    public function getSchedule(Teacher $teacher)
    {
        $schedules = DB::table('schedules')
            ->join('course_teacher', function($join) use ($teacher) {
                $join->on('schedules.study_plan_id', '=', 'course_teacher.study_plan_id')
                     ->on('schedules.academic_semester_id', '=', 'course_teacher.academic_semester_id')
                     ->where('course_teacher.teacher_id', '=', $teacher->id);
            })
            ->join('study_plans', 'schedules.study_plan_id', '=', 'study_plans.id')
            ->join('classrooms', 'schedules.classroom_id', '=', 'classrooms.id')
            ->join('academic_semesters', 'schedules.academic_semester_id', '=', 'academic_semesters.id')
            ->select(
                'schedules.id',
                'study_plans.name as course_name',
                'schedules.section',
                'schedules.type',
                'schedules.time_range',
                'schedules.day',
                'academic_semesters.semester_name as semester'
            )
            ->get();

        return response()->json($schedules);
    }
}
