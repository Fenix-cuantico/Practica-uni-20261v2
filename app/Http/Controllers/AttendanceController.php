<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->merge(['attendance_date' => now()->toDateString()]);

        $request->validate([
            'teacher_id' => 'required|integer',
            'schedule_id' => 'required|exists:schedules,id',
            'attendance_date' => [new \App\Rules\LectureWeekRule],
        ]);

        $user = auth()->user();
        if (!$user || !$user->teacher || $user->teacher->id != $request->teacher_id) {
            return response()->json(['message' => 'Unauthorized or invalid teacher ID'], 403);
        }

        $attendance = Attendance::create([
            'teacher_id' => $user->teacher->id,
            'schedule_id' => $request->schedule_id,
            'check_in' => now(),
            'status' => true,
        ]);

        return response()->json(['message' => 'Success', 'data' => $attendance]);
    }
}
