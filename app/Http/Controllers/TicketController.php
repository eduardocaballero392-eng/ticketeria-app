<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function store(Request $request)
{
    $idUsuario = session('id');

    // ── Validar sesión ──
    if (!$idUsuario) {
        return response()->json([
            'ok' => false,
            'message' => 'No autorizado.'
        ], 403);
    }

    // ── Buscar usuario ──
    $usuario = DB::table('usuario')
        ->where('id_usuario', $idUsuario)
        ->first();

    if (!$usuario) {
        return response()->json([
            'ok' => false,
            'message' => 'Usuario no encontrado.'
        ], 404);
    }

    // ── Validación ──
    // SOLO OBLIGATORIOS:
    // 1. Tipo de ticket
    // 2. Prioridad
    // 3. Descripción del problema
    // Evidencia es opcional
    $validator = Validator::make($request->all(), [
    'id_tipo_ticket' => 'required|exists:tipo_ticket,id_tipo_ticket',
    'id_prioridad'   => 'required|exists:prioridad,id_prioridad',
    'problema'       => 'required|string',

    // Opcionales
    'asunto'         => 'nullable|string|max:255',
    'tipo_equipo'    => 'nullable|string|max:100',
    'marca'          => 'nullable|string|max:100',
    'modelo'         => 'nullable|string|max:100',
    'serie_serial'   => 'nullable|string|max:100',

    // Evidencia opcional
    'evidencia'      => 'nullable|array|max:5',
    'evidencia.*'    => 'file|mimes:jpg,jpeg,png,pdf,mp4,mov|max:20480',
], [
    'id_tipo_ticket.required' => 'El tipo de ticket es obligatorio.',
    'id_tipo_ticket.exists'   => 'El tipo de ticket no es válido.',
    'id_prioridad.required'   => 'La prioridad es obligatoria.',
    'id_prioridad.exists'     => 'La prioridad no es válida.',
    'problema.required'       => 'La descripción del problema es obligatoria.',
    'asunto.max'              => 'El asunto no puede superar los 255 caracteres.',
    'evidencia.max'           => 'No puedes subir más de 5 archivos.',
    'evidencia.*.mimes'       => 'Solo se permiten archivos JPG, PNG, PDF, MP4 o MOV.',
    'evidencia.*.max'         => 'Cada archivo no puede superar los 20 MB.',
]);

if ($validator->fails()) {
    return response()->json(['ok' => false, 'message' => $validator->errors()->first()], 422);
}

    // ── Obtener tipo de ticket ──
    $tipoTicket = DB::table('tipo_ticket')
        ->where('id_tipo_ticket', $request->id_tipo_ticket)
        ->first();

    // ── Generar código único ──
    $incremento = Ticket::where('id_tipo_ticket', $request->id_tipo_ticket)->count() + 1;

    $codigo = strtoupper($tipoTicket->prefijo)
        . '-'
        . str_pad($incremento, 8, '0', STR_PAD_LEFT)
        . '-'
        . strtoupper($usuario->codigo_usuario);

    // ── Si no enviaron asunto, generar uno automático ──
    $asunto = trim($request->asunto);

    if (!$asunto) {
        $asunto = $tipoTicket->nombre;
    }

    // ── Crear ticket ──
    $ticket = Ticket::create([
        'codigo_ticket'  => $codigo,
        'id_cliente'     => $usuario->id_cliente,
        'id_usuario'     => $idUsuario,
        'id_tipo_ticket' => $request->id_tipo_ticket,
        'id_prioridad'   => $request->id_prioridad, 
        'id_estado'      => 1, // Pendiente

        // Opcionales
        'tipo_equipo'    => $request->tipo_equipo,
        'marca'          => $request->marca,
        'modelo'         => $request->modelo,
        'serie_serial'   => $request->serie_serial,

        // Obligatorios / automáticos
        'asunto'         => $asunto,
        'problema'       => $request->problema,
    ]);

    // ── Guardar evidencias (opcional) ──
    if ($request->hasFile('evidencia')) {
        foreach ($request->file('evidencia') as $archivo) {
            $nombreOriginal = $archivo->getClientOriginalName();
            $extension = $archivo->getClientOriginalExtension();

            $nombreBase = pathinfo($nombreOriginal, PATHINFO_FILENAME);
            $nombreBase = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nombreBase);

            $nombreFinal = $nombreBase . '_' . time() . '.' . $extension;

            $carpeta = 'usuario/Evidencias/'
                . strtoupper($usuario->codigo_usuario)
                . '-' . $ticket->id_ticket;

            $ruta = $archivo->storeAs($carpeta, $nombreFinal, 'public');

            DB::table('evidencia')->insert([
                'id_ticket'       => $ticket->id_ticket,
                'ruta_archivo'    => $ruta,
                'nombre_original' => $nombreOriginal,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }

    // ── Respuesta JSON ──
    return response()->json([
        'ok'      => true,
        'message' => 'Ticket creado correctamente.',
        'codigo'  => $codigo,
    ]);
}

public function datos()
{
    if (session('tipo') !== 'tecnico' || !session('id')) {
        return redirect('/')->with('error', 'Acceso restringido.');
    }

    $tecnico = \App\Models\Tecnico::find(session('id'));

    if (!$tecnico) {
        session()->flush();
        return redirect('/')->with('error', 'Técnico no encontrado.');
    }

    return view('tecnico.datos', compact('tecnico'));
}

public function update(Request $request)
{
    if (session('tipo') !== 'tecnico' || !session('id')) {
        return redirect('/')->with('error', 'Acceso restringido.');
    }

    $tecnico = \App\Models\Tecnico::find(session('id'));

    $validator = Validator::make($request->all(), [
        'nombre'           => 'required|string|max:100',
        'apellido_paterno' => 'required|string|max:100',
        'apellido_materno' => 'required|string|max:100',
        'telefono'         => 'nullable|string|max:15',
        'nueva_contraseña' => 'nullable|min:6',
    ], [
        'nombre.required'           => 'El nombre es obligatorio.',
        'nombre.string'             => 'El nombre debe ser un texto válido.',
        'nombre.max'                => 'El nombre no puede superar los 100 caracteres.',
        'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
        'apellido_paterno.string'   => 'El apellido paterno debe ser un texto válido.',
        'apellido_paterno.max'      => 'El apellido paterno no puede superar los 100 caracteres.',
        'apellido_materno.required' => 'El apellido materno es obligatorio.',
        'apellido_materno.string'   => 'El apellido materno debe ser un texto válido.',
        'apellido_materno.max'      => 'El apellido materno no puede superar los 100 caracteres.',
        'telefono.max'              => 'El teléfono no puede superar los 15 caracteres.',
        'nueva_contraseña.min'      => 'La nueva contraseña debe tener al menos 6 caracteres.',
    ]);

    if ($validator->fails()) {
        return back()->with('error', $validator->errors()->first());
    }

    $tecnico->nombre           = ucfirst(strtolower($request->nombre));
    $tecnico->apellido_paterno = ucfirst(strtolower($request->apellido_paterno));
    $tecnico->apellido_materno = ucfirst(strtolower($request->apellido_materno));

    if ($request->filled('nueva_contraseña')) {
        $tecnico->contraseña = \Illuminate\Support\Facades\Hash::make($request->nueva_contraseña);
    }

    $tecnico->save();

    session(['nombre' => $tecnico->nombre]);

    return back()->with('success', 'Perfil actualizado correctamente.');
}
}