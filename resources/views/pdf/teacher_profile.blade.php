@extends('layouts.pdf')

@section('content')

<h2 class="section-title">1. DATOS PERSONALES</h2>
<table class="table">
    <tr>
        <td width="30%"><strong>Nombres:</strong></td>
        <td width="70%">{{ optional($teacher)->name ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Apellidos:</strong></td>
        <td>{{ optional($teacher)->ape_pat }} {{ optional($teacher)->ape_mat }}</td>
    </tr>
    <tr>
        <td><strong>DNI:</strong></td>
        <td>{{ optional($teacher)->dni ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Teléfono/Celular:</strong></td>
        <td>{{ optional($teacher)->phone ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Correo Institucional:</strong></td>
        <td>{{ optional($user)->email ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Sexo:</strong></td>
        <td>{{ optional($teacher)->gender ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Fecha de Nacimiento:</strong></td>
        <td>{{ optional($teacher)->birthdate ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Lugar de Nacimiento:</strong></td>
        <td>{{ optional($teacher)->birthplace ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Domicilio Actual:</strong></td>
        <td>{{ optional($teacher)->address ?? 'No registrado' }}</td>
    </tr>
</table>

<h2 class="section-title">2. DATOS ACADÉMICOS</h2>
<table class="table">
    <tr>
        <td width="30%"><strong>Código Universitario:</strong></td>
        <td width="70%">{{ optional($teacher)->university_code ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Departamento Académico:</strong></td>
        <td>{{ optional($teacher)->academic_department ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Dedicación:</strong></td>
        <td>{{ optional($teacher)->dedication ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Condición:</strong></td>
        <td>{{ optional($teacher)->condition ?? 'No registrado' }}</td>
    </tr>
</table>

<h2 class="section-title">3. DATOS ADICIONALES (Ej. Vehículo)</h2>
<table class="table">
    <tr>
        <td width="30%"><strong>Brevete y Categoría:</strong></td>
        <td width="70%">{{ optional($teacher)->license_category ?? 'No registrado' }}</td>
    </tr>
    <tr>
        <td><strong>Vehículo (Modelo, Placa, etc.):</strong></td>
        <td>{{ optional($teacher)->vehicle_info ?? 'No registrado' }}</td>
    </tr>
</table>

<h2 class="section-title">4. CURSOS ASIGNADOS (Tablas relacionadas)</h2>
@if(optional($teacher)->courses && $teacher->courses->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Curso</th>
                <th>Ciclo</th>
                <th>Créditos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teacher->courses as $course)
                <tr>
                    <td>{{ $course->course_code ?? 'N/A' }}</td>
                    <td>{{ $course->name ?? 'N/A' }}</td>
                    <td>{{ $course->cycle ?? 'N/A' }}</td>
                    <td>{{ $course->credits ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No tiene cursos asignados actualmente.</p>
@endif

@endsection
