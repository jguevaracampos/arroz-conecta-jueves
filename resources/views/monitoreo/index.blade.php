<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-extrabold text-2xl text-[#1A1C1A] leading-tight flex items-center gap-2">
                    <span>💧</span> Monitoreo de Humedad & Sensores IoT
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Telemetría en tiempo real desde dispositivos NodeMCU ESP8266 en tus lotes de arroz</p>
            </div>

            <!-- Botón de Simulación para Pruebas / Demostración -->
            <form method="POST" action="{{ route('monitoreo.simular') }}">
                @csrf
                @if ($sensorActivo)
                    <input type="hidden" name="sensor_id" value="{{ $sensorActivo->id }}">
                @endif
                <button type="submit"
                        class="px-4 py-2.5 rounded-xl bg-[#316194] text-white hover:bg-[#224266] text-xs font-bold transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                    <span>Simular nueva lectura IoT</span>
                </button>
            </form>
        </div>
    </x-slot>

    @php
        $humedadVal = $ultimaMedicion?->humedad_suelo ?? 68.0;
        $tempVal = $ultimaMedicion?->temperatura ?? 28.0;
        $humAireVal = $ultimaMedicion?->humedad_aire ?? 75.0;
        $phVal = $ultimaMedicion?->ph ?? 6.5;
        $fechaMedicion = $ultimaMedicion ? \Carbon\Carbon::parse($ultimaMedicion->created_at)->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i:s');
        $estadoHum = $humedadVal < 50 ? 'Baja - Riego requerido' : ($humedadVal > 85 ? 'Exceso - Drenar' : 'Humedad adecuada');
        $colorBadge = $humedadVal < 50 ? 'bg-red-100 text-red-800' : ($humedadVal > 85 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800');
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Estado del Dispositivo y Última Medición -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-stone-200/80 text-xs">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="font-bold text-stone-800">
                        Dispositivo: {{ $sensorActivo?->codigo_sensor ?? 'ESP8266-SALDANA-01' }}
                    </span>
                    <span class="text-stone-400">·</span>
                    <span class="text-stone-500">
                        Lote: {{ $sensorActivo?->lote?->nombre ?? 'Lote La Esperanza' }}
                    </span>
                </div>
                <div class="text-stone-500">
                    Última sincronización: <strong class="text-stone-700">{{ $fechaMedicion }}</strong>
                    <span class="ml-2 px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 font-medium">Batería: {{ $sensorActivo?->bateria_porcentaje ?? 95 }}%</span>
                </div>
            </div>

            <!-- B. Diseño de la Pantalla: Las 4 Tarjetas de Medición Principales -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- 1. Humedad del Suelo -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-stone-500 uppercase tracking-wider">Sensor de Humedad</span>
                            <span class="w-8 h-8 rounded-xl bg-blue-50 text-[#316194] flex items-center justify-center font-bold">💧</span>
                        </div>
                        <div class="mt-4 flex items-baseline gap-2">
                            <span class="text-4xl font-extrabold text-[#316194]">{{ number_format($humedadVal, 1) }}%</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-stone-100">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $colorBadge }}">
                            Estado: {{ $estadoHum }}
                        </span>
                    </div>
                </div>

                <!-- 2. Humedad Relativa (Aire) -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-stone-500 uppercase tracking-wider">Humedad Relativa</span>
                            <span class="w-8 h-8 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center font-bold">💨</span>
                        </div>
                        <div class="mt-4">
                            <span class="text-4xl font-extrabold text-stone-900">{{ number_format($humAireVal, 1) }}%</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-stone-100 text-xs text-stone-500">
                        Adecuada para macollamiento y embuche
                    </div>
                </div>

                <!-- 3. Temperatura Ambiente -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-stone-500 uppercase tracking-wider">Temperatura</span>
                            <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold">🌡️</span>
                        </div>
                        <div class="mt-4">
                            <span class="text-4xl font-extrabold text-[#D2A736]">{{ number_format($tempVal, 1) }} °C</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-stone-100 text-xs text-stone-500">
                        Zona térmica Saldaña - Valle del Magdalena
                    </div>
                </div>

                <!-- 4. pH del Suelo -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-stone-500 uppercase tracking-wider">pH del Suelo</span>
                            <span class="w-8 h-8 rounded-xl bg-emerald-50 text-[#2B503A] flex items-center justify-center font-bold">🧪</span>
                        </div>
                        <div class="mt-4">
                            <span class="text-4xl font-extrabold text-[#2B503A]">{{ number_format($phVal, 2) }}</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-stone-100 text-xs text-stone-500">
                        Rango óptimo para absorción de nutrientes (6.0 - 7.0)
                    </div>
                </div>

            </div>

            <!-- C. Gráficas de Telemetría (Chart.js de Humedad 24h y Temperatura) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Gráfica 1: Humedad del Suelo (24 Horas) -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-extrabold text-base text-stone-900">Historial de Humedad del Suelo (%)</h3>
                            <p class="text-xs text-stone-500">Variación en las últimas 24 horas</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-blue-50 text-[#316194] text-xs font-bold">Sensor Capacitivo</span>
                    </div>

                    <div class="h-64 relative">
                        <canvas id="chartHumedadSuelo"></canvas>
                    </div>
                </div>

                <!-- Gráfica 2: Temperatura y Humedad del Aire -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-extrabold text-base text-stone-900">Temperatura y pH durante el día</h3>
                            <p class="text-xs text-stone-500">Monitoreo de estrés térmico y condiciones edáficas</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-amber-50 text-[#92400e] text-xs font-bold">Ambiente & Suelo</span>
                    </div>

                    <div class="h-64 relative">
                        <canvas id="chartTemperatura"></canvas>
                    </div>
                </div>

            </div>

            <!-- Historial de Mediciones en Tabla -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-extrabold text-lg text-stone-900">Historial de Mediciones Recientes</h3>
                        <p class="text-xs text-stone-500">Registros capturados por el microcontrolador NodeMCU</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-stone-50 text-stone-600 uppercase text-[10px] font-bold border-b border-stone-200">
                            <tr>
                                <th class="p-3">Fecha y Hora</th>
                                <th class="p-3">Humedad Suelo</th>
                                <th class="p-3">Temperatura</th>
                                <th class="p-3">H. Aire</th>
                                <th class="p-3">pH</th>
                                <th class="p-3">Estado</th>
                                <th class="p-3">Origen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse ($historial as $med)
                                <tr class="hover:bg-stone-50/60">
                                    <td class="p-3 font-semibold text-stone-800">{{ \Carbon\Carbon::parse($med->created_at)->format('d/m/Y H:i:s') }}</td>
                                    <td class="p-3 font-bold text-[#316194]">{{ number_format($med->humedad_suelo, 1) }} %</td>
                                    <td class="p-3 font-semibold text-stone-800">{{ number_format($med->temperatura, 1) }} °C</td>
                                    <td class="p-3 text-stone-600">{{ number_format($med->humedad_aire, 1) }} %</td>
                                    <td class="p-3 font-semibold text-[#2B503A]">{{ number_format($med->ph, 2) }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $med->humedad_suelo < 50 ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-800' }}">
                                            {{ $med->estado_humedad }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-stone-400 font-mono text-[10px]">{{ $med->origen }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-stone-500">No hay mediciones registradas aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Script de Inicialización de Chart.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.Chart === 'undefined') return;

            const labels = @json($chartLabels);
            const humSueloData = @json($chartHumedadSuelo);
            const tempData = @json($chartTemperatura);
            const phData = @json($chartPh);

            // 1. Gráfica de Humedad del Suelo
            const ctxHumedad = document.getElementById('chartHumedadSuelo');
            if (ctxHumedad) {
                new window.Chart(ctxHumedad, {
                    type: 'line',
                    data: {
                        labels: labels.length ? labels : ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'],
                        datasets: [{
                            label: 'Humedad Suelo (%)',
                            data: humSueloData.length ? humSueloData : [65, 66, 68, 70, 69, 68],
                            borderColor: '#316194',
                            backgroundColor: 'rgba(49, 97, 148, 0.12)',
                            fill: true,
                            tension: 0.35,
                            borderWidth: 2.5,
                            pointRadius: 4,
                            pointBackgroundColor: '#316194'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                min: 40,
                                max: 100,
                                ticks: { callback: v => v + '%' }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }

            // 2. Gráfica de Temperatura
            const ctxTemp = document.getElementById('chartTemperatura');
            if (ctxTemp) {
                new window.Chart(ctxTemp, {
                    type: 'line',
                    data: {
                        labels: labels.length ? labels : ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'],
                        datasets: [
                            {
                                label: 'Temperatura (°C)',
                                data: tempData.length ? tempData : [24, 26, 31, 32, 29, 28],
                                borderColor: '#D2A736',
                                backgroundColor: 'rgba(210, 167, 54, 0.1)',
                                tension: 0.35,
                                borderWidth: 2,
                                yAxisID: 'y'
                            },
                            {
                                label: 'pH del Suelo',
                                data: phData.length ? phData : [6.4, 6.4, 6.5, 6.5, 6.5, 6.5],
                                borderColor: '#2B503A',
                                borderDash: [5, 5],
                                tension: 0.2,
                                borderWidth: 2,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                position: 'left',
                                title: { display: true, text: '°C' }
                            },
                            y1: {
                                position: 'right',
                                min: 5,
                                max: 8,
                                grid: { drawOnChartArea: false },
                                title: { display: true, text: 'pH' }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>