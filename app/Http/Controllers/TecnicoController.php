<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tecnico;
use App\Models\Usuario;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;


class TecnicoController extends Controller
{
    public function dashboard()
    {
        if (session('tipo') !== 'tecnico' || !session('id')) {
            return redirect('/')->with('error', 'Acceso restringido.');
        }

        $tickets = DB::table('ticket')
            ->join('tipo_ticket',   'ticket.id_tipo_ticket', '=', 'tipo_ticket.id_tipo_ticket')
            ->join('prioridad',     'ticket.id_prioridad',   '=', 'prioridad.id_prioridad')
            ->join('estado_ticket', 'ticket.id_estado',      '=', 'estado_ticket.id_estado')
            ->join('cliente',       'ticket.id_cliente',     '=', 'cliente.id_cliente')
            ->join('usuario as usu','ticket.id_usuario',     '=', 'usu.id_usuario')
            ->leftJoin('tecnico as tec', 'ticket.id_tecnico_asignado', '=', 'tec.id_tecnico')
            ->where('estado_ticket.nombre_estado', 'PENDIENTE')
            ->select(
                'ticket.*',
                'tipo_ticket.nombre              as tipo_ticket_nombre',
                'prioridad.nombre                as prioridad_nombre',
                'prioridad.color_hex             as prioridad_color',
                'estado_ticket.nombre_estado     as estado',
                'estado_ticket.color_hex         as estado_color',
                'cliente.razon_social',
                'cliente.ruc',
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre"),
                'usu.codigo_usuario',
                DB::raw("CONCAT(COALESCE(usu.codigo_pais,''),' ',COALESCE(usu.telefono,'')) as usuario_telefono"),
                DB::raw("CONCAT(COALESCE(tec.nombre,''),' ',COALESCE(tec.apellido_paterno,'')) as tecnico_nombre"),
                'tec.codigo_tecnico as tecnico_codigo'
            )
            ->orderByDesc('ticket.created_at')
            ->get();

        $ticketIds = $tickets->pluck('id_ticket')->toArray();

        $evidencias  = DB::table('evidencia')
            ->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');
        $comentarios = DB::table('comentario')
            ->whereIn('id_ticket', $ticketIds)->orderBy('created_at')->get()->groupBy('id_ticket');
        $reportes    = DB::table('reporte_tecnico')
            ->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');

        $tickets->each(function ($t) use ($evidencias, $comentarios, $reportes) {
            $t->evidencias  = $evidencias->get($t->id_ticket,  collect());
            $t->comentarios = $comentarios->get($t->id_ticket, collect());
            $t->reportes    = $reportes->get($t->id_ticket,    collect());
        });

        $clientes = Cliente::orderBy('razon_social')->get();

        $resumen = [
            'total'     => $tickets->count(),
            'pendiente' => $tickets->count(),
        ];

        return view('tecnico.dashboard', compact('tickets', 'resumen', 'clientes'));
    }

