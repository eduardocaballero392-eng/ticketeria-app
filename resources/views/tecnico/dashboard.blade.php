@include('components.tecnico.sidebar-tecnico')
@include('components.notificaciones.alertas')
@include('components.admin.detalleticket')
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="main-content">
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Panel de Tickets</h1>
            <p class="page-subtitle">Tickets pendientes por atender</p>
        </div>
    </div>

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-nav" id="breadcrumb-nav">
        <span class="bc-item active" id="bc-inicio" onclick="volverInicio()">🏠 Todos los Clientes</span>
        <span class="bc-sep" id="bc-sep-1" style="display:none">›</span>
        <span class="bc-item" id="bc-cliente" style="display:none"></span>
        <span class="bc-sep" id="bc-sep-2" style="display:none">›</span>
        <span class="bc-item" id="bc-usuario" style="display:none"></span>
    </div>

    {{-- STATS --}}
    <div class="stats-container" id="stats-global">
        <div class="stat-card">
            <div class="stat-icon">🏢</div>
            <div class="stat-info">
                <span class="stat-label">Clientes</span>
                <span class="stat-number">{{ $clientes->count() }}</span>
            </div>
        </div>
        <div class="stat-card" style="background:#7c3aed10;border-left:4px solid #7c3aed;">
            <div class="stat-icon" style="background:#ede9fe;color:#7c3aed;">⏳</div>
            <div class="stat-info">
                <span class="stat-label">Total Pendientes</span>
                <span class="stat-number">{{ $resumen['total'] }}</span>
            </div>
        </div>
    </div>

    {{-- NIVEL 1: CLIENTES --}}
    <div id="panel-clientes">
        <div class="section-header">
            <h2 class="section-title">🏢 Clientes Registrados</h2>
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input type="text" id="buscar-cliente" onkeyup="buscarCliente()" placeholder="Buscar cliente...">
            </div>
        </div>

        <div class="user-grid" id="grid-clientes">
            @forelse($clientes as $cliente)
            @php
                $usuariosCliente = \App\Models\Usuario::where('id_cliente', $cliente->id_cliente)->get();
                $totalUsuarios   = $usuariosCliente->count();
                $ticketsCliente  = $tickets->where('id_cliente', $cliente->id_cliente);
                $ticketCount     = $ticketsCliente->count();
            @endphp
            @if($ticketCount > 0)
            <div class="card-wrapper cliente-card-wrapper"
                 data-search="{{ strtolower($cliente->razon_social . ' ' . $cliente->ruc . ' ' . $cliente->correo) }}"
                 data-id="{{ $cliente->id_cliente }}">
                <div class="user-card card-cliente" onclick="seleccionarCliente({{ $cliente->id_cliente }}, '{{ addslashes($cliente->razon_social) }}')">
                    <div class="status-indicator si-active">
                        <span class="dot"></span>Activo
                    </div>
                    <div class="card-body">
                        <div class="avatar-circle avatar-empresa">{{ strtoupper(substr($cliente->razon_social, 0, 2)) }}</div>
                        <div class="user-info">
                            <h3>{{ $cliente->razon_social }}</h3>
                            <p class="user-code">RUC: {{ $cliente->ruc }}</p>
                            <div class="detail-row"><span class="label">Correo:</span><span class="value truncate">{{ $cliente->correo }}</span></div>
                            <div class="detail-row"><span class="label">Rubro:</span><span class="value">{{ $cliente->rubro ?? '—' }}</span></div>
                            <div class="mini-stats">
                                <span class="mini-badge badge-users">👥 {{ $totalUsuarios }} usuarios</span>
                                <span class="mini-badge badge-pending">⏳ {{ $ticketCount }} pendientes</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer card-footer-single">
                        <span class="btn-ver-mas">Ver usuarios →</span>
                    </div>
                </div>
            </div>
            @endif
            @empty
            <div class="empty-state"><p>No hay clientes con tickets pendientes.</p></div>
            @endforelse
        </div>
    </div>

    {{-- NIVEL 2: USUARIOS --}}
    <div id="panel-usuarios" style="display:none">
        <div class="back-btn-row">
            <button class="btn-back" onclick="volverInicio()">← Volver a Clientes</button>
            <h2 class="section-title" id="titulo-usuarios">Usuarios</h2>
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input type="text" id="buscar-usuario" onkeyup="buscarUsuario()" placeholder="Buscar usuario...">
            </div>
        </div>
        <div class="stats-container" id="stats-usuarios" style="margin-bottom:24px"></div>
        <div class="user-grid" id="grid-usuarios"></div>
    </div>

    {{-- NIVEL 3: TICKETS --}}
    <div id="panel-tickets" style="display:none">
        <div class="back-btn-row">
            <button class="btn-back" onclick="volverUsuarios()">← Volver a Usuarios</button>
            <h2 class="section-title" id="titulo-tickets">Tickets</h2>
        </div>
        <div id="grid-tickets" class="ticket-grid"></div>
    </div>

