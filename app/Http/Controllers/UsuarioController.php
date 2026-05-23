<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 

class UsuarioController extends Controller
{
    public function dashboard()
    {
        if (
            (session('tipo') !== 'usuario' && session('tipo') !== 'admin')
            || !session('id')
        ) {
            return redirect('/')->with('error', 'Acceso restringido.');
        }

        $usuario = Usuario::find(session('id'));

        if (!$usuario) {
            session()->flush();
            return redirect('/')->with('error', 'Usuario no encontrado.');
        }

        $tickets = DB::table('ticket')
            ->join('tipo_ticket',   'ticket.id_tipo_ticket',          '=', 'tipo_ticket.id_tipo_ticket')
            ->join('prioridad',     'ticket.id_prioridad',            '=', 'prioridad.id_prioridad')
            ->join('estado_ticket', 'ticket.id_estado',               '=', 'estado_ticket.id_estado')
            ->join('cliente',       'ticket.id_cliente',              '=', 'cliente.id_cliente')
            ->join('usuario as usu','ticket.id_usuario',              '=', 'usu.id_usuario')
            ->leftJoin('tecnico as tec', 'ticket.id_tecnico_asignado','=', 'tec.id_tecnico')  // ← CAMBIO
            ->select(
                'ticket.*',
                'tipo_ticket.nombre              as tipo_ticket_nombre',
                'prioridad.nombre                as prioridad_nombre',
                'prioridad.color_hex             as prioridad_color',
                'estado_ticket.nombre_estado     as estado',
                'cliente.razon_social',
                'cliente.ruc',
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre"),
                'usu.codigo_usuario',
                DB::raw("CONCAT(COALESCE(usu.codigo_pais,''),' ',COALESCE(usu.telefono,'')) as usuario_telefono"),
                DB::raw("CONCAT(COALESCE(tec.nombre,''),' ',COALESCE(tec.apellido_paterno,'')) as tecnico_nombre"),  // ← CAMBIO
                'tec.codigo_tecnico as tecnico_codigo'  // ← CAMBIO
            )
            ->where('ticket.id_usuario', session('id'))
            ->orderByDesc('ticket.created_at')
            ->get();

        $ticketIds = $tickets->pluck('id_ticket')->toArray();

        $evidencias = DB::table('evidencia')
            ->whereIn('id_ticket', $ticketIds)
            ->get()
            ->groupBy('id_ticket');

        $comentarios = DB::table('comentario')
            ->whereIn('id_ticket', $ticketIds)
            ->orderBy('created_at')
            ->get()
            ->groupBy('id_ticket');

        $reportes = DB::table('reporte_tecnico')
            ->whereIn('id_ticket', $ticketIds)
            ->get()
            ->groupBy('id_ticket');

        $tickets->each(function ($ticket) use ($evidencias, $comentarios, $reportes) {
            $ticket->evidencias  = $evidencias->get($ticket->id_ticket,  collect());
            $ticket->comentarios = $comentarios->get($ticket->id_ticket, collect());
            $ticket->reportes    = $reportes->get($ticket->id_ticket,    collect());
        });

        return view('usuario.dashboard', compact('usuario', 'tickets'));
    }
    public function datos() 
    {
        // Necesitamos buscar al usuario para pasarlo a la vista
        $usuario = Usuario::find(session('id'));
        return view('usuario.datos', compact('usuario'));
    }

