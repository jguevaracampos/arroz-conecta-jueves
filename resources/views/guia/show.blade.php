<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('guia.index') }}"
                   class="p-2 rounded-xl bg-white border border-stone-200 text-stone-600 hover:text-stone-900 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                </a>
                <div>
                    <span class="text-xs font-bold text-[#2B503A] uppercase tracking-wider">{{ $guia->etapa }}</span>
                    <h1 class="font-extrabold text-xl text-stone-900">{{ $guia->titulo }}</h1>
                </div>
            </div>
            <a href="{{ route('guia.index') }}" class="text-xs font-bold text-stone-500 hover:text-stone-800">
                &larr; Volver a la guía
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-stone-200/80 space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-stone-100">
                    <span class="text-3xl">{{ $guia->icono ?? '🌾' }}</span>
                    <div>
                        <span class="px-3 py-1 rounded-full bg-[#EBF2ED] text-[#2B503A] font-bold text-xs">
                            Etapa: {{ $guia->etapa }}
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-stone-900 mt-2">{{ $guia->titulo }}</h2>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-sm font-medium leading-relaxed">
                    <strong>Resumen agronómico:</strong> {{ $guia->resumen }}
                </div>

                <!-- Contenido Principal -->
                <div class="text-sm text-stone-800 leading-relaxed space-y-4 whitespace-pre-line font-normal">
                    {{ $guia->contenido }}
                </div>

                <!-- Consejos Clave -->
                @if ($guia->consejos_clave)
                    <div class="p-5 rounded-2xl bg-[#FBF9F6] border border-stone-200 space-y-2">
                        <h3 class="font-bold text-sm text-[#2B503A] flex items-center gap-2">
                            <span>✅</span> Recomendaciones Clave de Campo
                        </h3>
                        <p class="text-xs text-stone-700 whitespace-pre-line leading-relaxed">
                            {{ $guia->consejos_clave }}
                        </p>
                    </div>
                @endif
            </div>

            <!-- Guías Relacionadas -->
            @if ($guiasRelacionadas->isNotEmpty())
                <div>
                    <h3 class="font-extrabold text-lg text-stone-900 mb-4">Otras etapas del cultivo</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach ($guiasRelacionadas as $rel)
                            <a href="{{ route('guia.show', $rel) }}"
                               class="bg-white p-4 rounded-2xl border border-stone-200/80 hover:border-[#436851] transition block space-y-1">
                                <span class="text-xs font-bold text-[#2B503A]">{{ $rel->etapa }}</span>
                                <h4 class="font-bold text-sm text-stone-900 line-clamp-1">{{ $rel->titulo }}</h4>
                                <p class="text-[11px] text-stone-500 line-clamp-2">{{ $rel->resumen }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
