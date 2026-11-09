<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear cuenta · ArrozConecta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-[#FBF9F6] text-[#1A1C1A]">
<div class="min-h-screen grid lg:grid-cols-2">

    <!-- Lado Izquierdo Institucional -->
    <div class="hidden lg:flex flex-col justify-between p-12 text-white"
         style="background: linear-gradient(135deg, #2B503A 0%, #436851 55%, #D2A736 150%);">

        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center backdrop-blur-sm border border-white/20">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V9m0 0c0-3 2-5 5-5 0 3-2 5-5 5Zm0 4c0-3-2-5-5-5 0 3 2 5 5 5Zm0 4c0-3 2-5 5-5 0 3-2 5-5 5Z"/>
                </svg>
            </div>
            <div>
                <span class="text-2xl font-bold tracking-tight">ArrozConecta</span>
                <span class="block text-xs text-amber-200">Plataforma Integral Arrocera</span>
            </div>
        </div>

        <div class="space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 text-amber-200 text-xs font-semibold backdrop-blur-sm border border-white/10">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                Registro para Agricultores y Productores
            </div>
            <h1 class="text-4xl font-extrabold leading-tight">
                Únete a la comunidad<br>arrocera más grande<br>de la región.
            </h1>
            <p class="text-green-100 max-w-md text-base leading-relaxed">
                Registra tus fincas y lotes, recibe alertas inteligentes de riego y fertilización, monitorea la humedad con sensores IoT y conecta con otros productores.
            </p>

            <ul class="space-y-3 text-green-50 text-sm">
                <li class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#D2A736]"></span> Registro personalizado por departamento y vereda
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#D2A736]"></span> Monitoreo y cálculo agronómico de etapas fenológicas
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#D2A736]"></span> Protección y tratamiento de datos (Ley 1581 de 2012)
                </li>
            </ul>
        </div>

        <div class="text-xs text-green-200 flex items-center justify-between">
            <p>© {{ date('Y') }} ArrozConecta · Saldaña, Tolima</p>
            <span class="text-amber-200 font-medium">Versión Final 2026</span>
        </div>
    </div>

    <!-- Lado Derecho: Formulario de Registro -->
    <div class="flex items-center justify-center p-6 sm:p-12 overflow-y-auto">
        <div class="w-full max-w-lg py-6"
             x-data="{
                 ver: false,
                 clave: '',
                 modalPolitica: false,
                 deptosData: {{ Js::from($departamentos ?? []) }},
                 departamentoSeleccionado: '{{ old('departamento', 'Tolima') }}',
                 municipiosDisponibles: [],
                 init() {
                     this.actualizarMunicipios();
                 },
                 actualizarMunicipios() {
                     const depto = this.deptosData.find(d => d.nombre === this.departamentoSeleccionado);
                     this.municipiosDisponibles = depto ? depto.municipios : [];
                 },
                 get largo() { return this.clave.length >= 8 },
                 get minus() { return /[a-z]/.test(this.clave) },
                 get mayus() { return /[A-Z]/.test(this.clave) },
                 get numero() { return /[0-9]/.test(this.clave) },
                 get simbolo() { return /[^A-Za-z0-9]/.test(this.clave) }
             }">

            <div class="lg:hidden mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#2B503A] text-white flex items-center justify-center">🌾</div>
                <span class="text-2xl font-bold text-[#2B503A]">ArrozConecta</span>
            </div>

            <h2 class="text-3xl font-extrabold text-[#1A1C1A]">Crea tu cuenta de agricultor</h2>
            <p class="mt-2 text-stone-600 text-sm">Completa tus datos para empezar a administrar tus cultivos y conectar con la comunidad.</p>

            @if ($errors->any())
                <div class="mt-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    <p class="font-semibold mb-1">Por favor verifica los campos:</p>
                    <ul class="list-disc list-inside space-y-0.5 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                @csrf

                <!-- Nombre Completo -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-stone-700">Nombre completo <span class="text-red-500">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           required autofocus autocomplete="name" placeholder="Ej. Alberto García"
                           class="mt-1 block w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-stone-900 placeholder-stone-400 focus:border-[#436851] focus:outline-none focus:ring-2 focus:ring-[#436851]/30">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Correo y Teléfono en dos columnas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-stone-700">Correo electrónico <span class="text-red-500">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autocomplete="username" placeholder="productor@arroz.com"
                               class="mt-1 block w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-stone-900 placeholder-stone-400 focus:border-[#436851] focus:outline-none focus:ring-2 focus:ring-[#436851]/30">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-semibold text-stone-700">Teléfono / WhatsApp <span class="text-red-500">*</span></label>
                        <input id="telefono" type="tel" name="telefono" value="{{ old('telefono') }}"
                               required placeholder="312 456 7890"
                               class="mt-1 block w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-stone-900 placeholder-stone-400 focus:border-[#436851] focus:outline-none focus:ring-2 focus:ring-[#436851]/30">
                        @error('telefono')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Departamento y Municipio dinámicos -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="departamento" class="block text-sm font-semibold text-stone-700">Departamento <span class="text-red-500">*</span></label>
                        <select id="departamento" name="departamento" required
                                x-model="departamentoSeleccionado"
                                @change="actualizarMunicipios()"
                                class="mt-1 block w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-stone-900 focus:border-[#436851] focus:outline-none focus:ring-2 focus:ring-[#436851]/30">
                            @foreach ($departamentos ?? [] as $dep)
                                <option value="{{ $dep->nombre }}">{{ $dep->nombre }}</option>
                            @endforeach
                            @if(empty($departamentos) || count($departamentos) === 0)
                                <option value="Tolima">Tolima</option>
                                <option value="Huila">Huila</option>
                                <option value="Casanare">Casanare</option>
                                <option value="Meta">Meta</option>
                            @endif
                        </select>
                        @error('departamento')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="municipio" class="block text-sm font-semibold text-stone-700">Municipio <span class="text-red-500">*</span></label>
                        <select id="municipio" name="municipio" required
                                class="mt-1 block w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-stone-900 focus:border-[#436851] focus:outline-none focus:ring-2 focus:ring-[#436851]/30">
                            <template x-for="muni in municipiosDisponibles" :key="muni.id">
                                <option :value="muni.nombre" x-text="muni.nombre"></option>
                            </template>
                            @if(empty($departamentos) || count($departamentos) === 0)
                                <option value="Saldaña">Saldaña</option>
                                <option value="El Espinal">El Espinal</option>
                                <option value="Purificación">Purificación</option>
                                <option value="Campoalegre">Campoalegre</option>
                            @endif
                        </select>
                        @error('municipio')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Vereda y Dirección -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="vereda" class="block text-sm font-semibold text-stone-700">Vereda</label>
                        <input id="vereda" type="text" name="vereda" value="{{ old('vereda') }}"
                               placeholder="Ej. Camao Arriba"
                               class="mt-1 block w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-stone-900 placeholder-stone-400 focus:border-[#436851] focus:outline-none focus:ring-2 focus:ring-[#436851]/30">
                    </div>

                    <div>
                        <label for="direccion" class="block text-sm font-semibold text-stone-700">Ubicación / Finca principal</label>
                        <input id="direccion" type="text" name="direccion" value="{{ old('direccion') }}"
                               placeholder="Ej. Km 4 Vía a Purificación"
                               class="mt-1 block w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-stone-900 placeholder-stone-400 focus:border-[#436851] focus:outline-none focus:ring-2 focus:ring-[#436851]/30">
                    </div>
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-stone-700">Contraseña <span class="text-red-500">*</span></label>
                    <div class="relative mt-1">
                        <input id="password" name="password" required autocomplete="new-password"
                               x-model="clave" :type="ver ? 'text' : 'password'" placeholder="••••••••"
                               class="block w-full rounded-xl border border-stone-300 bg-white px-4 py-3 pr-20 text-stone-900 placeholder-stone-400 focus:border-[#436851] focus:outline-none focus:ring-2 focus:ring-[#436851]/30">
                        <button type="button" @click="ver = !ver"
                                class="absolute inset-y-0 right-0 px-4 text-xs font-semibold text-[#2B503A] hover:text-[#436851]"
                                x-text="ver ? 'Ocultar' : 'Mostrar'"></button>
                    </div>

                    <ul class="mt-2 grid grid-cols-2 sm:grid-cols-3 gap-1.5 text-xs">
                        <li :class="largo ? 'text-[#2B503A] font-semibold' : 'text-stone-400'"><span x-text="largo ? '✓' : '○'"></span> Mínimo 8 caracteres</li>
                        <li :class="mayus ? 'text-[#2B503A] font-semibold' : 'text-stone-400'"><span x-text="mayus ? '✓' : '○'"></span> Una mayúscula</li>
                        <li :class="minus ? 'text-[#2B503A] font-semibold' : 'text-stone-400'"><span x-text="minus ? '✓' : '○'"></span> Una minúscula</li>
                        <li :class="numero ? 'text-[#2B503A] font-semibold' : 'text-stone-400'"><span x-text="numero ? '✓' : '○'"></span> Un número</li>
                        <li :class="simbolo ? 'text-[#2B503A] font-semibold' : 'text-stone-400'"><span x-text="simbolo ? '✓' : '○'"></span> Un símbolo (!@#)</li>
                    </ul>

                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-stone-700">Confirmar contraseña <span class="text-red-500">*</span></label>
                    <input id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                           :type="ver ? 'text' : 'password'" placeholder="••••••••"
                           class="mt-1 block w-full rounded-xl border border-stone-300 bg-white px-4 py-3 text-stone-900 placeholder-stone-400 focus:border-[#436851] focus:outline-none focus:ring-2 focus:ring-[#436851]/30">
                    @error('password_confirmation')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Política de Tratamiento de Datos (Ley 1581 de 2012) -->
                <div class="pt-2">
                    <label class="flex items-start gap-3 p-3 rounded-xl border border-stone-200 bg-stone-50 cursor-pointer hover:bg-stone-100 transition">
                        <input type="checkbox" name="politica_datos" value="1" required
                               class="mt-1 rounded border-stone-300 text-[#2B503A] focus:ring-[#436851] w-4 h-4">
                        <div class="text-xs text-stone-700 leading-snug">
                            Autorizo de manera libre, previa y voluntaria el tratamiento de mis datos personales de acuerdo con la <strong>Ley 1581 de 2012</strong> de la República de Colombia y la
                            <button type="button" @click.prevent="modalPolitica = true" class="text-[#2B503A] font-bold underline hover:text-[#436851]">
                                Política de Privacidad de ArrozConecta
                            </button>.
                        </div>
                    </label>
                    @error('politica_datos')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botón de Envío -->
                <button type="submit"
                        class="w-full rounded-xl bg-[#2B503A] hover:bg-[#1E3728] text-white py-3.5 px-6 font-bold shadow-md hover:shadow-lg transition-all text-base focus:outline-none focus:ring-4 focus:ring-[#436851]/40 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Completar registro
                </button>
            </form>

            <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-xs text-amber-900 flex items-start gap-3">
                <span class="text-xl">🛡️</span>
                <div>
                    <strong>Blindaje de cuenta:</strong> Al crear tu cuenta se activarán los códigos de seguridad de un solo uso para proteger el acceso a tus fincas y monitoreo IoT.
                </div>
            </div>

            <p class="mt-6 text-center text-sm text-stone-600">
                ¿Ya tienes una cuenta registrada?
                <a href="{{ route('login') }}" class="font-bold text-[#2B503A] hover:text-[#436851] underline">Inicia sesión</a>
            </p>

            <!-- Modal de Política de Privacidad y Tratamiento de Datos (Ley 1581 de 2012) -->
            <div x-show="modalPolitica"
                 x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
                 @keydown.escape.window="modalPolitica = false">
                <div class="bg-white rounded-2xl max-w-lg w-full max-h-[85vh] flex flex-col shadow-2xl border border-stone-200 overflow-hidden"
                     @click.away="modalPolitica = false">
                    <div class="p-5 border-b border-stone-200 bg-[#FBF9F6] flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">📜</span>
                            <h3 class="font-bold text-lg text-stone-900">Política de Datos (Ley 1581 de 2012)</h3>
                        </div>
                        <button type="button" @click="modalPolitica = false" class="text-stone-400 hover:text-stone-700 text-xl font-bold">&times;</button>
                    </div>

                    <div class="p-6 overflow-y-auto text-xs text-stone-700 space-y-3 leading-relaxed">
                        <p class="font-semibold text-stone-900">ArrozConecta informa a todos los productores y usuarios:</p>
                        <p>En cumplimiento de la <strong>Ley Estatutaria 1581 de 2012</strong> y su Decreto Reglamentario 1377 de 2013, los datos personales suministrados en esta plataforma serán recolectados, almacenados, utilizados y puestos en circulación para:</p>
                        <ul class="list-disc list-inside space-y-1 pl-2">
                            <li>Identificación y contacto del agricultor para soporte técnico y alertas del cultivo.</li>
                            <li>Georreferenciación de fincas, lotes y distritos de riego (Saldaña, Coello, Huila, etc.).</li>
                            <li>Vinculación con dispositivos de monitoreo IoT (sensores de humedad, temperatura y pH).</li>
                            <li>Publicación y contacto voluntario en los módulos de Comunidad y Servicios Agrícolas.</li>
                        </ul>
                        <p><strong>Derechos del Titular (Habeas Data):</strong> Como titular de sus datos, usted tiene derecho a conocer, actualizar, rectificar y suprimir sus datos en cualquier momento desde la sección "Mi Perfil" o comunicándose con el administrador de ArrozConecta.</p>
                        <p class="p-3 bg-green-50 rounded-lg text-green-900 font-medium">Sus contraseñas se almacenan mediante algoritmos criptográficos unidireccionales seguros y no se comparten con terceras entidades sin autorización expresa.</p>
                    </div>

                    <div class="p-4 border-t border-stone-200 bg-stone-50 flex justify-end">
                        <button type="button" @click="modalPolitica = false"
                                class="px-5 py-2.5 rounded-xl bg-[#2B503A] text-white text-xs font-bold hover:bg-[#1E3728]">
                            He leído y comprendido
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>