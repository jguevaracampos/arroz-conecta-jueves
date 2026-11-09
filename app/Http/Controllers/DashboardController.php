<?php

namespace App\Http\Controllers;

use App\Models\ConsejoSemanal;
use App\Models\Cultivo;
use App\Models\Notificacion;
use App\Models\Publicacion;
use App\Models\Sensor;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // 1. Cultivo principal del usuario (o el primero que tenga activo)
        $cultivoPrincipal = Cultivo::where('user_id', $user->id)
            ->where('estado', 'Activo')
            ->with(['lote.finca', 'variedad'])
            ->latest()
            ->first();

        // Si no tiene, buscar cualquier cultivo o el más reciente del sistema para muestra
        if (! $cultivoPrincipal) {
            $cultivoPrincipal = Cultivo::with(['lote.finca', 'variedad'])->latest()->first();
        }

        if ($cultivoPrincipal) {
            $cultivoPrincipal->recalcularProgreso();
            $cultivoPrincipal->save();
        }

        // 2. Sensor principal y última medición (de su lote o del sistema)
        $sensorPrincipal = null;
        if ($cultivoPrincipal?->lote_id) {
            $sensorPrincipal = Sensor::where('lote_id', $cultivoPrincipal->lote_id)->with('ultimaMedicion')->first();
        }
        if (! $sensorPrincipal) {
            $sensorPrincipal = Sensor::with('ultimaMedicion')->first();
        }

        $ultimaMedicion = $sensorPrincipal?->ultimaMedicion;

        // 3. Recordatorio o alerta del día
        $recordatorioDia = Notificacion::where('user_id', $user->id)
            ->where('leida', false)
            ->latest()
            ->first();

        if (! $recordatorioDia) {
            $recordatorioDia = (object) [
                'titulo' => 'Recordatorio de fertilización',
                'mensaje' => 'Mañana toca fertilización en el cultivo activo.',
                'tipo' => 'fertilizacion',
                'nivel' => 'advertencia',
            ];
        }

        // 4. Estadísticas rápidas
        $conteoNotificaciones = Notificacion::where('user_id', $user->id)->where('leida', false)->count();
        $totalCultivos = Cultivo::where('user_id', $user->id)->count();
        $totalPublicaciones = Publicacion::count();
        $totalServicios = Servicio::where('disponible', true)->count();

        // 5. Consejo de la semana
        $consejo = ConsejoSemanal::where('activo', true)->latest()->first();

        return view('dashboard', [
            'user' => $user,
            'cultivoPrincipal' => $cultivoPrincipal,
            'sensorPrincipal' => $sensorPrincipal,
            'ultimaMedicion' => $ultimaMedicion,
            'recordatorioDia' => $recordatorioDia,
            'conteoNotificaciones' => $conteoNotificaciones,
            'totalCultivos' => $totalCultivos,
            'totalPublicaciones' => $totalPublicaciones,
            'totalServicios' => $totalServicios,
            'consejo' => $consejo,
        ]);
    }
}
