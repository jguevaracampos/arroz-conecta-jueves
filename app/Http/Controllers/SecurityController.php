<?php

namespace App\Http\Controllers;

use App\Mail\RecoveryCodesMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SecurityController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $codes = $user->recovery_codes ?? [];
        $activeCodesCount = collect($codes)->where('used', false)->count();

        return view('configuracion.seguridad', [
            'user' => $user,
            'hasCodes' => ! empty($codes),
            'activeCodesCount' => $activeCodesCount,
            'plainCodes' => session('plain_recovery_codes'),
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ], [
            'current_password.current_password' => 'La contraseña actual no coincide con tu contraseña registrada.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status_password', '¡Contraseña actualizada con éxito!');
    }

    public function generateRecoveryCodes(Request $request): RedirectResponse
    {

        $plainCodes = collect(range(1, 6))->map(function () {
            return strtoupper(Str::random(4).'-'.Str::random(4));
        })->values()->all();

        $storedCodes = array_map(function (string $code) {
            return [
                'code' => Hash::make($code),
                'used' => false,
                'used_at' => null,
            ];
        }, $plainCodes);

        $user = $request->user();
        $user->recovery_codes = $storedCodes;
        $user->save();

        session(['plain_recovery_codes' => $plainCodes]);

        try {
            Mail::to($user->email)->send(new RecoveryCodesMail($user, $plainCodes));
            $mensaje = 'Se generaron 6 nuevos códigos de recuperación y se enviaron a tu correo.';
        } catch (\Throwable $e) {
            Log::error('No se pudo enviar el correo de códigos: '.$e->getMessage());
            $mensaje = 'Se generaron 6 nuevos códigos de recuperación, pero no se pudo enviar el correo. Descarga el archivo.';
        }

        return back()->with('status_codes', $mensaje);
    }

    public function downloadRecoveryCodes(Request $request): Response|RedirectResponse
    {
        $codes = session('plain_recovery_codes');

        if (empty($codes)) {
            return back()->with('error_codes', 'No hay códigos generados en la sesión activa para descargar. Si necesitas un nuevo archivo, genera los códigos nuevamente.');
        }

        $user = $request->user();
        $fecha = now()->format('d/m/Y H:i:s');

        $content = "============================================================\n";
        $content .= "    PLATAFORMA - CÓDIGOS DE RECUPERACIÓN (BLINDAJE)\n";
        $content .= "============================================================\n";
        $content .= 'Usuario: '.$user->email."\n";
        $content .= 'Fecha de generación: '.$fecha."\n";
        $content .= "------------------------------------------------------------\n";
        $content .= "INSTRUCCIONES IMPORTANTES:\n";
        $content .= "- Cada uno de estos 6 códigos solo puede utilizarse UNA VEZ.\n";
        $content .= "- Consérvalos en un lugar seguro (gestor de contraseñas, USB).\n";
        $content .= "- Si sospechas que alguien los vio, genera nuevos códigos.\n";
        $content .= "------------------------------------------------------------\n\n";
        $content .= "TUS 6 CÓDIGOS DE RECUPERACIÓN:\n\n";

        foreach ($codes as $index => $code) {
            $num = $index + 1;
            $content .= "  [{$num}]  {$code}\n";
        }

        $content .= "\n============================================================\n";

        $fileName = 'codigos_recuperacion_'.Str::slug($user->name ?: 'usuario').'.txt';

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function showRecoveryLogin(): View
    {
        return view('auth.recovery-code-login');
    }

    public function loginWithRecoveryCode(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'recovery_code' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || empty($user->recovery_codes)) {
            throw ValidationException::withMessages([
                'recovery_code' => ['El correo o el código de recuperación ingresado no es válido.'],
            ]);
        }

        $inputCode = strtoupper(trim($request->recovery_code));
        $codes = $user->recovery_codes;
        $matchedIndex = null;

        foreach ($codes as $index => $item) {
            if (! $item['used'] && Hash::check($inputCode, $item['code'])) {
                $matchedIndex = $index;
                break;
            }
        }

        if ($matchedIndex === null) {
            throw ValidationException::withMessages([
                'recovery_code' => ['El código de recuperación es incorrecto o ya ha sido utilizado.'],
            ]);
        }

        $codes[$matchedIndex]['used'] = true;
        $codes[$matchedIndex]['used_at'] = now()->toIso8601String();
        $user->recovery_codes = $codes;
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))->with('status', '¡Acceso concedido mediante código de recuperación! Te recomendamos ir a Configuración si necesitas actualizar tus códigos.');
    }
}
