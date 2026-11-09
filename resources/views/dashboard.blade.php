<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-extrabold text-2xl text-[#1A1C1A] leading-tight">
                    Panel Principal
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Control agronómico, sensores IoT y comunidad arrocera</p>
            </div>
            <div class="hidden sm:flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistema en línea
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. Saludo Personalizado (Banner Principal) -->
            <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 text-white shadow-lg"
                 style="background: linear-gradient(135deg, #2B503A 0%, #436851 60%, #D2A736 150%);">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-green-100 text-xs font-semibold backdrop-blur-sm">
                            <span>🌾</span> Distrito de Riego Saldaña & Tolima
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                            Hola, {{ $user->name }}
                        </h2>
                        <p class="text-green-100 max-w-xl text-sm sm:text-base leading-relaxed">
                            Bienvenido a <strong>ArrozConecta</strong>. Aquí tienes el estado en tiempo real de tus lotes, lecturas de humedad y avisos agronómicos del día.
                        </p>
                    </div>

                    <div class="flex sm:flex-col gap-2 shrink-0">
                        <a href="{{ route('cultivos.index') }}"
                           class="px-5 py-3 rounded-2xl bg-white text-[#2B503A] font-bold text-xs sm:text-sm shadow-md hover:bg-stone-100 transition text-center flex items-center justify-center gap-2">
                            <span>Gestionar lotes</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </a>
                        <a href="{{ route('monitoreo.index') }}"
                           class="px-5 py-3 rounded-2xl bg-white/20 hover:bg-white/30 text-white font-bold text-xs sm:text-sm backdrop-blur-sm transition text-center flex items-center justify-center gap-2">
                            <span>Ver sensores IoT</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Fila: Recordatorio del Día y Sensor Principal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- 2. Recordatorio del Día -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs uppercase font-extrabold text-amber-700 tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                Recordatorio del día
                            </span>
                            <span class="text-xs text-stone-400">Hoy</span>
                        </div>
                        <div class="mt-4 flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-2xl shrink-0">
                                🔔
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-stone-900 leading-snug">
                                    {{ $recordatorioDia->titulo ?? 'Mañana toca fertilización.' }}
                                </h3>
                                <p class="mt-1 text-xs text-stone-600 leading-relaxed">
                                    {{ $recordatorioDia->mensaje ?? 'Recuerda que mañana debes realizar la fertilización de tu cultivo según el plan nutricional.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between">
                        <span class="text-xs text-stone-500 font-medium">Recomendado para lote activo</span>
                        <a href="{{ route('alertas.index') }}" class="text-xs font-bold text-[#2B503A] hover:underline flex items-center gap-1">
                            Ver todas las alertas
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- 3. Sensor Principal (IoT) -->
                @php
                    $humedadVal = $ultimaMedicion?->humedad_suelo ?? 68.0;
                    $tempVal = $ultimaMedicion?->temperatura ?? 28.0;
                    $humAireVal = $ultimaMedicion?->humedad_aire ?? 75.0;
                    $phVal = $ultimaMedicion?->ph ?? 6.5;
                    $estadoHum = $humedadVal < 50 ? 'Baja - Riego requerido' : ($humedadVal > 85 ? 'Exceso' : 'Humedad adecuada');
                @endphp
                <div class="rounded-3xl p-6 text-white shadow-sm flex flex-col justify-between"
                     style="background: linear-gradient(135deg, #316194 0%, #1e3a5f 100%);">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs uppercase font-extrabold text-sky-200 tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                Sensor principal (NodeMCU ESP8266)
                            </span>
                            <span class="text-xs text-sky-200">En tiempo real</span>
                        </div>

                        <div class="mt-4 flex items-baseline justify-between">
                            <div>
                                <span class="text-xs text-sky-200 block">Humedad del suelo</span>
                                <div class="flex items-baseline gap-2 mt-1">
                                    <span class="text-5xl font-extrabold tracking-tight">{{ number_format($humedadVal, 1) }}%</span>
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                                        {{ $estadoHum }}
                                    </span>
                                </div>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center text-2xl shrink-0">
                                💧
                            </div>
                        </div>

                        <div class="mt-5 grid grid-cols-3 gap-3 pt-4 border-t border-white/15 text-xs">
                            <div>
                                <span class="text-sky-200 block text-[11px]">Temperatura</span>
                                <span class="font-bold text-sm">{{ number_format($tempVal, 1) }} °C</span>
                            </div>
                            <div>
                                <span class="text-sky-200 block text-[11px]">Humedad aire</span>
                                <span class="font-bold text-sm">{{ number_format($humAireVal, 1) }} %</span>
                            </div>
                            <div>
                                <span class="text-sky-200 block text-[11px]">pH del suelo</span>
                                <span class="font-bold text-sm">{{ number_format($phVal, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between">
                        <span class="text-xs text-sky-200">
                            {{ $sensorPrincipal?->nombre ?? 'Sensor Lote La Esperanza' }}
                        </span>
                        <a href="{{ route('monitoreo.index') }}" class="text-xs font-bold text-white underline hover:text-sky-200">
                            Consultar gráficas 24h &rarr;
                        </a>
                    </div>
                </div>

            </div>

            <!-- 4. Progreso del Cultivo -->
            @if ($cultivoPrincipal)
                <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-stone-200/80">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-stone-100">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-[#436851]/10 text-[#436851] flex items-center justify-center text-2xl font-bold">
                                🌾
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-extrabold text-lg text-stone-900">
                                        {{ $cultivoPrincipal->nombre_cultivo }}
                                    </h3>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        {{ $cultivoPrincipal->estado }}
                                    </span>
                                </div>
                                <p class="text-xs text-stone-500">
                                    Variedad: <strong class="text-stone-700">{{ $cultivoPrincipal->variedad_nombre }}</strong> ·
                                    Lote: <strong class="text-stone-700">{{ $cultivoPrincipal->lote?->nombre ?? 'Lote 1' }}</strong> ({{ $cultivoPrincipal->area_sembrada }} ha)
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6 text-right">
                            <div>
                                <span class="text-[11px] text-stone-400 block">Días transcurridos</span>
                                <span class="font-extrabold text-xl text-[#2B503A]">{{ $cultivoPrincipal->dias_transcurridos }} días</span>
                            </div>
                            <div>
                                <span class="text-[11px] text-stone-400 block">Etapa actual</span>
                                <span class="font-extrabold text-xl text-[#D2A736]">{{ $cultivoPrincipal->etapa_actual }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Barra de Progreso Agronómica -->
                    <div class="mt-5 space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-stone-600 font-semibold">Desarrollo agronómico del ciclo</span>
                            <span class="font-extrabold text-[#2B503A] text-sm">{{ $cultivoPrincipal->progreso_porcentaje }}%</span>
                        </div>
                        <div class="w-full h-4 rounded-full bg-stone-100 p-0.5 overflow-hidden border border-stone-200">
                            <div class="h-full rounded-full transition-all duration-500"
                                 style="width: {{ $cultivoPrincipal->progreso_porcentaje }}%; background: linear-gradient(90deg, #436851 0%, #D2A736 100%);"></div>
                        </div>

                        <!-- Marcadores de las 5 etapas -->
                        <div class="grid grid-cols-5 text-[10px] sm:text-xs text-center text-stone-500 pt-1">
                            <span class="{{ $cultivoPrincipal->etapa_actual === 'Germinación' ? 'font-bold text-[#2B503A]' : '' }}">1. Germinación</span>
                            <span class="{{ $cultivoPrincipal->etapa_actual === 'Macollamiento' ? 'font-bold text-[#2B503A]' : '' }}">2. Macollamiento</span>
                            <span class="{{ $cultivoPrincipal->etapa_actual === 'Embuche' ? 'font-bold text-[#2B503A]' : '' }}">3. Embuche</span>
                            <span class="{{ $cultivoPrincipal->etapa_actual === 'Floración' ? 'font-bold text-[#2B503A]' : '' }}">4. Floración</span>
                            <span class="{{ $cultivoPrincipal->etapa_actual === 'Maduración' ? 'font-bold text-[#2B503A]' : '' }}">5. Cosecha</span>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-stone-100 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-stone-500 gap-2">
                        <span>
                            📅 Siembra: <strong>{{ \Carbon\Carbon::parse($cultivoPrincipal->fecha_siembra)->format('d/m/Y') }}</strong> ·
                            Estimada Cosecha: <strong>{{ $cultivoPrincipal->fecha_estimada_cosecha ? \Carbon\Carbon::parse($cultivoPrincipal->fecha_estimada_cosecha)->format('d/m/Y') : 'En 80 días' }}</strong>
                        </span>
                        <a href="{{ route('cultivos.index') }}" class="font-bold text-[#2B503A] hover:underline">
                            Ver detalles de todos mis lotes &rarr;
                        </a>
                    </div>
                </div>
            @endif

            <!-- 5. Accesos Rápidos (Los 6 Botones del Documento) -->
            <div>
                <h3 class="font-extrabold text-lg text-stone-900 mb-4">Accesos Rápidos</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                    <!-- Botón 1: Mi cultivo -->
                    <a href="{{ route('cultivos.index') }}"
                       class="p-5 rounded-2xl bg-white border border-stone-200/80 hover:border-[#436851] hover:shadow-md transition text-center group flex flex-col items-center justify-center">
                        <div class="w-12 h-12 rounded-2xl bg-[#436851]/10 text-[#436851] flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            🌾
                        </div>
                        <h4 class="mt-3 font-bold text-sm text-stone-900">Mi cultivo</h4>
                        <p class="text-[11px] text-stone-500 mt-1">Fincas y lotes</p>
                    </a>

                    <!-- Botón 2: Humedad (Monitoreo) -->
                    <a href="{{ route('monitoreo.index') }}"
                       class="p-5 rounded-2xl bg-white border border-stone-200/80 hover:border-[#316194] hover:shadow-md transition text-center group flex flex-col items-center justify-center">
                        <div class="w-12 h-12 rounded-2xl bg-[#316194]/10 text-[#316194] flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            💧
                        </div>
                        <h4 class="mt-3 font-bold text-sm text-stone-900">Humedad</h4>
                        <p class="text-[11px] text-stone-500 mt-1">Monitoreo IoT</p>
                    </a>

                    <!-- Botón 3: Comunidad -->
                    <a href="{{ route('comunidad.index') }}"
                       class="p-5 rounded-2xl bg-white border border-stone-200/80 hover:border-[#6B338A] hover:shadow-md transition text-center group flex flex-col items-center justify-center">
                        <div class="w-12 h-12 rounded-2xl bg-[#6B338A]/10 text-[#6B338A] flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            👥
                        </div>
                        <h4 class="mt-3 font-bold text-sm text-stone-900">Comunidad</h4>
                        <p class="text-[11px] text-stone-500 mt-1">Publicaciones</p>
                    </a>

                    <!-- Botón 4: Servicios -->
                    <a href="{{ route('servicios.index') }}"
                       class="p-5 rounded-2xl bg-white border border-stone-200/80 hover:border-[#D2A736] hover:shadow-md transition text-center group flex flex-col items-center justify-center">
                        <div class="w-12 h-12 rounded-2xl bg-[#D2A736]/15 text-[#D2A736] flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            🚜
                        </div>
                        <h4 class="mt-3 font-bold text-sm text-stone-900">Servicios</h4>
                        <p class="text-[11px] text-stone-500 mt-1">Maquinaria</p>
                    </a>

                    <!-- Botón 5: Guía -->
                    <a href="{{ route('guia.index') }}"
                       class="p-5 rounded-2xl bg-white border border-stone-200/80 hover:border-[#436851] hover:shadow-md transition text-center group flex flex-col items-center justify-center">
                        <div class="w-12 h-12 rounded-2xl bg-[#436851]/10 text-[#436851] flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            📖
                        </div>
                        <h4 class="mt-3 font-bold text-sm text-stone-900">Guía</h4>
                        <p class="text-[11px] text-stone-500 mt-1">Técnica arroz</p>
                    </a>

                    <!-- Botón 6: Alertas -->
                    <a href="{{ route('alertas.index') }}"
                       class="p-5 rounded-2xl bg-white border border-stone-200/80 hover:border-amber-600 hover:shadow-md transition text-center group flex flex-col items-center justify-center">
                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            🔔
                        </div>
                        <h4 class="mt-3 font-bold text-sm text-stone-900">Alertas</h4>
                        <p class="text-[11px] text-stone-500 mt-1">{{ $conteoNotificaciones }} nuevas</p>
                    </a>

                </div>
            </div>

            <!-- Consejo de la Semana -->
            @if ($consejo)
                <div class="rounded-3xl p-6 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 shadow-xs flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-200/60 text-amber-900 flex items-center justify-center text-2xl shrink-0">
                        💡
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs uppercase font-extrabold text-amber-800 tracking-wider">Consejo de la semana</span>
                            @if ($consejo->etapa_relevante)
                                <span class="text-[11px] px-2 py-0.5 rounded-full bg-amber-200/80 text-amber-900 font-semibold">{{ $consejo->etapa_relevante }}</span>
                            @endif
                        </div>
                        <h4 class="font-bold text-base text-stone-900 mt-1">{{ $consejo->titulo }}</h4>
                        <p class="text-xs text-stone-700 mt-1 leading-relaxed">{{ $consejo->consejo }}</p>
                        <p class="text-[11px] text-stone-500 mt-2 font-medium">— {{ $consejo->autor }}</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
