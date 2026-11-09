<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use App\Models\Departamento;
use App\Models\Publicacion;
use App\Models\Servicio;
use App\Models\User;
use App\Models\VariedadArroz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $totalUsuarios = User::count();
        $totalCultivos = Cultivo::count();
        $totalPublicaciones = Publicacion::count();
        $totalServicios = Servicio::count();

        $usuarios = User::latest()->paginate(10, ['*'], 'usuarios_page');
        $publicacionesReportadas = Publicacion::where('reportada', true)->with('user')->get();
        $variedades = VariedadArroz::all();
        $departamentos = Departamento::withCount('municipios')->get();

        return view('admin.index', compact(
            'totalUsuarios',
            'totalCultivos',
            'totalPublicaciones',
            'totalServicios',
            'usuarios',
            'publicacionesReportadas',
            'variedades',
            'departamentos'
        ));
    }

    public function cambiarRol(Request $request, User $targetUser): RedirectResponse
    {
        $request->validate(['rol' => 'required|in:administrador,agricultor,tecnico']);

        $targetUser->update(['rol' => $request->rol]);

        return back()->with('status', "Rol de {$targetUser->name} actualizado a {$request->rol}.");
    }

    public function descartarReporte(Request $request, Publicacion $publicacion): RedirectResponse
    {
        $publicacion->update(['reportada' => false]);

        return back()->with('status', 'Reporte descartado. La publicación continúa visible.');
    }
}
