<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-extrabold text-2xl text-[#1A1C1A] leading-tight flex items-center gap-2">
                    <span>🚜</span> Mercado de Servicios Agrícolas
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Alquiler de tractores, fumigación con dron, transporte a molinos y mano de obra arrocera</p>
            </div>

            <div x-data="{ modalServicio: false }">
                <button type="button" @click="modalServicio = true"
                        class="px-4 py-2.5 rounded-xl bg-[#D2A736] text-white hover:bg-[#b8912b] text-xs font-bold transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span>Publicar un servicio</span>
                </button>

                <!-- Modal Publicar Servicio -->
                <div x-show="modalServicio" x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
                     @keydown.escape.window="modalServicio = false">
                    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-stone-200 overflow-y-auto max-h-[90vh]"
                         @click.away="modalServicio = false">
                        <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                            <h3 class="font-bold text-lg text-stone-900 flex items-center gap-2">
                                <span>🚜</span> Publicar Servicio Agrícola
                            </h3>
                            <button type="button" @click="modalServicio = false" class="text-stone-400 hover:text-stone-700 text-2xl font-bold">&times;</button>
                        </div>

                        <form method="POST" action="{{ route('servicios.store') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Nombre / Título del servicio *</label>
                                <input type="text" name="titulo" required placeholder="Ej. Alquiler de Tractor John Deere con rastra"
                                       class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Categoría *</label>
                                <select name="categoria" required
                                        class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30">
                                    @foreach ($categorias as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Descripción detallada *</label>
                                <textarea name="descripcion" rows="3" required
                                          placeholder="Especificaciones de maquinaria, potencia, implementos, experiencia del operario..."
                                          class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Precio (COP)</label>
                                    <input type="number" step="1000" name="precio" placeholder="Ej. 140000"
                                           class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Unidad de cobro *</label>
                                    <select name="unidad_precio" required
                                            class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30">
                                        <option value="por hora">Por hora</option>
                                        <option value="por hectárea">Por hectárea</option>
                                        <option value="por viaje">Por viaje</option>
                                        <option value="por día">Por día</option>
                                        <option value="a convenir">A convenir</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Departamento *</label>
                                    <input type="text" name="departamento" required value="Tolima"
                                           class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Municipio *</label>
                                    <input type="text" name="municipio" required value="Saldaña"
                                           class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">Teléfono de contacto *</label>
                                    <input type="tel" name="contacto_telefono" required value="{{ Auth::user()->telefono ?? '3124567890' }}"
                                           class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-stone-700 uppercase">WhatsApp</label>
                                    <input type="tel" name="contacto_whatsapp" placeholder="3124567890" value="{{ Auth::user()->telefono ?? '' }}"
                                           class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Foto de la maquinaria / servicio (opcional)</label>
                                <input type="file" name="imagen" accept="image/*"
                                       class="mt-1 block w-full text-xs text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-[#92400e] hover:file:bg-amber-100">
                            </div>

                            <div class="pt-3 flex justify-end gap-2">
                                <button type="button" @click="modalServicio = false"
                                        class="px-4 py-2.5 rounded-xl border border-stone-300 text-stone-600 text-xs font-bold hover:bg-stone-100">
                                    Cancelar
                                </button>
                                <button type="submit"
                                        class="px-5 py-2.5 rounded-xl bg-[#2B503A] text-white text-xs font-bold hover:bg-[#1E3728] shadow-sm">
                                    Publicar Servicio
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Barra de Filtros y Búsqueda -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-stone-200/80 space-y-3">
                <form method="GET" action="{{ route('servicios.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                    <div class="sm:col-span-6 relative">
                        <input type="text" name="q" value="{{ $busqueda }}"
                               placeholder="Buscar por tractor, dron, camión o servicio..."
                               class="w-full rounded-xl border border-stone-300 px-4 py-2.5 pl-10 text-xs sm:text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30">
                        <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                    </div>

                    <div class="sm:col-span-3">
                        <select name="municipio"
                                class="w-full rounded-xl border border-stone-300 px-3 py-2.5 text-xs sm:text-sm focus:border-[#D2A736] focus:ring-[#D2A736]/30">
                            <option value="">Todos los municipios</option>
                            <option value="Saldaña" {{ $municipioSeleccionado === 'Saldaña' ? 'selected' : '' }}>Saldaña</option>
                            <option value="El Espinal" {{ $municipioSeleccionado === 'El Espinal' ? 'selected' : '' }}>El Espinal</option>
                            <option value="Purificación" {{ $municipioSeleccionado === 'Purificación' ? 'selected' : '' }}>Purificación</option>
                            <option value="Campoalegre" {{ $municipioSeleccionado === 'Campoalegre' ? 'selected' : '' }}>Campoalegre</option>
                            <option value="Ibagué" {{ $municipioSeleccionado === 'Ibagué' ? 'selected' : '' }}>Ibagué</option>
                        </select>
                    </div>

                    <div class="sm:col-span-3 flex gap-2">
                        <button type="submit"
                                class="flex-grow px-4 py-2.5 rounded-xl bg-[#2B503A] text-white text-xs font-bold hover:bg-[#1E3728] transition">
                            Filtrar
                        </button>
                        @if ($busqueda || $categoriaSeleccionada || $municipioSeleccionado)
                            <a href="{{ route('servicios.index') }}"
                               class="px-3 py-2.5 rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 text-xs font-bold flex items-center justify-center">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Píldoras de Categorías -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 pt-1 scrollbar-none text-xs">
                    <a href="{{ route('servicios.index', ['municipio' => $municipioSeleccionado, 'q' => $busqueda]) }}"
                       class="px-3 py-1.5 rounded-full shrink-0 font-bold transition {{ empty($categoriaSeleccionada) ? 'bg-[#D2A736] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                        Todos
                    </a>
                    @foreach ($categorias as $cat)
                        <a href="{{ route('servicios.index', ['categoria' => $cat, 'municipio' => $municipioSeleccionado, 'q' => $busqueda]) }}"
                           class="px-3 py-1.5 rounded-full shrink-0 font-semibold transition {{ $categoriaSeleccionada === $cat ? 'bg-[#D2A736] text-white font-bold' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Listado de Servicios Disponibles (Tarjetas) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($servicios as $servicio)
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 flex flex-col justify-between space-y-4 hover:shadow-md transition">
                        <div>
                            <!-- Header de la tarjeta -->
                            <div class="flex items-start justify-between gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-[#92400e] border border-amber-200">
                                    {{ $servicio->categoria }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $servicio->disponible ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-500' }}">
                                    {{ $servicio->disponible ? 'Disponible' : 'No disponible' }}
                                </span>
                            </div>

                            <h3 class="font-extrabold text-base text-stone-900 mt-3 leading-snug">
                                {{ $servicio->titulo }}
                            </h3>

                            <p class="text-xs text-stone-600 mt-2 line-clamp-3 leading-relaxed">
                                {{ $servicio->descripcion }}
                            </p>

                            <!-- Precio y Ubicación -->
                            <div class="mt-4 p-3 rounded-2xl bg-[#FBF9F6] border border-stone-200 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-stone-400 block uppercase font-bold">Tarifa</span>
                                    @if ($servicio->precio)
                                        <span class="font-extrabold text-base text-[#2B503A]">
                                            ${{ number_format($servicio->precio, 0, ',', '.') }}
                                        </span>
                                        <span class="text-[10px] text-stone-500 font-medium">/ {{ $servicio->unidad_precio }}</span>
                                    @else
                                        <span class="font-bold text-xs text-stone-700">A convenir</span>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-stone-400 block uppercase font-bold">Ubicación</span>
                                    <span class="text-xs font-semibold text-stone-700">📍 {{ $servicio->municipio }}</span>
                                </div>
                            </div>

                            <!-- Proveedor -->
                            <div class="mt-3 flex items-center gap-2 text-xs text-stone-500">
                                <span class="w-6 h-6 rounded-full bg-[#2B503A] text-white text-[10px] font-bold flex items-center justify-center">
                                    {{ mb_substr($servicio->user->name, 0, 1) }}
                                </span>
                                <span>Publicado por <strong>{{ $servicio->user->name }}</strong></span>
                            </div>
                        </div>

                        <!-- Botones de Contacto Directo -->
                        <div class="pt-3 border-t border-stone-100 flex items-center gap-2">
                            <!-- WhatsApp -->
                            @php
                                $msgWhatsapp = urlencode("Hola, vi tu servicio de '{$servicio->titulo}' en ArrozConecta y me gustaría consultar disponibilidad.");
                            @endphp
                            <a href="https://wa.me/{{ $servicio->contacto_whatsapp }}?text={{ $msgWhatsapp }}" target="_blank"
                               class="flex-1 py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs text-center flex items-center justify-center gap-1.5 shadow-xs transition">
                                <span>💬</span>
                                <span>WhatsApp</span>
                            </a>

                            <!-- Llamada telefónica -->
                            <a href="tel:{{ $servicio->contacto_telefono }}"
                               class="py-2.5 px-3 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-800 font-bold text-xs flex items-center justify-center gap-1 transition"
                               title="Llamar al proveedor">
                                <span>📞</span>
                                <span>Llamar</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 text-center bg-white rounded-3xl border border-stone-200">
                        <div class="text-4xl mb-3">🚜</div>
                        <h3 class="font-bold text-stone-800 text-base">No hay servicios que coincidan</h3>
                        <p class="text-xs text-stone-500 max-w-md mx-auto mt-1">Prueba seleccionando otro municipio o categoría, o sé el primero en publicar tu maquinaria.</p>
                    </div>
                @endforelse
            </div>

            <div class="pt-2">
                {{ $servicios->links() }}
            </div>

            <!-- Sección D: Mis Servicios Publicados (Gestión personal) -->
            @if ($misServicios->isNotEmpty())
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-4">
                    <h2 class="font-extrabold text-lg text-stone-900">Mis Servicios Publicados</h2>
                    <div class="divide-y divide-stone-100">
                        @foreach ($misServicios as $miServicio)
                            <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                                <div>
                                    <h4 class="font-bold text-sm text-stone-900">{{ $miServicio->titulo }}</h4>
                                    <p class="text-stone-500">{{ $miServicio->categoria }} · {{ $miServicio->municipio }} · ${{ number_format($miServicio->precio, 0, ',', '.') }} {{ $miServicio->unidad_precio }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('servicios.toggle', $miServicio) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg border border-stone-300 font-semibold text-stone-700 hover:bg-stone-50">
                                            {{ $miServicio->disponible ? 'Pausar servicio' : 'Activar servicio' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('servicios.destroy', $miServicio) }}" onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 font-bold hover:bg-red-100">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