   public function update(Request $request)
{
    $usuario = Usuario::find(session('id'));

    $validator = Validator::make($request->all(), [
        'nombre'           => 'required|string|max:100',
        'apellido_paterno' => 'required|string|max:100',
        'apellido_materno' => 'required|string|max:100',
        'correo'           => 'required|email|unique:usuario,correo,' . $usuario->id_usuario . ',id_usuario',
        'telefono'         => 'required|digits_between:7,15',
        'nueva_contraseña' => 'nullable|min:6',
        'codigo_pais' => [
        'required',
        'regex:/^\+?\d{1,4}$/',
        'max:10'
        ],
    ], [
        'nombre.required'           => 'El nombre es obligatorio.',
        'nombre.string'             => 'El nombre debe ser un texto válido.',
        'nombre.max'                => 'El nombre no puede superar los 100 caracteres.',
        'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
        'apellido_paterno.string'   => 'El apellido paterno debe ser un texto válido.',
        'codigo_pais.required'      => 'El código de país es obligatorio.',
        'apellido_paterno.max'      => 'El apellido paterno no puede superar los 100 caracteres.',
        'apellido_materno.required' => 'El apellido materno es obligatorio.',
        'apellido_materno.string'   => 'El apellido materno debe ser un texto válido.',
        'apellido_materno.max'      => 'El apellido materno no puede superar los 100 caracteres.',
        'correo.required'           => 'El correo electrónico es obligatorio.',
        'correo.email'              => 'El correo electrónico no tiene un formato válido.',
        'correo.unique'             => 'Este correo ya está registrado en otro usuario.',
        'telefono.required'         => 'El número de teléfono es obligatorio.',
        'codigo_pais.required' => 'El código de país es obligatorio.',
        'codigo_pais.regex'    => 'El código de país debe tener formato válido (ej: +51, 51, +1).',
        'telefono.digits_between'   => 'El teléfono debe tener entre 7 y 15 dígitos numéricos.',
        'nueva_contraseña.min'      => 'La nueva contraseña debe tener al menos 6 caracteres.',
    ]);

    if ($validator->fails()) {
        return back()->with('error', $validator->errors()->first());
    }

    $usuario->nombre           = ucfirst(strtolower($request->nombre));
    $usuario->apellido_paterno = ucfirst(strtolower($request->apellido_paterno));
    $usuario->apellido_materno = ucfirst(strtolower($request->apellido_materno));
    $usuario->correo           = $request->correo;
    $usuario->codigo_pais      = $request->codigo_pais ?? '';
    $usuario->telefono         = $request->telefono;

    if ($request->filled('nueva_contraseña')) {
        $usuario->contraseña = Hash::make($request->nueva_contraseña);
    }

    $usuario->save();

    session(['nombre' => $usuario->nombre]);

    return back()->with('success', 'Perfil actualizado correctamente.');
}


    public function logout()
    {
        session()->flush();

        return redirect('/')
            ->with('success', 'Sesión cerrada correctamente.');
    }


    public function tickets()
    {
        if (session('tipo') !== 'usuario' || !session('id')) {
            return redirect('/')->with('error', 'Acceso restringido.');
        }

        $tickets = DB::table('ticket')
            ->join('tipo_ticket',   'ticket.id_tipo_ticket',          '=', 'tipo_ticket.id_tipo_ticket')
            ->join('prioridad',     'ticket.id_prioridad',            '=', 'prioridad.id_prioridad')
            ->join('estado_ticket', 'ticket.id_estado',               '=', 'estado_ticket.id_estado')
            ->join('cliente',       'ticket.id_cliente',              '=', 'cliente.id_cliente')
            ->join('usuario as usu','ticket.id_usuario',              '=', 'usu.id_usuario')
            ->leftJoin('tecnico as tec', 'ticket.id_tecnico_asignado', '=', 'tec.id_tecnico')
            ->select(
                'ticket.*',
                'tipo_ticket.nombre              as tipo_ticket_nombre',
                'prioridad.nombre                as prioridad_nombre',
                'prioridad.color_hex             as prioridad_color',
                'estado_ticket.nombre_estado     as estado',
                'cliente.razon_social',
                'cliente.ruc',
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre"),
                'usu.codigo_usuario',
                DB::raw("CONCAT(COALESCE(usu.codigo_pais,''), ' ', COALESCE(usu.telefono,'')) as usuario_telefono"),
                DB::raw("CONCAT(COALESCE(tec.nombre,''),' ',COALESCE(tec.apellido_paterno,''),' ',COALESCE(tec.apellido_materno,'')) as tecnico_nombre"),
                'tec.codigo_tecnico as tecnico_codigo'
            )
            ->where('ticket.id_usuario', session('id'))
            ->orderByDesc('ticket.created_at')
            ->get();

        $ticketIds = $tickets->pluck('id_ticket')->toArray();

        $evidencias = DB::table('evidencia')
            ->whereIn('id_ticket', $ticketIds)
            ->get()
            ->groupBy('id_ticket');

        $comentarios = DB::table('comentario')
            ->whereIn('id_ticket', $ticketIds)
            ->orderBy('created_at')
            ->get()
            ->groupBy('id_ticket');

        $reportes = DB::table('reporte_tecnico')
            ->whereIn('id_ticket', $ticketIds)
            ->get()
            ->groupBy('id_ticket');

        $tickets->each(function ($ticket) use ($evidencias, $comentarios, $reportes) {
            $ticket->evidencias  = $evidencias->get($ticket->id_ticket,  collect());
            $ticket->comentarios = $comentarios->get($ticket->id_ticket, collect());
            $ticket->reportes    = $reportes->get($ticket->id_ticket,    collect());
        });

        return view('usuario.tickets', compact('tickets'));
    }

    public function mail() {
        return view('usuario.mail');
    }
}