    public function misTickets()
    {
        if (session('tipo') !== 'tecnico' || !session('id')) {
            return redirect('/')->with('error', 'Acceso restringido.');
        }

        $idTecnico = session('id');

        $tickets = DB::table('ticket')
            ->join('tipo_ticket',   'ticket.id_tipo_ticket',      '=', 'tipo_ticket.id_tipo_ticket')
            ->join('prioridad',     'ticket.id_prioridad',        '=', 'prioridad.id_prioridad')
            ->join('estado_ticket', 'ticket.id_estado',           '=', 'estado_ticket.id_estado')
            ->join('cliente',       'ticket.id_cliente',          '=', 'cliente.id_cliente')
            ->join('usuario as usu','ticket.id_usuario',          '=', 'usu.id_usuario')
            ->join('tecnico as tec','ticket.id_tecnico_asignado', '=', 'tec.id_tecnico')
            ->where('ticket.id_tecnico_asignado', $idTecnico)
            ->select(
                'ticket.*',
                'tipo_ticket.nombre              as tipo_ticket_nombre',
                'prioridad.nombre                as prioridad_nombre',
                'prioridad.color_hex             as prioridad_color',
                'estado_ticket.nombre_estado     as estado',
                'estado_ticket.color_hex         as estado_color',
                'cliente.razon_social',
                'cliente.ruc',
                'ticket.fecha_programado',
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre"),
                'usu.codigo_usuario',
                DB::raw("CONCAT(COALESCE(usu.codigo_pais,''),' ',COALESCE(usu.telefono,'')) as usuario_telefono"),
                DB::raw("CONCAT(tec.nombre,' ',tec.apellido_paterno) as tecnico_nombre"),
                'tec.codigo_tecnico as tecnico_codigo'
            )
            ->orderByDesc('ticket.created_at')
            ->get();

        $ticketIds = $tickets->pluck('id_ticket')->toArray();

        $evidencias  = DB::table('evidencia')
            ->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');
        $comentarios = DB::table('comentario')
            ->whereIn('id_ticket', $ticketIds)->orderBy('created_at')->get()->groupBy('id_ticket');
        $reportes    = DB::table('reporte_tecnico')
            ->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');

        $tickets->each(function ($t) use ($evidencias, $comentarios, $reportes) {
            $t->evidencias  = $evidencias->get($t->id_ticket,  collect());
            $t->comentarios = $comentarios->get($t->id_ticket, collect());
            $t->reportes    = $reportes->get($t->id_ticket,    collect());
        });

        $resumen = [
            'total'      => $tickets->count(),
            'programado' => $tickets->where('estado', 'PROGRAMADO')->count(),
            'en_proceso' => $tickets->where('estado', 'EN PROCESO')->count(),
            'cerrado'    => $tickets->where('estado', 'CERRADO')->count(),
            'cancelado'  => $tickets->where('estado', 'CANCELADO')->count(),
        ];

        return view('tecnico.mistickets', compact('tickets', 'resumen'));
    }

    public function autoAsignar(Request $request, $id)
    {
        if (session('tipo') !== 'tecnico' || !session('id')) {
            return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
        }

        $idTecnico = session('id');

        $estadoProgramado = DB::table('estado_ticket')
            ->where('nombre_estado', 'PROGRAMADO')
            ->value('id_estado');

        if (!$estadoProgramado) {
            return response()->json(['ok' => false, 'message' => 'Estado PROGRAMADO no encontrado.'], 500);
        }

        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
        if (!$ticket) {
            return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
        }

        $estadoPendiente = DB::table('estado_ticket')
            ->where('nombre_estado', 'PENDIENTE')
            ->value('id_estado');

        if ($ticket->id_estado != $estadoPendiente) {
            return response()->json(['ok' => false, 'message' => 'Solo puedes autoasignarte tickets pendientes.'], 422);
        }

        DB::table('ticket')->where('id_ticket', $id)->update([
            'id_tecnico_asignado' => $idTecnico,
            'id_estado'           => $estadoProgramado,
            'fecha_programado'    => now(),
            'updated_at'          => now(),
        ]);

        return response()->json(['ok' => true]);
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

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/');
    }

    public function detalleTicket($id)
    {
        if (session('tipo') !== 'tecnico' || !session('id')) {
            return response()->json(['message' => 'No autenticado.'], 401);
        }

        $ticket = DB::table('ticket')
            ->join('tipo_ticket',   'ticket.id_tipo_ticket',          '=', 'tipo_ticket.id_tipo_ticket')
            ->join('prioridad',     'ticket.id_prioridad',            '=', 'prioridad.id_prioridad')
            ->join('estado_ticket', 'ticket.id_estado',               '=', 'estado_ticket.id_estado')
            ->join('cliente',       'ticket.id_cliente',              '=', 'cliente.id_cliente')
            ->join('usuario as usu','ticket.id_usuario',              '=', 'usu.id_usuario')
            ->leftJoin('tecnico as tec','ticket.id_tecnico_asignado', '=', 'tec.id_tecnico')
            ->where('ticket.id_ticket', $id)
            ->select(
                'ticket.*',
                'tipo_ticket.nombre              as tipo_ticket_nombre',
                'prioridad.nombre                as prioridad_nombre',
                'prioridad.color_hex             as prioridad_color',
                'estado_ticket.nombre_estado     as estado',
                'estado_ticket.color_hex         as estado_color',
                'cliente.razon_social', 'cliente.ruc',
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre"),
                'usu.codigo_usuario',
                DB::raw("CONCAT(COALESCE(usu.codigo_pais,''),' ',COALESCE(usu.telefono,'')) as usuario_telefono"),
                DB::raw("CONCAT(COALESCE(tec.nombre,''),' ',COALESCE(tec.apellido_paterno,'')) as tecnico_nombre"),
                'tec.codigo_tecnico as tecnico_codigo'
            )
            ->first();

        if (!$ticket) return response()->json(['message' => 'Ticket no encontrado.'], 404);

        $ticket->evidencias  = DB::table('evidencia')->where('id_ticket', $id)->get();
        $ticket->comentarios = DB::table('comentario')->where('id_ticket', $id)->orderBy('created_at')->get();
        $ticket->reportes    = DB::table('reporte_tecnico')->where('id_ticket', $id)->get();

        return response()->json($ticket);
    }

