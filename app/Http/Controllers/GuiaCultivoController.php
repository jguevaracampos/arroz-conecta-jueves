<?php

namespace App\Http\Controllers;

use App\Models\ConsejoSemanal;
use App\Models\GuiaCultivo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuiaCultivoController extends Controller
{
    public function index(Request $request): View
    {
        $etapaSeleccionada = $request->query('etapa');
        $busqueda = $request->query('q');

        $query = GuiaCultivo::query();

        if ($etapaSeleccionada) {
            $query->where('etapa', $etapaSeleccionada);
        }

        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('titulo', 'like', "%{$busqueda}%")
                    ->orWhere('resumen', 'like', "%{$busqueda}%")
                    ->orWhere('contenido', 'like', "%{$busqueda}%");
            });
        }

        $guias = $query->get();

        $etapas = [
            'Preparación del terreno',
            'Siembra',
            'Riego',
            'Fertilización',
            'Control de plagas y enfermedades',
            'Cosecha',
        ];

        $consejoSemanal = ConsejoSemanal::where('activo', true)->latest()->first();

        return view('guia.index', compact('guias', 'etapas', 'etapaSeleccionada', 'busqueda', 'consejoSemanal'));
    }

    public function show(GuiaCultivo $guia): View
    {
        $guiasRelacionadas = GuiaCultivo::where('id', '!=', $guia->id)->take(3)->get();

        return view('guia.show', compact('guia', 'guiasRelacionadas'));
    }
}
