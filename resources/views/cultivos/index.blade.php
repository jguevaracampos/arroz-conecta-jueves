<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-extrabold text-2xl text-[#1A1C1A] leading-tight">
                    Mi Cultivo
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Administra tus fincas, lotes, variedades de arroz y seguimiento fenológico</p>
            </div>

            <!-- Botones de Acción Rápida: Modal Finca y Modal Lote -->
            <div class="flex items-center gap-2" x-data="{ modalFinca: false, modalLote: false }">
                <button type="button" @click="modalFinca = true"
                        class="px-4 py-2.5 rounded-xl bg-white border border-stone-200 text-stone-700 hover:text-[#2B503A] hover:bg-stone-50 text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                    <span>🏡</span> Nueva Finca
                </button>
                <button type="button" @click="modalLote = true"
                        class="px-4 py-2.5 rounded-xl bg-[#2B503A] text-white hover:bg-[#1E3728] text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                    <span>🌾</span> Nuevo Lote
                </button>

                <!-- Modal Nueva Finca -->
                <div x-show="modalFinca" x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
                     @keydown.escape.window="modalFinca = false">
                    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-stone-200 overflow-y-auto max-h-[90vh]"
                         @click.away="modalFinca = false">
                        <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                            <h3 class="font-bold text-lg text-stone-900 flex items-center gap-2">
                                <span>🏡</span> Registrar Nueva Finca
                            </h3>
                            <button type="button" @click="modalFinca = false" class="text-stone-400 hover:text-stone-700 text-2xl font-bold">&times;</button>
                        </div>

                        <form method="POST" action="{{ route('fincas.store') }}" class="mt-5 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Nombre de la Finca *</label>
                                <input type="text" name="nombre" required placeholder="Ej. Finca La Esperanza"
                                       class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Departamento *</label>
                                    <input type="text" name="departamento" required value="Tolima"
                                           class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Municipio *</label>
                                    <input type="text" name="municipio" required value="Saldaña"
                                           class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Vereda</label>
                                    <input type="text" name="vereda" placeholder="Ej. Camao Arriba"
                                           class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Área Total (Hectáreas) *</label>
                                    <input type="number" step="0.1" name="area_total" required placeholder="Ej. 15.5"
                                           class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Dirección / Ubicación</label>
                                <input type="text" name="direccion" placeholder="Ej. Km 4 Vía Saldaña - Purificación"
                                       class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Propietario / Administrador</label>
                                <input type="text" name="propietario" value="{{ Auth::user()->name }}"
                                       class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                            </div>

                            <div class="pt-3 flex justify-end gap-2">
                                <button type="button" @click="modalFinca = false"
                                        class="px-4 py-2.5 rounded-xl border border-stone-300 text-stone-600 text-xs font-bold hover:bg-stone-100">
                                    Cancelar
                                </button>
                                <button type="submit"
                                        class="px-5 py-2.5 rounded-xl bg-[#2B503A] text-white text-xs font-bold hover:bg-[#1E3728] shadow-sm">
                                    Guardar Finca
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Nuevo Lote -->
                <div x-show="modalLote" x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
                     @keydown.escape.window="modalLote = false">
                    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-stone-200 overflow-y-auto max-h-[90vh]"
                         @click.away="modalLote = false">
                        <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                            <h3 class="font-bold text-lg text-stone-900 flex items-center gap-2">
                                <span>🌾</span> Registrar Nuevo Lote
                            </h3>
                            <button type="button" @click="modalLote = false" class="text-stone-400 hover:text-stone-700 text-2xl font-bold">&times;</button>
                        </div>

                        @if ($fincas->isEmpty())
                            <div class="mt-4 p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900">
                                ⚠️ Primero debes registrar al menos una <strong>finca</strong> antes de agregar lotes.
                            </div>
                        @else
                            <form method="POST" action="{{ route('lotes.store') }}" class="mt-5 space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Finca a la que pertenece *</label>
                                    <select name="finca_id" required
                                            class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                        @foreach ($fincas as $f)
                                            <option value="{{ $f->id }}">{{ $f->nombre }} ({{ $f->municipio }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Nombre del Lote *</label>
                                    <input type="text" name="nombre" required placeholder="Ej. Lote La Esperanza"
                                           class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-stone-700 uppercase">Área (Hectáreas) *</label>
                                        <input type="number" step="0.1" name="area_hectareas" required placeholder="Ej. 5.0"
                                               class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-stone-700 uppercase">Tipo de Arroz *</label>
                                        <select name="tipo_arroz" required
                                                class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                            <option value="Riego">Riego (Por gravedad/bombeo)</option>
                                            <option value="Secano">Secano favorecido</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-stone-700 uppercase">Variedad de Arroz</label>
                                        <select name="variedad_arroz_id"
                                                class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                            <option value="">-- Seleccionar --</option>
                                            @foreach ($variedades as $var)
                                                <option value="{{ $var->id }}">{{ $var->nombre }} ({{ $var->dias_ciclo }} días)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-stone-700 uppercase">Fecha de Siembra</label>
                                        <input type="date" name="fecha_siembra"
                                               class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Estado del Cultivo *</label>
                                    <select name="estado" required
                                            class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                                        <option value="Activo">Activo (En crecimiento)</option>
                                        <option value="En preparación">En preparación (Batido/Nivelación)</option>
                                        <option value="Cosechado">Cosechado</option>
                                        <option value="En descanso">En descanso / Barbecho</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Notas / Observaciones</label>
                                    <textarea name="notas" rows="2" placeholder="Observaciones de nivelación, compuertas o historial..."
                                              class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#436851] focus:ring-[#436851]/30"></textarea>
                                </div>

                                <div class="pt-3 flex justify-end gap-2">
                                    <button type="button" @click="modalLote = false"
                                            class="px-4 py-2.5 rounded-xl border border-stone-300 text-stone-600 text-xs font-bold hover:bg-stone-100">
                                        Cancelar
                                    </button>
                                    <button type="submit"
                                            class="px-5 py-2.5 rounded-xl bg-[#2B503A] text-white text-xs font-bold hover:bg-[#1E3728] shadow-sm">
                                        Guardar Lote
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Sección D: Desarrollo del Cultivo Activo (Cálculos Agronómicos) -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="font-extrabold text-xl text-stone-900">Desarrollo y Etapas Fenológicas</h2>
                        <p class="text-xs text-stone-500">Días transcurridos, avance del ciclo y fechas estimadas de corte</p>
                    </div>
                </div>

                @if ($cultivos->isEmpty())
                    <div class="p-8 text-center bg-white rounded-3xl border border-stone-200">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-stone-100 text-stone-400 flex items-center justify-center text-3xl mb-3">🌾</div>
                        <h3 class="font-bold text-stone-800">No tienes cultivos activos registrados</h3>
                        <p class="text-xs text-stone-500 max-w-md mx-auto mt-1">Registra un lote con fecha de siembra activa para ver automáticamente el progreso fenológico.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($cultivos as $cultivo)
                            <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 flex flex-col justify-between space-y-5">
                                <div>
                                    <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                                        <div>
                                            <span class="text-xs text-[#2B503A] font-bold uppercase tracking-wider">{{ $cultivo->lote?->finca?->nombre ?? 'Finca' }}</span>
                                            <h3 class="font-extrabold text-lg text-stone-900">{{ $cultivo->nombre_cultivo }}</h3>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $cultivo->estado === 'Activo' ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-600' }}">
                                            {{ $cultivo->estado }}
                                        </span>
                                    </div>

                                    <!-- Estadísticas del desarrollo -->
                                    <div class="grid grid-cols-3 gap-3 my-4 p-4 rounded-2xl bg-[#FBF9F6] border border-stone-200 text-center">
                                        <div>
                                            <span class="text-[10px] text-stone-500 block uppercase font-bold">Variedad</span>
                                            <span class="font-bold text-sm text-stone-800">{{ $cultivo->variedad_nombre }}</span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-stone-500 block uppercase font-bold">Días transcurridos</span>
                                            <span class="font-extrabold text-sm text-[#2B503A]">{{ $cultivo->dias_transcurridos }} días</span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] text-stone-500 block uppercase font-bold">Etapa</span>
                                            <span class="font-extrabold text-sm text-[#D2A736]">{{ $cultivo->etapa_actual }}</span>
                                        </div>
                                    </div>

                                    <!-- Barra de Progreso -->
                                    <div class="space-y-1.5">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-stone-500 font-semibold">Progreso acumulado:</span>
                                            <span class="font-extrabold text-[#2B503A]">{{ $cultivo->progreso_porcentaje }}%</span>
                                        </div>
                                        <div class="w-full h-3.5 rounded-full bg-stone-200 p-0.5 overflow-hidden">
                                            <div class="h-full rounded-full transition-all"
                                                 style="width: {{ $cultivo->progreso_porcentaje }}%; background: linear-gradient(90deg, #436851 0%, #D2A736 100%);"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-stone-100 flex items-center justify-between text-xs text-stone-500">
                                    <div>
                                        <span class="block">Siembra: <strong>{{ \Carbon\Carbon::parse($cultivo->fecha_siembra)->format('d/m/Y') }}</strong></span>
                                        <span>Cosecha est.: <strong>{{ $cultivo->fecha_estimada_cosecha ? \Carbon\Carbon::parse($cultivo->fecha_estimada_cosecha)->format('d/m/Y') : 'Aprox. 125 días' }}</strong></span>
                                    </div>

                                    <form method="POST" action="{{ route('cultivos.destroy', $cultivo) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este registro de cultivo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-800 hover:underline">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Sección B: Listado de Lotes (Tabla Ejemplo del Documento) -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2">
                    <div>
                        <h2 class="font-extrabold text-xl text-stone-900">Tabla de Lotes Registrados</h2>
                        <p class="text-xs text-stone-500">Cada finca cuenta con lotes independientes para rotación y siembra</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200 uppercase text-[11px]">
                            <tr>
                                <th class="p-3.5">Lote</th>
                                <th class="p-3.5">Finca</th>
                                <th class="p-3.5">Variedad</th>
                                <th class="p-3.5">Área</th>
                                <th class="p-3.5">Tipo</th>
                                <th class="p-3.5">Fecha Siembra</th>
                                <th class="p-3.5">Estado</th>
                                <th class="p-3.5 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse ($lotes as $lote)
                                <tr class="hover:bg-stone-50/60 transition">
                                    <td class="p-3.5 font-bold text-stone-900 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-[#436851]"></span>
                                        {{ $lote->nombre }}
                                    </td>
                                    <td class="p-3.5 text-stone-600">{{ $lote->finca->nombre ?? 'N/A' }}</td>
                                    <td class="p-3.5 font-semibold text-[#2B503A]">{{ $lote->variedad_nombre ?: ($lote->variedad?->nombre ?? 'Sin asignar') }}</td>
                                    <td class="p-3.5 font-bold text-stone-800">{{ $lote->area_hectareas }} ha</td>
                                    <td class="p-3.5 text-stone-600">{{ $lote->tipo_arroz }}</td>
                                    <td class="p-3.5 text-stone-600">
                                        {{ $lote->fecha_siembra ? \Carbon\Carbon::parse($lote->fecha_siembra)->format('d/m/Y') : 'Pendiente' }}
                                    </td>
                                    <td class="p-3.5">
                                        @if ($lote->estado === 'Activo')
                                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Activo</span>
                                        @elseif ($lote->estado === 'En preparación')
                                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">En preparación</span>
                                        @elseif ($lote->estado === 'Cosechado')
                                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800">Cosechado</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-stone-100 text-stone-700">{{ $lote->estado }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-right">
                                        <form method="POST" action="{{ route('lotes.destroy', $lote) }}" onsubmit="return confirm('¿Seguro de eliminar este lote?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-6 text-center text-stone-500">
                                        No hay lotes registrados aún. Haz clic en "Nuevo Lote" para comenzar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sección A: Fincas Registradas -->
            <div>
                <h2 class="font-extrabold text-xl text-stone-900 mb-4">Mis Fincas Registradas</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($fincas as $finca)
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                                    <h3 class="font-extrabold text-base text-stone-900 flex items-center gap-2">
                                        <span>🏡</span> {{ $finca->nombre }}
                                    </h3>
                                    <span class="text-xs font-bold text-[#2B503A] bg-[#EBF2ED] px-2.5 py-0.5 rounded-full">
                                        {{ $finca->area_total }} ha
                                    </span>
                                </div>

                                <div class="mt-4 space-y-2 text-xs text-stone-600">
                                    <p><strong>Ubicación:</strong> {{ $finca->municipio }}, {{ $finca->departamento }}</p>
                                    @if ($finca->vereda)
                                        <p><strong>Vereda:</strong> {{ $finca->vereda }}</p>
                                    @endif
                                    @if ($finca->direccion)
                                        <p><strong>Dirección:</strong> {{ $finca->direccion }}</p>
                                    @endif
                                    <p><strong>Propietario:</strong> {{ $finca->propietario }}</p>
                                    <p><strong>Lotes vinculados:</strong> {{ $finca->lotes->count() }} lotes</p>
                                </div>
                            </div>

                            <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between">
                                <span class="text-[11px] text-stone-400">Registrada el {{ $finca->created_at->format('d/m/Y') }}</span>
                                <form method="POST" action="{{ route('fincas.destroy', $finca) }}" onsubmit="return confirm('¿Eliminar esta finca y todos sus lotes asociados?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-900">Eliminar finca</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full p-8 text-center bg-white rounded-3xl border border-stone-200">
                            <p class="text-sm text-stone-600">No tienes fincas registradas. Agrega tu primera finca para empezar.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
