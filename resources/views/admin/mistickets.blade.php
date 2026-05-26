@include('components.admin.navbar-admin')
@include('components.admin.sidebar-admin')
@include('components.notificaciones.alertas')
@include('components.admin.editardetalleticket')
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="main-content">
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Mis Tickets</h1>
            <p class="page-subtitle">Tickets asignados a ti — {{ session('nombre') }}</p>
        </div>
    </div>

    {{-- STATS --}}
    <div class="mt-stats">

        <div class="mt-stat-card">
            <div class="mt-stat-icon" style="background:#e0e7ff;color:#4338ca;">🎫</div>
            <div class="mt-stat-info">
                <span class="mt-stat-label">Total</span>
                <span class="mt-stat-number">{{ $resumen['total'] }}</span>
            </div>
        </div>

        <div class="mt-stat-card" style="border-left:4px solid #3b82f6;">
            <div class="mt-stat-icon" style="background:#dbeafe;color:#2563eb;">📅</div>
            <div class="mt-stat-info">
                <span class="mt-stat-label">Programados</span>
                <span class="mt-stat-number">{{ $resumen['programado'] }}</span>
            </div>
        </div>

        <div class="mt-stat-card" style="border-left:4px solid #f59e0b;">
            <div class="mt-stat-icon" style="background:#fef3c7;color:#d97706;">🔧</div>
            <div class="mt-stat-info">
                <span class="mt-stat-label">En Proceso</span>
                <span class="mt-stat-number">{{ $resumen['en_proceso'] }}</span>
            </div>
        </div>

        <div class="mt-stat-card" style="border-left:4px solid #22c55e;">
            <div class="mt-stat-icon" style="background:#dcfce7;color:#15803d;">✅</div>
            <div class="mt-stat-info">
                <span class="mt-stat-label">Cerrados</span>
                <span class="mt-stat-number">{{ $resumen['cerrado'] }}</span>
            </div>
        </div>

        <div class="mt-stat-card" style="border-left:4px solid #ef4444;">
            <div class="mt-stat-icon" style="background:#fee2e2;color:#dc2626;">❌</div>
            <div class="mt-stat-info">
                <span class="mt-stat-label">Cancelados</span>
                <span class="mt-stat-number">{{ $resumen['cancelado'] }}</span>
            </div>
        </div>

    </div>

    {{-- FILTROS + BÚSQUEDA --}}
    <div class="mt-toolbar">
        <div class="mt-pills" id="mt-pills">
            <button class="mt-pill active" onclick="mtFiltrar('todos', this)">Todos</button>
            <button class="mt-pill" onclick="mtFiltrar('PROGRAMADO', this)">Programado</button>
            <button class="mt-pill" onclick="mtFiltrar('EN PROCESO', this)">En Proceso</button>
            <button class="mt-pill" onclick="mtFiltrar('CERRADO', this)">Cerrado</button>
            <button class="mt-pill" onclick="mtFiltrar('CANCELADO', this)">Cancelado</button>
        </div>
        <div class="mt-search">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="mt-buscar" placeholder="Buscar por asunto, cliente..." oninput="mtBuscar()">
        </div>
    </div>

    {{-- GRID TICKETS --}}
    <div class="mt-grid" id="mt-grid">
        {{-- Se llena dinámicamente --}}
    </div>

    {{-- EMPTY --}}
    <div class="mt-empty" id="mt-empty" style="display:none;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" style="color:#cbd5e0">
            <path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/>
            <path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/>
            <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>
        </svg>
        <p>No hay tickets para mostrar.</p>
    </div>

</div>
</div>

{{-- DATOS PHP → JS --}}
<script>
const MT_TICKETS = @json($tickets->values());

let mtFiltroActual = 'todos';
let mtBusqueda     = '';

