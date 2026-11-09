<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso con código · ArrozConecta</title>
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
                Tu cuenta siempre<br>tiene una salida segura.
            </h1>
            <p class="mt-4 text-green-100 max-w-md">
                Si olvidaste tu contraseña, entra con uno de los 6 códigos de recuperación que descargaste al registrarte.
            </p>

            <ul class="mt-8 space-y-3 text-green-50">
                <li class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-amber-300"></span> Cada código funciona una sola vez
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-amber-300"></span> Búscalos en tu archivo de respaldo
                </li>
                <li class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-amber-300"></span> Sin correos ni enlaces externos
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

            <div class="w-14 h-14 rounded-full bg-green-100 text-green-700 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4 6v6c0 4.5 3.2 8 8 9 4.8-1 8-4.5 8-9V6l-8-3Zm-1 11 5-5m-5 5-2-2"/>
                </svg>
            </div>

            <h2 class="mt-5 text-3xl font-bold text-stone-900">Acceso de emergencia</h2>
            <p class="mt-2 text-stone-500">
                Ingresa tu correo y uno de los 6 códigos de recuperación de tu archivo de respaldo.
            </p>

        
            @if ($errors->any())
                <div class="mt-6 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.recovery.store') }}" class="mt-8 space-y-5">
                @csrf

              
                <div>
                    <label for="email" class="block text-sm font-medium text-stone-700">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username" placeholder="tucorreo@ejemplo.com"
                           class="mt-1 block w-full rounded-lg border border-stone-300 bg-white px-4 py-3 text-stone-900 placeholder-stone-400 focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-600/30">
                </div>

                
                <div>
                    <label for="recovery_code" class="block text-sm font-medium text-stone-700">Código de recuperación</label>
                    <input id="recovery_code" type="text" name="recovery_code" value="{{ old('recovery_code') }}"
                           required autocomplete="off" placeholder="XXXX-XXXX"
                           class="mt-1 block w-full rounded-lg border border-stone-300 bg-white px-4 py-3 text-center font-mono text-lg tracking-widest uppercase text-stone-900 placeholder-stone-400 focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-600/30">
                    <p class="mt-2 text-xs text-stone-500 text-center">Este código solo puede usarse una única vez.</p>
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-green-700 px-4 py-3 font-semibold text-white shadow hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600/40 transition">
                    Verificar y acceder a la cuenta
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-stone-500">
                <a href="{{ route('login') }}" class="font-semibold text-green-700 hover:text-green-900">
                    ← Volver al inicio de sesión
                </a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
