<div class="tab-pane fade" id="nacimiento" role="tabpanel" tabindex="0">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h5 class="text-primary fw-bold mb-0 text-uppercase"><i class="fas fa-map-marker-alt me-2"></i> 2.- Lugar de Nacimiento</h5>
        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill fw-bold px-3 btn-edit-profile">
            <i class="fas fa-edit me-1"></i> Editar Perfil
        </button>
    </div>

    <div class="row g-4 p-4 bg-light rounded-3 shadow-sm border border-secondary-subtle">
        <div class="col-md-12">
            <label class="form-label text-secondary small fw-bold">Lugar de Nacimiento (País, Departamento, Provincia, Distrito)</label>
            <input type="text" name="birthplace" value="{{ old('birthplace', optional(auth()->user()->teacher)->birthplace) }}" class="form-control bg-white border-0 editable-field shadow-sm" readonly placeholder="Ej. Perú, Lima, Lima, San Martín de Porres">
        </div>
    </div>
</div>
