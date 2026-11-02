<x-app-layout>
    <!-- Inclusion de FullCalendar JS y CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>

    <style>
        .fc-event.fc-event-puntual { background-color: #a7e196 !important; border-color: #a7e196 !important; color: #fff; }
        .fc-event.fc-event-noaplica { background-color: #bfa5fa !important; border-color: #bfa5fa !important; color: #fff; }
        .holiday-bg { background-color: #fbe6e6 !important; }
        .fc-col-header-cell { font-weight: normal; font-size: 0.9em; text-transform: lowercase; }
    </style>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            
            <h2 class="text-primary fw-light mb-1">Asistencia Docente</h2>
            <p class="text-secondary small mb-4">Asistencia de clases por día, semana y mes</p>
            
            <!-- Status Legends -->
            <div class="d-flex flex-wrap align-items-center mb-4 gap-3" style="font-size: 0.75rem; font-weight: 500; color: #6c757d;">
                <div class="d-flex align-items-center">PROGRAMADAS <span class="badge rounded-pill bg-secondary ms-2 pb-1">2</span></div>
                <div class="d-flex align-items-center">PUNTUALES <span class="badge rounded-pill ms-2 pb-1" style="background-color: #28a745;">53</span></div>
                <div class="d-flex align-items-center">TARDANZAS <span class="badge rounded-pill bg-warning text-dark ms-2 pb-1">2</span></div>
                <div class="d-flex align-items-center">INASISTENCIAS <span class="badge rounded-pill bg-danger ms-2 pb-1">0</span></div>
                <div class="d-flex align-items-center">NO APLICA <span class="badge rounded-pill ms-2 pb-1" style="background-color: #6f42c1;">11</span></div>
                <div class="d-flex align-items-center">EN PROCESO DE CAMBIO <span class="badge rounded-pill bg-info ms-2 pb-1">0</span></div>
                <div class="ms-auto text-primary" style="cursor: pointer;">
                    <i class="fas fa-eye me-1"></i> Mis asistencias
                </div>
            </div>

            <!-- Today's Courses Table -->
            <h5 class="text-info fw-bold mb-2 fs-6">Cursos de hoy <span id="currentDateString" class="fw-normal"></span></h5>
            <div class="table-responsive border mb-4">
                <table class="table table-borderless table-sm mb-0">
                    <thead class="bg-light text-secondary border-bottom">
                        <tr>
                            <th class="py-2 px-3 fw-normal">Nº</th>
                            <th class="py-2 px-3 fw-normal">CURSO</th>
                            <th class="py-2 px-3 fw-normal">HR. CLASE</th>
                            <th class="py-2 px-3 fw-normal">HR. MARCACION</th>
                            <th class="py-2 px-3 fw-normal">ESTADO</th>
                            <th class="py-2 px-3 fw-normal">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="py-3 text-center text-secondary bg-light">No se encontraron registros</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-secondary fw-medium mb-3 cursor-pointer" style="color: #e83e8c !important;">
                &gt; Mis solicitudes
            </div>

            <!-- FullCalendar Container -->
            <div id='calendar' class="border rounded p-3 shadow-sm bg-white"></div>
            
        </div>
    </div>

    <!-- Attendance Details Modal -->
    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom position-relative py-3">
                    <h5 class="modal-title text-info fw-bold" id="attendanceModalLabel">Información de asistencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-secondary" style="font-size: 0.85rem;">
                    <div class="mb-3">
                        <h5 class="text-primary fw-bold mb-3">SESION N° 2510017672</h5>
                        <p class="mb-2">DOCENTE: <span class="fw-bold text-dark">RAMIREZ TENORIO, JULIAN</span></p>
                        <div class="row mb-2">
                            <div class="col-6">DIA: martes, 24 de junio de 2025</div>
                            <div class="col-6">HORA: <span id="modalHourRange">09-12</span></div>
                        </div>
                        <p class="mb-2">CURSO: <span class="text-dark fw-bold" id="modalCourseTitle">MB545 - C (P) PROGRAMACION ORIENTADA A OBJETOS</span></p>
                        <div class="row mb-3">
                            <div class="col-4">H. ENTRADA: <span id="modalStart">09:08</span></div>
                            <div class="col-4">H. SALIDA: <span id="modalEnd">12:00</span></div>
                            <div class="col-4 text-primary fw-bold">ASISTENCIAS TOMADAS: 1</div>
                        </div>
                    </div>

                    <h6 class="text-info fw-bold mb-2">TEMA</h6>
                    <div class="p-3 bg-light text-secondary rounded mb-4" style="background-color: #e0f2f1 !important;">
                        1. Aplicaciones con Menús, como un sistema de opciones
                    </div>

                    <!-- Navigation Pills -->
                    <ul class="nav nav-pills nav-fill mb-3 text-dark fw-bold border-bottom pb-2" id="attendanceTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-0" id="alumnos-tab" data-bs-toggle="pill" data-bs-target="#alumnos" type="button" role="tab" aria-controls="alumnos" aria-selected="true" style="transition: none;"><i class="fas fa-graduation-cap me-2"></i>Asistencia alumnos</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark rounded-0" id="solicitudes-tab" data-bs-toggle="pill" data-bs-target="#solicitudes" type="button" role="tab" aria-controls="solicitudes" aria-selected="false" style="transition: none;"><i class="fas fa-file-alt me-2"></i>Solicitudes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark rounded-0" id="acta-tab" data-bs-toggle="pill" data-bs-target="#acta" type="button" role="tab" aria-controls="acta" aria-selected="false" style="transition: none;"><i class="fas fa-archive me-2"></i>Acta física</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark rounded-0" id="cambios-tab" data-bs-toggle="pill" data-bs-target="#cambios" type="button" role="tab" aria-controls="cambios" aria-selected="false" style="transition: none;"><i class="fas fa-history me-2"></i>Control de cambios</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="attendanceTabContent">
                        <!-- Alumnos Tab -->
                        <div class="tab-pane fade show active" id="alumnos" role="tabpanel" aria-labelledby="alumnos-tab" tabindex="0">
                            <div class="d-flex justify-content-end mb-2">
                                <button class="btn btn-primary btn-sm"><i class="fas fa-file-pdf"></i></button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-borderless text-center align-middle">
                                    <thead class="text-info fw-normal border-bottom border-top">
                                        <tr>
                                            <th class="py-2">N°</th>
                                            <th class="py-2">COD.</th>
                                            <th class="py-2 text-start">APELLIDOS Y NOMBRES</th>
                                            <th class="py-2">SEC.</th>
                                            <th class="py-2">ULT. RESPONSABLE</th>
                                            <th class="py-2">ACT. FIS.</th>
                                            <th class="py-2">ACT. VIR.</th>
                                        </tr>
                                    </thead>
                                    <tbody id="studentAttendanceTableBody">
                                        <!-- Javascript populates -->
                                        <tr>
                                            <td colspan="7" class="py-3 text-center">Cargando alumnos...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Placeholder tabs -->
                        <div class="tab-pane fade p-4 text-center text-muted" id="solicitudes" role="tabpanel" aria-labelledby="solicitudes-tab" tabindex="0">
                            <i class="fas fa-file-alt fa-2x mb-3 text-secondary"></i>
                            <p>No hay solicitudes pendientes.</p>
                        </div>
                        <div class="tab-pane fade p-4 text-center text-muted" id="acta" role="tabpanel" aria-labelledby="acta-tab" tabindex="0">
                           <i class="fas fa-archive fa-2x mb-3 text-secondary"></i>
                            <p>Acta física no generada aún.</p>
                        </div>
                        <div class="tab-pane fade p-4 text-center text-muted" id="cambios" role="tabpanel" aria-labelledby="cambios-tab" tabindex="0">
                            <i class="fas fa-history fa-2x mb-3 text-secondary"></i>
                            <p>Sin historial de cambios reciente.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 bg-white">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnSaveAttendance" class="btn btn-primary px-4 fw-bold">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var currentScheduleId = null;
        var currentSessionDate = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            var date = new Date();
            var options = { weekday: 'short', month: 'short', day: 'numeric' };
            document.getElementById('currentDateString').textContent = date.toLocaleDateString('es-ES', options);

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                slotMinTime: "08:00:00",
                slotMaxTime: "22:00:00",
                allDaySlot: false,
                events: [
                    {
                        id: '1',
                        title: 'MB545-C-(P)\nCCLAB-1D',
                        daysOfWeek: [2], // Martes
                        startTime: '09:00:00',
                        endTime: '12:00:00',
                        classNames: ['fc-event-puntual'],
                        extendedProps: {
                            statusText: 'PUNTUAL (Verde)',
                            statusColor: 'text-success'
                        }
                    },
                    {
                        id: '2',
                        title: 'MB545-F (P)\nCCLAB-2A',
                        daysOfWeek: [2], // Martes
                        startTime: '13:00:00',
                        endTime: '16:00:00',
                        classNames: ['fc-event-puntual'],
                        extendedProps: {
                            statusText: 'PUNTUAL (Verde)',
                            statusColor: 'text-success'
                        }
                    },
                    {
                        id: '3',
                        title: 'MB545-D-(P)\nCCLAB-1E',
                        daysOfWeek: [4], // Jueves
                        startTime: '10:00:00',
                        endTime: '13:00:00',
                        classNames: ['fc-event-puntual'],
                        extendedProps: {
                            statusText: 'PUNTUAL (Verde)',
                            statusColor: 'text-success'
                        }
                    },
                    {
                        id: '4',
                        title: 'MB545-I-(P)\nCCLAB-2A',
                        daysOfWeek: [5], // Viernes
                        startTime: '19:00:00',
                        endTime: '22:00:00',
                        classNames: ['fc-event-noaplica'],
                        extendedProps: {
                            statusText: 'NO APLICA (Morado)',
                            statusColor: 'text-purple'
                        }
                    }
                ],
                dayCellDidMount: function(arg) {
                    if (arg.date.getDay() === 0) {
                        arg.el.classList.add('holiday-bg');
                        if(arg.view.type !== 'dayGridMonth') {
                            const wrapper = document.createElement('div');
                            wrapper.innerHTML = `<div style="position:absolute; bottom: 30%; color: red; font-size:10px; width:100%; text-align:center;">San Pedro y San Pablo</div>`;
                            arg.el.appendChild(wrapper);
                        }
                    }
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    
                    var title = info.event.title.replace('\n', ' / ');
                    var startHourDate = info.event.start;
                    var endHourDate = info.event.end;

                    var startFormatted = startHourDate.toLocaleTimeString('es-ES', { hour: '2-digit', minute:'2-digit' });
                    var endFormatted = endHourDate ? endHourDate.toLocaleTimeString('es-ES', { hour: '2-digit', minute:'2-digit' }) : 'N/A';
                    
                    var startHour = startHourDate.getHours().toString().padStart(2, '0');
                    var endHour = endHourDate ? endHourDate.getHours().toString().padStart(2, '0') : '--';
                    
                    var hourRange = startHour + '-' + endHour;

                    document.getElementById('modalCourseTitle').textContent = title;
                    document.getElementById('modalStart').textContent = startFormatted;
                    document.getElementById('modalEnd').textContent = endFormatted;
                    document.getElementById('modalHourRange').textContent = hourRange;

                    currentScheduleId = info.event.id;
                    currentSessionDate = startHourDate.toISOString().split('T')[0];
                    
                    loadStudents(currentScheduleId, currentSessionDate);
                    
                    var myModal = new bootstrap.Modal(document.getElementById('attendanceModal'));
                    myModal.show();
                }
            });
            calendar.render();

            document.getElementById('btnSaveAttendance').addEventListener('click', function() {
                saveAttendances();
            });
        });

        function loadStudents(scheduleId, date) {
            const tbody = document.getElementById('studentAttendanceTableBody');
            tbody.innerHTML = '<tr><td colspan="7" class="py-3 text-center">Cargando alumnos...</td></tr>';
            
            fetch(`/api/schedules/${scheduleId}/students?date=${date}`)
                .then(res => res.json())
                .then(students => {
                    tbody.innerHTML = '';
                    if (students.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="7" class="py-3 text-center text-danger">No hay alumnos (Asegurate de correr el seeder o tener datos)</td></tr>';
                        return;
                    }

                    students.forEach((s, index) => {
                        const tr = document.createElement('tr');
                        tr.className = 'border-bottom student-row';
                        tr.dataset.id = s.id;

                        // toggle button for act vis (boolean)
                        const virChecked = s.act_vir ? 'checked' : '';
                        
                        // fis icon (boolean) Let's make it clickable to toggle
                        const fisIcon = s.act_fis ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>';
                        const fisCheckedClass = s.act_fis ? 'fis-checked' : '';

                        tr.innerHTML = `
                            <td>${index + 1}</td>
                            <td><span class="bg-light px-2 py-1 rounded text-secondary shadow-sm">${s.code}</span></td>
                            <td class="text-start fw-bold text-dark">${s.ape_pat} ${s.ape_mat}, ${s.name}</td>
                            <td>${s.section}</td>
                            <td class="text-muted small">${s.ult_responsable}</td>
                            <td style="cursor: pointer;" class="fis-toggle" data-val="${s.act_fis ? 1 : 0}">
                                ${fisIcon}
                            </td>
                            <td>
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input vir-toggle" type="checkbox" role="switch" ${virChecked}>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });

                    // Add click listeners to physical attendance
                    document.querySelectorAll('.fis-toggle').forEach(el => {
                        el.addEventListener('click', function() {
                            let val = parseInt(this.dataset.val);
                            val = val === 1 ? 0 : 1;
                            this.dataset.val = val;
                            this.innerHTML = val === 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>';
                        });
                    });
                })
                .catch(err => {
                    tbody.innerHTML = '<tr><td colspan="7" class="py-3 text-center text-danger">Error al cargar datos.</td></tr>';
                    console.error(err);
                });
        }

        function saveAttendances() {
            if (!currentScheduleId || !currentSessionDate) return;

            const rows = document.querySelectorAll('.student-row');
            const data = [];

            rows.forEach(row => {
                const studentId = row.dataset.id;
                const actFis = parseInt(row.querySelector('.fis-toggle').dataset.val) === 1;
                const actVir = row.querySelector('.vir-toggle').checked;

                data.push({
                    student_id: studentId,
                    act_fis: actFis,
                    act_vir: actVir
                });
            });

            const btn = document.getElementById('btnSaveAttendance');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            btn.disabled = true;

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/api/schedules/${currentScheduleId}/students/attendances`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    date: currentSessionDate,
                    attendances: data
                })
            })
            .then(res => res.json())
            .then(res => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                
                showToast(res.message || 'Datos guardados correctamente', 'success');
                
                // Opcional: Cerrar el modal después de guardar
                var myModalEl = document.getElementById('attendanceModal');
                var modal = bootstrap.Modal.getInstance(myModalEl);
                if (modal) modal.hide();
            })
            .catch(err => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                showToast('Error al guardar datos de asistencia', 'danger');
                console.error(err);
            });
        }
    </script>
</x-app-layout>
