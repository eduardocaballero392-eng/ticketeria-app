<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function tickets()
    {
        if (session('tipo') !== 'cliente' || !session('id')) {
            return redirect('/')->with('error', 'Debes iniciar sesión como empresa.');
        }

        $cliente  = Cliente::find(session('id'));
        $usuarios = Usuario::where('id_cliente', $cliente->id_cliente)
                        ->where('activo', 1)
                        ->orderBy('nombre')
                        ->get();

        $usuarioIds = $usuarios->pluck('id_usuario')->toArray();

        $tickets = DB::table('ticket')
        ->join('tipo_ticket',   'ticket.id_tipo_ticket',          '=', 'tipo_ticket.id_tipo_ticket')
        ->join('prioridad',     'ticket.id_prioridad',            '=', 'prioridad.id_prioridad')
        ->join('estado_ticket', 'ticket.id_estado',               '=', 'estado_ticket.id_estado')
        ->join('cliente',       'ticket.id_cliente',              '=', 'cliente.id_cliente')  // 👈 esto faltaba
        ->join('usuario as usu','ticket.id_usuario',              '=', 'usu.id_usuario')
        ->leftJoin('tecnico as tec','ticket.id_tecnico_asignado', '=', 'tec.id_tecnico')
        ->select(
            'ticket.*',
            'tipo_ticket.nombre              as tipo_ticket_nombre',
            'prioridad.nombre                as prioridad_nombre',
            'prioridad.color_hex             as prioridad_color',
            'estado_ticket.nombre_estado     as estado',
            'cliente.razon_social',
            'cliente.ruc',  
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre"),
                'usu.id_usuario                  as usuario_id',
                'usu.codigo_usuario',
                'usu.dni                         as usuario_dni',
                DB::raw("CONCAT(COALESCE(usu.codigo_pais,''),' ',COALESCE(usu.telefono,'')) as usuario_telefono"),
                DB::raw("CONCAT(COALESCE(tec.nombre,''),' ',COALESCE(tec.apellido_paterno,'')) as tecnico_nombre"),
                'tec.codigo_tecnico as tecnico_codigo'
            )
            ->whereIn('ticket.id_usuario', $usuarioIds)
            ->orderByDesc('ticket.created_at')
            ->get();

        $ticketIds = $tickets->pluck('id_ticket')->toArray();

        $evidencias  = DB::table('evidencia')
            ->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');
        $comentarios = DB::table('comentario')
            ->whereIn('id_ticket', $ticketIds)->orderBy('created_at')->get()->groupBy('id_ticket');
        $reportes    = DB::table('reporte_tecnico')
            ->whereIn('id_ticket', $ticketIds)->get()->groupBy('id_ticket');

        $tickets->each(function ($ticket) use ($evidencias, $comentarios, $reportes) {
            $ticket->evidencias  = $evidencias->get($ticket->id_ticket,  collect());
            $ticket->comentarios = $comentarios->get($ticket->id_ticket, collect());
            $ticket->reportes    = $reportes->get($ticket->id_ticket,    collect());
        });

        $ticketsPorUsuario = $tickets->groupBy('usuario_id');

        return view('cliente.mistickets', compact('cliente', 'usuarios', 'tickets', 'ticketsPorUsuario'));
    }

    public function datos()
    {
        $cliente = Cliente::find(session('id'));

        session(['nombre' => $cliente->razon_social]);
        session(['correo'  => $cliente->correo]);

        return view('cliente.datos', compact('cliente'));
    }

    public function update(Request $request)
    {
        $cliente = Cliente::find(session('id'));

        $request->validate([
            'razon_social' => 'required|string|max:100',
            'ruc'          => 'required|digits:11',
            'correo'       => 'required|email|max:100',
            'rubro'        => 'required|string|max:100',
            'sedes'        => 'required|string|max:100',
        ]);

        $cliente->razon_social = ucfirst(strtolower($request->razon_social));
        $cliente->ruc          = $request->ruc;
        $cliente->correo       = $request->correo;
        $cliente->rubro        = ucfirst(strtolower($request->rubro));
        $cliente->sedes        = $request->sedes;

        if ($request->filled('password_nuevo')) {
            if ($request->password_actual !== $cliente->contraseña) {
                return back()->with('error', 'La contraseña actual es incorrecta.')->withInput();
            }
            $cliente->contraseña = $request->password_nuevo;
        }

        $cliente->save();

        session(['nombre' => $cliente->razon_social]);
        session(['correo'  => $cliente->correo]);

        return back()->with('success', 'Datos actualizados correctamente.');
    }

    public function dashboard()
    {
        $cliente  = Cliente::find(session('id'));
        $usuarios = Usuario::where('id_cliente', $cliente->id_cliente)->get();
        return view('cliente.dashboard', compact('cliente', 'usuarios'));
    }

    public function usuarios()
    {
        if (session('tipo') !== 'cliente' || !session('id')) {
            return redirect('/')->with('error', 'Debes iniciar sesión como empresa.');
        }

        $cliente  = Cliente::find(session('id'));
        $usuarios = Usuario::where('id_cliente', $cliente->id_cliente)->get();
        $activos  = $usuarios->where('activo', 1)->count();

        return view('cliente.usuarios', compact('usuarios', 'activos'));
    }

