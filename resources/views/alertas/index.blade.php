<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-extrabold text-2xl text-[#1A1C1A] leading-tight flex items-center gap-2">
                    <span>🔔</span> Alertas y Notificaciones del Cultivo
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Avisos oportunos de fertilización, turnos de riego, monitoreo de humedad y labores agronómicas</p>
            </div>

            <form method="POST" action="{{ route('alertas.marcar-todas') }}">
                @csrf
                <button type="submit"
                        class="px-4 py-2 rounded-xl bg-white border border-stone-200 text-stone-700 hover:text-[#2B503A] text-xs font-bold transition shadow-xs">
                    Marcar todas como leídas
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @forelse ($notificaciones as $notif)
                @php
                    $icono = '🔔';
                    $bgIcon = 'bg-stone-100 text-stone-700';
                    if ($notif->tipo === 'fertilizacion') {
                        $icono = '🌾';
                        $bgIcon = 'bg-amber-100 text-amber-800';
                    } elseif ($notif->tipo === 'riego') {
                        $icono = '💧';
                        $bgIcon = 'bg-sky-100 text-sky-800';
                    } elseif ($notif->tipo === 'humedad') {
                        $icono = '⚠️';
                        $bgIcon = 'bg-red-100 text-red-800';
                    } elseif ($notif->tipo === 'cosecha') {
                        $icono = '📦';
                        $bgIcon = 'bg-emerald-100 text-emerald-800';
                    }
                @endphp
                <div class="bg-white rounded-3xl p-5 shadow-sm border transition flex flex-col sm:flex-row sm:items-center justify-between gap-4 {{ $notif->leida ? 'border-stone-200/60 opacity-80' : 'border-[#436851] bg-[#FBF9F6]' }}">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl {{ $bgIcon }} flex items-center justify-center text-xl shrink-0">
                            {{ $icono }}
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-sm text-stone-900">{{ $notif->titulo }}</h3>
                                @if (! $notif->leida)
                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse" title="No leída"></span>
                                @endif
                            </div>
                            <p class="text-xs text-stone-600 leading-relaxed">{{ $notif->mensaje }}</p>
                            <div class="flex items-center gap-3 text-[11px] text-stone-400 pt-1">
                                <span>📅 {{ $notif->created_at->diffForHumans() }}</span>
                                @if ($notif->cultivo)
                                    <span>· Cultivo: <strong>{{ $notif->cultivo->nombre_cultivo }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                        @if (! $notif->leida)
                            <form method="POST" action="{{ route('alertas.marcar-leida', $notif) }}">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 rounded-xl border border-stone-200 text-stone-700 hover:bg-stone-50 text-xs font-semibold">
                                    Marcar leída
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('alertas.destroy', $notif) }}" onsubmit="return confirm('¿Eliminar esta alerta?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-stone-400 hover:text-red-600 text-xs">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center bg-white rounded-3xl border border-stone-200">
                    <div class="text-4xl mb-3">🔔</div>
                    <h3 class="font-bold text-stone-800 text-base">No tienes alertas pendientes</h3>
                    <p class="text-xs text-stone-500 max-w-md mx-auto mt-1">El sistema generará recordatorios automáticos según las fechas de siembra y mediciones de humedad de tus sensores IoT.</p>
                </div>
            @endforelse

            <div class="pt-2">
                {{ $notificaciones->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
