<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-extrabold text-2xl text-[#1A1C1A] leading-tight flex items-center gap-2">
                    <span>⚙️</span> Panel de Administración ArrozConecta
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Control general de agricultores, moderación de comunidad y configuración territorial</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold uppercase">
                Modo Administrador
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Métricas Globales del Sistema -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 text-center shadow-xs">
                    <span class="text-xs text-stone-500 block uppercase font-bold">Total Usuarios</span>
                    <span class="text-3xl font-extrabold text-[#2B503A] mt-1 block">{{ $totalUsuarios }}</span>
                    <span class="text-[10px] text-stone-400">Agricultores registrados</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 text-center shadow-xs">
                    <span class="text-xs text-stone-500 block uppercase font-bold">Cultivos en Seguimiento</span>
                    <span class="text-3xl font-extrabold text-[#316194] mt-1 block">{{ $totalCultivos }}</span>
                    <span class="text-[10px] text-stone-400">Lotes activos</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 text-center shadow-xs">
                    <span class="text-xs text-stone-500 block uppercase font-bold">Comunidad</span>
                    <span class="text-3xl font-extrabold text-[#6B338A] mt-1 block">{{ $totalPublicaciones }}</span>
                    <span class="text-[10px] text-stone-400">Publicaciones</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-stone-200/80 text-center shadow-xs">
                    <span class="text-xs text-stone-500 block uppercase font-bold">Mercado</span>
                    <span class="text-3xl font-extrabold text-[#D2A736] mt-1 block">{{ $totalServicios }}</span>
                    <span class="text-[10px] text-stone-400">Servicios publicados</span>
                </div>
            </div>

            <!-- Publicaciones Reportadas (Moderación de Contenido) -->
            @if ($publicacionesReportadas->isNotEmpty())
                <div class="bg-red-50 rounded-3xl p-6 border border-red-200 space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">🚩</span>
                        <h3 class="font-extrabold text-base text-red-900">Publicaciones Reportadas por la Comunidad</h3>
                    </div>

                    <div class="divide-y divide-red-200/60 bg-white rounded-2xl p-4 border border-red-200">
                        @foreach ($publicacionesReportadas as $rep)
                            <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                                <div>
                                    <h4 class="font-bold text-sm text-stone-900">{{ $rep->titulo }}</h4>
                                    <p class="text-stone-600 line-clamp-1">{{ $rep->contenido }}</p>
                                    <span class="text-[10px] text-stone-400">Autor: {{ $rep->user->name }} · {{ $rep->categoria }}</span>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <form method="POST" action="{{ route('admin.publicaciones.descartar', $rep) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg border border-stone-300 font-semibold text-stone-700 hover:bg-stone-50">
                                            Descartar reporte
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('comunidad.destroy', $rep) }}" onsubmit="return confirm('¿Eliminar definitivamente esta publicación?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600 text-white font-bold hover:bg-red-700">
                                            Eliminar publicación
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tabla de Usuarios y Asignación de Roles -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-extrabold text-lg text-stone-900">Gestión de Usuarios y Perfiles</h3>
                        <p class="text-xs text-stone-500">Administrador, Agricultor y Técnico Agrícola</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-stone-50 text-stone-600 uppercase text-[10px] font-bold border-b border-stone-200">
                            <tr>
                                <th class="p-3">Nombre</th>
                                <th class="p-3">Correo</th>
                                <th class="p-3">Teléfono</th>
                                <th class="p-3">Ubicación</th>
                                <th class="p-3">Rol Actual</th>
                                <th class="p-3 text-right">Modificar Rol</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @foreach ($usuarios as $u)
                                <tr class="hover:bg-stone-50/60">
                                    <td class="p-3 font-bold text-stone-900 flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-full bg-[#2B503A] text-white text-[10px] font-bold flex items-center justify-center">
                                            {{ mb_substr($u->name, 0, 1) }}
                                        </span>
                                        {{ $u->name }}
                                    </td>
                                    <td class="p-3 text-stone-600">{{ $u->email }}</td>
                                    <td class="p-3 text-stone-600">{{ $u->telefono ?? 'Sin teléfono' }}</td>
                                    <td class="p-3 text-stone-600">{{ $u->municipio ?? 'Saldaña' }}, {{ $u->departamento ?? 'Tolima' }}</td>
                                    <td class="p-3">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $u->rol === 'administrador' ? 'bg-red-100 text-red-800' : ($u->rol === 'tecnico' ? 'bg-sky-100 text-sky-800' : 'bg-emerald-100 text-emerald-800') }}">
                                            {{ $u->rol ?? 'agricultor' }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-right">
                                        <form method="POST" action="{{ route('admin.usuarios.rol', $u) }}" class="inline-flex items-center gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <select name="rol" onchange="this.form.submit()"
                                                    class="rounded-lg border border-stone-300 py-1 px-2 text-[11px] focus:ring-[#2B503A]">
                                                <option value="agricultor" {{ $u->rol === 'agricultor' ? 'selected' : '' }}>Agricultor</option>
                                                <option value="tecnico" {{ $u->rol === 'tecnico' ? 'selected' : '' }}>Técnico agrícola</option>
                                                <option value="administrador" {{ $u->rol === 'administrador' ? 'selected' : '' }}>Administrador</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pt-2">
                    {{ $usuarios->links() }}
                </div>
            </div>

            <!-- Variedades y Departamentos Registrados -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Variedades -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-3">
                    <h3 class="font-extrabold text-base text-stone-900">Variedades de Arroz Registradas</h3>
                    <div class="divide-y divide-stone-100 text-xs">
                        @foreach ($variedades as $var)
                            <div class="py-2.5 flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-stone-900">{{ $var->nombre }}</span>
                                    <p class="text-[11px] text-stone-500">{{ $var->dias_ciclo }} días de ciclo estimado</p>
                                </div>
                                <span class="font-bold text-[#2B503A]">{{ $var->rendimiento_estimado_ton }} ton/ha</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Departamentos -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-3">
                    <h3 class="font-extrabold text-base text-stone-900">Cobertura Territorial Arrocera</h3>
                    <div class="divide-y divide-stone-100 text-xs">
                        @foreach ($departamentos as $dep)
                            <div class="py-2.5 flex justify-between items-center">
                                <span class="font-bold text-stone-900">{{ $dep->nombre }}</span>
                                <span class="text-stone-500">{{ $dep->municipios_count }} municipios vinculados</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
