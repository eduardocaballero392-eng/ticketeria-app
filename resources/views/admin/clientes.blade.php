{{-- ══ GESTIÓN DE PERSONAS (CLIENTES / USUARIOS / TÉCNICOS) ══ --}}
@include('components.admin.detalleticket')
@include('components.admin.navbar-admin')
@include('components.admin.sidebar-admin')
@include('components.notificaciones.alertas')
@include('components.admin.modalcrearusuario')
@include('components.admin.modalcrearcliente')
@include('components.admin.modalcreartecnico')
@include('components.admin.modalverdetalle')

<style>

/* ── Variables ─────────────────────────────────────────────────────── */
:root {
  --erp-bg:           #f1f4f8;
  --erp-card:         #ffffff;
  --erp-text:         #0f172a;
  --erp-text-2:       #334155;
  --erp-muted:        #64748b;
  --erp-border:       #e2e8f0;
  --erp-border-li:    #f1f5f9;

  /* Brand primary */
  --erp-primary:      #0f4a8a;
  --erp-primary-h:    #1a6ed8;
  --erp-primary-bg:   #eff6ff;

  /* Semantic colors */
  --erp-success:      #166534;
  --erp-success-bg:   #f0fdf4;
  --erp-success-ring: #bbf7d0;
  --erp-danger:       #991b1b;
  --erp-danger-bg:    #fef2f2;
  --erp-danger-ring:  #fecaca;

  /* Type accent colors */
  --erp-teal:         #0f766e;
  --erp-teal-bg:      #f0fdfa;
  --erp-teal-ring:    #99f6e4;
  --erp-violet:       #5b21b6;
  --erp-violet-bg:    #f5f3ff;
  --erp-violet-ring:  #ddd6fe;

  --erp-radius:       6px;
  --erp-shadow:       0 1px 2px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.07);
  --erp-shadow-md:    0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px rgba(0,0,0,0.04);
}

/* ── Layout wrapper ─────────────────────────────────────────────────── */
.erp-content-wrapper {
  padding: 24px 32px;
  min-height: 100vh;
  background: var(--erp-bg);
}
@media (max-width: 1024px) { .erp-content-wrapper { padding: 20px; padding-top: 75px; } }
@media (max-width: 768px)  { .erp-content-wrapper { padding: 16px; padding-top: 65px; } }

/* ── Z-Index: Modales > Navbar > Sidebar (no tocar) ─────────────────── */
#modalVerDetalle, .modal-system-overlay,
#modalcrearcliente, #modalcrearusuario, #modalcreartecnico {
  z-index: 10500 !important;
}
#jhs-sidebar  { z-index: 200 !important; }
.admin-navbar { z-index: 300 !important; }

/* ────────────────────────────────────────────────────────────────────
   HEADER
   ─────────────────────────────────────────────────────────────────── */
.erp-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 20px;
  flex-wrap: wrap;
  gap: 16px;
  margin-top: 80px;
  position: relative;
  z-index: 20;
}
.erp-header-info { display: flex; flex-direction: column; gap: 3px; }
.erp-title {
  font-size: 1.375rem;
  font-weight: 700;
  color: var(--erp-text);
  margin: 0;
  letter-spacing: -0.015em;
  line-height: 1.2;
}
.erp-subtitle {
  font-size: 0.875rem;
  color: var(--erp-muted);
  margin: 0;
}
.erp-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

/* CTA buttons */
.btn-erp-primary,
.btn-erp-secondary {
  padding: 8px 15px;
  border-radius: var(--erp-radius);
  font-size: 0.8125rem;
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all .15s ease;
  line-height: 1;
  white-space: nowrap;
}
.btn-erp-primary {
  background: var(--erp-primary);
  color: #fff;
  border: 1px solid var(--erp-primary);
  box-shadow: 0 1px 2px rgba(15,74,138,.25);
}
.btn-erp-primary:hover {
  background: var(--erp-primary-h);
  border-color: var(--erp-primary-h);
  transform: translateY(-1px);
  box-shadow: 0 3px 8px rgba(15,74,138,.22);
}
.btn-erp-secondary {
  background: var(--erp-card);
  color: var(--erp-text-2);
  border: 1px solid var(--erp-border);
}
.btn-erp-secondary:hover {
  border-color: var(--erp-primary-h);
  color: var(--erp-primary);
  background: var(--erp-primary-bg);
}

