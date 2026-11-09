<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-extrabold text-2xl text-[#1A1C1A] leading-tight flex items-center gap-2">
                <span>📖</span> Guía Técnica del Cultivo de Arroz
            </h1>
            <p class="text-xs text-stone-500 mt-0.5">Biblioteca agronómica estructurada por etapas: preparación, siembra, riego, fertilización, plagas y cosecha</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Consejo de la Semana Destacado -->
            @if ($consejoSemanal)
                <div class="rounded-3xl p-6 sm:p-7 text-white shadow-md relative overflow-hidden"
                     style="background: linear-gradient(135deg, #2B503A 0%, #436851 60%, #D2A736 150%);">
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-amber-200 text-xs font-bold backdrop-blur-sm">
                                <span>💡</span> CONSEJO AGRONÓMICO DE LA SEMANA
                            </span>
                            <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight">{{ $consejoSemanal->titulo }}</h2>
                            <p class="text-xs sm:text-sm text-green-100 max-w-3xl leading-relaxed">{{ $consejoSemanal->consejo }}</p>
                            <p class="text-xs text-amber-200 font-semibold pt-1">— {{ $consejoSemanal->autor }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filtro por Etapas y Buscador -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-stone-200/80 space-y-3">
                <form method="GET" action="{{ route('guia.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <input type="text" name="q" value="{{ $busqueda }}"
                               placeholder="Buscar en la guía por tema: nivelación, sogata, pyricularia, urea, riego..."
                               class="w-full rounded-xl border border-stone-300 px-4 py-2.5 pl-10 text-xs sm:text-sm focus:border-[#436851] focus:ring-[#436851]/30">
                        <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                    </div>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-[#2B503A] text-white text-xs font-bold hover:bg-[#1E3728] transition">
                        Buscar
                    </button>
                    @if ($busqueda || $etapaSeleccionada)
                        <a href="{{ route('guia.index') }}"
                           class="px-4 py-2.5 rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 text-xs font-bold text-center">
                            Ver todas
                        </a>
                    @endif
                </form>

                <!-- Píldoras de las 6 Etapas Principales -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 pt-1 scrollbar-none text-xs">
                    <a href="{{ route('guia.index', ['q' => $busqueda]) }}"
                       class="px-3.5 py-1.5 rounded-full shrink-0 font-bold transition {{ empty($etapaSeleccionada) ? 'bg-[#2B503A] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                        Todas las etapas
                    </a>
                    @foreach ($etapas as $etapa)
                        <a href="{{ route('guia.index', ['etapa' => $etapa, 'q' => $busqueda]) }}"
                           class="px-3.5 py-1.5 rounded-full shrink-0 font-semibold transition {{ $etapaSeleccionada === $etapa ? 'bg-[#2B503A] text-white font-bold' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                            {{ $etapa }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Listado de Artículos / Guías -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($guias as $guia)
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 flex flex-col justify-between space-y-4 hover:shadow-md hover:border-[#436851] transition group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="w-10 h-10 rounded-2xl bg-[#EBF2ED] text-[#2B503A] flex items-center justify-center text-xl group-hover:scale-110 transition">
                                    {{ $guia->icono ?? '🌾' }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full bg-[#EBF2ED] text-[#2B503A] font-bold text-[11px]">
                                    {{ $guia->etapa }}
                                </span>
                            </div>

                            <h3 class="font-extrabold text-base text-stone-900 group-hover:text-[#2B503A] transition leading-snug">
                                {{ $guia->titulo }}
                            </h3>

                            <p class="text-xs text-stone-600 leading-relaxed line-clamp-3">
                                {{ $guia->resumen }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-stone-100 flex items-center justify-between text-xs">
                            <span class="text-stone-400 font-medium">Recomendaciones técnicas</span>
                            <a href="{{ route('guia.show', $guia) }}"
                               class="font-bold text-[#2B503A] hover:underline flex items-center gap-1">
                                Leer guía completa
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 text-center bg-white rounded-3xl border border-stone-200">
                        <div class="text-4xl mb-3">📖</div>
                        <h3 class="font-bold text-stone-800 text-base">No se encontraron artículos</h3>
                        <p class="text-xs text-stone-500 max-w-md mx-auto mt-1">Intenta con otra palabra clave o selecciona una de las 6 etapas del cultivo.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
