<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'razon_social' => 'required|string|max:255',
            'ruc'          => 'required|string|size:11|unique:cliente,ruc',
            'sedes'        => 'required|string|max:255',
            'rubro'        => 'required|string|max:100',
            'correo'       => 'required|email|max:150|unique:cliente,correo',
            'password'     => [
                'required',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ], [
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.mixed'     => 'La contraseña debe incluir mayúsculas y minúsculas.',
            'password.numbers'   => 'La contraseña debe incluir al menos un número.',
            'password.symbols'   => 'La contraseña debe incluir un signo especial (!@#$%&*).',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'ruc.unique'         => 'Este RUC ya se encuentra registrado.',
            'ruc.size'           => 'El RUC debe tener exactamente 11 dígitos.',
            'correo.unique'      => 'Este correo ya está registrado en JHARDSYSTEX.',
        ]);

        // Creación con formato elegante
        Cliente::create([
            'razon_social' => mb_convert_case($request->razon_social, MB_CASE_TITLE, "UTF-8"),
            'ruc'          => $request->ruc,
            'sedes'        => $request->sedes,
            'rubro'        => ucfirst(strtolower($request->rubro)),
            'correo'       => strtolower($request->correo),
            'contraseña'   => Hash::make($request->password), // Hasheado para seguridad
        ]);

        return redirect('/')->with('success', '¡Empresa registrada exitosamente!');
    }
}