</div>
</div>

<script>
const USUARIOS_POR_CLIENTE = @json(
    \App\Models\Usuario::all()->groupBy('id_cliente')->map(fn($u) => $u->values())
);

const TICKETS_POR_USUARIO = @json(
    $tickets->groupBy('id_usuario')->map(fn($t) => $t->values())
);

let clienteActual = null;
let usuarioActual = null;

// ── Nivel 1 → Cliente ────────────────────────────────────────────
function seleccionarCliente(idCliente, nombre) {
    clienteActual = idCliente;
    usuarioActual = null;

    document.getElementById('bc-cliente').textContent = '🏢 ' + nombre;
    document.getElementById('bc-cliente').style.display = 'inline';
    document.getElementById('bc-sep-1').style.display   = 'inline';
    document.getElementById('bc-usuario').style.display  = 'none';
    document.getElementById('bc-sep-2').style.display    = 'none';
    document.getElementById('bc-inicio').classList.remove('active');
    document.getElementById('bc-cliente').classList.add('active');

    document.getElementById('panel-clientes').style.display = 'none';
    document.getElementById('panel-tickets').style.display  = 'none';
    document.getElementById('panel-usuarios').style.display = '';
    document.getElementById('titulo-usuarios').textContent  = 'Usuarios de ' + nombre;

    const usuarios = USUARIOS_POR_CLIENTE[idCliente] || [];
    // Solo usuarios que tengan tickets pendientes
    const usuariosConTickets = usuarios.filter(u => (TICKETS_POR_USUARIO[u.id_usuario] || []).length > 0);
    renderUsuarios(usuariosConTickets);
    renderStatsUsuarios(usuariosConTickets);
}

// ── Nivel 2 → Usuario ────────────────────────────────────────────
function seleccionarUsuario(idUsuario, nombre) {
    usuarioActual = idUsuario;

    document.getElementById('bc-usuario').textContent = '👤 ' + nombre;
    document.getElementById('bc-usuario').style.display = 'inline';
    document.getElementById('bc-sep-2').style.display   = 'inline';
    document.getElementById('bc-cliente').classList.remove('active');
    document.getElementById('bc-usuario').classList.add('active');

    document.getElementById('panel-usuarios').style.display = 'none';
    document.getElementById('panel-tickets').style.display  = '';
    document.getElementById('titulo-tickets').textContent   = 'Tickets pendientes de ' + nombre;

    const tickets = TICKETS_POR_USUARIO[idUsuario] || [];
    renderTickets(tickets);
}

// ── Volver ────────────────────────────────────────────────────────
function volverInicio() {
    clienteActual = null; usuarioActual = null;
    document.getElementById('panel-clientes').style.display = '';
    document.getElementById('panel-usuarios').style.display = 'none';
    document.getElementById('panel-tickets').style.display  = 'none';
    ['bc-sep-1','bc-cliente','bc-sep-2','bc-usuario'].forEach(id => {
        document.getElementById(id).style.display = 'none';
        document.getElementById(id).classList.remove('active');
    });
    document.getElementById('bc-inicio').classList.add('active');
}

