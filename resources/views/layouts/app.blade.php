<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap 5 CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <style>
            body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }
        </style>
    </head>
    <body class="bg-light">
        <div class="d-flex">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex-grow-1" style="margin-left: 280px; width: calc(100% - 280px);">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow-sm mb-4 py-3 px-4 border-bottom">
                        <h4 class="mb-0 text-secondary">{{ $header }}</h4>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="container-fluid p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
        <!-- Global Toasts Container -->
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1060;">
            <div id="globalToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fw-medium" id="globalToastMessage">
                        Mensaje de éxito.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
            </div>
        </div>

        <!-- Bootstrap 5 JS Bundle with Popper -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script>
            // Función global para mostrar alertas Toast
            window.showToast = function(message, type = 'success') {
                const toastEl = document.getElementById('globalToast');
                const toastMsg = document.getElementById('globalToastMessage');
                
                // Actualizar el mensaje
                toastMsg.innerText = message;
                
                // Cambiar la clase de color basada en el tipo (success, danger, warning, info)
                toastEl.className = `toast align-items-center border-0 text-bg-${type}`;
                
                // Inicializar y mostrar el Toast usando la API de Bootstrap
                const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                toast.show();
            };
        </script>
    </body>
</html>
