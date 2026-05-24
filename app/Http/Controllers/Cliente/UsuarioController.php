<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\CredencialesUsuario;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Verificar autenticación
        if (session('tipo') !== 'cliente' || !session('id')) {
            return redirect('/')->with('error', 'Acceso restringido.');
        }

        $usuarios = Usuario::orderBy('created_at', 'desc')->get();
        
        // Contar tickets por usuario
        $ticketsPorUsuario = DB::table('ticket')
            ->select('id_usuario', DB::raw('count(*) as total'))
            ->groupBy('id_usuario')
            ->pluck('total', 'id_usuario');
        
        $tickets = DB::table('ticket')->get();

        return view('cliente.usuarios', compact('usuarios', 'ticketsPorUsuario', 'tickets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'dni' => 'required|string|min:3|max:15|unique:usuario,dni',
            'correo' => 'required|email|unique:usuario,correo',
            'telefono' => 'required|string|max:20',
            'codigo_usuario' => 'nullable|string|max:20',
            'codigo_pais' => 'nullable|string|max:10',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_materno.required' => 'El apellido materno es obligatorio.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'Ingrese un correo válido.',
            'correo.unique' => 'Este correo ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ok' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        try {
            // Generar código de usuario si no viene
            $codigoUsuario = $request->codigo_usuario;
            if (empty($codigoUsuario)) {
                $iniciales = strtoupper(substr($request->nombre, 0, 1) . 
                                        substr($request->apellido_paterno, 0, 1) . 
                                        substr($request->apellido_materno, 0, 1));
                $dniPrefix = substr($request->dni, 0, 3);
                $codigoUsuario = $iniciales . '-' . $dniPrefix;
            }

            // Crear el usuario - CORREGIDO: 'contraseña' en lugar de 'password', sin 'tipo'
            $usuario = Usuario::create([
                'nombre' => ucfirst(strtolower($request->nombre)),
                'apellido_paterno' => ucfirst(strtolower($request->apellido_paterno)),
                'apellido_materno' => ucfirst(strtolower($request->apellido_materno)),
                'dni' => $request->dni,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'codigo_pais' => $request->codigo_pais ?? '+51',
                'codigo_usuario' => $codigoUsuario,
                'contraseña' => Hash::make($request->dni), // ← CORREGIDO: 'contraseña' con ñ
                'activo' => 1,
            ]);

            // ENVIAR CORREO CON LAS CREDENCIALES
            try {
                Mail::to($usuario->correo)->send(new CredencialesUsuario($usuario, $request->dni));
            } catch (\Exception $mailError) {
                // Si falla el envío, igual creamos el usuario pero lo registramos
                \Log::error('Error al enviar correo: ' . $mailError->getMessage());
            }

            return response()->json([
                'ok' => true,
                'message' => 'Usuario creado exitosamente',
                'codigo' => $usuario->codigo_usuario,
                'correo' => $usuario->correo
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Error al crear el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle user active status.
     */
    public function toggle($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->activo = !$usuario->activo;
            $usuario->save();

            return response()->json([
                'ok' => true,
                'activo' => $usuario->activo,
                'message' => $usuario->activo ? 'Usuario activado' : 'Usuario desactivado'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Error al cambiar estado'
            ], 500);
        }
    }

    /**
     * Get user details for modal.
     */
    public function show($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            return response()->json([
                'ok' => true,
                'usuario' => $usuario
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }
    }
}