/* ────────────────────────────────────────────────────────────────────
   STATS STRIP
   ─────────────────────────────────────────────────────────────────── */
.erp-stats-strip {
  display: flex;
  gap: 10px;
  margin-bottom: 14px;
  flex-wrap: wrap;
}
.stat-card {
  display: flex;
  align-items: center;
  gap: 12px;
  background: var(--erp-card);
  border: 1px solid var(--erp-border);
  border-radius: var(--erp-radius);
  padding: 12px 16px;
  box-shadow: var(--erp-shadow);
  flex: 1;
  min-width: 120px;
  transition: box-shadow .15s, border-color .15s;
}
.stat-card:hover { box-shadow: var(--erp-shadow-md); }
.stat-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 34px;
  height: 34px;
  border-radius: 7px;
  flex-shrink: 0;
}
.stat-icon.si-c { background: var(--erp-primary-bg); color: var(--erp-primary-h); }
.stat-icon.si-u { background: var(--erp-teal-bg);    color: var(--erp-teal); }
.stat-icon.si-t { background: var(--erp-violet-bg);  color: var(--erp-violet); }
.stat-icon.si-a { background: var(--erp-success-bg); color: var(--erp-success); }
.stat-body  { display: flex; flex-direction: column; gap: 1px; }
.stat-value { font-size: 1.25rem; font-weight: 700; color: var(--erp-text); line-height: 1; }
.stat-label { font-size: 0.725rem; color: var(--erp-muted); font-weight: 500; letter-spacing: .01em; }

/* ────────────────────────────────────────────────────────────────────
   TOOLBAR (filtros + búsqueda)
   ─────────────────────────────────────────────────────────────────── */
.erp-toolbar {
  background: var(--erp-card);
  border: 1px solid var(--erp-border);
  border-radius: var(--erp-radius);
  padding: 11px 16px;
  margin-bottom: 14px;
  box-shadow: var(--erp-shadow);
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  align-items: center;
}
.filter-section {
  display: flex;
  align-items: center;
  gap: 8px;
}
.filter-section-lbl {
  font-size: 0.675rem;
  font-weight: 700;
  color: var(--erp-muted);
  text-transform: uppercase;
  letter-spacing: .07em;
  white-space: nowrap;
}
.toolbar-sep {
  width: 1px;
  height: 24px;
  background: var(--erp-border);
  flex-shrink: 0;
}

/* Segmented control container */
.seg-ctrl {
  display: inline-flex;
  background: var(--erp-bg);
  border: 1px solid var(--erp-border);
  border-radius: 7px;
  padding: 3px;
  gap: 2px;
}

/* filter-toggle mantiene el selector original para el JS */
.filter-toggle {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 5px 11px;
  border-radius: 5px;
  font-size: 0.7875rem;
  font-weight: 500;
  cursor: pointer;
  border: none;
  background: transparent;
  color: var(--erp-muted);
  transition: all .15s ease;
  white-space: nowrap;
  line-height: 1.15;
  -webkit-font-smoothing: antialiased;
}
.filter-toggle:hover {
  background: rgba(255,255,255,.75);
  color: var(--erp-text-2);
}
.filter-toggle.active {
  background: var(--erp-card);
  color: var(--erp-primary);
  font-weight: 600;
  box-shadow: 0 1px 3px rgba(0,0,0,.09), 0 1px 2px rgba(0,0,0,.05);
}
/* Contadores en los filtros */
.ft-ct {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 17px;
  height: 17px;
  padding: 0 4px;
  border-radius: 9px;
  font-size: 0.67rem;
  font-weight: 700;
  background: #e9edf3;
  color: var(--erp-muted);
  transition: all .15s;
  margin-left: 1px;
}
.filter-toggle.active .ft-ct {
  background: var(--erp-primary-bg);
  color: var(--erp-primary-h);
}

