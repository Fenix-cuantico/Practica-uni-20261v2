<div class="tab-pane fade" id="familia" role="tabpanel" tabindex="0">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h5 class="text-primary fw-bold mb-0 text-uppercase"><i class="fas fa-users me-2"></i> 4.- FAMILIA</h5>
    </div>
    
    <div class="mb-4">
        <button type="button" class="btn btn-primary btn-sm rounded shadow-sm fw-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalFamilia" style="background-color: #2c52aa; border: none;">
            AÑADIR FAMILIAR
        </button>
    </div>
    
    <div class="table-responsive bg-white shadow-sm rounded-3 border border-secondary-subtle" style="font-size: 0.85rem;">
        <table class="table table-hover table-striped mb-0 align-middle">
            <thead class="table-light text-dark">
                <tr>
                    <th>Apellidos y Nombres</th>
                    <th>Parentesco</th>
                    <th>Fecha Nacimiento</th>
                    <th>Est. Civil</th>
                    <th>Nivel Estudios</th>
                    <th>Ocupación</th>
                    <th>¿Depende?</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $familyMembers = auth()->user()->teacher ? auth()->user()->teacher->familyMembers : collect();
                @endphp
                @forelse ($familyMembers as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->relationship }}</td>
                        <td>{{ $member->birth_date ? $member->birth_date->format('d/m/Y') : '-' }}</td>
                        <td>{{ $member->civil_status ?? '-' }}</td>
                        <td>{{ $member->education_level ?? '-' }}</td>
                        <td>{{ $member->occupation ?? '-' }}</td>
                        <td>{{ $member->is_dependent ? 'Sí' : 'No' }}</td>
                        <td>
                            <form action="{{ route('family-members.destroy', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('¿Eliminar este familiar?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No hay familiares registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar Familiar -->
<div class="modal fade" id="modalFamilia" tabindex="-1" aria-labelledby="modalFamiliaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 0.5rem;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalFamiliaLabel">Agregar Familiar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('family-members.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Apellidos y Nombres</label>
                            <input type="text" name="name" class="form-control form-control-sm border-bottom-only" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Parentesco</label>
                            <select name="relationship" class="form-select form-select-sm border-bottom-only" required>
                                <option value="">Seleccionar</option>
                                <option value="Hijo(a)">Hijo(a)</option>
                                <option value="Cónyuge">Cónyuge</option>
                                <option value="Padre/Madre">Padre/Madre</option>
                                <option value="Hermano(a)">Hermano(a)</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mt-4">
                            <label class="form-label small text-muted">Fecha Nacimiento</label>
                            <input type="date" name="birth_date" class="form-control form-control-sm border-bottom-only">
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label small text-muted">Est. Civil</label>
                            <select name="civil_status" class="form-select form-select-sm border-bottom-only">
                                <option value="">Seleccionar</option>
                                <option value="Soltero(a)">Soltero(a)</option>
                                <option value="Casado(a)">Casado(a)</option>
                                <option value="Divorciado(a)">Divorciado(a)</option>
                                <option value="Viudo(a)">Viudo(a)</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mt-4">
                            <label class="form-label small text-muted">Nivel Estudios</label>
                            <select name="education_level" class="form-select form-select-sm border-bottom-only">
                                <option value="">Seleccionar</option>
                                <option value="Primaria">Primaria</option>
                                <option value="Secundaria">Secundaria</option>
                                <option value="Superior Técnico">Superior Técnico</option>
                                <option value="Universitario">Universitario</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label small text-muted">Ocupación</label>
                            <input type="text" name="occupation" class="form-control form-control-sm border-bottom-only">
                        </div>
                        
                        <div class="col-12 mt-4">
                            <label class="form-label small text-muted me-3">¿Depende económicamente de Ud.?</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_dependent" id="radioSi" value="si">
                                <label class="form-check-label small" for="radioSi">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_dependent" id="radioNo" value="no" checked>
                                <label class="form-check-label small" for="radioNo">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-link text-decoration-none fw-bold text-dark" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-link text-decoration-none fw-bold text-primary">GUARDAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* CSS Extra for modal inputs to trace the style in the screenshot */
.border-bottom-only {
    border: none !important;
    border-bottom: 1px solid #ced4da !important;
    border-radius: 0 !important;
    padding-left: 0 !important;
    background-color: transparent !important;
    box-shadow: none !important;
}
.border-bottom-only:focus {
    border-bottom: 2px solid #0d6efd !important;
}
</style>
