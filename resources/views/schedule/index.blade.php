<x-app-layout>
    <x-slot name="header">
        Horario de clase
    </x-slot>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-primary fw-light mb-3">Horario de clase</h2>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#configPdfModal">
                        <i class="fas fa-file-pdf me-2"></i>Generar PDF
                    </button>
                </div>
                <div class="text-end">
                    <select class="form-select w-auto d-inline-block mb-1">
                        <option>20251</option>
                    </select>
                    <div class="text-primary fw-bold text-uppercase" style="font-size: 0.9rem;">Definitivo</div>
                    <div class="text-secondary fw-light mt-3" style="font-size: 1.5rem;">Carga Horaria: {{ $totalHours ?? 0 }} HRS</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle" style="font-size: 0.85rem;">
                    <thead class="bg-light text-primary">
                        <tr>
                            <th class="py-3 fw-normal" style="width: 10%;">HORA</th>
                            <th class="py-3 fw-normal" style="width: 12.8%;">LUNES</th>
                            <th class="py-3 fw-normal" style="width: 12.8%;">MARTES</th>
                            <th class="py-3 fw-normal" style="width: 12.8%;">MIERCOLES</th>
                            <th class="py-3 fw-normal" style="width: 12.8%;">JUEVES</th>
                            <th class="py-3 fw-normal" style="width: 12.8%;">VIERNES</th>
                            <th class="py-3 fw-normal" style="width: 12.8%;">SABADO</th>
                            <th class="py-3 fw-normal" style="width: 12.8%;">DOMINGO</th>
                        </tr>
                    </thead>
@php
    $hours = [
        '07-08', '08-09', '09-10', '10-11', '11-12', '12-13', 
        '13-14', '14-15', '15-16', '16-17'
    ];
    $days = ['LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO'];
    
    $scheduleMap = [];
    $totalHours = 0;
    
    foreach ($schedules as $s) {
        $parts = explode('-', $s->time_range);
        if (count($parts) == 2) {
            $startHour = (int)$parts[0];
            $endHour = (int)$parts[1];
            $duration = $endHour - $startHour;
            $startKey = sprintf('%02d-%02d', $startHour, $startHour + 1);
            $dayUpper = strtoupper($s->day);
            $scheduleMap[$dayUpper][$startKey] = [
                'data' => $s,
                'duration' => $duration
            ];
            $totalHours += $duration;
        }
    }
    
    $skipCells = [];