public function storeUsuario(Request $request)
{
    $cliente = Cliente::find(session('id'));

    $request->validate([
        'nombre' => [
            'required', 'string', 'max:100',
            'regex:/^[\pL\s]+$/u'
        ],
        'apellido_paterno' => [
            'required', 'string', 'max:100',
            'regex:/^[\pL\s]+$/u'
        ],
        'apellido_materno' => [
            'required', 'string', 'max:100',
            'regex:/^[\pL\s]+$/u'
        ],
        'dni' => [
            'required',
            'string',
            'min:3',
            'max:15',
            'unique:usuario,dni'
        ],
        'telefono' => [
            'required',
            'string',
            'min:7',
            'max:15',
            'regex:/^[0-9]+$/'
        ],
    ], [
        'nombre.regex'           => 'El nombre solo debe contener letras.',
        'apellido_paterno.regex' => 'El apellido paterno solo debe contener letras.',
        'apellido_materno.regex' => 'El apellido materno solo debe contener letras.',
        'dni.min'                => 'El documento debe tener al menos 3 caracteres.',
        'dni.unique'             => 'Este DNI ya se encuentra registrado.',
        'telefono.required'      => 'El teléfono es obligatorio.',
        'telefono.min'           => 'El teléfono debe tener al menos 7 dígitos.',
        'telefono.max'           => 'El teléfono no puede tener más de 15 dígitos.',
        'telefono.regex'         => 'El teléfono solo debe contener números.',
    ]);

    // ── Helper limpiar ────────────────────────────────────────────────
    $limpiar = function (string $texto): string {
        $texto = mb_strtolower($texto, 'UTF-8');
        $texto = strtr($texto, [
            'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u',
            'à'=>'a','è'=>'e','ì'=>'i','ò'=>'o','ù'=>'u',
            'ä'=>'a','ë'=>'e','ï'=>'i','ö'=>'o','ü'=>'u',
            'â'=>'a','ê'=>'e','î'=>'i','ô'=>'o','û'=>'u',
            'ñ'=>'n','ç'=>'c',
        ]);
        return preg_replace('/[^a-z0-9]/', '', $texto);
    };

    $primerNombre  = $limpiar(explode(' ', trim($request->nombre))[0]);
    $primerEmpresa = $limpiar(explode(' ', trim($cliente->razon_social))[0]);

    // ── Código autoincrementable ──────────────────────────────────────
    $codigoBase  = strtoupper($request->codigo_usuario);
    $codigoFinal = $codigoBase;
    $contador    = 1;

    while (Usuario::where('codigo_usuario', $codigoFinal)->exists()) {
        $codigoFinal = $codigoBase . $contador++;
    }

    // ── Correo generado ───────────────────────────────────────────────
    $correoGenerado = $primerNombre
        . strtolower($codigoFinal)
        . '@'
        . $primerEmpresa
        . '.com';

    // ── Crear usuario ─────────────────────────────────────────────────
    Usuario::create([
        'id_cliente'       => $cliente->id_cliente,
        'codigo_usuario'   => $codigoFinal,
        'nombre'           => ucfirst(strtolower($request->nombre)),
        'apellido_paterno' => ucfirst(strtolower($request->apellido_paterno)),
        'apellido_materno' => ucfirst(strtolower($request->apellido_materno)),
        'dni'              => $request->dni,
        'codigo_pais'      => $request->codigo_pais,
        'telefono'         => $request->telefono,
        'correo'           => $correoGenerado,
        'contraseña'       => Hash::make($request->dni),
        'activo'           => 1,
    ]);

    // ✅ DEVOLVER JSON EN LUGAR DE with('success')
    return response()->json([
        'ok'      => true,
        'message' => 'Usuario creado.',
        'codigo'  => $codigoFinal,
        'correo'  => $correoGenerado,
    ]);
}

    public function toggleUsuario($id)
    {
        $cliente = Cliente::find(session('id'));
        $usuario = Usuario::where('id_usuario', $id)
                          ->where('id_cliente', $cliente->id_cliente)
                          ->firstOrFail();

        $usuario->activo = !$usuario->activo;
        $usuario->save();

        return response()->json(['ok' => true]);
    }

    public function mistickets()
    {
        if (session('tipo') !== 'cliente' || !session('id')) {
            return redirect('/')->with('error', 'Debes iniciar sesión como empresa.');
        }
    
        $cliente  = Cliente::find(session('id'));
        $usuarios = Usuario::where('id_cliente', $cliente->id_cliente)
                        ->where('activo', 1)
                        ->orderBy('nombre')
                        ->get();
    
        $usuarioIds = $usuarios->pluck('id_usuario')->toArray();
    
        $tickets = DB::table('ticket')
        ->join('tipo_ticket',   'ticket.id_tipo_ticket',          '=', 'tipo_ticket.id_tipo_ticket')
        ->join('prioridad',     'ticket.id_prioridad',            '=', 'prioridad.id_prioridad')
        ->join('estado_ticket', 'ticket.id_estado',               '=', 'estado_ticket.id_estado')
        ->join('cliente',       'ticket.id_cliente',              '=', 'cliente.id_cliente')  // 👈 esto faltaba
        ->join('usuario as usu','ticket.id_usuario',              '=', 'usu.id_usuario')
        ->leftJoin('tecnico as tec','ticket.id_tecnico_asignado', '=', 'tec.id_tecnico')
        ->select(
            'ticket.*',
            'tipo_ticket.nombre              as tipo_ticket_nombre',
            'prioridad.nombre                as prioridad_nombre',
            'prioridad.color_hex             as prioridad_color',
            'estado_ticket.nombre_estado     as estado',
            'cliente.razon_social',
            'cliente.ruc',                   
                DB::raw("CONCAT(usu.nombre,' ',usu.apellido_paterno,' ',usu.apellido_materno) as usuario_nombre"),
                'usu.id_usuario                  as usuario_id',
                'usu.codigo_usuario',
                'usu.dni                         as usuario_dni',
                DB::raw("CONCAT(COALESCE(usu.codigo_pais,''),' ',COALESCE(usu.telefono,'')) as usuario_telefono"),
                DB::raw("CONCAT(COALESCE(tec.nombre,''),' ',COALESCE(tec.apellido_paterno,'')) as tecnico_nombre"),
                'tec.codigo_tecnico as tecnico_codigo'
            )
            ->whereIn('ticket.id_usuario', $usuarioIds)
            ->orderByDesc('ticket.created_at')
            ->get();
    
        $ticketIds = $tickets->pluck('id_ticket')->toArray();
    
        $evidencias = DB::table('evidencia')
            ->whereIn('id_ticket', $ticketIds)
            ->get()->groupBy('id_ticket');
    
        $comentarios = DB::table('comentario')
            ->whereIn('id_ticket', $ticketIds)
            ->orderBy('created_at')
            ->get()->groupBy('id_ticket');
    
        $reportes = DB::table('reporte_tecnico')
            ->whereIn('id_ticket', $ticketIds)
            ->get()->groupBy('id_ticket');
    
        $tickets->each(function ($ticket) use ($evidencias, $comentarios, $reportes) {
            $ticket->evidencias  = $evidencias->get($ticket->id_ticket,  collect());
            $ticket->comentarios = $comentarios->get($ticket->id_ticket, collect());
            $ticket->reportes    = $reportes->get($ticket->id_ticket,    collect());
        });
    
        // Agrupar tickets por usuario para el JS
        $ticketsPorUsuario = $tickets->groupBy('usuario_id');
    
        return view('cliente.mistickets', compact('cliente', 'usuarios', 'tickets', 'ticketsPorUsuario'));
    }
}