/* Toolbar: caja de búsqueda */
.toolbar-search {
  display: flex;
  align-items: center;
  gap: 7px;
  margin-left: auto;
}
.erp-toolbar .toolbar-search .search-input {
  border: 1px solid var(--erp-border);
  border-radius: var(--erp-radius);
  padding: 7px 12px 7px 34px;
  font-size: 0.84rem;
  width: 260px;
  outline: none;
  background: var(--erp-bg)
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.2' stroke-linecap='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E")
    10px center no-repeat;
  color: var(--erp-text);
  transition: border-color .15s, box-shadow .15s, background-color .15s;
}
.erp-toolbar .toolbar-search .search-input:focus {
  border-color: var(--erp-primary-h);
  box-shadow: 0 0 0 3px rgba(26,110,216,.1);
  background-color: #fff;
}
.erp-toolbar .toolbar-search .search-input::placeholder { color: #94a3b8; }
.erp-toolbar .toolbar-search .btn-search {
  background: var(--erp-primary);
  color: #fff;
  border: 1px solid var(--erp-primary);
  border-radius: var(--erp-radius);
  padding: 7px 14px;
  font-size: 0.8125rem;
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: background .15s;
  white-space: nowrap;
}
.erp-toolbar .toolbar-search .btn-search:hover { background: var(--erp-primary-h); border-color: var(--erp-primary-h); }

/* ────────────────────────────────────────────────────────────────────
   TABLE
   ─────────────────────────────────────────────────────────────────── */
.erp-table-container {
  background: var(--erp-card);
  border: 1px solid var(--erp-border);
  border-radius: var(--erp-radius);
  box-shadow: var(--erp-shadow);
  overflow-x: auto;
  overflow-y: hidden;
}

.erp-table td:last-child {
  white-space: nowrap; /* Evita que los botones salten de línea */
}
.row-actions {
  flex-wrap: nowrap; /* Fuerza a los botones a mantenerse en una línea */
}

.erp-table               { width: 100%; border-collapse: collapse; }
.erp-table thead         { background: #f8fafc; border-bottom: 2px solid var(--erp-border); }
.erp-table th {
  padding: 10px 16px;
  text-align: left;
  font-size: 0.69rem;
  font-weight: 700;
  color: var(--erp-muted);
  text-transform: uppercase;
  letter-spacing: .065em;
  -webkit-font-smoothing: antialiased;
}
.erp-table td {
  padding: 11px 16px;
  border-bottom: 1px solid var(--erp-border-li);
  font-size: 0.875rem;
  color: var(--erp-text);
  vertical-align: middle;
}
.erp-table tbody tr:last-child td { border-bottom: none; }
.erp-table tbody tr:hover { background: #f8fbff; }

/* ── Celda ID ── */
.cell-id {
  font-size: 0.775rem;
  font-weight: 600;
  color: var(--erp-muted);
  font-variant-numeric: tabular-nums;
  letter-spacing: .01em;
}
/* ── Celda nombre ── */
.cell-name { font-weight: 500; color: var(--erp-text); }

/* ── Type badges ───────────────────────────────────────────────────── */
.type-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 3px 8px 3px 5px;
  border-radius: 4px;
  font-size: 0.73rem;
  font-weight: 600;
  letter-spacing: .01em;
  line-height: 1;
}
.type-badge svg { flex-shrink: 0; }
.type-badge.tb-c { background: var(--erp-primary-bg); color: var(--erp-primary-h); }
.type-badge.tb-u { background: var(--erp-teal-bg);    color: var(--erp-teal);      }
.type-badge.tb-t { background: var(--erp-violet-bg);  color: var(--erp-violet);    }

/* ── Status badges ─────────────────────────────────────────────────── */
.badge-active,
.badge-inactive {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 3px 8px;
  border-radius: 4px;
  font-size: 0.73rem;
  font-weight: 600;
  line-height: 1;
}
.badge-active   { background: var(--erp-success-bg); color: var(--erp-success); }
.badge-inactive { background: var(--erp-danger-bg);  color: var(--erp-danger);  }
.bdot {
  display: inline-block;
  width: 5px;
  height: 5px;
  border-radius: 50%;
  flex-shrink: 0;
}
.badge-active  .bdot { background: var(--erp-success); }
.badge-inactive .bdot{ background: var(--erp-danger);  }

/* ── Row action buttons ─────────────────────────────────────────────── */
.row-actions { display: flex; gap: 5px; align-items: center; }
.btn-action-sm {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 4px 10px;
  border-radius: 5px;
  font-size: 0.775rem;
  font-weight: 500;
  cursor: pointer;
  border: 1px solid var(--erp-border);
  background: var(--erp-card);
  color: var(--erp-muted);
  transition: all .15s ease;
  white-space: nowrap;
  line-height: 1;
}
.btn-action-sm:hover {
  border-color: var(--erp-primary-h);
  color: var(--erp-primary);
  background: var(--erp-primary-bg);
}
.btn-action-sm.btn-deactivate:hover {
  border-color: var(--erp-danger);
  color: var(--erp-danger);
  background: var(--erp-danger-bg);
}
.btn-action-sm.btn-activate:hover {
  border-color: var(--erp-success);
  color: var(--erp-success);
  background: var(--erp-success-bg);
}

/* ── Empty state ────────────────────────────────────────────────────── */
#erp-empty-row { display: none; }
#erp-empty-row.show { display: table-row; }
.erp-empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 56px 24px;
  text-align: center;
  color: var(--erp-muted);
}
.erp-empty-ico  { color: #cbd5e1; margin-bottom: 14px; }
.erp-empty-ttl  { font-size: 0.9375rem; font-weight: 600; color: var(--erp-text-2); margin: 0 0 4px; }
.erp-empty-desc { font-size: 0.84rem; margin: 0; }

/* ────────────────────────────────────────────────────────────────────
   PAGINATION
   ─────────────────────────────────────────────────────────────────── */
.erp-pagination {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 18px;
  border-top: 1px solid var(--erp-border);
  background: #f8fafc;
}
.pagination-info { font-size: 0.8125rem; color: var(--erp-muted); }
.pagination-info strong { color: var(--erp-text-2); font-weight: 600; }
.pagination-controls { display: flex; gap: 6px; align-items: center; }
.page-btn {
  padding: 5px 11px;
  border: 1px solid var(--erp-border);
  border-radius: 5px;
  background: var(--erp-card);
  cursor: pointer;
  font-size: 0.8rem;
  color: var(--erp-muted);
  display: inline-flex;
  align-items: center;
  gap: 4px;
  transition: all .15s;
}
.page-btn:hover:not(:disabled) {
  border-color: var(--erp-primary-h);
  color: var(--erp-primary);
  background: var(--erp-primary-bg);
}
.page-btn:disabled { opacity: .4; cursor: not-allowed; }
.page-input {
  width: 44px;
  text-align: center;
  border: 1px solid var(--erp-border);
  border-radius: 5px;
  padding: 5px;
  font-size: 0.8125rem;
  background: var(--erp-card);
}
</style>

{{-- ════════════════════════════════════════════════════════════════════
     LAYOUT — mismo wrapper que el original para no romper sidebar/navbar
     ════════════════════════════════════════════════════════════════════ --}}
<div class="dashboard-layout">
<div class="dashboard-content">

  {{-- ── HEADER ────────────────────────────────────────────────────── --}}
  <div class="erp-header">
    <div class="erp-header-info">
      <h1 class="erp-title">Gestión de Personas</h1>
      <p class="erp-subtitle">Administración centralizada de clientes, usuarios y técnicos</p>
    </div>
    <div class="erp-actions">
      {{-- Nuevo Cliente --}}
      <button class="btn-erp-primary" onclick="abrirModalCliente('modalcrearcliente')">
        {{-- building + plus --}}
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Nuevo Cliente
      </button>
      {{-- Nuevo Usuario --}}
      <button class="btn-erp-secondary" onclick="abrirModalUsuario('modalcrearusuario')">
        {{-- user-plus --}}
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
        Nuevo Usuario
      </button>
      {{-- Nuevo Técnico --}}
      <button class="btn-erp-secondary" onclick="abrirModalTecnico('modalcreartecnico')">
        {{-- wrench + plus --}}
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
        Nuevo Técnico
      </button>
    </div>
  </div>

  {{-- ── STATS STRIP ─────────────────────────────────────────────────── --}}
  @php
    $totalReg    = $clientes->count() + $usuarios_lista->count() + $tecnicos->count();
    $totalActivo = $clientes->where('activo',1)->count()
                 + $usuarios_lista->where('activo',1)->count()
                 + $tecnicos->where('activo',1)->count();
  @endphp
  <div class="erp-stats-strip">

    {{-- Clientes --}}
    <div class="stat-card">
      <div class="stat-icon si-c">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="7" width="20" height="14" rx="2"/>
          <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>
        </svg>
      </div>
      <div class="stat-body">
        <span class="stat-value">{{ $clientes->count() }}</span>
        <span class="stat-label">Clientes</span>
      </div>
    </div>

    {{-- Usuarios --}}
    <div class="stat-card">
      <div class="stat-icon si-u">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
      </div>
      <div class="stat-body">
        <span class="stat-value">{{ $usuarios_lista->count() }}</span>
        <span class="stat-label">Usuarios</span>
      </div>
    </div>

    {{-- Técnicos --}}
    <div class="stat-card">
      <div class="stat-icon si-t">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>
        </svg>
      </div>
      <div class="stat-body">
        <span class="stat-value">{{ $tecnicos->count() }}</span>
        <span class="stat-label">Técnicos</span>
      </div>
    </div>

    {{-- Activos --}}
    <div class="stat-card">
      <div class="stat-icon si-a">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
      </div>
      <div class="stat-body">
        <span class="stat-value">{{ $totalActivo }}</span>
        <span class="stat-label">Activos</span>
      </div>
    </div>

  </div>

  {{-- ── TOOLBAR: filtros + búsqueda ──────────────────────────────────── --}}
  <div class="erp-toolbar">

    {{-- Filtro por tipo --}}
    <div class="filter-section">
      <span class="filter-section-lbl">Tipo</span>
      <div class="seg-ctrl">
        {{-- Todos --}}
        <button class="filter-toggle active" data-filter="all">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
          </svg>
          Todos
          <span class="ft-ct">{{ $totalReg }}</span>
        </button>
        {{-- Clientes --}}
        <button class="filter-toggle" data-filter="cliente">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="7" width="20" height="14" rx="2"/>
            <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>
          </svg>
          Clientes
          <span class="ft-ct">{{ $clientes->count() }}</span>
        </button>
        {{-- Usuarios --}}
        <button class="filter-toggle" data-filter="usuario">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
          Usuarios
          <span class="ft-ct">{{ $usuarios_lista->count() }}</span>
        </button>
        {{-- Técnicos --}}
        <button class="filter-toggle" data-filter="tecnico">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>
          </svg>
          Técnicos
          <span class="ft-ct">{{ $tecnicos->count() }}</span>
        </button>
      </div>
    </div>

    <div class="toolbar-sep"></div>

    {{-- Filtro por estado --}}
    <div class="filter-section">
      <span class="filter-section-lbl">Estado</span>
      <div class="seg-ctrl">
        {{-- Todos --}}
        <button class="filter-toggle active" data-status="all">
          Todos
          <span class="ft-ct">{{ $totalReg }}</span>
        </button>
        {{-- Activos --}}
        <button class="filter-toggle" data-status="activo">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="9 12 11 14 15 10"/>
          </svg>
          Activos
          <span class="ft-ct">{{ $totalActivo }}</span>
        </button>
        {{-- Inactivos --}}
        <button class="filter-toggle" data-status="inactivo">
          <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/>
            <line x1="9" y1="9" x2="15" y2="15"/>
          </svg>
          Inactivos
          <span class="ft-ct">{{ $totalReg - $totalActivo }}</span>
        </button>
      </div>
    </div>

    {{-- Búsqueda --}}
    <div class="toolbar-search">
      <input
        type="text"
        class="search-input"
        placeholder="Buscar por nombre, RUC o código..."
        id="globalSearch"
      >
      <button class="btn-search">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        Buscar
      </button>
    </div>
  </div>

  {{-- ── TABLA ─────────────────────────────────────────────────────────── --}}
  <div class="erp-table-container">
    <table class="erp-table">
      <thead>
        <tr>
          <th style="width:60px">Cód.</th>
          <th style="width:115px">Tipo</th>
          <th>Nombre / Razón Social</th>
          <th>RUC / Código</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th style="width:100px">Estado</th>
          <th style="width:172px">Acciones</th>
        </tr>
      </thead>
      <tbody>

        {{-- ── CLIENTES ──────────────────────────────────────────────── --}}
        @foreach($clientes as $cliente)
        <tr data-type="cliente" data-id="{{ $cliente->id_cliente }}" data-status="{{ $cliente->activo ? 'activo' : 'inactivo' }}">
          <td class="cell-id">#{{ $cliente->id_cliente }}</td>
          <td>
            <span class="type-badge tb-c">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2"/>
                <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>
              </svg>
              Cliente
            </span>
          </td>
          <td class="cell-name">{{ Str::limit($cliente->razon_social, 40) }}</td>
          <td>{{ $cliente->ruc ?? '—' }}</td>
          <td>{{ Str::limit($cliente->correo ?? '—', 25) }}</td>
          <td>{{ $cliente->telefono ?? '—' }}</td>
          <td>
            @if($cliente->activo)
              <span class="badge-active"><span class="bdot"></span>Activo</span>
            @else
              <span class="badge-inactive"><span class="bdot"></span>Inactivo</span>
            @endif
          </td>
          <td>
            <div class="row-actions">
              <button class="btn-action-sm" onclick="verDetalleCliente({{ $cliente->id_cliente }})">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                Detalle
              </button>
              <button
                class="btn-action-sm {{ $cliente->activo ? 'btn-deactivate' : 'btn-activate' }}"
                onclick="toggleEstado('cliente', {{ $cliente->id_cliente }}, {{ $cliente->activo ? 0 : 1 }})"
              >
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18.36 6.64a9 9 0 11-12.73 0"/>
                  <line x1="12" y1="2" x2="12" y2="12"/>
                </svg>
                {{ $cliente->activo ? 'Suspender' : 'Activar' }}
              </button>
            </div>
          </td>
        </tr>
        @endforeach

        {{-- ── USUARIOS ──────────────────────────────────────────────── --}}
        @foreach($usuarios_lista as $u)
        <tr data-type="usuario" data-id="{{ $u->id_usuario }}" data-status="{{ $u->activo ? 'activo' : 'inactivo' }}">
          <td class="cell-id">#{{ $u->id_usuario }}</td>
          <td>
            <span class="type-badge tb-u">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
              Usuario
            </span>
          </td>
          <td class="cell-name">{{ Str::limit($u->nombre.' '.$u->apellido_paterno.' '.$u->apellido_materno, 40) }}</td>
          <td>{{ $u->codigo_usuario ?? '—' }}</td>
          <td>{{ Str::limit($u->correo ?? '—', 25) }}</td>
          <td>{{ $u->telefono ?? '—' }}</td>
          <td>
            @if($u->activo)
              <span class="badge-active"><span class="bdot"></span>Activo</span>
            @else
              <span class="badge-inactive"><span class="bdot"></span>Bloqueado</span>
            @endif
          </td>
          <td>
            <div class="row-actions">
              <button class="btn-action-sm" onclick="verDetalleUsuario({{ $u->id_usuario }})">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                Detalle
              </button>
              <button
                class="btn-action-sm {{ $u->activo ? 'btn-deactivate' : 'btn-activate' }}"
                onclick="toggleEstado('usuario', {{ $u->id_usuario }}, {{ $u->activo ? 0 : 1 }})"
              >
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18.36 6.64a9 9 0 11-12.73 0"/>
                  <line x1="12" y1="2" x2="12" y2="12"/>
                </svg>
                {{ $u->activo ? 'Bloquear' : 'Activar' }}
              </button>
            </div>
          </td>
        </tr>
        @endforeach

        {{-- ── TÉCNICOS ───────────────────────────────────────────────── --}}
        @foreach($tecnicos as $t)
        <tr data-type="tecnico" data-id="{{ $t->id_tecnico }}" data-status="{{ $t->activo ? 'activo' : 'inactivo' }}">
          <td class="cell-id">#{{ $t->id_tecnico }}</td>
          <td>
            <span class="type-badge tb-t">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>
              </svg>
              Técnico
            </span>
          </td>
          <td class="cell-name">{{ Str::limit($t->nombre.' '.$t->apellido_paterno.' '.$t->apellido_materno, 40) }}</td>
          <td>{{ $t->codigo_tecnico ?? '—' }}</td>
          <td>{{ Str::limit($t->correo ?? '—', 25) }}</td>
          <td>{{ $t->telefono ?? '—' }}</td>
          <td>
            @if($t->activo)
              <span class="badge-active"><span class="bdot"></span>Activo</span>
            @else
              <span class="badge-inactive"><span class="bdot"></span>Baja</span>
            @endif
          </td>
          <td>
            <div class="row-actions">
              <button class="btn-action-sm" onclick="verDetalleTecnico({{ $t->id_tecnico }})">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
                Detalle
              </button>
              <button
                class="btn-action-sm {{ $t->activo ? 'btn-deactivate' : 'btn-activate' }}"
                onclick="toggleEstado('tecnico', {{ $t->id_tecnico }}, {{ $t->activo ? 0 : 1 }})"
              >
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18.36 6.64a9 9 0 11-12.73 0"/>
                  <line x1="12" y1="2" x2="12" y2="12"/>
                </svg>
                {{ $t->activo ? 'Dar baja' : 'Activar' }}
              </button>
            </div>
          </td>
        </tr>
        @endforeach

      </tbody>
      {{-- Empty state row — el JS lo muestra cuando visibles === 0 --}}
      <tfoot>
        <tr id="erp-empty-row">
          <td colspan="8">
            <div class="erp-empty-state">
              <div class="erp-empty-ico">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="11" cy="11" r="8"/>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
              </div>
              <p class="erp-empty-ttl">Sin resultados</p>
              <p class="erp-empty-desc">No hay registros que coincidan con los filtros aplicados.</p>
            </div>
          </td>
        </tr>
      </tfoot>
    </table>

    {{-- ── PAGINACIÓN ──────────────────────────────────────────────── --}}
    <div class="erp-pagination">
      <div class="pagination-info">
        Mostrando <strong>1–{{ $clientes->count() + $usuarios_lista->count() + $tecnicos->count() }}</strong> de
        <strong>{{ $clientes->count() + $usuarios_lista->count() + $tecnicos->count() }}</strong> registros
      </div>
      <div class="pagination-controls">
        <button class="page-btn" disabled>
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"/>
          </svg>
          Anterior
        </button>
        <input type="number" class="page-input" value="1" min="1">
        <span style="font-size:.8rem;color:var(--erp-muted)">de 1</span>
        <button class="page-btn" disabled>
          Siguiente
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

</div>
</div>

<script>
/* ═══════════════════════════════════════════════════════════════════
   FILTROS TIPO (Todos / Clientes / Usuarios / Técnicos)
   — Selectores CSS idénticos al original (.filter-toggle[data-filter])
   ═══════════════════════════════════════════════════════════════════ */
document.querySelectorAll('.filter-toggle[data-filter]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.filter-toggle[data-filter]').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    filtrarTabla();
  });
});

