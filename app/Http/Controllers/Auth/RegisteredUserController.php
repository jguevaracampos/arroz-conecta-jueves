<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $departamentos = Departamento::with('municipios')->get();

        return view('auth.register', compact('departamentos'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'telefono' => ['required', 'string', 'max:20'],
            'departamento' => ['required', 'string', 'max:100'],
            'municipio' => ['required', 'string', 'max:100'],
            'vereda' => ['nullable', 'string', 'max:150'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'politica_datos' => ['required', 'accepted'],
        ], [
            'name.required' => 'El nombre completo es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado.',
            'telefono.required' => 'El número de teléfono es obligatorio para contactarte.',
            'departamento.required' => 'Debes seleccionar un departamento.',
            'municipio.required' => 'Debes seleccionar un municipio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'politica_datos.accepted' => 'Debes autorizar el tratamiento de datos personales conforme a la Ley 1581 de 2012.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'departamento' => $request->departamento,
            'municipio' => $request->municipio,
            'vereda' => $request->vereda,
            'direccion' => $request->direccion,
            'rol' => 'agricultor',
            'data_policy_accepted_at' => now(),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false))->with('status', '¡Bienvenido a ArrozConecta! Tu cuenta de agricultor ha sido creada exitosamente.');
    }
}
