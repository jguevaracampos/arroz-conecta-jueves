<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use App\Models\Departamento;
use App\Models\EtapaFenologica;
use App\Models\Finca;
use App\Models\Lote;
use App\Models\Notificacion;
use App\Models\VariedadArroz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CultivoController extends Controller
{
    /**
     * Pantalla principal de Mi Cultivo
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $fincas = Finca::where('user_id', $user->id)
            ->with(['lotes.cultivos', 'lotes.variedad'])
            ->latest()
            ->get();

        $lotes = Lote::whereHas('finca', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['finca', 'variedad', 'cultivos'])->get();

        $cultivos = Cultivo::where('user_id', $user->id)
            ->with(['lote.finca', 'variedad'])
            ->latest()
            ->get();

        // Recalcular el progreso dinámicamente según la fecha de siembra
        foreach ($cultivos as $c) {
            $c->recalcularProgreso();
            $c->save();
        }

        $variedades = VariedadArroz::orderBy('nombre')->get();
        $etapas = EtapaFenologica::orderBy('orden')->get();
        $departamentos = Departamento::with('municipios')->get();

        return view('cultivos.index', compact('fincas', 'lotes', 'cultivos', 'variedades', 'etapas', 'departamentos'));
    }

    /**
     * Registrar una finca
     */
    public function storeFinca(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'departamento' => ['required', 'string', 'max:100'],
            'municipio' => ['required', 'string', 'max:100'],
            'vereda' => ['nullable', 'string', 'max:150'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'area_total' => ['required', 'numeric', 'min:0.1'],
            'propietario' => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required' => 'El nombre de la finca es obligatorio.',
            'departamento.required' => 'Selecciona un departamento.',
            'municipio.required' => 'Selecciona un municipio.',
            'area_total.required' => 'El área total en hectáreas es obligatoria.',
        ]);

        $validated['user_id'] = $request->user()->id;
        if (empty($validated['propietario'])) {
            $validated['propietario'] = $request->user()->name;
        }

        Finca::create($validated);

        return redirect()->route('cultivos.index')->with('status', '¡Finca registrada exitosamente!');
    }

    /**
     * Registrar un lote
     */
    public function storeLote(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'finca_id' => ['required', 'exists:fincas,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'area_hectareas' => ['required', 'numeric', 'min:0.1'],
            'tipo_arroz' => ['required', 'string'],
            'variedad_arroz_id' => ['nullable', 'exists:variedades_arroz,id'],
            'fecha_siembra' => ['nullable', 'date'],
            'estado' => ['required', 'string'],
            'notas' => ['nullable', 'string'],
        ]);

        $finca = Finca::where('id', $validated['finca_id'])
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $variedad = null;
        if (! empty($validated['variedad_arroz_id'])) {
            $variedad = VariedadArroz::find($validated['variedad_arroz_id']);
            $validated['variedad_nombre'] = $variedad?->nombre;
        }

        $lote = Lote::create($validated);

        // Si se indicó fecha de siembra y estado activo, crear o enlazar cultivo automáticamente
        if (! empty($validated['fecha_siembra']) && $validated['estado'] === 'Activo') {
            $cultivo = new Cultivo([
                'user_id' => $request->user()->id,
                'lote_id' => $lote->id,
                'variedad_arroz_id' => $variedad?->id,
                'nombre_cultivo' => 'Cultivo '.$lote->nombre,
                'variedad_nombre' => $variedad ? $variedad->nombre : ($validated['variedad_nombre'] ?? 'Arroz Comercial'),
                'fecha_siembra' => $validated['fecha_siembra'],
                'area_sembrada' => $validated['area_hectareas'],
                'estado' => 'Activo',
                'observaciones' => $validated['notas'] ?? null,
            ]);
            $cultivo->recalcularProgreso();
            $cultivo->save();

            // Generar notificación de seguimiento
            Notificacion::create([
                'user_id' => $request->user()->id,
                'cultivo_id' => $cultivo->id,
                'tipo' => 'seguimiento',
                'titulo' => 'Nuevo cultivo registrado en '.$lote->nombre,
                'mensaje' => 'Se ha iniciado el seguimiento agronómico para la variedad '.$cultivo->variedad_nombre.'.',
                'nivel' => 'info',
                'fecha_evento' => now(),
            ]);
        }

        return redirect()->route('cultivos.index')->with('status', '¡Lote registrado exitosamente!');
    }

    /**
     * Registrar cultivo manualmente
     */
    public function storeCultivo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lote_id' => ['required', 'exists:lotes,id'],
            'nombre_cultivo' => ['required', 'string', 'max:255'],
            'variedad_arroz_id' => ['nullable', 'exists:variedades_arroz,id'],
            'fecha_siembra' => ['required', 'date'],
            'area_sembrada' => ['required', 'numeric', 'min:0.1'],
            'estado' => ['required', 'string'],
            'observaciones' => ['nullable', 'string'],
        ]);

        $lote = Lote::whereHas('finca', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
        })->where('id', $validated['lote_id'])->firstOrFail();

        $variedad = ! empty($validated['variedad_arroz_id']) ? VariedadArroz::find($validated['variedad_arroz_id']) : null;

        $cultivo = new Cultivo([
            'user_id' => $request->user()->id,
            'lote_id' => $lote->id,
            'variedad_arroz_id' => $variedad?->id,
            'nombre_cultivo' => $validated['nombre_cultivo'],
            'variedad_nombre' => $variedad ? $variedad->nombre : 'Fedearroz 67',
            'fecha_siembra' => $validated['fecha_siembra'],
            'area_sembrada' => $validated['area_sembrada'],
            'estado' => $validated['estado'],
            'observaciones' => $validated['observaciones'],
        ]);

        $cultivo->recalcularProgreso();
        $cultivo->save();

        return redirect()->route('cultivos.index')->with('status', '¡Cultivo registrado y seguimiento agronómico iniciado!');
    }

    /**
     * Eliminar cultivo
     */
    public function destroyCultivo(Request $request, Cultivo $cultivo): RedirectResponse
    {
        if ($cultivo->user_id !== $request->user()->id) {
            abort(403);
        }

        $cultivo->delete();

        return redirect()->route('cultivos.index')->with('status', 'Cultivo eliminado correctamente.');
    }

    /**
     * Eliminar lote
     */
    public function destroyLote(Request $request, Lote $lote): RedirectResponse
    {
        if ($lote->finca->user_id !== $request->user()->id) {
            abort(403);
        }

        $lote->delete();

        return redirect()->route('cultivos.index')->with('status', 'Lote eliminado correctamente.');
    }

    /**
     * Eliminar finca
     */
    public function destroyFinca(Request $request, Finca $finca): RedirectResponse
    {
        if ($finca->user_id !== $request->user()->id) {
            abort(403);
        }

        $finca->delete();

        return redirect()->route('cultivos.index')->with('status', 'Finca eliminada correctamente.');
    }
}
