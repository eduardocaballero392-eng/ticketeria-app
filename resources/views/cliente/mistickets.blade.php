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
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}
.mt-header h1 {
    font-size: 24px;
    font-weight: 700;
    color: #0a2540;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.mt-header-sub {
    font-size: 13px;
    color: #64748b;
    margin-top: 4px;
}

/* ══ PANEL USUARIOS MEJORADO ══ */
.mt-panel {
    background: #fff;
    border: 1px solid #dbe4f0;
    border-radius: 16px;
    margin-bottom: 24px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.mt-panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    border-bottom: 1px solid #f0f4fa;
    gap: 12px;
    flex-wrap: wrap;
    background: #ffffff;
}
.mt-panel-title {
    font-size: 12px;
    font-weight: 700;
    color: #1e3a5f;
    text-transform: uppercase;
    letter-spacing: .07em;
    display: flex;
    align-items: center;
    gap: 8px;
}
.mt-panel-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #dbeafe;
    color: #1d4ed8;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Selector rápido de usuarios */
.mt-user-selector {
    display: flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #f8fafd 0%, #ffffff 100%);
    padding: 6px 16px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
.mt-user-selector .selector-icon {
    font-size: 18px;
}
.mt-user-select {
    border: none;
    background: transparent;
    padding: 8px 4px;
    font-size: 13px;
    font-weight: 500;
    color: #0a2540;
    cursor: pointer;
    outline: none;
    min-width: 220px;
}
.mt-user-select option {
    padding: 10px;
    font-size: 13px;
}
.mt-user-selector .selector-badge {
    background: #185FA515;
    color: #185FA5;
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 20px;
    font-weight: 600;
}

/* Buscador usuarios */
.mt-user-search {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8fafd;
    border: 1px solid #e8eef8;
    border-radius: 10px;
    padding: 8px 15px;
    min-width: 250px;
    transition: all 0.2s;
}
.mt-user-search:focus-within {
    border-color: #185FA5;
    box-shadow: 0 0 0 3px #185FA520;
}
.mt-user-search input {
    border: none;
    outline: none;
    font-size: 13px;
    background: transparent;
    color: #0a2540;
    width: 100%;
}
.mt-user-search input::placeholder {
    color: #94a3b8;
}

/* Grid usuarios */
.mt-users-grid {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    padding: 20px 24px;
    max-height: 280px;
    overflow-y: auto;
}
.mt-users-grid::-webkit-scrollbar {
    width: 5px;
}
.mt-users-grid::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}
.mt-users-grid::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.mt-user-card {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #ffffff;
    border: 1.5px solid #e8eef8;
    border-radius: 14px;
    padding: 12px 16px;
    cursor: pointer;
    transition: all 0.2s ease;
    min-width: 240px;
    flex: 1 0 auto;
    max-width: calc(33% - 12px);
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
}
.mt-user-card:hover {
    border-color: #93c5fd;
    background: #f8fafc;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.mt-user-card.active {
    border-color: #185FA5;
    background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
    box-shadow: 0 0 0 3px #185FA520;
}
.mt-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1254a0, #1a6ed8);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.mt-user-info {
    min-width: 0;
    flex: 1;
}
.mt-user-name {
    font-size: 14px;
    font-weight: 600;
    color: #0a2540;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px;
    margin-bottom: 3px;
}
.mt-user-code {
    font-size: 11px;
    color: #64748b;
    font-family: monospace;
}
.mt-user-tcount {
    margin-left: auto;
    font-size: 12px;
    font-weight: 700;
    background: #185FA515;
    color: #185FA5;
    padding: 4px 10px;
    border-radius: 30px;
    flex-shrink: 0;
    transition: all 0.2s;
}
.mt-user-card.active .mt-user-tcount {
    background: #185FA5;
    color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.mt-no-users {
    padding: 40px;
    text-align: center;
    color: #94a3b8;
    font-size: 13px;
    font-style: italic;
    width: 100%;
}

/* ══ SECCIÓN TICKETS ══ */
.mt-tickets-section {
    background: #fff;
    border: 1px solid #dbe4f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

/* Usuario seleccionado header */
.mt-sel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    border-bottom: 1px solid #f0f4fa;
    flex-wrap: wrap;
    gap: 12px;
    background: linear-gradient(135deg, #0f4a8a 0%, #1a6ed8 100%);
}
.mt-sel-user {
    display: flex;
    align-items: center;
    gap: 12px;
}
.mt-sel-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: rgba(255,255,255,.2);
    border: 2px solid rgba(255,255,255,.5);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
}
.mt-sel-name {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
}
.mt-sel-code {
    font-size: 11px;
    color: rgba(255,255,255,.8);
    font-family: monospace;
    margin-top: 2px;
}

/* FILTRO ESTADOS - SELECT MEJORADO */
.mt-estado-bar {
    padding: 16px 24px;
    border-bottom: 1px solid #f0f4fa;
    background: #fafcff;
}
.mt-estado-selector {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.mt-estado-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 600;
    color: #1e3a5f;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.mt-estado-select {
    background: white;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 10px 16px;
    font-size: 13px;
    font-weight: 500;
    color: #0a2540;
    cursor: pointer;
    outline: none;
    min-width: 240px;
    transition: all 0.2s;
}
.mt-estado-select:hover {
    border-color: #185FA5;
    background: #f8fafc;
}
.mt-estado-select:focus {
    border-color: #185FA5;
    box-shadow: 0 0 0 3px #185FA520;
}

/* Barra búsqueda tickets */
.mt-tk-search {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 24px;
    border-bottom: 1px solid #f0f4fa;
    flex-wrap: wrap;
    background: #ffffff;
}
.mt-tk-input {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafd;
    border: 1px solid #e8eef8;
    border-radius: 10px;
    padding: 8px 15px;
    flex: 1;
    min-width: 200px;
    transition: all 0.2s;
}
.mt-tk-input:focus-within {
    border-color: #185FA5;
    box-shadow: 0 0 0 3px #185FA520;
}
.mt-tk-input input {
    border: none;
    outline: none;
    font-size: 13px;
    background: transparent;
    color: #0a2540;
    width: 100%;
}
.mt-tk-date {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafd;
    border: 1px solid #e8eef8;
    border-radius: 10px;
    padding: 7px 15px;
}
.mt-tk-date input {
    border: none;
    outline: none;
    font-size: 13px;
    background: transparent;
    color: #0a2540;
    cursor: pointer;
}
.mt-tk-clear {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 8px 18px;
    font-size: 12px;
    font-weight: 500;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s;
}
.mt-tk-clear:hover {
    background: #e2e8f0;
    color: #475569;
    transform: translateY(-1px);
}

/* Tabla */
.mt-table-wrap {
    overflow-x: auto;
    max-height: 420px;
    overflow-y: auto;
}
.mt-table-wrap::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.mt-table-wrap::-webkit-scrollbar-track {
    background: #f1f5f9;
}
.mt-table-wrap::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.mt-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    min-width: 600px;
}
.mt-table thead {
    background: #f8fafc;
    position: sticky;
    top: 0;
    z-index: 1;
}
.mt-table th {
    padding: 14px 20px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    color: #475569;
    border-bottom: 1.5px solid #e2e8f0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.mt-table td {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
}
.mt-table tr:last-child td {
    border-bottom: none;
}
.mt-table tbody tr:hover td {
    background: #f8fafc;
}

