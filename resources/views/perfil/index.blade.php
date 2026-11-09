<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-extrabold text-2xl text-[#1A1C1A] leading-tight flex items-center gap-2">
                    <span>🧑‍🌾</span> Perfil del Agricultor
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Información del productor, estadísticas de campo y administración de cuenta</p>
            </div>
            <a href="{{ route('configuracion.index') }}"
               class="px-4 py-2 rounded-xl bg-white border border-stone-200 text-stone-700 hover:text-[#2B503A] text-xs font-bold transition flex items-center gap-1.5 shadow-xs">
                <span>🛡️</span> Blindaje & Seguridad
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8"
             x-data="{ tab: 'datos' }">

            <!-- Tarjeta de Encabezado de Perfil (Don Alberto García style) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-stone-200/80 flex flex-col md:flex-row items-center gap-6">
                <!-- Avatar -->
                <div class="relative shrink-0">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}"
                             class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover border-4 border-[#2B503A]/20 shadow-md">
                    @else
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-[#2B503A] text-white text-3xl sm:text-4xl font-extrabold flex items-center justify-center border-4 border-emerald-100 shadow-md uppercase">
                            {{ mb_substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    <span class="absolute bottom-1 right-1 w-6 h-6 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-white text-[10px]" title="Agricultor verificado">
                        ✓
                    </span>
                </div>

                <!-- Datos Principales -->
                <div class="flex-grow text-center md:text-left space-y-2">
                    <div class="flex flex-col md:flex-row md:items-center gap-2">
                        <h2 class="text-2xl font-extrabold text-[#1A1C1A]">{{ $user->name }}</h2>
                        <span class="inline-block px-3 py-0.5 rounded-full text-xs font-bold bg-[#EBF2ED] text-[#2B503A] self-center md:self-auto uppercase">
                            {{ $user->rol ?? 'Agricultor' }}
                        </span>
                    </div>

                    <p class="text-xs sm:text-sm text-stone-600">
                        📍 {{ $user->municipio ?? 'Saldaña' }}, {{ $user->departamento ?? 'Tolima' }}
                        @if ($user->vereda)
                            · Vereda {{ $user->vereda }}
                        @endif
                    </p>

                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs text-stone-500 pt-1">
                        <span>✉️ {{ $user->email }}</span>
                        @if ($user->telefono)
                            <span>📞 {{ $user->telefono }}</span>
                        @endif
                        <span>📅 Miembro desde: <strong>{{ $user->created_at->format('M Y') }}</strong></span>
                    </div>
                </div>

                <!-- Botón de Cerrar Sesión -->
                <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2.5 rounded-xl border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 font-bold text-xs transition">
                        Cerrar sesión
                    </button>
                </form>
            </div>

            <!-- Estadísticas Personales del Productor -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 text-center">
                    <span class="text-xs text-stone-500 block uppercase font-bold">Cultivos Activos</span>
                    <span class="text-3xl font-extrabold text-[#2B503A] mt-1 block">{{ $stats['cultivos_activos'] }}</span>
                    <span class="text-[10px] text-stone-400">En seguimiento</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 text-center">
                    <span class="text-xs text-stone-500 block uppercase font-bold">Total Lotes</span>
                    <span class="text-3xl font-extrabold text-[#316194] mt-1 block">{{ $stats['total_cultivos'] }}</span>
                    <span class="text-[10px] text-stone-400">Registrados</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 text-center">
                    <span class="text-xs text-stone-500 block uppercase font-bold">Publicaciones</span>
                    <span class="text-3xl font-extrabold text-[#6B338A] mt-1 block">{{ $stats['publicaciones'] }}</span>
                    <span class="text-[10px] text-stone-400">En la comunidad</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 text-center">
                    <span class="text-xs text-stone-500 block uppercase font-bold">Servicios</span>
                    <span class="text-3xl font-extrabold text-[#D2A736] mt-1 block">{{ $stats['servicios'] }}</span>
                    <span class="text-[10px] text-stone-400">Ofrecidos</span>
                </div>
            </div>

            <!-- Selector de Pestañas -->
            <div class="flex items-center gap-2 border-b border-stone-200 pb-2 text-xs font-bold overflow-x-auto">
                <button type="button" @click="tab = 'datos'"
                        class="px-4 py-2 rounded-xl transition"
                        :class="tab === 'datos' ? 'bg-[#2B503A] text-white shadow-xs' : 'text-stone-600 hover:bg-stone-100'">
                    ✏️ Datos Personales
                </button>
                <button type="button" @click="tab = 'cultivos'"
                        class="px-4 py-2 rounded-xl transition"
                        :class="tab === 'cultivos' ? 'bg-[#2B503A] text-white shadow-xs' : 'text-stone-600 hover:bg-stone-100'">
                    🌾 Mis Cultivos ({{ $misCultivos->count() }})
                </button>
                <button type="button" @click="tab = 'publicaciones'"
                        class="px-4 py-2 rounded-xl transition"
                        :class="tab === 'publicaciones' ? 'bg-[#2B503A] text-white shadow-xs' : 'text-stone-600 hover:bg-stone-100'">
                    👥 Mis Publicaciones ({{ $misPublicaciones->count() }})
                </button>
                <button type="button" @click="tab = 'servicios'"
                        class="px-4 py-2 rounded-xl transition"
                        :class="tab === 'servicios' ? 'bg-[#2B503A] text-white shadow-xs' : 'text-stone-600 hover:bg-stone-100'">
                    🚜 Mis Servicios ({{ $misServicios->count() }})
                </button>
            </div>

            <!-- Contenido Pestaña 1: Editar Datos Personales -->
            <div x-show="tab === 'datos'" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-stone-200/80 space-y-6">
                <div>
                    <h3 class="font-extrabold text-lg text-stone-900">Editar Información del Agricultor</h3>
                    <p class="text-xs text-stone-500">Mantén actualizados tus datos de ubicación para conectarte con agricultores cercanos</p>
                </div>

                <form method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase">Nombre completo *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#2B503A] focus:ring-[#2B503A]/30">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-stone-700 uppercase">Correo electrónico</label>
                            <input type="email" value="{{ $user->email }}" disabled
                                   class="mt-1 block w-full rounded-xl border border-stone-200 bg-stone-100 px-4 py-2.5 text-sm text-stone-500 cursor-not-allowed">
                            <span class="text-[10px] text-stone-400">El correo está vinculado a tu seguridad criptográfica.</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 uppercase">Teléfono de contacto / WhatsApp</label>
                            <input type="tel" name="telefono" value="{{ old('telefono', $user->telefono) }}" placeholder="312 456 7890"
                                   class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#2B503A] focus:ring-[#2B503A]/30">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-stone-700 uppercase">Departamento</label>
                            <input type="text" name="departamento" value="{{ old('departamento', $user->departamento ?? 'Tolima') }}"
                                   class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#2B503A] focus:ring-[#2B503A]/30">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 uppercase">Municipio</label>
                            <input type="text" name="municipio" value="{{ old('municipio', $user->municipio ?? 'Saldaña') }}"
                                   class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#2B503A] focus:ring-[#2B503A]/30">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-stone-700 uppercase">Vereda</label>
                            <input type="text" name="vereda" value="{{ old('vereda', $user->vereda) }}" placeholder="Ej. Camao Arriba"
                                   class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#2B503A] focus:ring-[#2B503A]/30">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 uppercase">Dirección / Finca</label>
                            <input type="text" name="direccion" value="{{ old('direccion', $user->direccion) }}" placeholder="Ej. Km 4 Vía a Purificación"
                                   class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#2B503A] focus:ring-[#2B503A]/30">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase">Actualizar foto de perfil (avatar)</label>
                        <input type="file" name="avatar" accept="image/*"
                               class="mt-1 block w-full text-xs text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#EBF2ED] file:text-[#2B503A] hover:file:bg-[#d5e6d9]">
                    </div>

                    <div class="pt-4 flex items-center justify-between">
                        <a href="{{ route('configuracion.index') }}" class="text-xs font-bold text-[#2B503A] hover:underline flex items-center gap-1">
                            <span>🔑</span> Cambiar contraseña y ver códigos de blindaje
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-[#2B503A] text-white font-bold text-xs hover:bg-[#1E3728] shadow-sm transition">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contenido Pestaña 2: Mis Cultivos -->
            <div x-show="tab === 'cultivos'" x-cloak class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-stone-100">
                    <h3 class="font-extrabold text-lg text-stone-900">Mis Cultivos Registrados</h3>
                    <a href="{{ route('cultivos.index') }}" class="text-xs font-bold text-[#2B503A] hover:underline">Gestionar en Mi Cultivo &rarr;</a>
                </div>

                <div class="divide-y divide-stone-100">
                    @forelse ($misCultivos as $c)
                        <div class="py-3 flex items-center justify-between text-xs">
                            <div>
                                <h4 class="font-bold text-sm text-stone-900">{{ $c->nombre_cultivo }}</h4>
                                <p class="text-stone-500">Variedad {{ $c->variedad_nombre }} · {{ $c->area_sembrada }} ha · Etapa: <strong>{{ $c->etapa_actual }}</strong> ({{ $c->progreso_porcentaje }}%)</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">{{ $c->estado }}</span>
                        </div>
                    @empty
                        <p class="py-6 text-center text-xs text-stone-500">No tienes cultivos registrados.</p>
                    @endforelse
                </div>
            </div>

            <!-- Contenido Pestaña 3: Mis Publicaciones -->
            <div x-show="tab === 'publicaciones'" x-cloak class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-stone-100">
                    <h3 class="font-extrabold text-lg text-stone-900">Mis Preguntas y Publicaciones</h3>
                    <a href="{{ route('comunidad.index') }}" class="text-xs font-bold text-[#6B338A] hover:underline">Ir a la Comunidad &rarr;</a>
                </div>

                <div class="divide-y divide-stone-100">
                    @forelse ($misPublicaciones as $p)
                        <div class="py-3 flex items-center justify-between text-xs">
                            <div>
                                <h4 class="font-bold text-sm text-stone-900">{{ $p->titulo }}</h4>
                                <p class="text-stone-500">{{ $p->categoria }} · {{ $p->created_at->format('d/m/Y') }} · ❤️ {{ $p->likes_count }} likes</p>
                            </div>
                            <form method="POST" action="{{ route('comunidad.destroy', $p) }}" onsubmit="return confirm('¿Eliminar publicación?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-bold hover:underline">Eliminar</button>
                            </form>
                        </div>
                    @empty
                        <p class="py-6 text-center text-xs text-stone-500">No has publicado aún en la comunidad.</p>
                    @endforelse
                </div>
            </div>

            <!-- Contenido Pestaña 4: Mis Servicios -->
            <div x-show="tab === 'servicios'" x-cloak class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-stone-100">
                    <h3 class="font-extrabold text-lg text-stone-900">Mis Servicios Agrícolas Ofrecidos</h3>
                    <a href="{{ route('servicios.index') }}" class="text-xs font-bold text-[#D2A736] hover:underline">Ir al Mercado &rarr;</a>
                </div>

                <div class="divide-y divide-stone-100">
                    @forelse ($misServicios as $s)
                        <div class="py-3 flex items-center justify-between text-xs">
                            <div>
                                <h4 class="font-bold text-sm text-stone-900">{{ $s->titulo }}</h4>
                                <p class="text-stone-500">{{ $s->categoria }} · ${{ number_format($s->precio, 0, ',', '.') }} {{ $s->unidad_precio }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $s->disponible ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-100 text-stone-600' }}">
                                {{ $s->disponible ? 'Disponible' : 'Pausado' }}
                            </span>
                        </div>
                    @empty
                        <p class="py-6 text-center text-xs text-stone-500">No tienes servicios publicados en el mercado.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
