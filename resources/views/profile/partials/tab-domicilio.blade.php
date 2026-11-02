<div class="tab-pane fade" id="domicilio" role="tabpanel" tabindex="0">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h5 class="text-primary fw-bold mb-0 text-uppercase"><i class="fas fa-home me-2"></i> 3.- DOMICILIO</h5>
        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill fw-bold px-3 btn-edit-profile">
            <i class="fas fa-edit me-1"></i> Editar Perfil
        </button>
    </div>
    
    <div class="row g-4 p-4 bg-light rounded-3 shadow-sm border border-secondary-subtle">
        <div class="col-md-12">
            <label class="form-label text-secondary small fw-bold">Domicilio Actual (Dirección completa)</label>
            <textarea name="address" class="form-control bg-white border-0 editable-field shadow-sm" rows="3" readonly placeholder="Ej. Av. Los Incas 123, Lima">{{ old('address', optional(auth()->user()->teacher)->address) }}</textarea>
        </div>
    </div>
</div>