/* ═══════════════════════════════════════════════════════════════════
   FILTROS ESTADO (Todos / Activos / Inactivos)
   — Selectores CSS idénticos al original (.filter-toggle[data-status])
   ═══════════════════════════════════════════════════════════════════ */
document.querySelectorAll('.filter-toggle[data-status]').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.filter-toggle[data-status]').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    filtrarTabla();
  });
});

/* ═══════════════════════════════════════════════════════════════════
   BÚSQUEDA GLOBAL
   ═══════════════════════════════════════════════════════════════════ */
document.getElementById('globalSearch').addEventListener('keyup', function() {
  filtrarTabla();
});

document.querySelector('.btn-search').addEventListener('click', function() {
  filtrarTabla();
});

/* ═══════════════════════════════════════════════════════════════════
   FUNCIÓN CENTRAL DE FILTRADO
   Lógica 100% idéntica al original + toggle del empty-state
   ═══════════════════════════════════════════════════════════════════ */
function filtrarTabla() {
  const tipoActivo   = document.querySelector('.filter-toggle[data-filter].active').getAttribute('data-filter');
  const estadoActivo = document.querySelector('.filter-toggle[data-status].active').getAttribute('data-status');
  const busqueda     = document.getElementById('globalSearch').value.toLowerCase().trim();

  const filas    = document.querySelectorAll('.erp-table tbody tr');
  let   visibles = 0;

  filas.forEach(fila => {
    const tipoFila   = fila.getAttribute('data-type');
    const estadoFila = fila.getAttribute('data-status');
    const textoFila  = fila.textContent.toLowerCase();

    const coincideTipo     = tipoActivo   === 'all' || tipoFila   === tipoActivo;
    const coincideEstado   = estadoActivo === 'all' || estadoFila === estadoActivo;
    const coincideBusqueda = !busqueda || textoFila.includes(busqueda);

    if (coincideTipo && coincideEstado && coincideBusqueda) {
      fila.style.display = '';
      visibles++;
    } else {
      fila.style.display = 'none';
    }
  });

  /* Empty state */
  const emptyRow = document.getElementById('erp-empty-row');
  if (emptyRow) emptyRow.className = visibles === 0 ? 'show' : '';

  /* Actualizar contador de paginación */
  document.querySelector('.pagination-info strong:first-child').textContent =
    visibles > 0 ? `1\u20133${visibles}` : '0';  /* guion em "1–N" */
  document.querySelector('.pagination-info strong:last-child').textContent = filas.length;
}