    public function update(Request $request)
{
    // 1. Validar sesión (igual que en otros métodos)
    if (session('tipo') !== 'tecnico' || !session('id')) {
        return redirect('/')->with('error', 'Acceso restringido.');
    }

    // 2. Obtener el técnico
    $tecnico = \App\Models\Tecnico::find(session('id'));
    
    if (!$tecnico) {
        session()->flush();
        return redirect('/')->with('error', 'Técnico no encontrado.');
    }

    // 3. Validar datos (IDÉNTICO a UsuarioController, adaptado)
    $validator = Validator::make($request->all(), [
        'nombre'           => 'required|string|max:100',
        'apellido_paterno' => 'required|string|max:100',
        'apellido_materno' => 'required|string|max:100',
        'correo'           => 'required|email|unique:tecnico,correo,' . $tecnico->id_tecnico . ',id_tecnico',
        'telefono'         => 'required|digits_between:7,15',
        'nueva_contraseña' => 'nullable|min:6',
        'codigo_pais' => [
        'required',
        'regex:/^\+?\d{1,4}$/',  // ← Solo permite: + opcional + 1 a 4 números
        'max:10'  // ← Por seguridad extra
        ],
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
        'correo.required'           => 'El correo electrónico es obligatorio.',
        'correo.email'              => 'El correo electrónico no tiene un formato válido.',
        'correo.unique'             => 'Este correo ya está registrado en otro técnico.',
        'telefono.required'         => 'El número de teléfono es obligatorio.',
        'telefono.digits_between'   => 'El teléfono debe tener entre 7 y 15 dígitos numéricos.',
        'nueva_contraseña.min'      => 'La nueva contraseña debe tener al menos 6 caracteres.',
        'codigo_pais.required' => 'El código de país es obligatorio.',
        'codigo_pais.regex'    => 'El código de país debe tener formato válido (ej: +51, 51, +1).',
    ]);

    if ($validator->fails()) {
        return back()->with('error', $validator->errors()->first());
    }

    // 4. Actualizar campos (con formato igual que UsuarioController)
    $tecnico->nombre           = ucfirst(strtolower($request->nombre));
    $tecnico->apellido_paterno = ucfirst(strtolower($request->apellido_paterno));
    $tecnico->apellido_materno = ucfirst(strtolower($request->apellido_materno));
    $tecnico->correo           = $request->correo;
    $tecnico->codigo_pais      = $request->codigo_pais ?? '';
    $tecnico->telefono         = $request->telefono;

    // 5. Actualizar contraseña si se proporcionó
    if ($request->filled('nueva_contraseña')) {
        $tecnico->contraseña = Hash::make($request->nueva_contraseña);
    }

    // 6. Guardar (usando save() como en UsuarioController)
    $tecnico->save();

    // 7. Actualizar sesión con el nuevo nombre
    session(['nombre' => $tecnico->nombre]);

    // 8. Redirigir con mensaje de éxito (igual que UsuarioController)
    return back()->with('success', 'Perfil actualizado correctamente.');
}

    public function editarCamposTicket(Request $request, $id)
    {
        if (session('tipo') !== 'tecnico' || !session('id')) {
            return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'tipo_equipo'  => 'nullable|string|max:100',
            'marca'        => 'nullable|string|max:100',
            'modelo'       => 'nullable|string|max:100',
            'serie_serial' => 'nullable|string|max:100',
            'asunto'       => 'nullable|string|max:255',
            'problema'     => 'nullable|string',
        ], [
            'tipo_equipo.max'  => 'El tipo de equipo no puede superar los 100 caracteres.',
            'marca.max'        => 'La marca no puede superar los 100 caracteres.',
            'modelo.max'       => 'El modelo no puede superar los 100 caracteres.',
            'serie_serial.max' => 'El número de serie no puede superar los 100 caracteres.',
            'asunto.max'       => 'El asunto no puede superar los 255 caracteres.',
            'problema.string'  => 'El campo problema no es válido.',
        ]);

