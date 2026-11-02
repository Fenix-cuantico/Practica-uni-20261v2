@extends('layouts.pdf')

@section('content')

    <div>
        <p><strong>Docente:</strong> {{ $teacher->ape_pat }} {{ $teacher->ape_mat }}, {{ $teacher->name }}</p>
        <p><strong>DNI:</strong> {{ $teacher->dni }}</p>
        <p><strong>Código Universitario:</strong> {{ $teacher->university_code }}</p>
        <p><strong>Condición:</strong> {{ $teacher->condition }}</p>
        <p><strong>Dedicación:</strong> {{ $teacher->dedication }}</p>
    </div>

    <table class="table" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Código Curso</th>
                <th>Nombre del Curso</th>
                <th>Especialidad</th>
                <th>Créditos</th>
                <th>Ciclo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teacher->courses as $course)
                <tr>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->specialty }}</td>
                    <td>{{ $course->credits }}</td>
                    <td>{{ $course->cycle }}</td>
                </tr>
            @endforeach
            @if($teacher->courses->isEmpty())
                <tr>
                    <td colspan="5" style="text-align: center;">No hay cursos asignados.</td>
                </tr>
            @endif
        </tbody>
    </table>

@endsection
