<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\PdfGeneratorService;
use App\Models\Teacher;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function teacherLoad(Request $request, Teacher $teacher)
    {
        $teacher->load(['courses']); 
        
        $pdfService = new PdfGeneratorService();
        $pdfService->setConfig([
            'title' => 'Carga Docente',
            'orientation' => $request->input('orientation', 'landscape'),
            'paper_size' => $request->input('paper_size', 'a4'),
            'show_header' => $request->has('show_header'),
            'show_footer' => $request->has('show_footer'),
            'show_pagination' => $request->has('show_pagination'),
            'font_size' => $request->input('font_size', '12px'),
            'background_opacity' => $request->input('background_opacity', 0.1),
            'background_image' => $request->has('use_background') ? 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f7/Uni-logo_transparente_granate.png/1024px-Uni-logo_transparente_granate.png' : null,
        ])->setView('reports.teacher_load', compact('teacher'))
          ->generate();
        
        $filename = 'carga_docente_' . $teacher->ape_pat . '.pdf';
        
        if ($request->has('download')) {
            return $pdfService->download($filename);
        }
        
        return $pdfService->stream($filename);
    }

    public function exportStudents(Request $request)
    {
        $specialty = $request->query('specialty');
        $admissionYear = $request->query('admission_year');
        
        return Excel::download(new StudentsExport($specialty, $admissionYear), 'estudiantes.xlsx');
    }
}
