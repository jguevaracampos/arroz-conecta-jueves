<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-extrabold text-2xl text-[#1A1C1A] leading-tight flex items-center gap-2">
                    <span>👥</span> Comunidad Arrocera
                </h1>
                <p class="text-xs text-stone-500 mt-0.5">Comparte dudas sobre plagas, experiencias de siembra y recomendaciones con otros productores</p>
            </div>

            <!-- Botón para crear publicación -->
            <div x-data="{ modalPublicar: false }">
                <button type="button" @click="modalPublicar = true"
                        class="px-4 py-2.5 rounded-xl bg-[#6B338A] text-white hover:bg-[#582972] text-xs font-bold transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    <span>Crear publicación</span>
                </button>

                <!-- Modal Nueva Publicación -->
                <div x-show="modalPublicar" x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
                     @keydown.escape.window="modalPublicar = false">
                    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-stone-200 overflow-y-auto max-h-[90vh]"
                         @click.away="modalPublicar = false">
                        <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                            <h3 class="font-bold text-lg text-stone-900 flex items-center gap-2">
                                <span>✍️</span> Nueva Publicación en la Comunidad
                            </h3>
                            <button type="button" @click="modalPublicar = false" class="text-stone-400 hover:text-stone-700 text-2xl font-bold">&times;</button>
                        </div>

                        <form method="POST" action="{{ route('comunidad.store') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Título de la publicación o pregunta *</label>
                                <input type="text" name="titulo" required placeholder="Ej. ¿Alguien sabe cómo controlar este foco de sogata?"
                                       class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#6B338A] focus:ring-[#6B338A]/30">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Categoría *</label>
                                <select name="categoria" required
                                        class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#6B338A] focus:ring-[#6B338A]/30">
                                    @foreach ($categorias as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Contenido / Descripción *</label>
                                <textarea name="contenido" rows="4" required
                                          placeholder="Describe detalladamente tu situación, variedad de arroz, zona y lo que has observado..."
                                          class="mt-1 block w-full rounded-xl border border-stone-300 px-4 py-2.5 text-sm focus:border-[#6B338A] focus:ring-[#6B338A]/30"></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase">Fotografía adjunta (opcional)</label>
                                <input type="file" name="imagen" accept="image/*"
                                       class="mt-1 block w-full text-xs text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-[#6B338A] hover:file:bg-purple-100">
                            </div>

                            <div class="pt-3 flex justify-end gap-2">
                                <button type="button" @click="modalPublicar = false"
                                        class="px-4 py-2.5 rounded-xl border border-stone-300 text-stone-600 text-xs font-bold hover:bg-stone-100">
                                    Cancelar
                                </button>
                                <button type="submit"
                                        class="px-5 py-2.5 rounded-xl bg-[#6B338A] text-white text-xs font-bold hover:bg-[#582972] shadow-sm">
                                    Publicar ahora
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Filtros por Categoría y Buscador -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-stone-200/80 space-y-3">
                <form method="GET" action="{{ route('comunidad.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <input type="text" name="q" value="{{ $busqueda }}"
                               placeholder="Buscar por plaga, variedad, fertilizante o palabra clave..."
                               class="w-full rounded-xl border border-stone-300 px-4 py-2.5 pl-10 text-xs sm:text-sm focus:border-[#6B338A] focus:ring-[#6B338A]/30">
                        <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                    </div>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-[#2B503A] text-white text-xs font-bold hover:bg-[#1E3728] transition">
                        Buscar
                    </button>
                    @if ($busqueda || $categoriaSeleccionada)
                        <a href="{{ route('comunidad.index') }}"
                           class="px-4 py-2.5 rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 text-xs font-bold text-center">
                            Limpiar
                        </a>
                    @endif
                </form>

                <!-- Píldoras de Categorías (7 categorías requeridas) -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 pt-1 scrollbar-none text-xs">
                    <a href="{{ route('comunidad.index', array_merge(request()->query(), ['categoria' => null])) }}"
                       class="px-3 py-1.5 rounded-full shrink-0 font-bold transition {{ empty($categoriaSeleccionada) ? 'bg-[#6B338A] text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                        Todas
                    </a>
                    @foreach ($categorias as $cat)
                        <a href="{{ route('comunidad.index', ['categoria' => $cat, 'q' => $busqueda]) }}"
                           class="px-3 py-1.5 rounded-full shrink-0 font-semibold transition {{ $categoriaSeleccionada === $cat ? 'bg-[#6B338A] text-white font-bold' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Listado de Publicaciones -->
            <div class="space-y-6">
                @forelse ($publicaciones as $pub)
                    @php
                        $userLiked = $pub->isLikedBy(Auth::user());
                    @endphp
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-stone-200/80 space-y-4">
                        <!-- Cabecera de la publicación -->
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-full bg-[#436851] text-white font-bold flex items-center justify-center text-sm uppercase">
                                    {{ mb_substr($pub->user->name, 0, 1) }}
                                </span>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-bold text-sm text-stone-900">{{ $pub->user->name }}</h3>
                                        @if ($pub->user->municipio)
                                            <span class="text-[11px] text-stone-400">· {{ $pub->user->municipio }}</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] text-stone-400">{{ $pub->created_at->diffForHumans() }}</span>
                                        <span class="inline-block px-2.5 py-0.5 rounded-full bg-purple-50 text-[#6B338A] font-bold text-[10px]">
                                            {{ $pub->categoria }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Opciones: Eliminar propia / Reportar -->
                            <div class="flex items-center gap-2">
                                @if ($pub->user_id === Auth::id() || Auth::user()->rol === 'administrador')
                                    <form method="POST" action="{{ route('comunidad.destroy', $pub) }}" onsubmit="return confirm('¿Seguro de eliminar tu publicación?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Eliminar publicación" class="text-stone-400 hover:text-red-600 text-xs p-1">
                                            🗑️
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('comunidad.reportar', $pub) }}">
                                        @csrf
                                        <button type="submit" title="Reportar contenido inapropiado" class="text-stone-400 hover:text-amber-600 text-xs p-1">
                                            🚩
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Título y Contenido -->
                        <div>
                            <h4 class="font-extrabold text-base text-stone-900 leading-snug">{{ $pub->titulo }}</h4>
                            <p class="mt-2 text-stone-700 text-sm leading-relaxed whitespace-pre-line">{{ $pub->contenido }}</p>
                        </div>

                        <!-- Imagen adjunta si existe -->
                        @if ($pub->imagen)
                            <div class="rounded-2xl overflow-hidden max-h-96 border border-stone-200">
                                <img src="{{ asset('storage/'.$pub->imagen) }}" alt="Fotografía del cultivo" class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- Barra de Interacción (Likes y Comentarios) -->
                        <div class="pt-3 border-t border-stone-100 flex items-center justify-between text-xs text-stone-500">
                            <div class="flex items-center gap-4">
                                <!-- Botón Me gusta -->
                                <form method="POST" action="{{ route('comunidad.reaccion', $pub) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-bold transition {{ $userLiked ? 'bg-red-50 text-red-600' : 'hover:bg-stone-100 text-stone-600' }}">
                                        <span>{{ $userLiked ? '❤️' : '🤍' }}</span>
                                        <span>{{ $pub->likes_count }} Me gusta</span>
                                    </button>
                                </form>

                                <!-- Contador de Comentarios -->
                                <span class="flex items-center gap-1.5 text-stone-600 font-semibold">
                                    <span>💬</span>
                                    <span>{{ $pub->comentarios->count() }} comentarios</span>
                                </span>
                            </div>
                        </div>

                        <!-- Sección de Comentarios Desplegada -->
                        <div class="pt-3 border-t border-stone-100 space-y-3 bg-[#FBF9F6] p-4 rounded-2xl">
                            <!-- Listado de comentarios -->
                            @foreach ($pub->comentarios as $comentario)
                                <div class="flex items-start gap-2.5 text-xs">
                                    <span class="w-7 h-7 rounded-full bg-stone-300 text-stone-700 font-bold flex items-center justify-center shrink-0 uppercase text-[10px]">
                                        {{ mb_substr($comentario->user->name, 0, 1) }}
                                    </span>
                                    <div class="flex-grow bg-white p-3 rounded-2xl border border-stone-200/70">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-stone-900">{{ $comentario->user->name }}</span>
                                            <span class="text-[10px] text-stone-400">{{ $comentario->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="mt-1 text-stone-700">{{ $comentario->contenido }}</p>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Formulario para agregar comentario -->
                            <form method="POST" action="{{ route('comunidad.comentarios.store', $pub) }}" class="flex gap-2 pt-2">
                                @csrf
                                <input type="text" name="contenido" required placeholder="Escribe un consejo o comentario para este agricultor..."
                                       class="flex-grow rounded-xl border border-stone-300 px-3.5 py-2 text-xs focus:border-[#6B338A] focus:ring-[#6B338A]/30">
                                <button type="submit"
                                        class="px-4 py-2 rounded-xl bg-[#2B503A] text-white font-bold text-xs hover:bg-[#1E3728] transition shrink-0">
                                    Comentar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center bg-white rounded-3xl border border-stone-200">
                        <div class="text-4xl mb-3">💬</div>
                        <h3 class="font-bold text-stone-800 text-base">No se encontraron publicaciones</h3>
                        <p class="text-xs text-stone-500 max-w-md mx-auto mt-1">Sé el primero en hacer una pregunta sobre tus cultivos o compartir tu experiencia en esta categoría.</p>
                    </div>
                @endforelse

                <div class="pt-4">
                    {{ $publicaciones->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