function volverUsuarios() {
    usuarioActual = null;
    document.getElementById('panel-tickets').style.display  = 'none';
    document.getElementById('panel-usuarios').style.display = '';
    document.getElementById('bc-sep-2').style.display       = 'none';
    document.getElementById('bc-usuario').style.display     = 'none';
    document.getElementById('bc-usuario').classList.remove('active');
    document.getElementById('bc-cliente').classList.add('active');
}

// ── Render Usuarios ───────────────────────────────────────────────
function renderUsuarios(usuarios) {
    const grid = document.getElementById('grid-usuarios');
    if (!usuarios.length) {
        grid.innerHTML = '<div class="empty-state"><p>No hay usuarios con tickets pendientes.</p></div>';
        return;
    }
    grid.innerHTML = usuarios.map(u => {
        const tickets = TICKETS_POR_USUARIO[u.id_usuario] || [];
        return `
        <div class="card-wrapper usuario-card-wrapper"
             data-search="${(u.nombre+' '+u.apellido_paterno+' '+u.dni+' '+u.correo+' '+u.codigo_usuario).toLowerCase()}">
            <div class="user-card card-active">
                <div class="card-body">
                    <div class="avatar-circle">${(u.nombre||'?').charAt(0).toUpperCase()}</div>
                    <div class="user-info">
                        <h3>${u.nombre} ${u.apellido_paterno}</h3>
                        <p class="user-code">Cod: ${u.codigo_usuario}</p>
                        <div class="detail-row"><span class="label">DNI:</span><span class="value">${u.dni}</span></div>
                        <div class="detail-row"><span class="label">Email:</span><span class="value truncate">${u.correo}</span></div>
                        <div class="mini-stats">
                            <span class="mini-badge badge-pending">⏳ ${tickets.length} pendientes</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer card-footer-single">
                    <button class="btn-ver-mas" onclick="seleccionarUsuario(${u.id_usuario}, '${(u.nombre+' '+u.apellido_paterno).replace(/'/g,"\\'")}')">Ver Tickets →</button>
                </div>
            </div>
        </div>`;
    }).join('');
}

function renderStatsUsuarios(usuarios) {
    const total = usuarios.length;
    const totalTickets = usuarios.reduce((sum, u) => sum + (TICKETS_POR_USUARIO[u.id_usuario]||[]).length, 0);
    document.getElementById('stats-usuarios').innerHTML = `
        <div class="stat-card"><div class="stat-icon">👥</div><div class="stat-info"><span class="stat-label">Usuarios con pendientes</span><span class="stat-number">${total}</span></div></div>
        <div class="stat-card" style="border-left:4px solid #7c3aed"><div class="stat-icon" style="background:#ede9fe;color:#7c3aed">⏳</div><div class="stat-info"><span class="stat-label">Total pendientes</span><span class="stat-number">${totalTickets}</span></div></div>`;
}

