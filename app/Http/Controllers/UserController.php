<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cliente;

class UserController extends Controller
{
    public function index()
    {
        $userId = session('id');
        $tipo   = session('tipo');

        if (!$userId) {
            return redirect('/')->with('error', 'Debes iniciar sesión.');
        }

        $user = User::find($userId);

        if (!$user) {
            session()->flush();
            return redirect('/')->with('error', 'Usuario no válido.');
        }

        // Redirección si es Admin
        if ($tipo === 'admin' && $user->esAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Panel para el Técnico
        if ($tipo === 'tecnico' && $user->esTecnico()) {
            $clientes = Cliente::all();
            
            // Obtenemos los tickets asignados al técnico actual
            $tickets = $this->obtenerTicketsBase()
                ->where('ticket.id_tecnico_asignado', $userId)
                ->get();

            return view('tecnico.dashboard', [
                'user'               => $user,
                'tickets'            => $tickets,
                'clientes'           => $clientes,
                'totalTickets'       => $tickets->count(),
                'ticketsPendientes'  => $tickets->where('estado', 'PENDIENTE')->count(),
                'ticketsProgramados' => $tickets->where('estado', 'PROGRAMADO')->count(),
                'ticketsEnProceso'   => $tickets->where('estado', 'EN PROCESO')->count(),
                'ticketsCerrados'    => $tickets->where('estado', 'CERRADO')->count(),
                'ticketsCancelados'  => $tickets->where('estado', 'CANCELADO')->count(),    
            ]);
        }

        return redirect('/')->with('error', 'Permisos insuficientes.');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/')->with('success', 'Sesión cerrada.');
    }

    
}