<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'civil_status' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'is_dependent' => 'nullable|in:si,no',
        ]);

        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            return redirect()->back()->with('error', 'Debe completar su perfil como docente primero.');
        }

        $teacher->familyMembers()->create([
            'name' => $request->name,
            'relationship' => $request->relationship,
            'birth_date' => $request->birth_date,
            'civil_status' => $request->civil_status,
            'education_level' => $request->education_level,
            'occupation' => $request->occupation,
            'is_dependent' => $request->is_dependent === 'si',
        ]);

        return redirect()->route('profile.index')->with('status', 'familiar-added');
    }

    public function destroy($id)
    {
        $teacher = auth()->user()->teacher;
        $familyMember = $teacher->familyMembers()->findOrFail($id);
        $familyMember->delete();

        return redirect()->route('profile.index')->with('status', 'familiar-deleted');
    }
}