// ── Render ────────────────────────────────────────────────────────
function mtRender() {
    const grid  = document.getElementById('mt-grid');
    const empty = document.getElementById('mt-empty');

    let lista = MT_TICKETS;

    if (mtFiltroActual !== 'todos') {
        lista = lista.filter(t => t.estado === mtFiltroActual);
    }

    if (mtBusqueda.trim()) {
        const q = mtBusqueda.toLowerCase();
        lista = lista.filter(t =>
            (t.asunto         || '').toLowerCase().includes(q) ||
            (t.razon_social   || '').toLowerCase().includes(q) ||
            (t.usuario_nombre || '').toLowerCase().includes(q) ||
            (t.codigo_ticket  || '').toLowerCase().includes(q)
        );
    }

    if (!lista.length) {
        grid.innerHTML = '';
        empty.style.display = 'flex';
        return;
    }

    empty.style.display = 'none';

    grid.innerHTML = lista.map(t => {
        const estadoStyle = t.estado_color
            ? `background:${t.estado_color}20;color:${t.estado_color};border:1px solid ${t.estado_color}40`
            : '';
        const prioStyle = t.prioridad_color
            ? `background:${t.prioridad_color}20;color:${t.prioridad_color};border:1px solid ${t.prioridad_color}40`
            : '';
        const fecha = t.created_at
            ? new Date(t.created_at).toLocaleDateString('es-PE', {
                day: '2-digit', month: 'short', year: 'numeric'
              })
            : '—';

        return `
<div class="mt-card">
    <div class="mt-card-header">
        <div class="mt-card-header-left">
        <span class="mt-card-id">#${t.id_ticket}</span>
            <span class="mt-card-codigo">${t.codigo_ticket || '—'}</span>
            
        </div>
        <span class="mt-card-estado" style="${estadoStyle}">${t.estado}</span>
    </div>

    <div class="mt-card-body">
        <p class="mt-card-asunto">${t.asunto || 'Sin asunto'}</p>

        <div class="mt-card-info-group">
            <div class="mt-card-info-row">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                <span>${t.razon_social || '—'}</span>
            </div>
            <div class="mt-card-info-row">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>${t.usuario_nombre || '—'}</span>
            </div>
        </div>

        <div class="mt-card-divider"></div>

        <div class="mt-card-bottom">
            <div class="mt-card-badges">
                <span class="mt-card-tipo">📋 ${t.tipo_ticket_nombre}</span>
                <span class="mt-card-prio" style="${prioStyle}">⚡ ${t.prioridad_nombre}</span>
            </div>
            <div class="mt-card-fecha">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                ${fecha}
            </div>
        </div>
    </div>

    <div class="mt-card-footer">
        <button class="mt-btn-detalle" onclick="abrirDetalleTicket(${t.id_ticket})">
            👁 Ver detalle
        </button>
    </div>
</div>`;
    }).join('');
}

// ── Filtrar ───────────────────────────────────────────────────────
function mtFiltrar(estado, btn) {
    mtFiltroActual = estado;
    document.querySelectorAll('.mt-pill').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    mtRender();
}

// ── Buscar ────────────────────────────────────────────────────────
function mtBuscar() {
    mtBusqueda = document.getElementById('mt-buscar').value;
    mtRender();
}

// ── Init ──────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', mtRender);

// ── stub requerido por detalleticket.blade.php del admin ─────────
function cerrarPanelEdicion() {}
</script>

<style>
.main-content {
    margin-left: 260px;
    padding: 30px;
    background: #f0f4f8;
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
    transition: margin-left .35s ease;
}
body.sb-collapsed .main-content { margin-left: 70px; }

