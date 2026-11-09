<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ArrozConecta') }} · Monitoreo y Comunidad Arrocera</title>

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts & Styles con Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#FBF9F6] text-[#1A1C1A] selection:bg-[#D2A736] selection:text-white">
        <div class="min-h-screen flex flex-col justify-between pb-20 sm:pb-0">
            <div>
                @include('layouts.navigation')

                <!-- Alerta global de sesión -->
                @if (session('status'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <div class="rounded-2xl p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">✅</span>
                                <span class="text-sm font-semibold">{{ session('status') }}</span>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 text-sm font-bold px-2 py-1">&times;</button>
                        </div>
                    </div>
                @endif

                @isset($header)
                    <header class="bg-white border-b border-stone-200/80 shadow-xs">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Contenido principal -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            <!-- Navegación Inferior Fija para Móviles (Exigida en el Documento) -->
            <nav class="fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-stone-200 py-1.5 px-3 sm:hidden shadow-lg">
                <div class="grid grid-cols-5 gap-1 text-center">
                    <!-- 1. Inicio -->
                    <a href="{{ route('dashboard') }}"
                       class="flex flex-col items-center py-1 rounded-xl transition {{ request()->routeIs('dashboard') ? 'text-[#2B503A] font-bold' : 'text-stone-500 hover:text-stone-800' }}">
                        <svg class="w-6 h-6 {{ request()->routeIs('dashboard') ? 'stroke-[2.5]' : '' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Inicio</span>
                    </a>

                    <!-- 2. Mi Cultivo -->
                    <a href="{{ route('cultivos.index') }}"
                       class="flex flex-col items-center py-1 rounded-xl transition {{ request()->routeIs('cultivos.*') ? 'text-[#2B503A] font-bold' : 'text-stone-500 hover:text-stone-800' }}">
                        <svg class="w-6 h-6 {{ request()->routeIs('cultivos.*') ? 'stroke-[2.5]' : '' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V9m0 0c0-3 2-5 5-5 0 3-2 5-5 5Zm0 4c0-3-2-5-5-5 0 3 2 5 5 5Zm0 4c0-3 2-5 5-5 0 3-2 5-5 5Z"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Mi Cultivo</span>
                    </a>

                    <!-- 3. Comunidad -->
                    <a href="{{ route('comunidad.index') }}"
                       class="flex flex-col items-center py-1 rounded-xl transition {{ request()->routeIs('comunidad.*') ? 'text-[#6B338A] font-bold' : 'text-stone-500 hover:text-stone-800' }}">
                        <svg class="w-6 h-6 {{ request()->routeIs('comunidad.*') ? 'stroke-[2.5]' : '' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Comunidad</span>
                    </a>

                    <!-- 4. Servicios -->
                    <a href="{{ route('servicios.index') }}"
                       class="flex flex-col items-center py-1 rounded-xl transition {{ request()->routeIs('servicios.*') ? 'text-[#D2A736] font-bold' : 'text-stone-500 hover:text-stone-800' }}">
                        <svg class="w-6 h-6 {{ request()->routeIs('servicios.*') ? 'stroke-[2.5]' : '' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-19.5 0v-4.5c0-.621.504-1.125 1.125-1.125h12.75c.621 0 1.125.504 1.125 1.125v4.5m-15 0h15"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Servicios</span>
                    </a>

                    <!-- 5. Perfil -->
                    <a href="{{ route('perfil.index') }}"
                       class="flex flex-col items-center py-1 rounded-xl transition {{ request()->routeIs('perfil.*') ? 'text-[#2B503A] font-bold' : 'text-stone-500 hover:text-stone-800' }}">
                        <svg class="w-6 h-6 {{ request()->routeIs('perfil.*') ? 'stroke-[2.5]' : '' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                        <span class="text-[10px] mt-0.5">Perfil</span>
                    </a>
                </div>
            </nav>
        </div>
    </body>
</html>
