<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devtools - Crear Usuarios Ficticios</title>
    <!-- Usamos el CDN default del proyecto -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f3f4f6; }
    </style>
</head>
<body class="d-flex align-items-center py-5">
    
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-dark text-white border-0 py-3 rounded-top-4">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-hammer me-2"></i>Dev Tool: Fast Registration</h5>
                </div>
                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success fw-bold">
                            <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('dev.register.post') }}">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label text-secondary small fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" required placeholder="ejemplo@gmail.com" value="{{ old('email') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-bold">Nombres</label>
                                <input type="text" name="name" class="form-control" required placeholder="Pepe" value="{{ old('name') }}">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-bold">Password (min 6)</label>
                                <input type="password" name="password" class="form-control" required value="password">
                                <div class="form-text">Default: 'password'</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-bold">Apellido Paterno</label>
                                <input type="text" name="ape_pat" class="form-control" required placeholder="Perez" value="{{ old('ape_pat') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-bold">Apellido Materno</label>
                                <input type="text" name="ape_mat" class="form-control" required placeholder="Gomez" value="{{ old('ape_mat') }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label text-secondary small fw-bold">Rol (Crea Relación)</label>
                                <select name="role" class="form-select bg-light">
                                    <option value="teacher">Teacher (Crea tabla Teacher)</option>
                                    <option value="student">Student (Crea tabla Student)</option>
                                    <option value="admin">Admin (Crea tabla Teacher)</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark fw-bold shadow-sm py-2">Inyectar Data Dual</button>
                            <a href="{{ url('/') }}" class="btn btn-link mt-2 text-decoration-none">Volver al Index</a>
                        </div>
                    </form>

                </div>
            </div>
            <div class="text-center mt-3 text-muted small">
                <i class="fas fa-shield-alt"></i> Tool para entorno local. Injecta en `users` y `teachers/students` simultáneamente.
            </div>
        </div>
    </div>
</div>

</body>
</html>