        if ($validator->fails()) {
            return response()->json(['ok' => false, 'message' => $validator->errors()->first()], 422);
        }

        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
        if (!$ticket) {
            return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
        }

        if ($ticket->id_tecnico_asignado != session('id')) {
            return response()->json(['ok' => false, 'message' => 'No tienes permiso.'], 403);
        }

        $estadoEnProceso = DB::table('estado_ticket')
            ->where('nombre_estado', 'EN PROCESO')->value('id_estado');

        $estadoActual = DB::table('estado_ticket')
            ->where('id_estado', $ticket->id_estado)->value('nombre_estado');

        $update = [
            'tipo_equipo'  => $request->tipo_equipo  ?: $ticket->tipo_equipo,
            'marca'        => $request->marca         ?: $ticket->marca,
            'modelo'       => $request->modelo        ?: $ticket->modelo,
            'serie_serial' => $request->serie_serial  ?: $ticket->serie_serial,
            'asunto'       => $request->asunto        ?: $ticket->asunto,
            'problema'     => $request->problema      ?: $ticket->problema,
            'updated_at'   => now(),
        ];

        if (in_array($estadoActual, ['PENDIENTE', 'PROGRAMADO'])) {
            $update['id_estado']        = $estadoEnProceso;
            $update['fecha_en_proceso'] = now();
        }

        DB::table('ticket')->where('id_ticket', $id)->update($update);

