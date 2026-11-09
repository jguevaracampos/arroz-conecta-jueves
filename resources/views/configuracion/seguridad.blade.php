<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-stone-800 leading-tight">
                    {{ __('Configuración & Seguridad') }}
                </h2>
                <p class="text-xs text-stone-500 mt-1">
                    Framework &rarr; Blindaje - Hardening (Estilo Proton)
                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                <span class="w-2 h-2 rounded-full bg-green-600 animate-pulse"></span>
                Escudo Activo
            </span>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- SECCIÓN 1: Restablecer contraseña --}}
            <div class="bg-white shadow-sm border border-stone-200 sm:rounded-2xl overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-green-800 via-green-600 to-amber-500"></div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        <header class="flex items-start gap-3">
                            <div class="w-10 h-10 shrink-0 rounded-xl bg-green-100 text-green-700 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-stone-900">{{ __('Restablecer Contraseña') }}</h2>
                                <p class="mt-1 text-sm text-stone-500">
                                    {{ __('Asegúrate de que tu cuenta utilice una contraseña larga y aleatoria para mantener la seguridad.') }}
                                </p>
                            </div>
                        </header>

                        @if (session('status_password'))
                            <div class="mt-5 p-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ session('status_password') }}
                            </div>
                        @endif

                        <form method="post" action="{{ route('seguridad.password') }}" class="mt-6 space-y-5">
                            @csrf
                            @method('put')

                            <div>
                                <x-input-label for="current_password" :value="__('Contraseña Actual')" />
                                <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full focus:border-green-600 focus:ring-green-600" autocomplete="current-password" required />
                                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Nueva Contraseña')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full focus:border-green-600 focus:ring-green-600" autocomplete="new-password" required />
                                <p class="mt-1 text-xs text-stone-400">Mínimo 8 caracteres, con mayúscula, minúscula, número y símbolo.</p>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full focus:border-green-600 focus:ring-green-600" autocomplete="new-password" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 bg-green-700 rounded-lg font-semibold text-sm text-white shadow-sm hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition">
                                {{ __('Actualizar Contraseña') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 2: Recovery code -> generar *(6 códigos) + Archivo --}}
            <div class="bg-white shadow-sm border border-stone-200 sm:rounded-2xl overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-amber-500 via-green-600 to-green-800"></div>
                <div class="p-6 sm:p-8">
                    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 shrink-0 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-stone-900">{{ __('Códigos de Recuperación (Recovery Codes)') }}</h2>
                                <p class="mt-1 text-sm text-stone-500">
                                    {{ __('Blindaje de acceso: genera 6 códigos de emergencia de un solo uso para recuperar tu cuenta.') }}
                                </p>
                            </div>
                        </div>

                        {{-- Botón: generar 6 códigos --}}
                        <form method="post" action="{{ route('seguridad.codes.generate') }}" class="shrink-0">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('¿Estás seguro de generar 6 nuevos códigos de recuperación? Los códigos anteriores quedarán invalidados de inmediato.');"
                                    class="inline-flex items-center px-4 py-2.5 bg-green-700 rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition">
                                <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                {{ __('Generar *(6 códigos)') }}
                            </button>
                        </form>
                    </header>

                    @if (session('status_codes'))
                        <div class="mt-5 p-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ session('status_codes') }}
                        </div>
                    @endif

                    @if (session('error_codes'))
                        <div class="mt-5 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">
                            {{ session('error_codes') }}
                        </div>
                    @endif

                    {{-- RECUADRO DE LA PIZARRA: Archivo y contenedor de códigos --}}
                    @if (!empty($plainCodes))
                        <div class="mt-6 border-2 border-dashed border-green-500 bg-green-50/60 rounded-2xl p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 mb-4 border-b border-green-200 gap-3">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-green-200 text-green-900 uppercase tracking-wide">
                                            {{ __('Archivo de Recuperación Activo') }}
                                        </span>
                                        <span class="text-xs text-green-700 font-medium">(6 códigos únicos generados)</span>
                                    </div>
                                    <p class="text-xs text-amber-800 font-semibold mt-2">
                                        ⚠️ Guarda estos códigos ahora. Al cerrar esta sesión no se volverán a mostrar en texto plano.
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="copiarCodigos()"
                                            class="inline-flex items-center px-3 py-2 bg-white border border-stone-300 rounded-lg text-xs font-medium text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 shadow-sm transition">
                                        <svg class="w-3.5 h-3.5 me-1 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        <span id="btn-copiar-texto">{{ __('Copiar') }}</span>
                                    </button>

                                    {{-- ARCHIVO -> descargar --}}
                                    <a href="{{ route('seguridad.codes.download') }}"
                                       class="inline-flex items-center px-3.5 py-2 bg-amber-500 rounded-lg text-xs font-semibold text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 shadow-sm transition">
                                        <svg class="w-3.5 h-3.5 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        {{ __('Archivo (.txt)') }}
                                    </a>
                                </div>
                            </div>

                            <div id="contenedor-codigos" class="grid grid-cols-2 md:grid-cols-3 gap-3 font-mono">
                                @foreach ($plainCodes as $index => $code)
                                    <div class="bg-white border-2 border-green-300 rounded-xl p-3 text-center shadow-sm hover:border-green-600 transition">
                                        <span class="text-xs text-green-600 block font-sans font-bold">#{{ $index + 1 }}</span>
                                        <span class="text-base font-black tracking-widest text-green-950 select-all">{{ $code }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-6 border-2 border-dashed border-stone-300 rounded-2xl p-8 text-center bg-stone-50/60">
                            @if ($hasCodes)
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 text-green-700 mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-stone-800">
                                    {{ __('Blindaje Activo: Códigos de recuperación configurados') }}
                                </h3>
                                <p class="text-xs text-stone-500 mt-1 max-w-md mx-auto">
                                    Tienes {{ $activeCodesCount }} de 6 códigos disponibles y seguros. Si perdiste tu archivo o sospechas que fueron comprometidos, haz clic en <strong>"Generar *(6 códigos)"</strong> para reemplazarlos.
                                </p>
                            @else
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 text-amber-700 mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-stone-800">
                                    {{ __('No tienes códigos de recuperación generados') }}
                                </h3>
                                <p class="text-xs text-stone-500 mt-1 max-w-md mx-auto">
                                    Haz clic arriba en <strong>"Generar *(6 códigos)"</strong> para crear tu paquete de códigos de emergencia y poder descargar el archivo de respaldo.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        function copiarCodigos() {
            const spans = document.querySelectorAll('#contenedor-codigos span.select-all');
            const codigos = Array.from(spans).map(span => span.textContent.trim()).join('\n');

            navigator.clipboard.writeText(codigos).then(() => {
                const btnTexto = document.getElementById('btn-copiar-texto');
                const original = btnTexto.textContent;
                btnTexto.textContent = '¡Copiado!';
                setTimeout(() => { btnTexto.textContent = original; }, 2000);
            }).catch(() => {
                alert('No se pudo copiar automáticamente. Por favor selecciónalos manualmente.');
            });
        }
    </script>
</x-app-layout>