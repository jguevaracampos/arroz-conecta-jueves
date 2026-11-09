<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertaController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $notificaciones = Notificacion::where('user_id', $user->id)
            ->with('cultivo')
            ->latest()
            ->paginate(15);

        return view('alertas.index', compact('notificaciones'));
    }

    public function marcarLeida(Request $request, Notificacion $notificacion): RedirectResponse
    {
        if ($notificacion->user_id !== $request->user()->id) {
            abort(403);
        }

        $notificacion->update(['leida' => true]);

        return back()->with('status', 'Alerta marcada como leída.');
    }

    public function marcarTodasLeidas(Request $request): RedirectResponse
    {
        Notificacion::where('user_id', $request->user()->id)->update(['leida' => true]);

        return back()->with('status', 'Todas las alertas han sido marcadas como leídas.');
    }

    public function destroy(Request $request, Notificacion $notificacion): RedirectResponse
    {
        if ($notificacion->user_id !== $request->user()->id) {
            abort(403);
        }

        $notificacion->delete();

        return back()->with('status', 'Alerta eliminada.');
    }
}
