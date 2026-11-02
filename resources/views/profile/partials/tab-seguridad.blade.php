<!-- TAB 2: SEGURIDAD DE CUENTA (Breeze Update Password standard form wrapper) -->
<div class="tab-pane fade" id="cuenta" role="tabpanel" tabindex="0">
    <h5 class="text-secondary fw-bold mb-4">Actualización de Contraseña</h5>
    
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')
        
        <div class="row g-3">
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="password" name="current_password" class="form-control border-primary-subtle @error('current_password', 'updatePassword') is-invalid @enderror" id="current_password" required autocomplete="current-password">
                    <label for="current_password">Contraseña Actual</label>
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="password" name="password" class="form-control border-primary-subtle @error('password', 'updatePassword') is-invalid @enderror" id="password" required autocomplete="new-password">
                    <label for="password">Nueva Contraseña</label>
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="password" name="password_confirmation" class="form-control border-primary-subtle @error('password_confirmation', 'updatePassword') is-invalid @enderror" id="password_confirmation" required autocomplete="new-password">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    @error('password_confirmation', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-4 align-items-center gap-3">
            @if (session('status') === 'password-updated')
                <span class="text-success fw-bold small"><i class="fas fa-check-circle me-1"></i>Contraseña guardada</span>
            @endif
            <button type="button" class="btn btn-outline-secondary px-4 fw-bold rounded-pill shadow-sm" onclick="document.getElementById('personal-tab').click();">Cancelar</button>
            <button type="submit" class="btn btn-dark px-4 fw-bold rounded-pill shadow-sm"><i class="fas fa-key me-2"></i>Cambiar Contraseña</button>
        </div>
    </form>
</div>
