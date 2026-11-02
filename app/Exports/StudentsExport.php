<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $specialty;
    protected $admissionYear;

    public function __construct($specialty = null, $admissionYear = null)
    {
        $this->specialty = $specialty;
        $this->admissionYear = $admissionYear;
    }

    public function query()
    {
        $query = Student::query();

        if ($this->specialty) {
            $query->where('specialty', $this->specialty);
        }

        if ($this->admissionYear) {
            $query->where('admission_year', $this->admissionYear);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Código',
            'Apellidos y Nombres',
            'DNI',
            'Especialidad',
            'Año de Ingreso',
            'Especialidad Anterior',
        ];
    }

    public function map($student): array
    {
        return [
            $student->student_code,
            $student->ape_pat . ' ' . $student->ape_mat . ', ' . $student->name,
            $student->dni,
            $student->specialty,
            $student->admission_year,
            $student->previous_specialty ?? '-',
        ];
    }
}
