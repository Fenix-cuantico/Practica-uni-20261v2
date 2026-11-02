<x-app-layout>
    <x-slot name="header">
        Horario de clase
    </x-slot>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-primary fw-light mb-3">Horario de clase</h2>
                </div>
                <div class="text-end">
                    <select class="form-select w-auto d-inline-block mb-1">
                        <option>20251</option>
                    </select>
                    <div class="text-primary fw-bold text-uppercase" style="font-size: 0.9rem;">Definitivo</div>
                    <div class="text-secondary fw-light mt-3" style="font-size: 1.5rem;">Horas de clase: {{ $totalHours ?? 0 }} HRS</div>
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
                                        <td rowspan="{{ $duration }}" class="p-0 align-middle border-0 shadow-sm">
                                            <div class="d-flex flex-column justify-content-center h-100 p-2" style="background-color: {{ $bgColor }}; color: {{ $textColor }}; min-height: {{ $duration * 45 }}px;">
                                                <div class="fw-bold" style="font-size: 0.85rem;"><i class="fas fa-book me-1"></i>{{ $sch['data']->course_code }}-{{ $sch['data']->section }} /</div>
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

</x-app-layout>
