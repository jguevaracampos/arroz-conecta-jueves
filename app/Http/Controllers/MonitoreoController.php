<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\MedicionSensor;
use App\Models\Notificacion;
use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MonitoreoController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Buscar sensores asociados a sus lotes o el primer sensor del sistema
        $sensores = Sensor::where('user_id', $user->id)
            ->orWhereHas('lote.finca', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with(['lote', 'ultimaMedicion'])
            ->get();

        if ($sensores->isEmpty()) {
            $sensores = Sensor::with(['lote', 'ultimaMedicion'])->get();
        }

        $sensorActivo = $sensores->first();

        // Última medición
        $ultimaMedicion = $sensorActivo?->ultimaMedicion;

        // Historial de las últimas 15 mediciones para tabla y gráfica
        $historial = $sensorActivo
            ? MedicionSensor::where('sensor_id', $sensorActivo->id)->latest()->take(20)->get()->reverse()->values()
            : collect([]);

        // Preparar datos JSON para Chart.js
        $chartLabels = $historial->map(fn ($m) => Carbon::parse($m->created_at)->format('H:i'))->toArray();
        $chartHumedadSuelo = $historial->pluck('humedad_suelo')->toArray();
        $chartTemperatura = $historial->pluck('temperatura')->toArray();
        $chartHumedadAire = $historial->pluck('humedad_aire')->toArray();
        $chartPh = $historial->pluck('ph')->toArray();

        $lotes = Lote::whereHas('finca', fn ($q) => $q->where('user_id', $user->id))->get();

        return view('monitoreo.index', compact(
            'sensores',
            'sensorActivo',
            'ultimaMedicion',
            'historial',
            'chartLabels',
            'chartHumedadSuelo',
            'chartTemperatura',
            'chartHumedadAire',
            'chartPh',
            'lotes'
        ));
    }

    /**
     * Endpoint API para hardware IoT (NodeMCU ESP8266)
     */
    public function registrarMedicionIoT(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'codigo_sensor' => ['required', 'string'],
            'humedad_suelo' => ['required', 'numeric', 'min:0', 'max:100'],
            'humedad_aire' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'temperatura' => ['nullable', 'numeric'],
            'ph' => ['nullable', 'numeric', 'min:0', 'max:14'],
        ]);

        $sensor = Sensor::firstOrCreate([
            'codigo_sensor' => $validated['codigo_sensor'],
        ], [
            'nombre' => 'Sensor '.$validated['codigo_sensor'],
            'tipo' => 'NodeMCU ESP8266 IoT',
            'estado' => 'activo',
            'bateria_porcentaje' => 95,
        ]);

        $sensor->ultima_conexion = now();
        $sensor->save();

        $humedad = (float) $validated['humedad_suelo'];
        $estadoHumedad = 'Adecuada';
        if ($humedad < 50) {
            $estadoHumedad = 'Baja - Requiere Riego';
        } elseif ($humedad > 85) {
            $estadoHumedad = 'Exceso - Drenar';
        }

        $medicion = MedicionSensor::create([
            'sensor_id' => $sensor->id,
            'lote_id' => $sensor->lote_id,
            'humedad_suelo' => $humedad,
            'humedad_aire' => $validated['humedad_aire'] ?? 75.0,
            'temperatura' => $validated['temperatura'] ?? 28.0,
            'ph' => $validated['ph'] ?? 6.5,
            'estado_humedad' => $estadoHumedad,
            'origen' => 'iot_nodemcu',
        ]);

        // Disparar alerta si la humedad está crítica
        if ($sensor->user_id && $humedad < 50) {
            Notificacion::create([
                'user_id' => $sensor->user_id,
                'tipo' => 'humedad',
                'titulo' => 'Alerta de Humedad Baja',
                'mensaje' => 'El sensor '.$sensor->nombre.' registró una humedad crítica de '.$humedad.'%. Se requiere riego.',
                'nivel' => 'peligro',
                'fecha_evento' => now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Medición registrada exitosamente desde NodeMCU ESP8266.',
            'medicion_id' => $medicion->id,
            'timestamp' => now()->toIso8601String(),
        ], 201);
    }

    /**
     * Botón para simular una lectura en vivo desde la interfaz
     */
    public function simularLectura(Request $request): RedirectResponse
    {
        $sensorId = $request->input('sensor_id');
        $sensor = Sensor::find($sensorId) ?? Sensor::first();

        if (! $sensor) {
            $sensor = Sensor::create([
                'codigo_sensor' => 'ESP8266-DEMO',
                'nombre' => 'Sensor Demostración ESP8266',
                'tipo' => 'Capacitivo IoT',
                'estado' => 'activo',
            ]);
        }

        // Variación natural de valores
        $humedadSuelo = round(fake()->randomFloat(1, 62, 73), 1);
        $temperatura = round(fake()->randomFloat(1, 26, 32), 1);
        $humedadAire = round(fake()->randomFloat(1, 70, 82), 1);
        $ph = round(fake()->randomFloat(2, 6.2, 6.8), 2);

        $estadoHumedad = $humedadSuelo < 55 ? 'Baja' : ($humedadSuelo > 80 ? 'Exceso' : 'Adecuada');

        MedicionSensor::create([
            'sensor_id' => $sensor->id,
            'lote_id' => $sensor->lote_id,
            'humedad_suelo' => $humedadSuelo,
            'humedad_aire' => $humedadAire,
            'temperatura' => $temperatura,
            'ph' => $ph,
            'estado_humedad' => $estadoHumedad,
            'origen' => 'simulado',
        ]);

        $sensor->ultima_conexion = now();
        $sensor->save();

        return back()->with('status', 'Nueva medición registrada: Humedad '.$humedadSuelo.'%, Temp '.$temperatura.'°C, pH '.$ph.'.');
    }
}
