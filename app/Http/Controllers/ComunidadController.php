<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Publicacion;
use App\Models\Reaccion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ComunidadController extends Controller
{
    public function index(Request $request): View
    {
        $categoriaSeleccionada = $request->query('categoria');
        $busqueda = $request->query('q');

        $query = Publicacion::with(['user', 'comentarios.user', 'reacciones'])
            ->latest();

        if ($categoriaSeleccionada) {
            $query->where('categoria', $categoriaSeleccionada);
        }

        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('titulo', 'like', "%{$busqueda}%")
                    ->orWhere('contenido', 'like', "%{$busqueda}%");
            });
        }

        $publicaciones = $query->paginate(10)->withQueryString();

        $categorias = [
            'Plagas y enfermedades',
            'Fertilizantes',
            'Siembra',
            'Riego',
            'Maquinaria',
            'Cosecha',
            'Experiencias agrícolas',
        ];

        return view('comunidad.index', compact('publicaciones', 'categorias', 'categoriaSeleccionada', 'busqueda'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'categoria' => ['required', 'string'],
            'contenido' => ['required', 'string'],
            'imagen' => ['nullable', 'image', 'max:4096'],
        ], [
            'titulo.required' => 'Escribe un título para tu publicación o pregunta.',
            'categoria.required' => 'Selecciona una categoría.',
            'contenido.required' => 'El contenido de la publicación no puede estar vacío.',
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('comunidad', 'public');
        }

        Publicacion::create([
            'user_id' => $request->user()->id,
            'titulo' => $validated['titulo'],
            'categoria' => $validated['categoria'],
            'contenido' => $validated['contenido'],
            'imagen' => $imagenPath,
            'likes_count' => 0,
        ]);

        return redirect()->route('comunidad.index')->with('status', '¡Tu publicación ha sido compartida con la comunidad arrocera!');
    }

    public function storeComment(Request $request, Publicacion $publicacion): RedirectResponse
    {
        $request->validate([
            'contenido' => ['required', 'string', 'max:1000'],
        ], [
            'contenido.required' => 'El comentario no puede estar vacío.',
        ]);

        Comentario::create([
            'publicacion_id' => $publicacion->id,
            'user_id' => $request->user()->id,
            'contenido' => $request->contenido,
        ]);

        return back()->with('status', 'Comentario publicado.');
    }

    public function toggleLike(Request $request, Publicacion $publicacion): RedirectResponse
    {
        $user = $request->user();
        $reaccion = Reaccion::where('publicacion_id', $publicacion->id)
            ->where('user_id', $user->id)
            ->first();

        if ($reaccion) {
            $reaccion->delete();
            $publicacion->decrement('likes_count');
        } else {
            Reaccion::create([
                'publicacion_id' => $publicacion->id,
                'user_id' => $user->id,
                'tipo' => 'me_gusta',
            ]);
            $publicacion->increment('likes_count');
        }

        return back();
    }

    public function reportar(Request $request, Publicacion $publicacion): RedirectResponse
    {
        $publicacion->update(['reportada' => true]);

        return back()->with('status', 'Publicación reportada para revisión de moderación.');
    }

    public function destroy(Request $request, Publicacion $publicacion): RedirectResponse
    {
        if ($publicacion->user_id !== $request->user()->id && $request->user()->rol !== 'administrador') {
            abort(403);
        }

        if ($publicacion->imagen) {
            Storage::disk('public')->delete($publicacion->imagen);
        }

        $publicacion->delete();

        return redirect()->route('comunidad.index')->with('status', 'Publicación eliminada correctamente.');
    }
}