        return response()->json(['ok' => true]);
    }

    public function agregarComentario(Request $request, $id)
    {
        if (session('tipo') !== 'tecnico' || !session('id')) {
            return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'comentario' => 'required|string|max:2000',
        ], [
            'comentario.required' => 'El comentario es obligatorio.',
            'comentario.string'   => 'El comentario no es válido.',
            'comentario.max'      => 'El comentario no puede superar los 2000 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json(['ok' => false, 'message' => $validator->errors()->first()], 422);
        }

        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
        if (!$ticket) {
            return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
        }

        if ($ticket->id_tecnico_asignado != session('id')) {
            return response()->json(['ok' => false, 'message' => 'No tienes permiso.'], 403);
        }

        DB::table('comentario')->insert([
            'id_ticket'  => $id,
            'id_tecnico' => session('id'),
            'comentario' => $request->comentario,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $estadoActual = DB::table('estado_ticket')
            ->where('id_estado', $ticket->id_estado)->value('nombre_estado');

        if (in_array($estadoActual, ['PENDIENTE', 'PROGRAMADO'])) {
            $estadoEnProceso = DB::table('estado_ticket')
                ->where('nombre_estado', 'EN PROCESO')->value('id_estado');

            DB::table('ticket')->where('id_ticket', $id)->update([
                'id_estado'        => $estadoEnProceso,
                'fecha_en_proceso' => now(),
                'updated_at'       => now(),
            ]);
        }

        return response()->json(['ok' => true]);
    }

    public function subirReporte(Request $request, $id)
    {
        try {
            if (session('tipo') !== 'tecnico' || !session('id')) {
                return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
            }

            $validator = Validator::make($request->all(), [
                'archivo' => 'required|file|mimes:jpg,jpeg,png,gif,webp,pdf|max:10240',
            ], [
                'archivo.required' => 'Debes adjuntar un archivo.',
                'archivo.file'     => 'El archivo no es válido.',
                'archivo.mimes'    => 'Solo se permiten archivos JPG, PNG, GIF, WEBP o PDF.',
                'archivo.max'      => 'El archivo no puede superar los 5 MB.',
            ]);

            if ($validator->fails()) {
                return response()->json(['ok' => false, 'message' => $validator->errors()->first()], 422);
            }

            $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
            if (!$ticket) {
                return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
            }

            if ($ticket->id_tecnico_asignado != session('id')) {
                return response()->json(['ok' => false, 'message' => 'No tienes permiso.'], 403);
            }

            $yaExiste = DB::table('reporte_tecnico')->where('id_ticket', $id)->exists();
            if ($yaExiste) {
                return response()->json(['ok' => false, 'message' => 'Ya existe un reporte para este ticket.'], 422);
            }

            $file           = $request->file('archivo');
            $nombreOriginal = $file->getClientOriginalName();
            $extension      = $file->getClientOriginalExtension();
            $nombreBase     = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($nombreOriginal, PATHINFO_FILENAME));
            $nombreFinal    = $nombreBase . '_' . time() . '.' . $extension;
            $carpeta        = 'tecnico/Reportes/' . session('id') . '-TICKET-' . $id;
            $ruta           = $file->storeAs($carpeta, $nombreFinal, 'public');

            DB::table('reporte_tecnico')->insert([
                'id_ticket'       => $id,
                'id_tecnico'      => session('id'),
                'archivo_reporte' => $ruta,
                'nombre_original' => $nombreOriginal,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            $estadoActual = DB::table('estado_ticket')
                ->where('id_estado', $ticket->id_estado)->value('nombre_estado');

            if (in_array($estadoActual, ['PENDIENTE', 'PROGRAMADO'])) {
                $estadoEnProceso = DB::table('estado_ticket')
                    ->where('nombre_estado', 'EN PROCESO')->value('id_estado');

                DB::table('ticket')->where('id_ticket', $id)->update([
                    'id_estado'        => $estadoEnProceso,
                    'fecha_en_proceso' => now(),
                    'updated_at'       => now(),
                ]);
            }

            return response()->json(['ok' => true]);

        } catch (\Exception $e) {
            \Log::error('Error al subir reporte ticket #' . $id . ': ' . $e->getMessage());
            return response()->json(['ok' => false, 'message' => 'Ocurrió un error al subir el reporte. Inténtalo nuevamente.'], 500);
        }
    }

    public function cerrarTicket(Request $request, $id)
    {
        if (session('tipo') !== 'tecnico' || !session('id')) {
            return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
        }

        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
        if (!$ticket) {
            return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
        }

        if ($ticket->id_tecnico_asignado != session('id')) {
            return response()->json(['ok' => false, 'message' => 'No tienes permiso.'], 403);
        }

        $tieneReporte = DB::table('reporte_tecnico')->where('id_ticket', $id)->exists();
        if (!$tieneReporte) {
            return response()->json(['ok' => false, 'message' => 'No puedes cerrar el ticket sin subir el reporte técnico.'], 422);
        }

        $estadoCerrado = DB::table('estado_ticket')
            ->where('nombre_estado', 'CERRADO')->value('id_estado');

        DB::table('ticket')->where('id_ticket', $id)->update([
            'id_estado'      => $estadoCerrado,
            'fecha_resuelto' => now(),
            'updated_at'     => now(),
        ]);

        return response()->json(['ok' => true]);
    }

    public function cancelarTicket(Request $request, $id)
    {
        if (session('tipo') !== 'tecnico' || !session('id')) {
            return response()->json(['ok' => false, 'message' => 'No autenticado.'], 401);
        }

        $ticket = DB::table('ticket')->where('id_ticket', $id)->first();
        if (!$ticket) {
            return response()->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
        }

        if ($ticket->id_tecnico_asignado != session('id')) {
            return response()->json(['ok' => false, 'message' => 'No tienes permiso para cancelar este ticket.'], 403);
        }

        $estadoProgramado = DB::table('estado_ticket')
            ->where('nombre_estado', 'PROGRAMADO')->value('id_estado');

        if ($ticket->id_estado !== $estadoProgramado) {
            return response()->json(['ok' => false, 'message' => 'Solo se pueden cancelar tickets en estado PROGRAMADO.'], 422);
        }

        $estadoCancelado = DB::table('estado_ticket')
            ->where('nombre_estado', 'CANCELADO')->value('id_estado');

        if (!$estadoCancelado) {
            return response()->json(['ok' => false, 'message' => 'Estado CANCELADO no encontrado en la base de datos.'], 500);
        }

        DB::table('ticket')->where('id_ticket', $id)->update([
            'id_estado'  => $estadoCancelado,
            'updated_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }
}