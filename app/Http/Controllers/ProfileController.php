<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Services\PdfGeneratorService;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        $request->user()->fill([
            'email' => $validated['email'],
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        if (in_array($request->user()->role, ['teacher', 'admin'])) {
            $request->user()->teacher()->updateOrCreate(
                ['user_id' => $request->user()->id],
                [
                    'name' => $validated['name'] ?? $request->user()->teacher->name ?? '',
                    'ape_pat' => $validated['ape_pat'] ?? $request->user()->teacher->ape_pat ?? '',
                    'ape_mat' => $validated['ape_mat'] ?? $request->user()->teacher->ape_mat ?? '',
                    'university_code' => $validated['university_code'] ?? $request->user()->teacher->university_code ?? 'TBD',
                    'academic_department' => $validated['academic_department'] ?? $request->user()->teacher->academic_department ?? 'TBD',
                    'dedication' => $validated['dedication'] ?? $request->user()->teacher->dedication ?? 'TBD',
                    'condition' => $validated['condition'] ?? $request->user()->teacher->condition ?? 'TBD',
                    'dni' => $validated['dni'] ?? $request->user()->teacher->dni ?? 'TBD',
                    'phone' => $validated['phone'] ?? $request->user()->teacher->phone ?? 'TBD',
                    'gender' => $validated['gender'] ?? $request->user()->teacher->gender ?? null,
                    'birthdate' => $validated['birthdate'] ?? $request->user()->teacher->birthdate ?? null,
                    'ruc' => $validated['ruc'] ?? $request->user()->teacher->ruc ?? null,
                    'military_lib' => $validated['military_lib'] ?? $request->user()->teacher->military_lib ?? null,
                    'license_category' => $validated['license_category'] ?? $request->user()->teacher->license_category ?? null,
                    'vehicle_info' => $validated['vehicle_info'] ?? $request->user()->teacher->vehicle_info ?? null,
                    'marital_status' => $validated['marital_status'] ?? $request->user()->teacher->marital_status ?? null,
                    'marriage_date' => $validated['marriage_date'] ?? $request->user()->teacher->marriage_date ?? null,
                    'blood_type' => $validated['blood_type'] ?? $request->user()->teacher->blood_type ?? null,
                    'personal_email' => $validated['personal_email'] ?? $request->user()->teacher->personal_email ?? null,
                    'birthplace' => $validated['birthplace'] ?? $request->user()->teacher->birthplace ?? null,
                    'address' => $validated['address'] ?? $request->user()->teacher->address ?? null,
                ]
            );
        }

        return Redirect::route('profile.index')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Set up the PDF generator for the user's teacher profile.
     */
    private function setupProfilePdf(Request $request)
    {
        $user = $request->user();
        $user->load('teacher.courses'); // load related teacher and courses
        
        $pdfService = new PdfGeneratorService();
        $pdfService->setConfig([
            'title' => 'Perfil del Docente',
            'orientation' => $request->input('orientation', 'portrait'),
            'paper_size' => $request->input('paper_size', 'a4'),
            'show_header' => $request->has('show_header'),
            'show_footer' => $request->has('show_footer'),
            'show_pagination' => $request->has('show_pagination'),
            'font_size' => $request->input('font_size', '12px'),
            'background_opacity' => $request->input('background_opacity', 0.1),
            'background_image' => $request->has('use_background') ? 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f7/Uni-logo_transparente_granate.png/1024px-Uni-logo_transparente_granate.png' : null,
        ]);

        $pdfService->setView('pdf.teacher_profile', [
            'user' => $user,
            'teacher' => $user->teacher,
        ]);

        return $pdfService->generate();
    }

    /**
     * View the profile PDF in the browser.
     */
    public function viewPdf(Request $request)
    {
        return $this->setupProfilePdf($request)->stream('perfil_docente.pdf');
    }

    /**
     * Download the profile PDF.
     */
    public function downloadPdf(Request $request)
    {
        return $this->setupProfilePdf($request)->download('perfil_docente.pdf');
    }
}