@endphp
                        @foreach ($hours as $hour)
                            <tr>
                                <td class="py-3 align-middle">{{ $hour }}</td>
                                @foreach ($days as $day)
                                    @if (isset($skipCells[$day]) && $skipCells[$day] > 0)
                                        @php $skipCells[$day]--; @endphp
                                        @continue
                                    @endif

                                    @if (isset($scheduleMap[$day][$hour]))
                                        @php
                                            $sch = $scheduleMap[$day][$hour];
                                            $duration = $sch['duration'];
                                            if ($duration > 1) {
                                                $skipCells[$day] = $duration - 1;
                                            }
                                            // T = Theory (Darker blue), P = Practice (Lighter blue)
                                            $bgColor = $sch['data']->type == 'T' ? '#3aa3d0' : '#b5e5f5';
                                            $textColor = $sch['data']->type == 'T' ? '#ffffff' : '#3aa3d0';
                                        @endphp
                                        <td rowspan="{{ $duration }}" class="p-0 align-middle border-0 shadow-sm" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#studentsModal" data-bs-title="{{ $sch['data']->course_code }}-{{ $sch['data']->section }} / {{ $sch['data']->room_code }} | {{ $sch['data']->semester }}" data-schedule-id="{{ $sch['data']->id }}">
                                            <div class="d-flex flex-column justify-content-center h-100 p-2" style="background-color: {{ $bgColor }}; color: {{ $textColor }}; min-height: {{ $duration * 45 }}px;">
                                                <div class="fw-bold" style="font-size: 0.85rem;"><i class="fas fa-user me-1"></i>(10) {{ $sch['data']->course_code }}-{{ $sch['data']->section }} /</div>
                                                <div style="font-size: 0.75rem;">[{{ $sch['data']->room_code }}]({{ $sch['data']->type }})</div>
                                            </div>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                </table>
            </div>
        </div>
    </div>

    <!-- Modal (Student list) -->
    <div class="modal fade" id="studentsModal" tabindex="-1" aria-labelledby="studentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0 flex-column align-items-start">
                    <h4 class="modal-title text-primary" id="studentsModalLabel">MB545-C / CCLAB-1D | 20251</h4>
                    <p class="text-info mb-3">Cantidad de alumnos: 12</p>
                    <div class="d-flex gap-2 w-100 justify-content-center mb-3">
                        <button class="btn btn-danger btn-sm px-4"><i class="fas fa-cloud-download-alt me-1"></i> PDF</button>
                        <button class="btn btn-success btn-sm px-4"><i class="fas fa-cloud-download-alt me-1"></i> EXCEL</button>
                    </div>
                </div>
                <div class="modal-body p-0">
                    <ul class="list-group list-group-flush" id="studentsList" style="max-height: 400px; overflow-y: auto;">
                        <li class="list-group-item text-center py-4 text-muted" id="studentsLoading">
                            <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                            Cargando alumnos...
                        </li>
                    </ul>
                </div>
                <div class="modal-footer border-top-0 bg-light">
                    <button type="button" class="btn btn-light border w-100" data-bs-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentsModal = document.getElementById('studentsModal');
            if (studentsModal) {
                studentsModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const title = button.getAttribute('data-bs-title');
                    const scheduleId = button.getAttribute('data-schedule-id');
                    
                    if (title) {
                        const modalTitle = studentsModal.querySelector('.modal-title');
                        modalTitle.textContent = title;
                    }
                    
                    const studentsList = document.getElementById('studentsList');
                    studentsList.innerHTML = `<li class="list-group-item text-center py-4 text-muted">
                        <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                        Cargando alumnos...
                    </li>`;
                    
                    document.querySelector('.text-info.mb-3').textContent = 'Cantidad de alumnos: ...';

                    if (scheduleId) {
                        fetch(`/api/schedules/${scheduleId}/enrolled`)
                            .then(response => response.json())
                            .then(data => {
                                document.querySelector('.text-info.mb-3').textContent = `Cantidad de alumnos: ${data.length}`;
                                studentsList.innerHTML = '';
                                
                                if (data.length === 0) {
                                    studentsList.innerHTML = `<li class="list-group-item text-center py-4 text-muted">No hay alumnos inscritos en este horario.</li>`;
                                    return;
                                }
                                
                                data.forEach((student, index) => {
                                    const li = document.createElement('li');
                                    li.className = 'list-group-item d-flex justify-content-between align-items-center py-3';
                                    li.innerHTML = `
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-light rounded p-2 text-secondary"><i class="fas fa-image fa-lg"></i></div>
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">${student.ape_pat} ${student.ape_mat}, ${student.name}</div>
                                                <div class="text-primary mt-1" style="font-size: 0.8rem;"><i class="fas fa-mobile-alt me-1"></i> ${student.email}</div>
                                            </div>
                                        </div>
                                        <div class="text-end" style="font-size: 0.8rem;">
                                            <div>condici&oacute;n: <strong class="text-dark">N</strong></div>
                                            <div class="text-secondary mt-1">${student.student_code}</div>
                                            <a href="mailto:${student.email}" class="text-dark text-decoration-none d-block xl-mt-1"><i class="fas fa-envelope text-dark"></i> Enviar correo</a>
                                        </div>
                                    `;
                                    studentsList.appendChild(li);
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching students:', error);
                                studentsList.innerHTML = `<li class="list-group-item text-center py-4 text-danger">Error al cargar los alumnos.</li>`;
                            });
                    }
                });
            }
        });
    </script>
    <div class="modal fade" id="configPdfModal" tabindex="-1" aria-labelledby="configPdfModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-secondary fw-bold" id="configPdfModalLabel"><i class="fas fa-cog me-2"></i>Configuración de PDF</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="formPdfConfig" target="_blank" method="GET" action="{{ route('reports.teacher_load', ['teacher' => $teacher->id ?? 1]) }}">
          <div class="modal-body">
             <div class="row g-3">
                 <div class="col-md-6">
                     <label class="form-label small text-muted">Orientación</label>
                     <select name="orientation" class="form-select form-select-sm border-bottom-only">
                         <option value="portrait">Vertical</option>
                         <option value="landscape" selected>Horizontal</option>
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
            <input type="hidden" name="download" id="downloadFlag" value="">
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
            var downloadFlag = document.getElementById('downloadFlag');
            
            if (actionType === 'download') {
                downloadFlag.value = "1";
                form.target = "_self";
            } else {
                downloadFlag.disabled = true; // don't send download param
                form.target = "_blank";
            }
            form.submit();
            downloadFlag.disabled = false; // re-enable for future clicks
            downloadFlag.value = "";
            
            var modalEl = document.getElementById('configPdfModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                var modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            }
        }
    </script>
</x-app-layout>
