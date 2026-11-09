<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use App\Models\Departamento;
use App\Models\Publicacion;
use App\Models\Servicio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PerfilAgricultorController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'cultivos_activos' => Cultivo::where('user_id', $user->id)->where('estado', 'Activo')->count(),
            'total_cultivos' => Cultivo::where('user_id', $user->id)->count(),
            'publicaciones' => Publicacion::where('user_id', $user->id)->count(),
            'servicios' => Servicio::where('user_id', $user->id)->count(),
        ];

        $misCultivos = Cultivo::where('user_id', $user->id)->with(['lote.finca'])->latest()->get();
        $misPublicaciones = Publicacion::where('user_id', $user->id)->latest()->get();
        $misServicios = Servicio::where('user_id', $user->id)->latest()->get();

        $departamentos = Departamento::with('municipios')->get();

        return view('perfil.index', compact('user', 'stats', 'misCultivos', 'misPublicaciones', 'misServicios', 'departamentos'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'departamento' => ['nullable', 'string', 'max:100'],
            'municipio' => ['nullable', 'string', 'max:100'],
            'vereda' => ['nullable', 'string', 'max:150'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return back()->with('status', 'Perfil de agricultor actualizado con éxito.');
    }
}
