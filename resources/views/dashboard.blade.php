<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body py-5">
                    <i class="fas fa-calendar-alt text-primary fa-3x mb-3"></i>
                    <h5 class="card-title text-secondary">Horarios de Clase</h5>
                    <p class="card-text text-muted small">Visualiza y descarga tu horario docente oficial.</p>
                    <a href="{{ route('schedule.index') }}" class="btn btn-outline-primary btn-sm mt-2">Ir a Horarios</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body py-5">
                    <i class="fas fa-clipboard-list text-success fa-3x mb-3"></i>
                    <h5 class="card-title text-secondary">Asistencia Docente</h5>
                    <p class="card-text text-muted small">Gestiona tus marcaciones e historial de asistencias.</p>
                    <a href="{{ route('attendances.create') }}" class="btn btn-outline-success btn-sm mt-2">Ver Asistencia</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center">
                <div class="card-body py-5">
                    <i class="fas fa-user-circle text-info fa-3x mb-3"></i>
                    <h5 class="card-title text-secondary">Mi Perfil</h5>
                    <p class="card-text text-muted small">Actualiza tus datos personales y documentos.</p>
                    <a href="{{ route('profile.index') }}" class="btn btn-outline-info btn-sm mt-2">Editar Perfil</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
