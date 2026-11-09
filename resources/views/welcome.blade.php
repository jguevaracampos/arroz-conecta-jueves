<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a ArrozConecta · Comunidad & Tecnología Arrocera</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#FBF9F6] text-[#1A1C1A] font-sans antialiased selection:bg-[#D2A736] selection:text-white flex flex-col justify-between">

    <!-- Barra de Navegación Superior -->
    <header class="sticky top-0 z-40 bg-[#FBF9F6]/95 backdrop-blur-md border-b border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-[#2B503A] text-white flex items-center justify-center shadow-md shadow-[#2B503A]/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V9m0 0c0-3 2-5 5-5 0 3-2 5-5 5Zm0 4c0-3-2-5-5-5 0 3 2 5 5 5Zm0 4c0-3 2-5 5-5 0 3-2 5-5 5Z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-2xl font-extrabold tracking-tight text-[#2B503A]">Arroz<span class="text-[#6B338A]">Conecta</span></span>
                    <span class="hidden sm:block text-xs font-medium text-stone-500">Del cultivo a la comunidad</span>
                </div>
            </div>

            <nav class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-2.5 rounded-xl bg-[#2B503A] text-white font-bold text-sm shadow hover:bg-[#1E3728] transition flex items-center gap-2">
                        <span>Ir al Panel Principal</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2.5 rounded-xl text-stone-700 hover:text-[#2B503A] font-bold text-sm hover:bg-stone-100 transition">
                        Iniciar sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-5 py-2.5 rounded-xl bg-[#2B503A] text-white font-bold text-sm shadow-md hover:bg-[#1E3728] transition flex items-center gap-1.5">
                            <span class="text-amber-300">🌾</span> Registrarme
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <!-- Héroe Principal / Bienvenida -->
    <main class="flex-grow">
        <section class="relative overflow-hidden py-12 md:py-20 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-12 items-center">

                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#EBF2ED] text-[#2B503A] text-xs font-bold border border-[#436851]/20">
                            <span class="w-2 h-2 rounded-full bg-[#D2A736]"></span>
                            Plataforma Agrícola e IoT · Saldaña, Tolima
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-[#1A1C1A] tracking-tight leading-[1.15]">
                            Tecnología sencilla para el <span class="text-[#2B503A] underline decoration-[#D2A736] decoration-4">agricultor arrocero</span>.
                        </h1>

                        <p class="text-lg text-stone-600 max-w-2xl leading-relaxed">
                            ArrozConecta integra el monitoreo inteligente con sensores IoT en tus lotes, gestión de etapas fenológicas, mercado de maquinaria y una comunidad solidaria de productores arroceros.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            @auth
                                <a href="{{ route('dashboard') }}"
                                   class="px-8 py-4 rounded-2xl bg-[#2B503A] text-white text-center font-bold text-base shadow-lg shadow-[#2B503A]/25 hover:bg-[#1E3728] transition flex items-center justify-center gap-2">
                                    <span>Entrar a mi cultivo</span>
                                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                   class="px-8 py-4 rounded-2xl bg-[#2B503A] text-white text-center font-bold text-base shadow-lg shadow-[#2B503A]/25 hover:bg-[#1E3728] transition flex items-center justify-center gap-2">
                                    <span>Crear mi cuenta gratis</span>
                                    <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                    </svg>
                                </a>
                                <a href="{{ route('login') }}"
                                   class="px-8 py-4 rounded-2xl bg-white border-2 border-[#2B503A] text-[#2B503A] text-center font-bold text-base hover:bg-stone-50 transition">
                                    Ya tengo cuenta
                                </a>
                            @endauth
                        </div>

                        <!-- Indicadores de confianza -->
                        <div class="grid grid-cols-3 gap-4 pt-8 border-t border-stone-200">
                            <div>
                                <p class="text-2xl font-extrabold text-[#2B503A]">100%</p>
                                <p class="text-xs text-stone-500 font-medium">Adaptado al campo</p>
                            </div>
                            <div>
                                <p class="text-2xl font-extrabold text-[#316194]">IoT</p>
                                <p class="text-xs text-stone-500 font-medium">Humedad en vivo</p>
                            </div>
                            <div>
                                <p class="text-2xl font-extrabold text-[#6B338A]">Comunidad</p>
                                <p class="text-xs text-stone-500 font-medium">Red de productores</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lado Derecho: Tarjeta Interactiva / Preview -->
                    <div class="lg:col-span-5">
                        <div class="relative mx-auto max-w-md rounded-3xl p-6 shadow-2xl border border-stone-200/80 bg-white space-y-5">
                            <!-- Header de la tarjeta -->
                            <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-[#436851] text-white flex items-center justify-center font-bold">🌾</div>
                                    <div>
                                        <h2 class="font-bold text-sm text-[#1A1C1A]">Lote La Esperanza</h2>
                                        <p class="text-xs text-stone-500">Fedearroz 67 · Saldaña, Tolima</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-bold">Activo</span>
                            </div>

                            <!-- Tarjeta de Humedad IoT -->
                            <div class="rounded-2xl p-4 text-white relative overflow-hidden"
                                 style="background: linear-gradient(135deg, #316194 0%, #224266 100%);">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-blue-100 font-semibold uppercase tracking-wider flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                        Sensor ESP8266
                                    </span>
                                    <span class="text-xs text-blue-200">Actualizado ahora</span>
                                </div>
                                <div class="mt-3 flex items-baseline gap-2">
                                    <span class="text-4xl font-extrabold">68%</span>
                                    <span class="text-sm text-blue-200 font-medium">Humedad adecuada</span>
                                </div>
                                <div class="mt-3 grid grid-cols-3 gap-2 pt-3 border-t border-white/10 text-xs">
                                    <div>
                                        <span class="text-blue-200 block text-[10px]">Temperatura</span>
                                        <span class="font-bold">28.0 °C</span>
                                    </div>
                                    <div>
                                        <span class="text-blue-200 block text-[10px]">H. Relativa</span>
                                        <span class="font-bold">75 %</span>
                                    </div>
                                    <div>
                                        <span class="text-blue-200 block text-[10px]">pH Suelo</span>
                                        <span class="font-bold">6.5</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Progreso del Cultivo -->
                            <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200 space-y-2">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-bold text-[#1A1C1A]">Etapa: Macollamiento</span>
                                    <span class="font-extrabold text-[#D2A736]">Día 45 (35%)</span>
                                </div>
                                <div class="w-full h-3 rounded-full bg-stone-200 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-[#436851] to-[#D2A736] rounded-full" style="width: 35%"></div>
                                </div>
                                <p class="text-[11px] text-stone-500">Próxima labor: Segunda fertilización nitrogenada</p>
                            </div>

                            <!-- Alerta rápida -->
                            <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 flex items-center gap-3 text-xs text-amber-900">
                                <span class="text-xl">🔔</span>
                                <div>
                                    <span class="font-bold block">Alerta de riego</span>
                                    <span>Lámina de agua óptima para inicio de embuche.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Sección de los 6 Módulos Principales -->
        <section class="py-16 bg-white border-y border-stone-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <h2 class="text-xs uppercase tracking-widest text-[#D2A736] font-bold">Todo lo que necesitas</h2>
                    <p class="text-3xl font-extrabold text-[#1A1C1A] mt-2">Módulos diseñados para el trabajo de campo</p>
                    <p class="text-stone-500 text-sm mt-2">Navegación sencilla, botones grandes e información clara para que no pierdas tiempo.</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- 1. Mi cultivo -->
                    <div class="p-6 rounded-2xl border border-stone-200 bg-[#FBF9F6] hover:border-[#436851] transition group">
                        <div class="w-12 h-12 rounded-xl bg-[#436851]/10 text-[#436851] flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            🌾
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1C1A] mt-4">1. Mi Cultivo & Lotes</h3>
                        <p class="text-xs text-stone-600 mt-2 leading-relaxed">
                            Registra tus fincas, lotes, variedades de arroz sembradas y calcula automáticamente el progreso y la fecha estimada de cosecha.
                        </p>
                    </div>

                    <!-- 2. Monitoreo IoT -->
                    <div class="p-6 rounded-2xl border border-stone-200 bg-[#FBF9F6] hover:border-[#316194] transition group">
                        <div class="w-12 h-12 rounded-xl bg-[#316194]/10 text-[#316194] flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            💧
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1C1A] mt-4">2. Monitoreo de Humedad</h3>
                        <p class="text-xs text-stone-600 mt-2 leading-relaxed">
                            Conecta tus sensores NodeMCU ESP8266 para medir humedad del suelo, humedad del aire, temperatura y pH en tiempo real con gráficas de 24 horas.
                        </p>
                    </div>

                    <!-- 3. Comunidad -->
                    <div class="p-6 rounded-2xl border border-stone-200 bg-[#FBF9F6] hover:border-[#6B338A] transition group">
                        <div class="w-12 h-12 rounded-xl bg-[#6B338A]/10 text-[#6B338A] flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            👥
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1C1A] mt-4">3. Comunidad Arrocera</h3>
                        <p class="text-xs text-stone-600 mt-2 leading-relaxed">
                            Comparte preguntas sobre plagas, experiencias de siembra y fertilización con otros productores de la región.
                        </p>
                    </div>

                    <!-- 4. Servicios -->
                    <div class="p-6 rounded-2xl border border-stone-200 bg-[#FBF9F6] hover:border-[#D2A736] transition group">
                        <div class="w-12 h-12 rounded-xl bg-[#D2A736]/15 text-[#D2A736] flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            🚜
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1C1A] mt-4">4. Mercado de Servicios</h3>
                        <p class="text-xs text-stone-600 mt-2 leading-relaxed">
                            Encuentra o alquila tractores, servicio de fumigación con dron, transporte de arroz verde a molinos y mano de obra calificada.
                        </p>
                    </div>

                    <!-- 5. Guía del cultivo -->
                    <div class="p-6 rounded-2xl border border-stone-200 bg-[#FBF9F6] hover:border-[#436851] transition group">
                        <div class="w-12 h-12 rounded-xl bg-[#436851]/10 text-[#436851] flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            📖
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1C1A] mt-4">5. Guía Agronómica</h3>
                        <p class="text-xs text-stone-600 mt-2 leading-relaxed">
                            Biblioteca técnica organizada por las 6 etapas del arroz con recomendaciones de expertos y el consejo de la semana.
                        </p>
                    </div>

                    <!-- 6. Alertas -->
                    <div class="p-6 rounded-2xl border border-stone-200 bg-[#FBF9F6] hover:border-amber-600 transition group">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            🔔
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1C1A] mt-4">6. Alertas Oportunas</h3>
                        <p class="text-xs text-stone-600 mt-2 leading-relaxed">
                            Recordatorios preventivos de fertilización, turnos de riego, umbrales de humedad baja y fechas estimadas de recolección.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Pie de página -->
    <footer class="bg-[#1A1C1A] text-white py-10 border-t border-stone-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#436851] text-white flex items-center justify-center font-bold">🌾</div>
                <div>
                    <span class="text-lg font-bold">ArrozConecta</span>
                    <p class="text-xs text-stone-400">Protección de Datos conforme a la Ley 1581 de 2012</p>
                </div>
            </div>
            <div class="text-xs text-stone-400 text-center md:text-right">
                <p>© {{ date('Y') }} ArrozConecta · Desarrollado para productores del Tolima y Colombia</p>
                <p class="mt-1 text-amber-300">Saldaña · El Espinal · Campoalegre</p>
            </div>
        </div>
    </footer>

</body>
</html>
