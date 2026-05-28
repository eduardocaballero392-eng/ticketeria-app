<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Cliente\UsuarioController as ClienteUsuarioController; // ← NUEVO

// ===================== RUTAS PÚBLICAS =====================
Route::get('/', function () {
    return view('index');
})->name('home');

Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ===================== 1. CLIENTE (Empresas) =====================
Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/', function () { return redirect()->route('cliente.datos'); });
    Route::get('/datos',         [ClienteController::class, 'datos'])->name('datos');
    Route::post('/datos/update', [ClienteController::class, 'update'])->name('update');
    Route::get('/dashboard',     [ClienteController::class, 'dashboard'])->name('dashboard');
    Route::get('/mistickets',    [ClienteController::class, 'tickets'])->name('tickets');
    Route::post('/ticket',       [TicketController::class, 'store'])->name('ticket.store');
    Route::get('/contactos',     [ClienteController::class, 'contactos'])->name('contactos');

    // Gestión de usuarios - AHORA USA EL NUEVO CONTROLADOR
    Route::get('/usuarios',              [ClienteUsuarioController::class, 'index'])->name('usuarios');
    Route::post('/usuarios/store',       [ClienteUsuarioController::class, 'store'])->name('usuarios.store');
    Route::post('/usuarios/{id}/toggle', [ClienteUsuarioController::class, 'toggle'])->name('usuarios.toggle');
    Route::get('/usuarios/{id}',         [ClienteUsuarioController::class, 'show'])->name('usuarios.show');
}); 


// ===================== 2. ADMIN =====================
Route::prefix('admin')->name('admin.')->group(function () {

    // Toggle estado (activar/desactivar)
    Route::post('/{tipo}/{id}/toggle', [AdminController::class, 'toggleEstado']);

    Route::get('/dashboard',     [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/datos',         [AdminController::class, 'datos'])->name('datos');
    Route::post('/datos/update', [AdminController::class, 'update'])->name('update');
    Route::get('/asignarticket', [AdminController::class, 'asignarticket'])->name('asignarticket');
    Route::get('/clientes',      [AdminController::class, 'clientes'])->name('clientes');
    Route::get('/mis-tickets',   [AdminController::class, 'misTickets'])->name('mistickets');
    Route::get('/contactos',     [AdminController::class, 'contactos'])->name('contactos');
    
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::post('/clientes/{id}/estado', [AdminController::class, 'cambiarEstado']);
    Route::post('/tecnicos/{id}/estado', [AdminController::class, 'cambiarEstadoTecnico']);

    Route::get('/detalle/cliente/{id}', [AdminController::class, 'detalleCliente'])->name('detalle.cliente');
    Route::get('/detalle/usuario/{id}', [AdminController::class, 'detalleUsuario'])->name('detalle.usuario');
    Route::get('/detalle/tecnico/{id}', [AdminController::class, 'detalleTecnico'])->name('detalle.tecnico');

    Route::post('/editar/cliente/{id}', [AdminController::class, 'editarCliente'])->name('editar.cliente');
    Route::post('/editar/usuario/{id}', [AdminController::class, 'editarUsuario'])->name('editar.usuario');
    Route::post('/editar/tecnico/{id}', [AdminController::class, 'editarTecnico'])->name('editar.tecnico');

    Route::post('/guardar-cliente', [AdminController::class, 'crearCliente'])->name('cliente.guardar');
    Route::post('/guardar-usuario', [AdminController::class, 'guardarUsuario'])->name('usuario.guardar');
    Route::post('/guardar-tecnico', [AdminController::class, 'crearTecnico'])->name('tecnico.guardar');

    Route::get('/ticket/{id}/detalle',        [AdminController::class, 'detalleTicket'])->name('ticket.detalle');
    Route::post('/ticket/{id}/asignar',       [AdminController::class, 'asignarTecnico'])->name('ticket.asignar');
    Route::post('/ticket/{id}/cancelar',      [AdminController::class, 'cancelarTicket'])->name('ticket.cancelar');
    Route::post('/ticket/{id}/editar-campos', [AdminController::class, 'editarCamposTicket'])->name('ticket.editarCampos');
    Route::post('/ticket/{id}/comentario',    [AdminController::class, 'agregarComentario'])->name('ticket.comentario');
    Route::post('/ticket/{id}/reporte',       [AdminController::class, 'subirReporte'])->name('ticket.reporte');
    Route::post('/ticket/{id}/cerrar',        [AdminController::class, 'cerrarTicket'])->name('ticket.cerrar');
});

// ===================== 3. TECNICO =====================
Route::prefix('tecnico')->name('tecnico.')->group(function () {

    Route::get('/dashboard',   [TecnicoController::class, 'dashboard'])->name('dashboard');
    Route::get('/datos',       [TecnicoController::class, 'datos'])->name('datos');
    Route::post('/datos/update', [TecnicoController::class, 'update'])->name('update');    
    Route::get('/mis-tickets', [TecnicoController::class, 'misTickets'])->name('mistickets');
    Route::post('/logout',     [TecnicoController::class, 'logout'])->name('logout');
    Route::get('/contactos',   [TecnicoController::class, 'contactos'])->name('contactos');

    Route::post('/ticket/{id}/autoasignar',   [TecnicoController::class, 'autoAsignar'])->name('ticket.autoasignar');
    Route::get('/ticket/{id}/detalle',        [TecnicoController::class, 'detalleTicket'])->name('ticket.detalle');
    Route::post('/ticket/{id}/editar-campos', [TecnicoController::class, 'editarCamposTicket']);
    Route::post('/ticket/{id}/comentario',    [TecnicoController::class, 'agregarComentario']);
    Route::post('/ticket/{id}/reporte',       [TecnicoController::class, 'subirReporte']);
    Route::post('/ticket/{id}/cerrar',        [TecnicoController::class, 'cerrarTicket']);
    Route::post('/ticket/{id}/cancelar',      [TecnicoController::class, 'cancelarTicket']);
});


// ===================== 4. USUARIO (Personal General) =====================
Route::prefix('usuario')->name('usuario.')->group(function () {

    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
    Route::get('/datos',     [UsuarioController::class, 'datos'])->name('datos');
    Route::get('/tickets',   [UsuarioController::class, 'tickets'])->name('tickets');
    Route::get('/mail',      [UsuarioController::class, 'mail'])->name('mail');
    Route::post('/logout',   [UsuarioController::class, 'logout'])->name('logout');
    Route::post('/perfil/update', [UsuarioController::class, 'update'])->name('update');
    Route::post('/ticket/store', [TicketController::class, 'store'])->name('ticket.store');

});