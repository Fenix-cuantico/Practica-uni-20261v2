@extends('layouts.app')

@section('title', 'Gestión de Aulas')

@section('content')
<h2 class="mb-4 text-secondary"><i class="fa-solid fa-chalkboard-user me-2"></i> Gestión de Aulas</h2>

<div class="row" id="classroomsContainer">
    <!-- Aquí se inyectarán las JS Cards de Aulas dinámicamente -->
</div>
@endsection

@push('scripts')
@vite(['resources/js/api.js'])
<script type="module">
    import { performRequest, generateRow, updateTable } from '{{ Vite::asset("resources/js/api.js") }}';

    function createClassroomCard(classroom) {
        const projectorColor = classroom.has_projector ? 'text-success' : 'text-secondary';
        const pcColor = classroom.has_teacher_pc ? 'text-success' : 'text-secondary';

        return `
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-lift transition-all">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Aula: ${classroom.room_code || 'N/A'}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Capacidad: ${classroom.capacity || '-'} alumnos</h6>
                        <hr>
                        <div class="d-flex flex-column gap-2">
                            <div>
                                <i class="fa-solid fa-video ${projectorColor}"></i> Proyector
                            </div>
                            <div>
                                <i class="fa-solid fa-desktop ${pcColor}"></i> PC Docente
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    document.addEventListener('DOMContentLoaded', async () => {
        try {
            // Datos quemados para demostrar el funcionamiento solicitado (simula un fetch real)
            const mockClassrooms = [
                { room_code: 'L-101', capacity: 40, has_projector: true, has_teacher_pc: true },
                { room_code: 'A-205', capacity: 30, has_projector: false, has_teacher_pc: true },
                { room_code: 'B-103', capacity: 25, has_projector: false, has_teacher_pc: false }
            ];

            updateTable('classroomsContainer', mockClassrooms, createClassroomCard);
            
            // Si el backend estuviera listo, se usaría:
            // const realData = await performRequest('/api/classrooms');
            // updateTable('classroomsContainer', realData, createClassroomCard);
        } catch (error) {
            alertify.error('Error al renderizar las aulas');
        }
    });
</script>
@endpush
