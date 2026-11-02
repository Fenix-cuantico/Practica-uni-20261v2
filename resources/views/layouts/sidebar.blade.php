<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100vh; position: fixed;">
    <a href="{{ route('dashboard') }}" class="d-flex items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none border-bottom pb-3">
        <span class="fs-4 fw-bold text-primary ms-2"><i class="fas fa-university me-2"></i>FENIX SYSTEM</span>
    </a>
    <ul class="nav nav-pills flex-column mb-auto mt-3">
        @if(auth()->user() && auth()->user()->role === 'student')
            <li class="nav-item">
                <a href="{{ route('student.courses') }}" class="nav-link text-white {{ request()->routeIs('student.courses') ? 'active' : '' }}">
                    <i class="fas fa-book me-2"></i> Mis Cursos
                </a>
            </li>
        @else
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('schedule.index') }}" class="nav-link text-white {{ request()->routeIs('schedule.index') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt me-2"></i> Horarios
                </a>
            </li>
            <li>
                <a href="{{ route('attendances.create') }}" class="nav-link text-white {{ request()->routeIs('attendances.create') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check me-2"></i> Asistencia Docente
                </a>
            </li>
            <li>
                <a href="{{ route('profile.index') }}" class="nav-link text-white {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                    <i class="fas fa-user me-2"></i> Mi Perfil
                </a>
            </li>
        @endif
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->email ?? 'Admin') }}&background=0D8ABC&color=fff" alt="User" width="32" height="32" class="rounded-circle me-2">
            <strong>{{ explode('@', Auth::user()->email)[0] ?? 'Usuario' }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Configuración</a></li>
            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">Cerrar Sesión</button>
                </form>
            </li>
        </ul>
    </div>
</div>