.mt-empty-state {
    padding: 60px 20px;
    text-align: center;
    color: #94a3b8;
    font-size: 13px;
}
.mt-empty-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: #f1f5f9;
    margin: 0 auto 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.mt-placeholder {
    padding: 80px 20px;
    text-align: center;
    color: #94a3b8;
}
.mt-placeholder-icon {
    width: 64px;
    height: 64px;
    border-radius: 20px;
    background: #f1f5f9;
    margin: 0 auto 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-detalle {
    background: linear-gradient(135deg, #E6F1FB 0%, #dbeafe 100%);
    color: #185FA5;
    border: none;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-detalle:hover {
    background: linear-gradient(135deg, #185FA5 0%, #1a6ed8 100%);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(24,95,165,0.3);
}

/* Responsive */
@media (min-width: 769px) and (max-width: 1024px) {
    .mt-main {
        margin-left: 0;
        padding-top: 68px;
    }
    .mt-inner {
        padding: 20px;
    }
    .mt-user-card {
        max-width: calc(50% - 12px);
    }
}
@media (max-width: 768px) {
    .mt-main {
        margin-left: 0 !important;
        padding-top: 64px;
    }
    .mt-inner {
        padding: 16px;
    }
    .mt-user-card {
        min-width: 100%;
        max-width: 100%;
    }
    .mt-user-search {
        min-width: 100%;
        width: 100%;
    }
    .mt-user-selector {
        width: 100%;
    }
    .mt-user-select {
        min-width: auto;
        flex: 1;
    }
    .mt-estado-select {
        min-width: 100%;
    }
}
</style>

<div class="mt-main">
<div class="mt-inner">

    {{-- Header --}}
    <div class="mt-header">
        <div>
            <h1>
                <span></span> Seguimiento de Tickets
            </h1>
            <div class="mt-header-sub">Selecciona un usuario para ver sus tickets</div>
        </div>
    </div>

    {{-- ══ PANEL USUARIOS ══ --}}
    <div class="mt-panel">
        <div class="mt-panel-header">
            <div class="mt-panel-title">
                <div class="mt-panel-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                Usuarios
                <span style="background:#185FA515;color:#185FA5;font-size:11px;padding:2px 8px;border-radius:20px;font-weight:600;">
                    {{ $usuarios->count() }}
                </span>
            </div>
            
            {{-- SELECTOR RÁPIDO DE USUARIOS --}}
            <div class="mt-user-selector">
             
                <select class="mt-user-select" id="quickUserSelect">
                    <option value=""> Seleccionar usuario rápidamente...</option>
                    <option value="" disabled style="background:#f0f4f8;">━━━━━━━━━━━━━━━━━━━━</option>
                    @foreach($usuarios->take(10) as $user)
                    <option value="{{ $user->id_usuario }}">
                        👤 {{ $user->nombre }} {{ $user->apellido_paterno }} - {{ $user->codigo_usuario }}
                    </option>
                    @endforeach
                </select>
                <span class="selector-badge">Rápido</span>
            </div>
            
            <div class="mt-user-search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="userSearch" placeholder="Buscar por nombre, DNI, código o correo..." oninput="filterUsers()">
            </div>
        </div>

        <div class="mt-users-grid" id="usersGrid">
            @forelse($usuarios as $user)
            <div class="mt-user-card"
                 id="ucard-{{ $user->id_usuario }}"
                 data-id="{{ $user->id_usuario }}"
                 data-nombre="{{ strtolower($user->nombre . ' ' . $user->apellido_paterno . ' ' . ($user->apellido_materno ?? '')) }}"
                 data-dni="{{ strtolower($user->dni ?? '') }}"
                 data-codigo="{{ strtolower($user->codigo_usuario ?? '') }}"
                 data-correo="{{ strtolower($user->correo ?? '') }}"
                 data-inicial="{{ strtoupper(substr($user->nombre, 0, 1)) . strtoupper(substr($user->apellido_paterno, 0, 1)) }}"
                 onclick="selectUser({{ $user->id_usuario }}, '{{ addslashes($user->nombre . ' ' . $user->apellido_paterno) }}', '{{ $user->codigo_usuario }}')">
                <div class="mt-avatar">{{ strtoupper(substr($user->nombre, 0, 1)) . strtoupper(substr($user->apellido_paterno, 0, 1)) }}</div>
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

        {{-- FILTRO ESTADOS - SELECT --}}
        <div class="mt-estado-bar">
            <div class="mt-estado-selector">
                <label class="mt-estado-label">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                        <polyline points="2 17 12 22 22 17"/>
                        <polyline points="2 12 12 17 22 12"/>
                    </svg>
                    Filtrar por estado:
                </label>
                <select id="estadoSelect" class="mt-estado-select" onchange="setEstado(this.value)">
                    <option value="all"> Todos los estados</option>
                    <option value="PENDIENTE"> Pendiente</option>
                    <option value="PROGRAMADO"> Programado</option>
                    <option value="EN PROCESO"> En Proceso</option>
                    <option value="CERRADO"> Cerrado</option>
                    <option value="CANCELADO"> Cancelado</option>
                </select>
            </div>
        </div>

        {{-- Barra búsqueda tickets --}}
        <div class="mt-tk-search">
            <div class="mt-tk-input">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="tkSearch" placeholder="Buscar por código de ticket..." oninput="renderTickets()">
            </div>
            <div class="mt-tk-date">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
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
let userTickets     = [];
let estadoFiltro    = 'all';

// ── SELECTOR RÁPIDO DE USUARIOS ───────────────────────────────────────────────
document.getElementById('quickUserSelect')?.addEventListener('change', function(e) {
    const userId = parseInt(e.target.value);
    if (!userId) return;
    
    const user = usuarios.find(u => u.id_usuario === userId);
    if (user) {
        e.target.value = '';
        selectUser(userId, user.nombre + ' ' + user.apellido_paterno, user.codigo_usuario);
        
        const card = document.getElementById('ucard-' + userId);
        if (card) {
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});

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

    // Resetear el select de estados
    const estadoSelect = document.getElementById('estadoSelect');
    if (estadoSelect) estadoSelect.value = 'all';

    // Marcar card activa
    document.querySelectorAll('.mt-user-card').forEach(c => c.classList.remove('active'));
    const activeCard = document.getElementById('ucard-' + id);
    if (activeCard) activeCard.classList.add('active');

    // Header tickets
    const inicial = nombre.trim().charAt(0).toUpperCase();
    document.getElementById('selAvatar').textContent = inicial;
    document.getElementById('selName').textContent   = nombre;
    document.getElementById('selCode').textContent   = codigo;

    // Filtrar tickets de este usuario
    userTickets = allTickets.filter(t => t.usuario_id == id);

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

    renderTickets();
}

// ── Cambiar filtro estado con SELECT ─────────────────────────────────────────
function setEstado(e) {
    estadoFiltro = e;
    const select = document.getElementById('estadoSelect');
    if (select && select.value !== e) select.value = e;
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
    return `<span style="${map[s]??'background:#f1f5f9;color:#64748b;'}font-size:11px;font-weight:600;padding:4px 12px;border-radius:30px;">${s}</span>`;
}

function priBadge(nombre, color) {
    const c = color || '#1a6ed8';
    return nombre
        ? `<span style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:500;color:${c};">
               <span style="width:8px;height:8px;border-radius:50%;background:${c};display:inline-block;box-shadow:0 0 0 2px ${c}20;"></span>${nombre}
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
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div style="font-weight:600;color:#64748b;margin-bottom:6px;">Ningún usuario seleccionado</div>
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
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    Sin tickets que mostrar
                </div>
            </td></tr>`;
        return;
    }

    tbody.innerHTML = pool.map(t => {
        const globalIdx = allTickets.findIndex(x => x.id_ticket === t.id_ticket);
        return `
        <tr>
            <td style="font-family:monospace;font-size:12px;font-weight:600;color:#185FA5;">${t.codigo_ticket}</td>
            <td style="color:#0a2540;max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${t.asunto ?? '—'}</td>
            <td>${badge(t.estado)}</td>
            <td>${priBadge(t.prioridad_nombre, t.prioridad_color)}</td>
            <td style="color:#64748b;font-size:12px;">${(t.created_at ?? '').substring(0,10)}</td>
            <td style="text-align:center;">
                <button class="btn-detalle" onclick="openModal(${globalIdx})"> Ver detalle</button>
            </td>
        </tr>`;
    }).join('');
}

// ── tickets global para el modal detalleticket ────────────────────────────────
const tickets = allTickets;

// Render inicial
renderTickets();
</script>