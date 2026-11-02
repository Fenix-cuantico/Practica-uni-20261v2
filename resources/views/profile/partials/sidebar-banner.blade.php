<div class="card border-0 shadow-sm rounded-0 mb-4 h-10">
    <div class="profile-banner-horizontal">
        <!-- Default to the first part of email for avatar if name unavailable -->
        @php 
            $teacher = auth()->user()->teacher;
            $stored_name = $teacher->name ?? '';
            $stored_paternal = $teacher->ape_pat ?? '';
            $stored_maternal = $teacher->ape_mat ?? '';
            $full_name = trim("$stored_paternal $stored_maternal, $stored_name");
            if ($full_name === ',') {
                $display_name = explode('@', auth()->user()->email)[0];
                $full_name = str_replace(['.', '_'], ' ', $display_name);
            } else {
                $display_name = $stored_name ?: explode('@', auth()->user()->email)[0];
            }
        @endphp
        
        <div class="profile-photo-container rounded shadow-sm">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($display_name) }}&background=random&color=fff&size=150" alt="Profile">
        </div>
        
        <div class="profile-info-container">
            <h4 class="text-secondary fw-normal mb-0" style="font-size: 1.3rem;">{{ $full_name }}</h4>
            <div class="text-primary mb-3" style="font-size: 0.9rem;">08161078</div>
            
            <div class="d-flex align-items-center gap-3 mb-3" style="font-size: 0.8rem; color: #6c757d;">
                <span>Actualizar</span>
                <span>Historial</span>
            </div>
            
            <div class="d-flex gap-2 mb-3">
                <button class="btn btn-outline-secondary py-1 px-3"><i class="fas fa-cloud-upload-alt text-dark"></i></button>
                <button class="btn btn-outline-secondary py-1 px-3"><i class="fas fa-copy text-dark"></i></button>
            </div>
            
            <div class="d-flex gap-2 pb-2">
                <button class="btn btn-outline-info py-1 px-3 text-info border-info"><i class="fas fa-redo-alt"></i></button>
                <button class="btn btn-outline-danger py-1 px-3 text-danger border-danger" type="button" data-bs-toggle="modal" data-bs-target="#configPdfModal">
                    <i class="fas fa-file-pdf me-1"></i> Generar PDF
                </button>
            </div>
    </div>
</div>

<!-- Config PDF Modal -->
<div class="modal fade" id="configPdfModal" tabindex="-1" aria-labelledby="configPdfModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-secondary fw-bold" id="configPdfModalLabel"><i class="fas fa-cog me-2"></i>Configuración de PDF</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formPdfConfig" target="_blank" method="GET" action="{{ route('profile.pdf.view') }}">
      <div class="modal-body">
         <div class="row g-3">
             <div class="col-md-6">
                 <label class="form-label small text-muted">Orientación</label>
                 <select name="orientation" class="form-select form-select-sm border-bottom-only">
                     <option value="portrait">Vertical</option>
                     <option value="landscape">Horizontal</option>
                 </select>
             </div>
             <div class="col-md-6">
                 <label class="form-label small text-muted">Tamaño de Hoja</label>
                 <select name="paper_size" class="form-select form-select-sm border-bottom-only">
                     <option value="a4">A4</option>
                     <option value="letter">Carta</option>
                 </select>
             </div>
             
             <div class="col-md-12 mt-3">
                 <label class="form-label small text-muted mb-2">Estructura del Documento</label>
                 <div class="form-check form-switch mb-2">
                     <input class="form-check-input" type="checkbox" name="show_header" id="showHeader" value="1" checked>
                     <label class="form-check-label" for="showHeader">Incluir Cabecera</label>
                 </div>
                 <div class="form-check form-switch mb-2">
                     <input class="form-check-input" type="checkbox" name="show_footer" id="showFooter" value="1" checked>
                     <label class="form-check-label" for="showFooter">Incluir Pie de Página</label>
                 </div>
                 <div class="form-check form-switch mb-2">
                     <input class="form-check-input" type="checkbox" name="show_pagination" id="showPagination" value="1" checked>
                     <label class="form-check-label" for="showPagination">Numeración de páginas</label>
                 </div>
                 <div class="form-check form-switch">
                     <input class="form-check-input" type="checkbox" name="use_background" id="useBackground" value="1">
                     <label class="form-check-label" for="useBackground">Incluir Imagen de Fondo (Logo UNI)</label>
                 </div>
             </div>
             
             <div class="col-md-6 mt-3">
                 <label class="form-label small text-muted">Opacidad de Fondo</label>
                 <input type="range" class="form-range" name="background_opacity" min="0.05" max="0.5" step="0.05" id="bgOpacity" value="0.1">
                 <div class="text-center small text-muted" id="bgOpacityValue">10%</div>
             </div>
             
             <div class="col-md-6 mt-3">
                 <label class="form-label small text-muted">Tamaño de Letra</label>
                 <select name="font_size" class="form-select form-select-sm border-bottom-only">
                     <option value="10px">Pequeño (10px)</option>
                     <option value="12px" selected>Normal (12px)</option>
                     <option value="14px">Grande (14px)</option>
                 </select>
             </div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-dark" onclick="submitPdfConfig('view')"><i class="fas fa-eye me-2"></i> Ver PDF</button>
        <button type="button" class="btn btn-danger" onclick="submitPdfConfig('download')"><i class="fas fa-download me-2"></i> Descargar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let opacitySlider = document.getElementById('bgOpacity');
        if (opacitySlider) {
            opacitySlider.addEventListener('input', function(e) {
                document.getElementById('bgOpacityValue').innerText = Math.round(e.target.value * 100) + '%';
            });
        }
    });
    
    function submitPdfConfig(actionType) {
        var form = document.getElementById('formPdfConfig');
        if (actionType === 'download') {
            form.action = "{{ route('profile.pdf.download') }}";
            form.target = "_self";
        } else {
            form.action = "{{ route('profile.pdf.view') }}";
            form.target = "_blank";
        }
        form.submit();
        
        var modalEl = document.getElementById('configPdfModal');
        if (modalEl && typeof bootstrap !== 'undefined') {
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
        }
    }
</script>
