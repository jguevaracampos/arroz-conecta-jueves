<nav x-data="{ open: false }" class="bg-white border-b border-stone-200 sticky top-0 z-30 shadow-xs">
    @php
        $notificacionesSinLeer = Auth::check() ? Auth::user()->notificaciones()->where('leida', false)->count() : 0;
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">

                <!-- Logo ArrozConecta -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                        <span class="w-10 h-10 rounded-xl bg-[#2B503A] text-white flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V9m0 0c0-3 2-5 5-5 0 3-2 5-5 5Zm0 4c0-3-2-5-5-5 0 3 2 5 5 5Zm0 4c0-3 2-5 5-5 0 3-2 5-5 5Z"/>
                            </svg>
                        </span>
                        <div class="leading-tight">
                            <span class="text-xl font-extrabold tracking-tight text-[#2B503A]">Arroz<span class="text-[#6B338A]">Conecta</span></span>
                            <span class="hidden md:block text-[10px] text-stone-500 font-medium">Saldaña · Tolima</span>
                        </div>
                    </a>
                </div>

                <!-- Enlaces Principales de Escritorio -->
                <div class="hidden space-x-1 lg:space-x-3 sm:-my-px sm:ms-8 sm:flex">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-[#EBF2ED] text-[#2B503A]' : 'text-stone-600 hover:text-[#2B503A] hover:bg-stone-50' }}">
                        Inicio
                    </a>

                    <a href="{{ route('cultivos.index') }}"
                       class="inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg transition {{ request()->routeIs('cultivos.*') ? 'bg-[#EBF2ED] text-[#2B503A]' : 'text-stone-600 hover:text-[#2B503A] hover:bg-stone-50' }}">
                        Mi Cultivo
                    </a>

                    <a href="{{ route('monitoreo.index') }}"
                       class="inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg transition {{ request()->routeIs('monitoreo.*') ? 'bg-sky-50 text-[#316194]' : 'text-stone-600 hover:text-[#316194] hover:bg-stone-50' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#316194] mr-1.5"></span>
                        Monitoreo IoT
                    </a>

                    <a href="{{ route('comunidad.index') }}"
                       class="inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg transition {{ request()->routeIs('comunidad.*') ? 'bg-purple-50 text-[#6B338A]' : 'text-stone-600 hover:text-[#6B338A] hover:bg-stone-50' }}">
                        Comunidad
                    </a>

                    <a href="{{ route('servicios.index') }}"
                       class="inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg transition {{ request()->routeIs('servicios.*') ? 'bg-amber-50 text-[#92400e]' : 'text-stone-600 hover:text-[#92400e] hover:bg-stone-50' }}">
                        Servicios
                    </a>

                    <a href="{{ route('guia.index') }}"
                       class="inline-flex items-center px-3 py-2 text-xs font-semibold rounded-lg transition {{ request()->routeIs('guia.*') ? 'bg-[#EBF2ED] text-[#2B503A]' : 'text-stone-600 hover:text-[#2B503A] hover:bg-stone-50' }}">
                        Guía
                    </a>
                </div>
            </div>

            <!-- Accesos Rápidos de Derecha (Alertas + Usuario) -->
            <div class="flex items-center gap-2">

                <!-- Botón de Alertas / Notificaciones -->
                <a href="{{ route('alertas.index') }}"
                   title="Ver Alertas y Notificaciones"
                   class="relative p-2 rounded-xl text-stone-600 hover:text-[#2B503A] hover:bg-[#EBF2ED] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                    </svg>
                    @if ($notificacionesSinLeer > 0)
                        <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-red-600 text-white text-[10px] font-extrabold flex items-center justify-center animate-pulse">
                            {{ $notificacionesSinLeer }}
                        </span>
                    @endif
                </a>

                <!-- Menú Desplegable de Usuario -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2.5 px-3 py-2 border border-stone-200 text-xs font-semibold rounded-xl text-stone-700 bg-white hover:bg-stone-50 focus:outline-none transition">
                                <span class="w-7 h-7 rounded-full bg-[#2B503A] text-white font-bold flex items-center justify-center text-xs uppercase">
                                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                                </span>
                                <div class="text-left">
                                    <div class="font-bold text-stone-900 leading-tight">{{ Str::limit(Auth::user()->name, 15) }}</div>
                                    <div class="text-[10px] text-stone-400 capitalize">{{ Auth::user()->rol ?? 'Agricultor' }}</div>
                                </div>
                                <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-stone-100 bg-stone-50/50">
                                <p class="text-xs font-semibold text-stone-900">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-stone-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <x-dropdown-link :href="route('perfil.index')">
                                🧑‍🌾 {{ __('Perfil del Agricultor') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('cultivos.index')">
                                🌾 {{ __('Mis Fincas y Lotes') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('configuracion.index')">
                                🛡️ {{ __('Blindaje & Seguridad') }}
                            </x-dropdown-link>

                            @if (Auth::user()->rol === 'administrador')
                                <div class="border-t border-stone-100"></div>
                                <x-dropdown-link :href="route('admin.index')">
                                    ⚙️ {{ __('Panel Administrativo') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-stone-100"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-red-700 hover:bg-red-50">
                                    🚪 {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Botón Hamburguesa Móvil -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-stone-500 hover:text-[#2B503A] hover:bg-[#EBF2ED] focus:outline-none transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Menú Desplegable Móvil -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-stone-200 bg-white">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                🌾 {{ __('Inicio / Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cultivos.index')" :active="request()->routeIs('cultivos.*')">
                🚜 {{ __('Mi Cultivo (Fincas y Lotes)') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('monitoreo.index')" :active="request()->routeIs('monitoreo.*')">
                💧 {{ __('Monitoreo de Humedad IoT') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('comunidad.index')" :active="request()->routeIs('comunidad.*')">
                👥 {{ __('Comunidad Arrocera') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('servicios.index')" :active="request()->routeIs('servicios.*')">
                📦 {{ __('Mercado de Servicios') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('guia.index')" :active="request()->routeIs('guia.*')">
                📖 {{ __('Guía del Cultivo') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('alertas.index')" :active="request()->routeIs('alertas.*')">
                🔔 {{ __('Alertas y Notificaciones') }} ({{ $notificacionesSinLeer }})
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('configuracion.index')" :active="request()->routeIs('configuracion.*')">
                🛡️ {{ __('Blindaje & Seguridad') }}
            </x-responsive-nav-link>
            @if (Auth::user()->rol === 'administrador')
                <x-responsive-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.*')">
                    ⚙️ {{ __('Panel Administrativo') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-3 pb-3 border-t border-stone-200 px-4 bg-stone-50">
            <div class="flex items-center gap-3">
                <span class="w-9 h-9 rounded-full bg-[#2B503A] text-white font-bold flex items-center justify-center text-sm uppercase">
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </span>
                <div>
                    <div class="font-bold text-sm text-stone-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-stone-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('perfil.index')">
                    🧑‍🌾 {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-700">
                        🚪 {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>