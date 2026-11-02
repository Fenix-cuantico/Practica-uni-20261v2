<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DevController extends Controller
{
    public function showRegistrationForm()
    {
        // View for creating temp users
        return view('dev.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,teacher,student',
            'password' => 'required|min:6',
            'name' => 'required|string',
            'ape_pat' => 'required|string',
            'ape_mat' => 'required|string',
        ]);

        // Create the user
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => true,
        ]);

        // Based on role, insert the linked profile
        if ($request->role === 'teacher' || $request->role === 'admin') {
            Teacher::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'ape_pat' => $request->ape_pat,
                'ape_mat' => $request->ape_mat,
                'university_code' => 'TBD',
                'academic_department' => 'TBD',
                'dedication' => 'TBD',
                'condition' => 'TBD',
                'dni' => 'TBD',
                'phone' => 'TBD',
            ]);
        } elseif ($request->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'ape_pat' => $request->ape_pat,
                'ape_mat' => $request->ape_mat,
                'student_code' => 'TBD',
                'specialty' => 'TBD',
                'dni' => 'TBD',
            ]);
        }

        return redirect()->back()->with('status', "¡Usuario {$request->email} insertado con rol {$request->role} exitosamente!");
    }
}
