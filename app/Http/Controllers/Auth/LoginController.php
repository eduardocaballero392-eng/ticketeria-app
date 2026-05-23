<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\Tecnico;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1. Limpiar sesión previa
        session()->flush();

        // 2. Validación (Acepta cualquier correo registrado en las 3 tablas)
        $request->validate([
            'correo'   => 'required|email',
            'password' => 'required|string',
        ], [
            'correo.required' => 'El correo es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $email = $request->correo;
        $password = $request->password;

        // --- 3. SECCIÓN: USUARIO (Administradores / Personal Interno) ---
        $usuario = Usuario::where('correo', $email)->first();

        if ($usuario && Hash::check($password, $usuario->contraseña)) {

            if (!$usuario->activo) {
                return back()->withErrors([
                    'correo' => 'Esta cuenta de usuario está desactivada.'
                ]);
            }

            session([
                'id'         => $usuario->id_usuario,
                'id_cliente' => $usuario->id_cliente,
                'nombre'     => $usuario->nombre . ' ' . $usuario->apellido_paterno,
                'correo'     => $usuario->correo,
                'tipo'       => 'usuario',
            ]);

            return redirect()->route('usuario.dashboard');
        }

        // --- 4. SECCIÓN: TÉCNICO ---
        $tecnico = Tecnico::with('cargo')->where('correo', $email)->first();
        if ($tecnico && Hash::check($password, $tecnico->contraseña)) {
            if (!$tecnico->activo) {
                return back()->withErrors(['correo' => 'Tu cuenta está desactivada.']);
            }

            // Determinar si es admin o técnico según el cargo o campo en la tabla
            $esAdmin = $tecnico->esAdmin(); // ajusta según tu modelo

            session([
                'id'     => $tecnico->id_tecnico,
                'nombre' => $tecnico->nombre . ' ' . $tecnico->apellido_paterno,
                'correo' => $tecnico->correo,
                'tipo'   => $esAdmin ? 'admin' : 'tecnico',
                'cargo'  => optional($tecnico->cargo)->nombre_cargo,
            ]);

            return $esAdmin
                ? redirect()->route('admin.dashboard')
                : redirect()->route('tecnico.dashboard');
        }

        // --- 5. SECCIÓN: CLIENTE (Empresas) ---
        // Nota: Se busca por 'correo' según tu modelo de Cliente
        $cliente = Cliente::where('correo', $email)->first();
        if ($cliente && Hash::check($password, $cliente->contraseña)) {
            // Asumiendo que el cliente siempre está activo tras el registro exitoso
            session([
                'id'     => $cliente->id_cliente,
                'nombre' => $cliente->razon_social,
                'correo' => $cliente->correo,
                'tipo'   => 'cliente',
            ]);

            return redirect()->route('cliente.dashboard');
        }

        // --- 6. FALLO TOTAL ---
        return back()
            ->withErrors(['correo' => 'Las credenciales no coinciden con nuestros registros.'])
            ->withInput();
    }

    public function logout()
    {
        session()->flush();
        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}