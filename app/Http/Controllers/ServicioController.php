<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Servicio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServicioController extends Controller
{
    public function index(Request $request): View
    {
        $categoriaSeleccionada = $request->query('categoria');
        $municipioSeleccionado = $request->query('municipio');
        $busqueda = $request->query('q');

        $query = Servicio::with('user')->latest();

        if ($categoriaSeleccionada) {
            $query->where('categoria', $categoriaSeleccionada);
        }

        if ($municipioSeleccionado) {
            $query->where('municipio', $municipioSeleccionado);
        }

        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('titulo', 'like', "%{$busqueda}%")
                    ->orWhere('descripcion', 'like', "%{$busqueda}%");
            });
        }

        $servicios = $query->paginate(9)->withQueryString();

        $categorias = [
            'Alquiler de tractor',
            'Preparación de terreno',
            'Fumigación',
            'Transporte de arroz',
            'Recolección y cosecha',
            'Mano de obra',
            'Alquiler de maquinaria',
        ];

        $departamentos = Departamento::with('municipios')->get();
        $municipios = Municipio::orderBy('nombre')->get();

        $misServicios = Servicio::where('user_id', $request->user()->id)->latest()->get();

        return view('servicios.index', compact(
            'servicios',
            'categorias',
            'departamentos',
            'municipios',
            'categoriaSeleccionada',
            'municipioSeleccionado',
            'busqueda',
            'misServicios'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'categoria' => ['required', 'string'],
            'descripcion' => ['required', 'string'],
            'precio' => ['nullable', 'numeric', 'min:0'],
            'unidad_precio' => ['required', 'string'],
            'departamento' => ['required', 'string'],
            'municipio' => ['required', 'string'],
            'contacto_telefono' => ['required', 'string', 'max:20'],
            'contacto_whatsapp' => ['nullable', 'string', 'max:20'],
            'imagen' => ['nullable', 'image', 'max:4096'],
        ], [
            'titulo.required' => 'El título del servicio es obligatorio.',
            'categoria.required' => 'Selecciona la categoría del servicio.',
            'descripcion.required' => 'Describe las características y condiciones del servicio.',
            'departamento.required' => 'El departamento es requerido.',
            'municipio.required' => 'El municipio es requerido.',
            'contacto_telefono.required' => 'Indica un teléfono de contacto.',
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('servicios', 'public');
        }

        // Normalizar número de whatsapp
        $whatsapp = ! empty($validated['contacto_whatsapp']) ? $validated['contacto_whatsapp'] : ($validated['contacto_telefono'] ?? '');
        $cleanWhatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
        if (strlen($cleanWhatsapp) === 10 && ! str_starts_with($cleanWhatsapp, '57')) {
            $cleanWhatsapp = '57'.$cleanWhatsapp;
        }

        Servicio::create([
            'user_id' => $request->user()->id,
            'titulo' => $validated['titulo'],
            'categoria' => $validated['categoria'],
            'descripcion' => $validated['descripcion'],
            'precio' => $validated['precio'] ?? null,
            'unidad_precio' => $validated['unidad_precio'],
            'departamento' => $validated['departamento'],
            'municipio' => $validated['municipio'],
            'contacto_telefono' => $validated['contacto_telefono'],
            'contacto_whatsapp' => $cleanWhatsapp ?: $validated['contacto_telefono'],
            'imagen' => $imagenPath,
            'disponible' => true,
        ]);

        return redirect()->route('servicios.index')->with('status', '¡Servicio agrícola publicado exitosamente!');
    }

    public function toggleDisponibilidad(Request $request, Servicio $servicio): RedirectResponse
    {
        if ($servicio->user_id !== $request->user()->id && $request->user()->rol !== 'administrador') {
            abort(403);
        }

        $servicio->disponible = ! $servicio->disponible;
        $servicio->save();

        return back()->with('status', 'Disponibilidad actualizada.');
    }

    public function destroy(Request $request, Servicio $servicio): RedirectResponse
    {
        if ($servicio->user_id !== $request->user()->id && $request->user()->rol !== 'administrador') {
            abort(403);
        }

        if ($servicio->imagen) {
            Storage::disk('public')->delete($servicio->imagen);
        }

        $servicio->delete();

        return redirect()->route('servicios.index')->with('status', 'Servicio eliminado correctamente.');
    }
}