/* Header */
.page-header  { margin-bottom: 24px; }
.page-title   { font-size: 24px; font-weight: 700; color: #1a202c; margin: 0; }
.page-subtitle{ font-size: 14px; color: #718096; margin: 4px 0 0; }

/* Stats */
.mt-stats {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 14px;
    margin-bottom: 28px;
}
.mt-stat-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px;
    display: flex; align-items: center; gap: 12px;
}
.mt-stat-icon {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.mt-stat-label  { display: block; font-size: 11px; color: #718096; font-weight: 500; }
.mt-stat-number { font-size: 22px; font-weight: 700; color: #2d3748; }

/* Toolbar */
.mt-toolbar {
    display: flex; align-items: center; gap: 14px;
    margin-bottom: 22px; flex-wrap: wrap;
}
.mt-pills { display: flex; gap: 8px; flex-wrap: wrap; flex: 1; }
.mt-pill {
    padding: 7px 16px; border-radius: 20px;
    border: 1px solid #e2e8f0; background: #fff;
    font-size: 12px; font-weight: 600; color: #718096;
    cursor: pointer; transition: .15s;
}
.mt-pill:hover  { background: #f7fafc; }
.mt-pill.active { background: #13294b; color: #fff; border-color: #13294b; }

.mt-search {
    display: flex; align-items: center; gap: 8px;
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 10px; padding: 9px 14px;
    min-width: 220px; color: #a0aec0;
}
.mt-search input {
    border: none; outline: none; font-size: 13px;
    color: #4a5568; background: transparent; width: 100%;
}
.mt-search input::placeholder { color: #b0bec5; }

/* Grid */
.mt-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 18px;
    margin-bottom: 30px;
}

/* Card */
/* Card */
.mt-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: box-shadow .2s, transform .15s;
}
.mt-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,.09);
    transform: translateY(-2px);
}

/* Header */
.mt-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: #f8fafc;
    border-bottom: 1px solid #eef2f7;
}
.mt-card-header-left {
    display: flex;
    align-items: center;
    gap: 8px;
}
.mt-card-codigo {
    font-size: 12px;
    font-weight: 700;
    color: #2563eb;
    background: #eff6ff;
    padding: 3px 10px;
    border-radius: 20px;
    border: 1px solid #bfdbfe;
}
.mt-card-id {
    font-size: 11px;
    color: #b0bec5;
    font-weight: 600;
}
.mt-card-estado {
    font-size: 11px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 20px;
    white-space: nowrap;
}

/* Body */
.mt-card-body {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.mt-card-asunto {
    font-size: 14px;
    font-weight: 700;
    color: #1e3a5f;
    margin: 0;
    line-height: 1.45;
}

/* Info rows */
.mt-card-info-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.mt-card-info-row {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 12px;
    color: #4a5568;
}
.mt-card-info-row svg {
    flex-shrink: 0;
    color: #94a3b8;
}

/* Divider */
.mt-card-divider {
    border: none;
    border-top: 1px dashed #e9eef5;
    margin: 2px 0;
}

/* Bottom row */
.mt-card-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}
.mt-card-badges {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.mt-card-tipo {
    font-size: 11px;
    background: #f1f5f9;
    color: #475569;
    padding: 3px 10px;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
}
.mt-card-prio {
    font-size: 11px;
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: 700;
}
.mt-card-fecha {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: #94a3b8;
    white-space: nowrap;
}

/* Footer */
.mt-card-footer {
    border-top: 1px solid #eef2f7;
    background: #f8fafc;
}
.mt-btn-detalle {
    width: 100%;
    padding: 11px;
    border: none;
    background: transparent;
    font-size: 13px;
    font-weight: 600;
    color: #2563eb;
    cursor: pointer;
    transition: background .15s;
    letter-spacing: 0.01em;
}
.mt-btn-detalle:hover { background: #eff6ff; }
/* Empty */
.mt-empty {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; gap: 12px;
    padding: 80px 0; color: #a0aec0; font-size: 14px;
}

/* Responsive */
@media (min-width: 769px) and (max-width: 1024px) {
    .main-content { margin-left: 0 !important; padding: 24px 20px; padding-top: 68px; }
    .mt-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .main-content { margin-left: 0 !important; padding: 16px; padding-top: 68px; box-sizing: border-box; }
    .mt-stats { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .mt-grid  { grid-template-columns: 1fr; }
    .mt-toolbar { flex-direction: column; align-items: flex-start; }
    .mt-search  { width: 100%; box-sizing: border-box; }
    .mt-pills   { width: 100%; }
}
@media (max-width: 480px) {
    .main-content { padding: 12px; padding-top: 68px; }
    .mt-stats { grid-template-columns: 1fr 1fr; }
    .mt-stat-number { font-size: 18px; }
}
</style>