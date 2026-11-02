<x-app-layout>
    <x-slot name="header">
        Configuración de Perfil
    </x-slot>

    @if (session('status') === 'profile-updated')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast('Perfil actualizado correctamente', 'success');
            });
        </script>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3 shadow-sm" role="alert">
            <h6 class="alert-heading fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Se encontraron errores en el formulario:</h6>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Profile CSS Link -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    <div class="row mb-5">
        <!-- Top Header Banner (Full Width) -->
        <div class="col-12">
            @include('profile.partials.sidebar-banner')
        </div>

        <!-- Right Content: Interactive Form Tabs (Full Width) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-0">
                
                <div class="card-header bg-white border-bottom pt-4 pb-0">
                    <ul class="nav nav-pills nav-pills-custom" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-2 fw-medium" id="personal-tab" data-bs-toggle="pill" data-bs-target="#personal" type="button" role="tab" style="font-size: 0.9rem;">1. DATOS PERSONALES</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-2 fw-medium" id="nacimiento-tab" data-bs-toggle="pill" data-bs-target="#nacimiento" type="button" role="tab" style="font-size: 0.9rem;">2. LUGAR DE NACIMIENTO</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-2 fw-medium" id="domicilio-tab" data-bs-toggle="pill" data-bs-target="#domicilio" type="button" role="tab" style="font-size: 0.9rem;">3. DOMICILIO</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-2 fw-medium" id="familia-tab" data-bs-toggle="pill" data-bs-target="#familia" type="button" role="tab" style="font-size: 0.9rem;">4. FAMILIA</button>
                        </li>
                        <li class="nav-item ms-auto" role="presentation">
                            <button class="nav-link py-2 text-muted" id="cuenta-tab" data-bs-toggle="pill" data-bs-target="#cuenta" type="button" role="tab" style="font-size: 0.9rem;"><i class="fas fa-cog me-1"></i> Config</button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content" id="profileTabsContent">
                        @include('profile.partials.tab-datos-personales')
                        @include('profile.partials.tab-lugar-nacimiento')
                        @include('profile.partials.tab-domicilio')
                        @include('profile.partials.tab-familia')
                    </div>
                    <div class="tab-content" id="profileTabsContentSecurity">
                        @include('profile.partials.tab-seguridad')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form id="profileUpdateForm" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold" id="editProfileModalLabel"><i class="fas fa-edit me-2"></i> Editar Perfil</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalFormBody" style="max-height: 65vh; overflow-y: auto;">
                        <!-- Content cloned via JS -->
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary fw-bold rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4 shadow"><i class="fas fa-save me-2"></i> Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Profile Form Interactive JS -->
<script src="{{ asset('js/profile.js') }}?v={{ time() }}"></script>
