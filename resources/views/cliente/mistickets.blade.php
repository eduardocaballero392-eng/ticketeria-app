@include('components.cliente.sidebar-cliente')
@include('components.usuario.detalleticket')

<style>
/* ══ LAYOUT ══ */
.mt-main {
    margin-left: 260px;
    background: #f0f4f8;
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
    transition: margin-left .35s;
    box-sizing: border-box;
}
body.sb-collapsed .mt-main { margin-left: 70px; }
.mt-inner { padding: 28px 32px; }

/* ══ HEADER ══ */
.mt-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
}
.mt-header h1 { font-size: 22px; font-weight: 700; color: #0a2540; margin: 0; }
.mt-header-sub { font-size: 13px; color: #64748b; margin-top: 2px; }

/* ══ PANEL USUARIOS ══ */
.mt-panel {
    background: #fff;
    border: 1px solid #dbe4f0;
    border-radius: 14px;
    margin-bottom: 20px;
    overflow: hidden;
}
.mt-panel-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px;
    border-bottom: 1px solid #f0f4fa;
    gap: 12px; flex-wrap: wrap;
}
.mt-panel-title {
    font-size: 12px; font-weight: 700; color: #1e3a5f;
    text-transform: uppercase; letter-spacing: .07em;
    display: flex; align-items: center; gap: 8px;
}
.mt-panel-icon {
    width: 24px; height: 24px; border-radius: 6px;
    background: #dbeafe; color: #1d4ed8;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

/* Buscador usuarios */
.mt-user-search {
    display: flex; align-items: center; gap: 8px;
    background: #f8fafd; border: 1px solid #e8eef8;
    border-radius: 8px; padding: 7px 13px;
    min-width: 240px;
}
.mt-user-search input {
    border: none; outline: none; font-size: 13px;
    background: transparent; color: #0a2540; width: 100%;
}

/* Grid usuarios */
.mt-users-grid {
    display: flex; gap: 10px; flex-wrap: wrap;
    padding: 16px 20px;
    max-height: 220px;
    overflow-y: auto;
}
.mt-users-grid::-webkit-scrollbar { width: 4px; }
.mt-users-grid::-webkit-scrollbar-thumb { background: #c8d8f0; border-radius: 99px; }

.mt-user-card {
    display: flex; align-items: center; gap: 10px;
    background: #f8fafd; border: 1.5px solid #e8eef8;
    border-radius: 12px; padding: 10px 14px;
    cursor: pointer; transition: all .15s;
    min-width: 200px;
}
.mt-user-card:hover { border-color: #93c5fd; background: #eff6ff; }
.mt-user-card.active {
    border-color: #185FA5; background: #dbeafe;
    box-shadow: 0 0 0 3px #185FA520;
}
.mt-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #1254a0, #1a6ed8);
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700; flex-shrink: 0;
}
.mt-user-info { min-width: 0; }
.mt-user-name { font-size: 13px; font-weight: 600; color: #0a2540; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; }
.mt-user-code { font-size: 11px; color: #64748b; font-family: monospace; }
.mt-user-tcount {
    margin-left: auto; font-size: 11px; font-weight: 600;
    background: #185FA515; color: #185FA5;
    padding: 2px 8px; border-radius: 20px; flex-shrink: 0;
}
.mt-user-card.active .mt-user-tcount { background: #185FA5; color: #fff; }

.mt-no-users {
    padding: 20px; text-align: center;
    color: #94a3b8; font-size: 13px; font-style: italic;
    width: 100%;
}

/* ══ SECCIÓN TICKETS ══ */
.mt-tickets-section {
    background: #fff;
    border: 1px solid #dbe4f0;
    border-radius: 14px;
    overflow: hidden;
}

/* Usuario seleccionado header */
.mt-sel-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px;
    border-bottom: 1px solid #f0f4fa;
    flex-wrap: wrap; gap: 12px;
    background: linear-gradient(135deg, #0f4a8a 0%, #1a6ed8 100%);
}
.mt-sel-user {
    display: flex; align-items: center; gap: 10px;
}
.mt-sel-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,.2); border: 1.5px solid rgba(255,255,255,.4);
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700;
}
.mt-sel-name  { font-size: 14px; font-weight: 700; color: #fff; }
.mt-sel-code  { font-size: 11px; color: rgba(255,255,255,.7); font-family: monospace; }

/* Estado filtros */
.mt-estado-bar {
    display: flex; gap: 8px; flex-wrap: wrap;
    padding: 14px 20px;
    border-bottom: 1px solid #f0f4fa;
}
.mt-est-btn {
    padding: 5px 14px; border-radius: 20px;
    font-size: 12px; font-weight: 500;
    cursor: pointer; border: 1.5px solid transparent;
    transition: all .15s;
}
.mt-est-btn.active-all        { background: #1e3a5f; color: #fff; border-color: #1e3a5f; }
.mt-est-btn.e-PENDIENTE       { background: #f3f0ff; color: #7c3aed; border-color: #ddd6fe; }
.mt-est-btn.e-PENDIENTE.sel   { background: #7c3aed; color: #fff; border-color: #7c3aed; }
.mt-est-btn.e-PROGRAMADO      { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
.mt-est-btn.e-PROGRAMADO.sel  { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
.mt-est-btn.e-EN-PROCESO      { background: #fff7ed; color: #c2410c; border-color: #fed7aa; }
.mt-est-btn.e-EN-PROCESO.sel  { background: #c2410c; color: #fff; border-color: #c2410c; }
.mt-est-btn.e-CERRADO         { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.mt-est-btn.e-CERRADO.sel     { background: #15803d; color: #fff; border-color: #15803d; }
.mt-est-btn.e-CANCELADO       { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
.mt-est-btn.e-CANCELADO.sel   { background: #b91c1c; color: #fff; border-color: #b91c1c; }
.mt-est-btn:not(.active-all):not([class*="sel"]):hover { opacity: .75; }

/* Barra búsqueda tickets */
.mt-tk-search {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 20px;
    border-bottom: 1px solid #f0f4fa;
    flex-wrap: wrap;
}
.mt-tk-input {
    display: flex; align-items: center; gap: 8px;
    background: #f8fafd; border: 1px solid #e8eef8;
    border-radius: 8px; padding: 7px 13px;
    flex: 1; min-width: 180px;
}
.mt-tk-input input {
    border: none; outline: none; font-size: 13px;
    background: transparent; color: #0a2540; width: 100%;
}
.mt-tk-date {
    display: flex; align-items: center; gap: 8px;
    background: #f8fafd; border: 1px solid #e8eef8;
    border-radius: 8px; padding: 6px 13px;
}
.mt-tk-date input {
    border: none; outline: none; font-size: 13px;
    background: transparent; color: #0a2540; cursor: pointer;
}
.mt-tk-clear {
    background: transparent; border: 1px solid #e8eef8;
    border-radius: 8px; padding: 7px 14px;
    font-size: 12px; color: #94a3b8; cursor: pointer;
    transition: all .15s;
}
.mt-tk-clear:hover { background: #f1f5f9; color: #64748b; }

/* Tabla */
.mt-table-wrap { overflow-x: auto; max-height: 420px; overflow-y: auto; }
.mt-table-wrap::-webkit-scrollbar { width: 5px; height: 5px; }
.mt-table-wrap::-webkit-scrollbar-thumb { background: #c8d8f0; border-radius: 99px; }

.mt-table {
    width: 100%; border-collapse: collapse;
    font-size: 13px; min-width: 540px;
}
.mt-table thead { background: #f4f7fa; position: sticky; top: 0; z-index: 1; }
.mt-table th {
    padding: 10px 14px; text-align: left;
    font-size: 11px; font-weight: 600; color: #64748b;
    border-bottom: 1px solid #dbe4f0;
    text-transform: uppercase; letter-spacing: .05em;
}
.mt-table td { padding: 10px 14px; border-bottom: 1px solid #f0f4fa; color: #0a2540; }
.mt-table tr:last-child td { border-bottom: none; }
.mt-table tr:hover td { background: #f8fafd; }

.mt-empty-state {
    padding: 48px 20px; text-align: center; color: #94a3b8; font-size: 13px;
}
.mt-empty-icon {
    width: 48px; height: 48px; border-radius: 12px;
    background: #f1f5f9; margin: 0 auto 12px;
    display: flex; align-items: center; justify-content: center;
}

/* Placeholder cuando no hay usuario seleccionado */
.mt-placeholder {
    padding: 60px 20px; text-align: center; color: #94a3b8;
}
.mt-placeholder-icon {
    width: 56px; height: 56px; border-radius: 16px;
    background: #f1f5f9; margin: 0 auto 14px;
    display: flex; align-items: center; justify-content: center;
}

.btn-detalle {
    background: #E6F1FB; color: #185FA5; border: none;
    border-radius: 6px; padding: 5px 12px;
    font-size: 12px; font-weight: 500; cursor: pointer; transition: background .15s;
}
.btn-detalle:hover { background: #185FA5; color: #fff; }

/* Responsive */
@media (min-width: 769px) and (max-width: 1024px) {
    .mt-main { margin-left: 0; padding-top: 68px; }
    .mt-inner { padding: 20px; }
}
@media (max-width: 768px) {
    .mt-main  { margin-left: 0 !important; padding-top: 64px; }
    .mt-inner { padding: 14px; }
    .mt-user-card { min-width: calc(50% - 5px); }
    .mt-user-search { min-width: 100%; width: 100%; }
}
</style>

<div class="mt-main">
<div class="mt-inner">

    {{-- Header --}}
    <div class="mt-header">
        <div>
            <h1>Seguimiento de Tickets</h1>
            <div class="mt-header-sub">Selecciona un usuario para ver sus tickets</div>
        </div>
    </div>

    {{-- ══ PANEL USUARIOS ══ --}}
    <div class="mt-panel">
        <div class="mt-panel-header">
            <div class="mt-panel-title">
                <div class="mt-panel-icon">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                Usuarios
                <span style="background:#185FA515;color:#185FA5;font-size:11px;padding:2px 8px;border-radius:20px;font-weight:600;">
                    {{ $usuarios->count() }}
                </span>
            </div>
            <div class="mt-user-search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="userSearch" placeholder="Buscar por nombre, DNI, código o correo..." oninput="filterUsers()">
            </div>
        </div>

        <div class="mt-users-grid" id="usersGrid">
            @forelse($usuarios as $user)
            <div class="mt-user-card"
                 id="ucard-{{ $user->id_usuario }}"
                 data-id="{{ $user->id_usuario }}"
                 data-nombre="{{ strtolower($user->nombre . ' ' . $user->apellido_paterno . ' ' . $user->apellido_materno) }}"
                 data-dni="{{ strtolower($user->dni ?? '') }}"
                 data-codigo="{{ strtolower($user->codigo_usuario ?? '') }}"
                 data-correo="{{ strtolower($user->correo ?? '') }}"
                 data-initial="{{ strtoupper(substr($user->nombre, 0, 1)) }}"
                 onclick="selectUser({{ $user->id_usuario }}, '{{ addslashes($user->nombre . ' ' . $user->apellido_paterno) }}', '{{ $user->codigo_usuario }}')">
                <div class="mt-avatar">{{ strtoupper(substr($user->nombre, 0, 1)) }}</div>
                <div class="mt-user-info">
                    <div class="mt-user-name">{{ $user->nombre }} {{ $user->apellido_paterno }}</div>
                    <div class="mt-user-code">{{ $user->codigo_usuario }}</div>
                </div>
                <div class="mt-user-tcount" id="tcount-{{ $user->id_usuario }}">
                    {{ isset($ticketsPorUsuario[$user->id_usuario]) ? $ticketsPorUsuario[$user->id_usuario]->count() : 0 }}
                </div>
            </div>
            @empty
            <div class="mt-no-users">No hay usuarios registrados.</div>
            @endforelse
        </div>
    </div>

    {{-- ══ SECCIÓN TICKETS ══ --}}
    <div class="mt-tickets-section">

        {{-- Header dinámico --}}
        <div class="mt-sel-header" id="selHeader">
            <div class="mt-sel-user">
                <div class="mt-sel-avatar" id="selAvatar">—</div>
                <div>
                    <div class="mt-sel-name" id="selName">Selecciona un usuario</div>
                    <div class="mt-sel-code" id="selCode">—</div>
                </div>
            </div>
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;" id="selStats"></div>
        </div>

        {{-- Filtro estados --}}
        <div class="mt-estado-bar" id="estadoBar">
            <button class="mt-est-btn active-all" id="ebtn-all" onclick="setEstado('all')">
                Todos <span id="ecnt-all" style="font-size:10px;opacity:.7;"></span>
            </button>
            <button class="mt-est-btn e-PENDIENTE" id="ebtn-PENDIENTE" onclick="setEstado('PENDIENTE')">Pendiente <span id="ecnt-PENDIENTE" style="font-size:10px;opacity:.7;"></span></button>
            <button class="mt-est-btn e-PROGRAMADO" id="ebtn-PROGRAMADO" onclick="setEstado('PROGRAMADO')">Programado <span id="ecnt-PROGRAMADO" style="font-size:10px;opacity:.7;"></span></button>
            <button class="mt-est-btn e-EN-PROCESO" id="ebtn-EN-PROCESO" onclick="setEstado('EN PROCESO')">En Proceso <span id="ecnt-EN PROCESO" style="font-size:10px;opacity:.7;"></span></button>
            <button class="mt-est-btn e-CERRADO" id="ebtn-CERRADO" onclick="setEstado('CERRADO')">Cerrado <span id="ecnt-CERRADO" style="font-size:10px;opacity:.7;"></span></button>
            <button class="mt-est-btn e-CANCELADO" id="ebtn-CANCELADO" onclick="setEstado('CANCELADO')">Cancelado <span id="ecnt-CANCELADO" style="font-size:10px;opacity:.7;"></span></button>
        </div>

        {{-- Barra búsqueda tickets --}}
        <div class="mt-tk-search">
            <div class="mt-tk-input">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="tkSearch" placeholder="Buscar por código de ticket..." oninput="renderTickets()">
            </div>
            <div class="mt-tk-date">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <input type="date" id="tkDate" onchange="renderTickets()">
            </div>
            <button class="mt-tk-clear" onclick="clearTkFilters()">✕ Limpiar</button>
        </div>

        {{-- Tabla --}}
        <div class="mt-table-wrap">
            <table class="mt-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Asunto</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Fecha</th>
                        <th style="text-align:center;">Detalle</th>
                    </tr>
                </thead>
                <tbody id="tkBody"></tbody>
            </table>
        </div>

    </div>

</div>
</div>

<script>
// ── Datos del servidor ────────────────────────────────────────────────────────
const allTickets   = @json($tickets->values());
const usuarios     = @json($usuarios->values());

let selectedUserId  = null;
let userTickets     = [];   // tickets del usuario seleccionado
let estadoFiltro    = 'all';

// ── Filtrar tarjetas de usuarios ─────────────────────────────────────────────
function filterUsers() {
    const q = document.getElementById('userSearch').value.trim().toLowerCase();
    document.querySelectorAll('.mt-user-card').forEach(card => {
        const match = !q
            || card.dataset.nombre.includes(q)
            || card.dataset.dni.includes(q)
            || card.dataset.codigo.includes(q)
            || card.dataset.correo.includes(q);
        card.style.display = match ? '' : 'none';
    });
}

// ── Seleccionar usuario ───────────────────────────────────────────────────────
function selectUser(id, nombre, codigo) {
    selectedUserId = id;
    estadoFiltro   = 'all';
    document.getElementById('tkSearch').value = '';
    document.getElementById('tkDate').value   = '';

    // Marcar card activa
    document.querySelectorAll('.mt-user-card').forEach(c => c.classList.remove('active'));
    document.getElementById('ucard-' + id)?.classList.add('active');

    // Header tickets
    const inicial = nombre.trim().charAt(0).toUpperCase();
    document.getElementById('selAvatar').textContent = inicial;
    document.getElementById('selName').textContent   = nombre;
    document.getElementById('selCode').textContent   = codigo;

    // Filtrar tickets de este usuario
    userTickets = allTickets.filter(t => t.usuario_id == id);

    // Contadores por estado
    const estados = ['PENDIENTE','PROGRAMADO','EN PROCESO','CERRADO','CANCELADO'];
    document.getElementById('ecnt-all').textContent = '(' + userTickets.length + ')';
    estados.forEach(e => {
        const cnt = userTickets.filter(t => t.estado === e).length;
        const el  = document.getElementById('ecnt-' + e);
        if (el) el.textContent = cnt > 0 ? '(' + cnt + ')' : '';
    });

    // Stats en header
    const abiertos  = userTickets.filter(t => !['CERRADO','CANCELADO'].includes(t.estado)).length;
    const cerrados  = userTickets.filter(t => t.estado === 'CERRADO').length;
    document.getElementById('selStats').innerHTML = `
        <span style="font-size:12px;background:rgba(255,255,255,.15);color:#fff;padding:4px 12px;border-radius:20px;">
            ${userTickets.length} tickets
        </span>
        <span style="font-size:12px;background:rgba(255,255,255,.15);color:#fff;padding:4px 12px;border-radius:20px;">
            ${abiertos} activos
        </span>
        <span style="font-size:12px;background:rgba(34,197,94,.2);color:#86efac;padding:4px 12px;border-radius:20px;">
            ${cerrados} cerrados
        </span>`;

    // Reset estado filtro
    document.querySelectorAll('.mt-est-btn').forEach(b => b.classList.remove('sel','active-all'));
    document.getElementById('ebtn-all').classList.add('active-all');

    renderTickets();
}

// ── Cambiar filtro estado ─────────────────────────────────────────────────────
function setEstado(e) {
    estadoFiltro = e;
    document.querySelectorAll('.mt-est-btn').forEach(b => {
        b.classList.remove('sel','active-all');
    });
    if (e === 'all') {
        document.getElementById('ebtn-all').classList.add('active-all');
    } else {
        const btn = document.getElementById('ebtn-' + e);
        if (btn) btn.classList.add('sel');
    }
    renderTickets();
}

// ── Limpiar filtros tickets ───────────────────────────────────────────────────
function clearTkFilters() {
    document.getElementById('tkSearch').value = '';
    document.getElementById('tkDate').value   = '';
    renderTickets();
}

// ── Badge estado ──────────────────────────────────────────────────────────────
function badge(s) {
    const map = {
        'PENDIENTE':  'background:#f3f0ff;color:#7c3aed;',
        'PROGRAMADO': 'background:#eff6ff;color:#1d4ed8;',
        'EN PROCESO': 'background:#fff7ed;color:#c2410c;',
        'CERRADO':    'background:#f0fdf4;color:#15803d;',
        'CANCELADO':  'background:#fef2f2;color:#b91c1c;',
    };
    return `<span style="${map[s]??'background:#f1f5f9;color:#64748b;'}font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;">${s}</span>`;
}

function priBadge(nombre, color) {
    const c = color || '#1a6ed8';
    return nombre
        ? `<span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:500;color:${c};">
               <span style="width:6px;height:6px;border-radius:50%;background:${c};display:inline-block;"></span>${nombre}
           </span>`
        : '—';
}

// ── Render tabla tickets ──────────────────────────────────────────────────────
function renderTickets() {
    const tbody = document.getElementById('tkBody');

    if (!selectedUserId) {
        tbody.innerHTML = `
            <tr><td colspan="6">
                <div class="mt-placeholder">
                    <div class="mt-placeholder-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div style="font-weight:600;color:#64748b;margin-bottom:4px;">Ningún usuario seleccionado</div>
                    <div style="font-size:12px;">Elige un usuario en el panel de arriba para ver sus tickets</div>
                </div>
            </td></tr>`;
        return;
    }

    const q    = document.getElementById('tkSearch').value.trim().toLowerCase();
    const date = document.getElementById('tkDate').value;

    let pool = [...userTickets];
    if (estadoFiltro !== 'all') pool = pool.filter(t => t.estado === estadoFiltro);
    if (date) pool = pool.filter(t => (t.created_at ?? '').substring(0,10) === date);
    if (q)    pool = pool.filter(t => t.codigo_ticket?.toLowerCase().includes(q));

    if (!pool.length) {
        tbody.innerHTML = `
            <tr><td colspan="6">
                <div class="mt-empty-state">
                    <div class="mt-empty-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    Sin tickets que mostrar
                </div>
            </td></tr>`;
        return;
    }

    // Necesitamos los índices globales para openModal()
    tbody.innerHTML = pool.map(t => {
        const globalIdx = allTickets.findIndex(x => x.id_ticket === t.id_ticket);
        return `
        <tr>
            <td style="font-family:monospace;font-size:12px;color:#185FA5;">${t.codigo_ticket}</td>
            <td style="color:#0a2540;max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${t.asunto ?? '—'}</td>
            <td>${badge(t.estado)}</td>
            <td>${priBadge(t.prioridad_nombre, t.prioridad_color)}</td>
            <td style="color:#64748b;font-size:12px;">${(t.created_at ?? '').substring(0,10)}</td>
            <td style="text-align:center;">
                <button class="btn-detalle" onclick="openModal(${globalIdx})">Ver detalle</button>
            </td>
        </tr>`;
    }).join('');
}

// ── tickets global para el modal detalleticket ────────────────────────────────
const tickets = allTickets;

// Render inicial
renderTickets();
</script>