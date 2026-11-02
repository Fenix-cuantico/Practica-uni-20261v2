<!-- TAB 1: DATOS PERSONALES COMPLETOS -->
<div class="tab-pane fade show active" id="personal" role="tabpanel" tabindex="0">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h5 class="text-primary fw-bold mb-0 text-uppercase"><i class="fas fa-address-card me-2"></i> 1.- Datos Personales</h5>
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill fw-bold px-3 btn-edit-profile">
                <i class="fas fa-edit me-1"></i> Editar Perfil
            </button>
        </div>
        
        <div class="row g-4 mb-5">
            <!-- Datos Académicos -->
            <div class="col-12 mt-2">
                <h6 class="text-primary fw-bold mb-3"><i class="fas fa-graduation-cap me-2"></i>Datos Académicos</h6>
            </div>
            <div class="col-md-3">
                <label class="form-label text-secondary small fw-bold">Código Universitario</label>
                <input type="text" name="university_code" value="{{ old('university_code', optional(auth()->user()->teacher)->university_code) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly maxlength="10" inputmode="numeric" pattern="[0-9]*" data-only-digits>
            </div>
            <div class="col-md-3">
                <label class="form-label text-secondary small fw-bold">Dpto. Académico</label>
                <input type="text" name="academic_department" value="{{ old('academic_department', optional(auth()->user()->teacher)->academic_department) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label text-secondary small fw-bold">Dedicación</label>
                <input type="text" name="dedication" value="{{ old('dedication', optional(auth()->user()->teacher)->dedication) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label text-secondary small fw-bold">Condición</label>
                <input type="text" name="condition" value="{{ old('condition', optional(auth()->user()->teacher)->condition) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly>
            </div>

            <div class="col-md-12 mt-4">
                <hr class="text-secondary opacity-25">
            </div>

            <!-- Nombres y Apellidos -->
            <div class="col-md-12">
                <label class="form-label text-secondary small fw-bold">Nombres</label>
                <input type="text" name="name" value="{{ old('name', optional(auth()->user()->teacher)->name) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly maxlength="255" data-only-letters>
            </div>
            <div class="col-md-6">
                <label class="form-label text-secondary small fw-bold">Apellido Paterno</label>
                <input type="text" name="ape_pat" value="{{ old('ape_pat', optional(auth()->user()->teacher)->ape_pat) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly maxlength="255" data-only-letters>
            </div>
            <div class="col-md-6">
                <label class="form-label text-secondary small fw-bold">Apellido Materno</label>
                <input type="text" name="ape_mat" value="{{ old('ape_mat', optional(auth()->user()->teacher)->ape_mat) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly maxlength="255" data-only-letters>
            </div>
            
            <div class="col-md-12 mt-4">
                <hr class="text-secondary opacity-25">
            </div>

            <!-- Fila 1: Sexo, Fecha, DNI -->
            <div class="col-md-4">
                <label class="form-label text-secondary small fw-bold">Sexo</label>
                <select name="gender" class="form-select bg-light border-0 editable-field shadow-sm" disabled>
                    <option value="">Seleccionar</option>
                    <option value="Masculino" {{ old('gender', optional(auth()->user()->teacher)->gender) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ old('gender', optional(auth()->user()->teacher)->gender) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label text-secondary small fw-bold">Fecha Nacimiento</label>
                <div class="input-group shadow-sm">
                    <input type="date" name="birthdate" value="{{ old('birthdate', optional(auth()->user()->teacher)->birthdate) }}" class="form-control bg-light border-0 editable-field" readonly max="{{ date('Y-m-d') }}">
                    <span class="input-group-text bg-white border-0 text-muted"><i class="far fa-calendar-alt"></i></span>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label text-secondary small fw-bold">DNI <i class="fas fa-check-circle text-success ms-1"></i></label>
                <div class="input-group shadow-sm">
                    <input type="text" name="dni" value="{{ old('dni', optional(auth()->user()->teacher)->dni) }}" class="form-control bg-light border-0 editable-field" readonly maxlength="8" inputmode="numeric" pattern="[0-9]{8}" data-only-digits placeholder="Ej: 12345678">
                    <button type="button" class="btn btn-light border-0 text-primary" title="Subir"><i class="fas fa-cloud-upload-alt"></i></button>
                    <button type="button" class="btn btn-light border-0 text-dark" title="Ver"><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-light border-0 text-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                </div>
                <small class="text-muted d-none field-hint">Solo 8 dígitos numéricos</small>
            </div>

            <!-- Fila 2: Telefonos -->
            <div class="col-md-12">
                <label class="form-label text-secondary small fw-bold">Teléfono/Celular <i class="fas fa-pen text-primary ms-1" style="font-size: 0.7rem;"></i></label>
                <input type="text" name="phone" value="{{ old('phone', optional(auth()->user()->teacher)->phone) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly maxlength="9" inputmode="numeric" pattern="[0-9]{9}" data-only-digits placeholder="Ej: 987654321">
                <small class="text-muted d-none field-hint">Solo 9 dígitos numéricos, sin letras ni espacios</small>
            </div>

            <!-- Fila 3: RUC, Lib -->
            <div class="col-md-6">
                <label class="form-label text-secondary small fw-bold">RUC</label>
                <input type="text" name="ruc" value="{{ old('ruc', optional(auth()->user()->teacher)->ruc) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly maxlength="11" inputmode="numeric" pattern="[0-9]{11}" data-only-digits placeholder="Ej: 10123456789">
                <small class="text-muted d-none field-hint">Solo 11 dígitos numéricos</small>
            </div>
            <div class="col-md-6">
                <label class="form-label text-secondary small fw-bold">Lib Militar</label>
                <input type="text" name="military_lib" value="{{ old('military_lib', optional(auth()->user()->teacher)->military_lib) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly maxlength="20" inputmode="numeric" data-only-digits>
            </div>

            <!-- Fila 4: Vehiculo -->
            <div class="col-md-5">
                <label class="form-label text-secondary small fw-bold">Brevete y Categoría</label>
                <input type="text" name="license_category" value="{{ old('license_category', optional(auth()->user()->teacher)->license_category) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly maxlength="50">
            </div>
            <div class="col-md-7">
                <label class="form-label text-secondary small fw-bold">Si cuenta con vehículo, indicar modelo, placa, año, color</label>
                <input type="text" name="vehicle_info" value="{{ old('vehicle_info', optional(auth()->user()->teacher)->vehicle_info) }}" class="form-control bg-light border-0 editable-field shadow-sm" readonly maxlength="255">
            </div>

            <!-- Fila 5: Estado Civil -->
            <div class="col-md-4">
                <label class="form-label text-secondary small fw-bold">Estado Civil</label>
                <select name="marital_status" class="form-select bg-light border-0 editable-field shadow-sm" disabled>
                    <option value="">Seleccionar</option>
                    <option value="Soltero(a)" {{ old('marital_status', optional(auth()->user()->teacher)->marital_status) == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                    <option value="Casado(a)" {{ old('marital_status', optional(auth()->user()->teacher)->marital_status) == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                    <option value="Viudo(a)" {{ old('marital_status', optional(auth()->user()->teacher)->marital_status) == 'Viudo(a)' ? 'selected' : '' }}>Viudo(a)</option>
                    <option value="Divorciado(a)" {{ old('marital_status', optional(auth()->user()->teacher)->marital_status) == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label text-secondary small fw-bold">Fecha Matrimonio</label>
                <div class="input-group shadow-sm">
                    <input type="date" name="marriage_date" value="{{ old('marriage_date', optional(auth()->user()->teacher)->marriage_date) }}" class="form-control bg-light border-0 editable-field" readonly max="{{ date('Y-m-d') }}">
                    <span class="input-group-text bg-white border-0 text-muted"><i class="far fa-calendar-alt"></i></span>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label text-secondary small fw-bold">Grupo Sanguíneo</label>
                <select name="blood_type" class="form-select bg-light border-0 editable-field shadow-sm" disabled>
                    <option value="">Seleccionar</option>
                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)
                        <option value="{{ $type }}" {{ old('blood_type', optional(auth()->user()->teacher)->blood_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fila 6: Correos Dinámicos -->
            <div class="col-12 mt-4">
                <label class="form-label text-secondary small fw-bold">E-mail (S) <i class="fas fa-pen text-primary ms-1" style="font-size: 0.7rem;"></i></label>
                <div class="d-flex align-items-center flex-wrap gap-3 p-3 bg-light rounded shadow-sm border border-secondary-subtle">
                    <div class="input-group w-auto">
                        <input type="email" name="email" class="form-control form-control-sm border-0 editable-field text-primary fw-medium" value="{{ old('email', auth()->user()->email) }}" required readonly>
                        <span class="input-group-text bg-white border-0 text-success" title="Institucional"><i class="fas fa-university"></i></span>
                    </div>
                    <div class="input-group w-auto">
                        <input type="email" name="personal_email" class="form-control form-control-sm border-0 editable-field text-secondary" value="{{ old('personal_email', optional(auth()->user()->teacher)->personal_email) }}" readonly>
                        <span class="input-group-text bg-white border-0 text-danger" title="Personal"><i class="fab fa-google"></i></span>
                    </div>
                </div>
            </div>
        </div>

</div>