/* ═══════════════════════════════════════════════════════════════════
   ABRIR MODALES DE CREACIÓN
   ═══════════════════════════════════════════════════════════════════ */
function abrirModalBlade(modalId) {
  const el = document.getElementById(modalId);
  if (el) {
    el.style.display = 'flex';
  } else {
    console.warn('Modal #' + modalId + ' no encontrado');
  }
}

/* ═══════════════════════════════════════════════════════════════════
   WRAPPERS: conectan los botones con modalverdetalle.blade.php
   ═══════════════════════════════════════════════════════════════════ */
function verDetalleCliente(id) { abrirDetalle('cliente', id); }
function verDetalleUsuario(id) { abrirDetalle('usuario', id); }
function verDetalleTecnico(id) { abrirDetalle('tecnico',  id); }

/* ═══════════════════════════════════════════════════════════════════
   TOGGLE ESTADO — AJAX real (Activar / Suspender / Dar Baja)
   ═══════════════════════════════════════════════════════════════════ */
async function toggleEstado(tipo, id, nuevoEstado) {
  const url    = `/admin/${tipo}/${id}/toggle`;
  const accion = nuevoEstado ? 'activar' : 'desactivar';

  ModalSystem.show('question', {
    title:       `${nuevoEstado ? 'Activar' : 'Desactivar'} ${tipo}?`,
    text:        '¿Estás seguro? Esta acción se puede revertir.',
    confirmText: 'Sí, continuar',
    cancelText:  'Cancelar',
    onConfirm: async () => {
      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}',
            'Accept':       'application/json'
          },
          body: JSON.stringify({ activo: nuevoEstado ? 1 : 0 })
        });
        const data = await res.json();

        if (data.ok) {
          showNotification('success', '¡Éxito!', `${tipo.charAt(0).toUpperCase() + tipo.slice(1)} ${nuevoEstado ? 'activado' : 'desactivado'} correctamente.`);

          // 🔍 ACTUALIZACIÓN EN VIVO (sin recargar la página)
          const fila = document.querySelector(`tr[data-type="${tipo}"][data-id="${id}"]`);
          if (fila) {
            fila.setAttribute('data-status', nuevoEstado ? 'activo' : 'inactivo');

            // Actualizar badge de estado (columna 7)
            const badge = fila.querySelector('td:nth-child(7)');
            const statusText = nuevoEstado ? 'Activo' : (tipo === 'cliente' ? 'Inactivo' : 'Bloqueado');
            badge.innerHTML = `<span class="${nuevoEstado ? 'badge-active' : 'badge-inactive'}"><span class="bdot"></span>${statusText}</span>`;

            // Actualizar botón de acción (columna 8)
            const btn = fila.querySelector('td:nth-child(8) .btn-action-sm:last-child');
            if (btn) {
              const nuevoLabel = nuevoEstado ? (tipo === 'usuario' ? 'Bloquear' : (tipo === 'tecnico' ? 'Dar baja' : 'Suspender')) : 'Activar';
              btn.className = `btn-action-sm ${nuevoEstado ? 'btn-deactivate' : 'btn-activate'}`;
              btn.setAttribute('onclick', `toggleEstado('${tipo}', ${id}, ${nuevoEstado ? 0 : 1})`);
              btn.innerHTML = `
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18.36 6.64a9 9 0 11-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/>
                </svg>
                ${nuevoLabel}
              `;
            }
          }
        } else {
          showNotification('danger', 'Error', data.message || `No se pudo ${accion} el ${tipo}.`);
        }
      } catch (e) {
        console.error('Toggle Error:', e);
        showNotification('danger', 'Error de conexión', 'No se pudo conectar con el servidor.');
      }
    }
  });
}
</script>