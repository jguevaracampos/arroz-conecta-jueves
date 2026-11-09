<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión · ArrozConecta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-stone-50 text-stone-800">
<div class="min-h-screen grid lg:grid-cols-2">

  
    <div class="hidden lg:flex flex-col justify-between p-12 text-white"
         style="background: linear-gradient(135deg, #14532d 0%, #166534 50%, #a16207 140%);">

        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V9m0 0c0-3 2-5 5-5 0 3-2 5-5 5Zm0 4c0-3-2-5-5-5 0 3 2 5 5 5Zm0 4c0-3 2-5 5-5 0 3-2 5-5 5Z"/>
                </svg>
            </div>
            <span class="text-2xl font-bold tracking-tight">ArrozConecta</span>
        </div>

        <div>
            <h1 class="text-4xl font-bold leading-tight">
                Del cultivo a la comunidad,<br>todo en un solo lugar.
            </h1>
            <p class="mt-4 text-green-100 max-w-md">
                Conecta con otros arroceros, comparte experiencias y lleva el monitoreo de tu cultivo sin complicaciones.
            </p>

            <ul class="mt-8 space-y-3 text-green-50">
                <li class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-amber-300"></span> Comunidad de productores
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-amber-300"></span> Monitoreo de tu cultivo de arroz
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-amber-300"></span> Tu cuenta protegida con códigos de recuperación
                </li>
            </ul>
        </div>

        <p class="text-sm text-green-200">© {{ date('Y') }} ArrozConecta</p>
    </div>

   
    <div class="flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md">

           
            <div class="lg:hidden mb-8 text-center">
                <span class="text-2xl font-bold text-green-800">ArrozConecta</span>
            </div>

            <h2 class="text-3xl font-bold text-stone-900">Bienvenido de nuevo</h2>
            <p class="mt-2 text-stone-500">Ingresa a tu cuenta para continuar.</p>

            @if (session('status'))
                <div class="mt-6 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5" x-data="{ ver: false }">
                @csrf

           
                <div>
                    <label for="email" class="block text-sm font-medium text-stone-700">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username" placeholder="tucorreo@ejemplo.com"
                           class="mt-1 block w-full rounded-lg border border-stone-300 bg-white px-4 py-3 text-stone-900 placeholder-stone-400 focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-600/30">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            
                <div>
                    <label for="password" class="block text-sm font-medium text-stone-700">Contraseña</label>
                    <div class="relative mt-1">
                        <input id="password" name="password" required autocomplete="current-password"
                               x-bind:type="ver ? 'text' : 'password'" placeholder="••••••••"
                               class="block w-full rounded-lg border border-stone-300 bg-white px-4 py-3 pr-20 text-stone-900 placeholder-stone-400 focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-600/30">
                        <button type="button" @click="ver = !ver"
                                class="absolute inset-y-0 right-0 px-4 text-sm font-medium text-green-700 hover:text-green-900"
                                x-text="ver ? 'Ocultar' : 'Ver'"></button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-stone-600">
                    <input type="checkbox" name="remember"
                           class="rounded border-stone-300 text-green-700 focus:ring-green-600">
                    Mantener sesión iniciada
                </label>

                <button type="submit"
                        class="w-full rounded-lg bg-green-700 px-4 py-3 font-semibold text-white shadow hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600/40 transition">
                    Iniciar sesión
                </button>
            </form>

            
            <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900 flex items-start gap-3">
                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4 6v6c0 4.5 3.2 8 8 9 4.8-1 8-4.5 8-9V6l-8-3Zm-1 11 5-5m-5 5-2-2"/>
                </svg>
                <span>
                    ¿Problemas para acceder?
                   <a href="{{ route('login.recovery') }}" class="font-semibold underline hover:text-amber-700">
                        Usa un código de recuperación
                    </a>
                </span>
            </div>

            @if (Route::has('register'))
                <p class="mt-8 text-center text-sm text-stone-500">
                    ¿Aún no tienes cuenta?
                    <a href="{{ route('register') }}" class="font-semibold text-green-700 hover:text-green-900">Regístrate</a>
                </p>
            @endif
        </div>
    </div>
</div>
</body>
</html>