@extends('layouts.app')

@section('title', 'Horarios Dinámicos')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0 text-primary"><i class="fa-solid fa-calendar-alt me-2"></i> Mi Horario</h4>
        
        <div>
            <select class="form-select" id="semesterFilter">
                <option value="">Cargando semestres...</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Día</th>
                        <th>Horario</th>
                        <th>Curso</th>
                        <th>Sección</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody id="schedulesTableBody">
                    <tr><td colspan="5" class="text-center">Seleccione un semestre para ver su horario.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/api.js'])
<script type="module">
    import { performRequest, updateTable } from '{{ Vite::asset("resources/js/api.js") }}';

    function scheduleRowTemplate(item) {
        return `
            <tr>
                <td class="fw-bold">${item.day}</td>
                <td><span class="badge bg-secondary">${item.time_range}</span></td>
                <td>${item.course_name}</td>
                <td>${item.section}</td>
                <td><span class="badge bg-${item.type === 'T' ? 'info' : 'warning text-dark'}">${item.type === 'T' ? 'Teoría' : 'Práctica'}</span></td>
            </tr>
        `;
    }

    document.addEventListener('DOMContentLoaded', async () => {
        const semesterSelect = document.getElementById('semesterFilter');
        
        try {
            // Llenar mock de semestres
            semesterSelect.innerHTML = `
                <option value="1">2026-I</option>
                <option value="2">2026-II</option>
            `;

            // Mock de horarios iniciales
            const mockSchedules = [
                { day: 'Lunes', time_range: '08:00 - 10:00', course_name: 'Desarrollo Web', section: 'A1', type: 'T' },
                { day: 'Miércoles', time_range: '10:00 - 12:00', course_name: 'Base de Datos Avanzadas', section: 'B2', type: 'P' },
            ];

            updateTable('schedulesTableBody', mockSchedules, scheduleRowTemplate);

            semesterSelect.addEventListener('change', async (e) => {
                alertify.success('Cargando horario para semestre seleccionado...');
                // Simulando carga
                setTimeout(() => {
                    updateTable('schedulesTableBody', mockSchedules.reverse(), scheduleRowTemplate);
                }, 500);
            });
            
        } catch (error) {
            alertify.error('Error cargando iniciales');
        }
    });
</script>
@endpush