// ── Render Tickets (solo PENDIENTE, solo Ver detalle) ─────────────
function renderTickets(tickets) {
    const grid = document.getElementById('grid-tickets');

    if (!tickets.length) {
        grid.innerHTML = '<div class="empty-state"><p>No hay tickets pendientes.</p></div>';
        return;
    }

    grid.innerHTML = tickets.map(t => {
        const estadoStyle = t.estado_color
            ? `background:${t.estado_color}20;color:${t.estado_color};border:1px solid ${t.estado_color}40` : '';
        const prioColor = t.prioridad_color
            ? `background:${t.prioridad_color}20;color:${t.prioridad_color};border:1px solid ${t.prioridad_color}40` : '';
        const fecha = t.created_at
            ? new Date(t.created_at).toLocaleDateString('es-PE',{day:'2-digit',month:'short',year:'numeric'}) : '—';

        return `
        <div class="ticket-card" id="ticket-card-${t.id_ticket}">
            <div class="ticket-header">
                <div class="ticket-header-left">
                    <span class="ticket-id">#${t.id_ticket}</span>
                    ${t.codigo_ticket ? `<span class="ticket-codigo">${t.codigo_ticket}</span>` : ''}
                </div>
                <span class="ticket-estado" style="${estadoStyle}">${t.estado}</span>
            </div>
            <div class="ticket-body">
                <p class="ticket-asunto">${t.asunto || 'Sin asunto'}</p>
                <div class="ticket-info-group">
                    <div class="ticket-info-row">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>${t.usuario_nombre || '—'}</span>
                    </div>
                </div>
                <div class="ticket-divider"></div>
                <div class="ticket-bottom">
                    <div class="ticket-badges">
                        <span class="ticket-tipo">📋 ${t.tipo_ticket_nombre}</span>
                        <span class="ticket-prio" style="${prioColor}">⚡ ${t.prioridad_nombre}</span>
                    </div>
                    <div class="ticket-fecha">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        ${fecha}
                    </div>
                </div>
            </div>
            <div class="ticket-actions">
                <button class="btn-ticket-detail"
                        onclick="abrirDetalleTicket(${t.id_ticket})">
                    👁 Ver detalle
                </button>
                <button class="btn-ticket-autoasignar"
                        onclick="autoAsignarTicket(${t.id_ticket}, this)">
                    🔧 Autoasignar
                </button>
            </div>
        </div>`;
    }).join('');
}
async function autoAsignarTicket(idTicket, btn) {
ModalSystem.show('confirm', {
        title: '¿Autoasignar ticket?',
        text: '¿Deseas autoasignarte este ticket? Se moverá a tu lista de "Mis Tickets".',
        confirmText: 'Sí, autoasignar',
        cancelText: 'Cancelar',
        onConfirm: async () => {
            btn.disabled    = true;
            btn.textContent = 'Asignando…';

            try {
                const res  = await fetch(`/tecnico/ticket/${idTicket}/autoasignar`, {
                    method:  'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept':       'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();

                if (data.ok) {
                    // Animación de eliminación
                    const card = document.getElementById('ticket-card-' + idTicket);
                    if (card) {
                        card.style.transition = 'opacity .3s, transform .3s';
                        card.style.opacity    = '0';
                        card.style.transform  = 'scale(.95)';
                        setTimeout(() => card.remove(), 300);
                    }
                    
                    // Notificación de éxito
                    if (typeof showNotification === 'function') {
                        showNotification('success', '¡Autoasignado!', 'El ticket ahora está en tu lista.');
                    }
                } else {
                    if (typeof showNotification === 'function') {
                        showNotification('danger', 'Error', data.message || 'No se pudo autoasignar.');
                    }
                    btn.disabled    = false;
                    btn.textContent = '🔧 Autoasignar';
                }
            } catch (e) {
                if (typeof showNotification === 'function') {
                    showNotification('danger', 'Error de conexión', 'No se pudo conectar.');
                }
                btn.disabled    = false;
                btn.textContent = '🔧 Autoasignar';
            }
        }
    });
}
// ── Búsquedas ─────────────────────────────────────────────────────
function buscarCliente() {
    const q = document.getElementById('buscar-cliente').value.toLowerCase();
    document.querySelectorAll('.cliente-card-wrapper').forEach(c => {
        c.style.display = c.dataset.search.includes(q) ? '' : 'none';
    });
}
function buscarUsuario() {
    const q = document.getElementById('buscar-usuario').value.toLowerCase();
    document.querySelectorAll('.usuario-card-wrapper').forEach(c => {
        c.style.display = c.dataset.search.includes(q) ? '' : 'none';
    });
}

document.getElementById('bc-cliente').addEventListener('click', function() {
    if (!clienteActual) return;
    volverUsuarios();
});

function cerrarPanelEdicion() {}

async function cancelarTicketTecnico(idTicket) {
    if (!confirm('¿Deseas cancelar este ticket?')) return;

    try {
        const res  = await fetch(`/tecnico/ticket/${idTicket}/cancelar`, {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        const data = await res.json();

        if (data.ok) {
            const card = document.getElementById('ticket-card-' + idTicket);
            if (card) {
                card.style.transition = 'opacity .3s, transform .3s';
                card.style.opacity    = '0';
                card.style.transform  = 'scale(.95)';
                setTimeout(() => card.remove(), 300);
            }
            if (typeof showNotification === 'function') {
                showNotification('success', '¡Cancelado!', 'Ticket cancelado correctamente.');
            }
        } else {
            if (typeof showNotification === 'function') {
                showNotification('danger', 'Error', data.message || 'No se pudo cancelar.');
            }
        }
    } catch (e) {
        if (typeof showNotification === 'function') {
            showNotification('danger', 'Error de conexión', 'No se pudo conectar.');
        }
    }
}
</script>

<style>
.btn-ticket-cancel {
    flex: 1;
    padding: 12px;
    border: none;
    background: transparent;
    font-size: 13px;
    font-weight: 600;
    color: #dc2626;
    cursor: pointer;
    transition: background .15s;
    border-left: 1px solid #eef2f7;
}
.btn-ticket-cancel:hover { background: #fef2f2; }
.btn-ticket-autoasignar {
    flex: 1;
    padding: 12px;
    border: none;
    background: transparent;
    font-size: 13px;
    font-weight: 600;
    color: #7c3aed;
    cursor: pointer;
    transition: background .15s;
    border-left: 1px solid #eef2f7;
}
.btn-ticket-autoasignar:hover { background: #f5f3ff; }
.btn-ticket-autoasignar:disabled { opacity: .5; cursor: not-allowed; }
.main-content {
    margin-left: 260px; padding: 40px;
    background: #f0f4f8; min-height: 100vh;
    font-family: 'Poppins', sans-serif;
    transition: margin-left .35s ease;
}
body.sb-collapsed .main-content { margin-left: 70px; }

.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.page-title  { font-size: 24px; font-weight: 700; color: #1a202c; margin: 0; }
.page-subtitle { font-size: 14px; color: #718096; margin: 4px 0 0; }

.breadcrumb-nav { display: flex; align-items: center; gap: 8px; margin-bottom: 24px; font-size: 13px; font-weight: 500; color: #718096; }
.bc-item { cursor: pointer; padding: 4px 10px; border-radius: 20px; transition: .15s; }
.bc-item:hover { background: #e2e8f0; color: #2d3748; }
.bc-item.active { background: #ebf4ff; color: #2b6cb0; }
.bc-sep { color: #cbd5e0; font-size: 16px; }

.stats-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px; margin-bottom: 28px; }
.stat-card { background: white; min-width: 0; padding: 18px; border-radius: 14px; display: flex; align-items: center; gap: 14px; border: 1px solid #e2e8f0; }
.stat-icon { width: 42px; height: 42px; background: #edf2f7; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.stat-label  { display: block; font-size: 12px; color: #718096; font-weight: 500; }
.stat-number { font-size: 22px; font-weight: 700; color: #2d3748; }

.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; gap: 16px; flex-wrap: wrap; }
.section-title { font-size: 18px; font-weight: 700; color: #2d3748; margin: 0; }
.back-btn-row { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; }
.btn-back { background: white; border: 1px solid #e2e8f0; color: #4a5568; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500; }
.btn-back:hover { background: #f7fafc; }

.search-box { background: white; display: flex; align-items: center; padding: 10px 16px; border-radius: 10px; border: 1px solid #e2e8f0; min-width: 220px; }
.search-icon { margin-right: 8px; color: #a0aec0; }
.search-box input { border: none; outline: none; font-size: 14px; color: #4a5568; width: 100%; background: transparent; }

.user-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 22px; margin-bottom: 30px; }
.card-wrapper { display: block; }
.user-card { background: white; border-radius: 14px; border: 1px solid #e2e8f0; position: relative; overflow: hidden; transition: box-shadow .2s, transform .15s; }
.user-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.08); transform: translateY(-2px); }
.card-cliente { cursor: pointer; }
.card-active  { border-left: 4px solid #48bb78; }
.card-body { padding: 28px 18px 16px; text-align: center; }
.avatar-circle { width: 56px; height: 56px; background: #ebf4ff; color: #2b6cb0; font-size: 20px; font-weight: 700; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto 12px; }
.avatar-empresa { background: #e9d8fd; color: #6b46c1; font-size: 16px; }
.status-indicator { position: absolute; top: 12px; right: 12px; font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; }
.si-active { background: #ebfbee; color: #2f855a; }
.dot { width: 7px; height: 7px; border-radius: 50%; background: #48bb78; }
.user-info h3 { font-size: 15px; font-weight: 600; color: #2d3748; margin: 0 0 4px; }
.user-code { font-size: 11px; color: #a0aec0; background: #f7fafc; display: inline-block; padding: 2px 10px; border-radius: 20px; margin-bottom: 10px; }
.detail-row { display: flex; justify-content: space-between; font-size: 12px; padding: 4px 0; border-bottom: 1px solid #f7fafc; text-align: left; }
.detail-row .label { color: #a0aec0; font-weight: 500; }
.detail-row .value { color: #4a5568; }
.truncate { max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block; vertical-align: bottom; }
.mini-stats { display: flex; gap: 8px; justify-content: center; margin-top: 10px; flex-wrap: wrap; }
.mini-badge { font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 600; }
.badge-users   { background: #ebf4ff; color: #2b6cb0; }
.badge-pending { background: #ede9fe; color: #6d28d9; }
.card-footer { display: grid; grid-template-columns: 1fr; background: #f7fafc; border-top: 1px solid #edf2f7; }
.card-footer-single { grid-template-columns: 1fr; }
.btn-ver-mas { display: block; padding: 12px; text-align: center; font-size: 13px; font-weight: 600; color: #3182ce; cursor: pointer; border: none; background: transparent; width: 100%; }

.empty-state { grid-column: 1/-1; text-align: center; padding: 60px 0; color: #a0aec0; }

.ticket-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 18px; }
.ticket-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; transition: box-shadow .2s, transform .15s; }
.ticket-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.09); transform: translateY(-2px); }
.ticket-header { display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #f8fafc; border-bottom: 1px solid #eef2f7; }
.ticket-header-left { display: flex; align-items: center; gap: 8px; }
.ticket-id { font-size: 11px; color: #b0bec5; font-weight: 600; }
.ticket-codigo { font-size: 12px; font-weight: 700; color: #2563eb; background: #eff6ff; padding: 3px 10px; border-radius: 20px; border: 1px solid #bfdbfe; }
.ticket-estado { font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; white-space: nowrap; }
.ticket-body { padding: 16px; flex: 1; display: flex; flex-direction: column; gap: 10px; }
.ticket-asunto { font-size: 14px; font-weight: 700; color: #1e3a5f; margin: 0; line-height: 1.45; }
.ticket-info-group { display: flex; flex-direction: column; gap: 6px; }
.ticket-info-row { display: flex; align-items: center; gap: 7px; font-size: 12px; color: #4a5568; }
.ticket-info-row svg { flex-shrink: 0; color: #94a3b8; }
.ticket-divider { border: none; border-top: 1px dashed #e9eef5; margin: 2px 0; }
.ticket-bottom { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
.ticket-badges { display: flex; gap: 6px; flex-wrap: wrap; }
.ticket-tipo { font-size: 11px; background: #f1f5f9; color: #475569; padding: 3px 10px; border-radius: 20px; border: 1px solid #e2e8f0; }
.ticket-prio { font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 700; }
.ticket-fecha { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #94a3b8; white-space: nowrap; }
.ticket-actions { display: flex; border-top: 1px solid #eef2f7; background: #f8fafc; }
.btn-ticket-detail { flex: 1; padding: 12px; border: none; background: transparent; font-size: 13px; font-weight: 600; color: #2563eb; cursor: pointer; transition: background .15s; }
.btn-ticket-detail:hover { background: #eff6ff; }

@media (min-width: 769px) and (max-width: 1024px) {
    .main-content { margin-left: 0 !important; padding: 24px 20px; padding-top: 68px; }
    .user-grid, .ticket-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
}
@media (max-width: 768px) {
    .main-content { margin-left: 0 !important; padding: 16px; padding-top: 68px; box-sizing: border-box; }
    .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    .user-grid, .ticket-grid { grid-template-columns: 1fr; gap: 14px; }
    .section-header, .back-btn-row { flex-direction: column; align-items: flex-start; gap: 10px; }
    .search-box { width: 100%; box-sizing: border-box; }
}
@media (max-width: 480px) {
    .main-content { padding: 12px; padding-top: 68px; }
}
</style>