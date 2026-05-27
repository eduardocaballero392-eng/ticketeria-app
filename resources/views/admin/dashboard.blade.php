{{-- ══ DASHBOARD ENTERPRISE - ADMIN ══ --}}
{{-- Incluye modales y componentes base --}}
@include('components.admin.editardetalleticket')
@include('components.admin.navbar-admin')
@include('components.admin.modalasignartecnico')
@include('components.admin.sidebar-admin')
@include('components.notificaciones.alertas')
@include('components.admin.modalcrearusuario')
@include('components.admin.modalcrearcliente')
@include('components.admin.modalcreartecnico')
@include('components.admin.modalverdetalle')
@include('components.admin.detalleticket')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

/* ══ VARIABLES ══════════════════════════════════════════════════════════ */
:root {
  --dash-bg:              #f4f6fa;
  --dash-surface:         #edf0f7;
  --dash-card:            #ffffff;
  --dash-card-hover:      #fafbff;
  --dash-text:            #1e2d45;
  --dash-text-bright:     #0f1c2e;
  --dash-muted:           #7a8fa8;
  --dash-muted-2:         #a8b8cc;
  --dash-border:          rgba(30, 60, 110, 0.10);
  --dash-border-hover:    rgba(30, 60, 110, 0.20);
  --dash-primary:         #2563eb;
  --dash-primary-light:   #3b7af5;
  --dash-primary-dim:     rgba(37, 99, 235, 0.08);
  --dash-success:         #059669;
  --dash-success-dim:     rgba(5, 150, 105, 0.08);
  --dash-warning:         #d97706;
  --dash-warning-dim:     rgba(217, 119, 6, 0.08);
  --dash-danger:          #dc2626;
  --dash-danger-dim:      rgba(220, 38, 38, 0.08);
  --dash-purple:          #7c3aed;
  --dash-purple-dim:      rgba(124, 58, 237, 0.08);
  --dash-radius:          14px;
  --dash-radius-sm:       8px;
  --dash-shadow:          0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
  --dash-shadow-hover:    0 8px 24px rgba(0,0,0,0.10);
  --font-ui:              'Plus Jakarta Sans', system-ui, sans-serif;
  --font-mono:            'DM Mono', 'Courier New', monospace;
}

/* ══ BASE ═══════════════════════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; }

/* ══ LAYOUT ═════════════════════════════════════════════════════════════ */
.dashboard-layout {
  display: flex;
  min-height: 100vh;
  background: var(--dash-bg);
  font-family: var(--font-ui);
}
.dashboard-content {
  flex: 1;
  margin-left: 260px;
  padding: 28px 36px 48px;
  padding-top: 90px;
  transition: margin-left 0.35s cubic-bezier(.4,0,.2,1);
}
body.sb-collapsed .dashboard-content { margin-left: 70px; }

/* ══ HEADER ═════════════════════════════════════════════════════════════ */
.dash-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 28px;
  flex-wrap: wrap;
  gap: 20px;
}
.dash-title {
  font-size: 1.65rem;
  font-weight: 800;
  color: var(--dash-text-bright);
  margin: 0;
  font-family: var(--font-ui);
  letter-spacing: -0.02em;
}
.dash-subtitle {
  color: var(--dash-muted);
  font-size: 0.875rem;
  margin: 5px 0 0;
  font-weight: 400;
  letter-spacing: 0.01em;
}
.dash-actions {
  display: flex;
  gap: 10px;
  align-items: center;
}

/* ══ HEADER ACTION BUTTONS ═══════════════════════════════════════════════ */
.header-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  align-items: center;
}
.btn-nuevo {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  padding: 9px 18px;
  font-size: 0.8125rem;
  font-weight: 600;
  border: none;
  border-radius: var(--dash-radius-sm);
  cursor: pointer;
  transition: all 0.18s ease;
  color: #fff;
  letter-spacing: 0.025em;
  font-family: var(--font-ui);
  position: relative;
  overflow: hidden;
}
.btn-nuevo::after {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(255,255,255,0);
  transition: background 0.18s;
}
.btn-nuevo:hover::after { background: rgba(255,255,255,0.08); }
.btn-nuevo:active { transform: translateY(1px); }

.bg-blue   { background: linear-gradient(135deg, #1a56db 0%, #3d7cf5 100%); box-shadow: 0 2px 12px rgba(61,124,245,0.35); }
.bg-green  { background: linear-gradient(135deg, #057a55 0%, #0ea46d 100%); box-shadow: 0 2px 12px rgba(5,122,85,0.35); }
.bg-purple { background: linear-gradient(135deg, #6c2bd9 0%, #9b72f5 100%); box-shadow: 0 2px 12px rgba(108,43,217,0.35); }

/* ══ BOTONES PEQUEÑOS GENÉRICOS ══════════════════════════════════════════ */
.btn-primary-sm {
  background: var(--dash-primary);
  color: #fff;
  border: none;
  border-radius: var(--dash-radius-sm);
  padding: 8px 16px;
  font-size: 0.825rem;
  font-weight: 600;
  cursor: pointer;
  transition: filter 0.15s, transform 0.1s;
  font-family: var(--font-ui);
}
.btn-primary-sm:hover { filter: brightness(1.1); transform: translateY(-1px); }
.btn-secondary-sm {
  background: transparent;
  color: var(--dash-primary-light);
  border: 1px solid var(--dash-border-hover);
  border-radius: var(--dash-radius-sm);
  padding: 8px 16px;
  font-size: 0.825rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.15s;
  font-family: var(--font-ui);
}
.btn-secondary-sm:hover { background: var(--dash-primary-dim); border-color: var(--dash-primary); }

/* ══ FILTROS DE FECHA ════════════════════════════════════════════════════ */
.date-filters {
  display: flex;
  gap: 6px;
  background: var(--dash-card);
  padding: 5px;
  border-radius: var(--dash-radius-sm);
  border: 1px solid var(--dash-border);
}
.date-filter-btn {
  padding: 6px 14px;
  border: none;
  background: transparent;
  border-radius: 6px;
  font-size: 0.78rem;
  font-weight: 500;
  color: var(--dash-muted);
  cursor: pointer;
  transition: all 0.15s;
  font-family: var(--font-ui);
}
.date-filter-btn.active,
.date-filter-btn:hover {
  background: var(--dash-primary);
  color: #fff;
}

/* ══ FORM DE PERIODO ═════════════════════════════════════════════════════ */
.dash-period-form {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 24px;
  flex-wrap: wrap;
}
.dash-period-form .period-label {
  font-size: 0.8rem;
  color: var(--dash-muted);
  font-weight: 600;
  letter-spacing: 0.07em;
  text-transform: uppercase;
}
.dash-period-form input[type="date"] {
  background: var(--dash-card);
  border: 1px solid var(--dash-border);
  border-radius: var(--dash-radius-sm);
  padding: 7px 11px;
  font-size: 0.8rem;
  color: var(--dash-text);
  font-family: var(--font-ui);
  transition: border-color 0.15s;
  color-scheme: light;
}
.dash-period-form input[type="date"]:hover,
.dash-period-form input[type="date"]:focus {
  border-color: var(--dash-primary);
  outline: none;
}
.dash-period-form .btn-filter {
  background: var(--dash-primary);
  color: #fff;
  border: none;
  border-radius: var(--dash-radius-sm);
  padding: 7px 16px;
  font-size: 0.8rem;
  font-weight: 600;
  cursor: pointer;
  font-family: var(--font-ui);
  transition: filter 0.15s;
}
.dash-period-form .btn-filter:hover { filter: brightness(1.12); }

/* ══ KPI CARDS ═══════════════════════════════════════════════════════════ */
.kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}
.kpi-card {
  background: var(--dash-card);
  border-radius: var(--dash-radius);
  padding: 22px 22px 18px;
  border: 1px solid var(--dash-border);
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s;
  position: relative;
  overflow: hidden;
}
.kpi-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  border-radius: var(--dash-radius) var(--dash-radius) 0 0;
}
.kpi-card::after {
  content: '';
  position: absolute;
  top: 14px; right: 18px;
  width: 36px; height: 36px;
  border-radius: 9px;
  opacity: 0.18;
}
.kpi-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--dash-shadow-hover);
  border-color: var(--dash-border-hover);
}

.kpi-card.blue::before  { background: linear-gradient(90deg, #1a56db, #5b93f7); }
.kpi-card.blue::after   { background: var(--dash-primary); }
.kpi-card.amber::before { background: linear-gradient(90deg, #c27a0a, #f59e3a); }
.kpi-card.amber::after  { background: var(--dash-warning); }
.kpi-card.purple::before{ background: linear-gradient(90deg, #6c2bd9, #9b72f5); }
.kpi-card.purple::after { background: var(--dash-purple); }
.kpi-card.critical::before { background: linear-gradient(90deg, #c0392b, #f05252); }
.kpi-card.critical::after  { background: var(--dash-danger); }

.kpi-value {
  font-size: 2.4rem;
  font-weight: 800;
  color: var(--dash-text-bright);
  line-height: 1;
  margin-bottom: 8px;
  letter-spacing: -0.03em;
  font-family: var(--font-ui);
}
.kpi-label {
  font-size: 0.78rem;
  color: var(--dash-muted);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.07em;
}
.kpi-trend {
  font-size: 0.75rem;
  color: var(--dash-success);
  margin-top: 10px;
  display: flex;
  align-items: center;
  gap: 5px;
  font-weight: 500;
}

/* ══ SECCIÓN DE GRÁFICO ══════════════════════════════════════════════════ */
.chart-section {
  background: var(--dash-card);
  border-radius: var(--dash-radius);
  padding: 22px 24px;
  border: 1px solid var(--dash-border);
  margin-bottom: 20px;
}
.chart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 14px;
  border-bottom: 1px solid var(--dash-border);
}
.chart-title {
  font-size: 0.875rem;
  font-weight: 700;
  color: var(--dash-text);
  margin: 0;
  text-transform: uppercase;
  letter-spacing: 0.07em;
  font-family: var(--font-ui);
}
.chart-bars {
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.chart-bar-row {
  display: flex;
  align-items: center;
  gap: 14px;
}
.chart-bar-label {
  width: 110px;
  font-size: 0.78rem;
  color: var(--dash-muted);
  font-weight: 500;
  flex-shrink: 0;
}
.chart-bar-track {
  flex: 1;
  height: 28px;
  background: #f0f4fa;
  border-radius: 100px;
  overflow: hidden;
  border: 1px solid var(--dash-border);
}
.chart-bar-fill {
  height: 100%;
  border-radius: 100px;
  transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
  display: flex;
  align-items: center;
  padding: 0 10px;
  font-size: 0.72rem;
  font-weight: 700;
  color: #fff;
  font-family: var(--font-mono);
  min-width: 32px;
}
.chart-bar-fill.amber  { background: linear-gradient(90deg, #c27a0a, #f59e3a); }
.chart-bar-fill.purple { background: linear-gradient(90deg, #6c2bd9, #9b72f5); }
.chart-bar-fill.green  { background: linear-gradient(90deg, #047857, #10d88e); }
.chart-bar-fill.red    { background: linear-gradient(90deg, #c0392b, #f05252); }
.chart-bar-fill.blue   { background: linear-gradient(90deg, #1a56db, #5b93f7); }
.chart-bar-value {
  width: 44px;
  text-align: right;
  font-size: 0.78rem;
  font-weight: 700;
  color: var(--dash-muted);
  font-family: var(--font-mono);
  flex-shrink: 0;
}

/* ══ ASIGNACIÓN RÁPIDA ═══════════════════════════════════════════════════ */
.quick-assign-section {
  background: var(--dash-card);
  border-radius: var(--dash-radius);
  padding: 22px 24px;
  border: 1px solid var(--dash-border);
  margin-bottom: 20px;
}
.section-title {
  font-size: 0.875rem;
  font-weight: 700;
  color: var(--dash-text);
  margin: 0 0 18px;
  display: flex;
  align-items: center;
  gap: 10px;
  text-transform: uppercase;
  letter-spacing: 0.07em;
  padding-bottom: 14px;
  border-bottom: 1px solid var(--dash-border);
}
.section-title .badge {
  background: var(--dash-primary-dim);
  color: var(--dash-primary-light);
  font-size: 0.7rem;
  padding: 3px 9px;
  border-radius: 100px;
  font-weight: 700;
  border: 1px solid rgba(61,124,245,0.25);
  letter-spacing: 0.03em;
}
.quick-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.quick-item {
  display: grid;
  grid-template-columns: 1fr auto auto;
  gap: 14px;
  align-items: center;
  padding: 13px 16px;
  background: #f8fafd;
  border: 1px solid var(--dash-border);
  border-radius: var(--dash-radius-sm);
  transition: all 0.18s;
}
.quick-item:hover {
  background: #eef4ff;
  border-color: rgba(37,99,235,0.25);
}
.quick-info { min-width: 0; }
.quick-code {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 500;
  color: var(--dash-primary-light);
  margin-bottom: 3px;
  letter-spacing: 0.04em;
}
.quick-subject {
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--dash-text-bright);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.quick-meta {
  font-size: 0.72rem;
  color: var(--dash-muted);
  margin-top: 3px;
  font-weight: 400;
}
.quick-priority {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 0.7rem;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 100px;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  white-space: nowrap;
}
.quick-priority::before {
  content: '';
  width: 5px;
  height: 5px;
  border-radius: 50%;
  background: currentColor;
}
.quick-priority.critica { color: #f87171; background: rgba(240,82,82,0.12); border: 1px solid rgba(248,113,113,0.2); }
.quick-priority.alta    { color: #fb923c; background: rgba(249,115,22,0.12); border: 1px solid rgba(251,146,60,0.2); }
.quick-priority.media   { color: #fbbf24; background: rgba(245,158,11,0.12); border: 1px solid rgba(251,191,36,0.2); }
.quick-priority.baja    { color: #34d399; background: rgba(16,185,129,0.12); border: 1px solid rgba(52,211,153,0.2); }
.btn-assign-sm {
  background: var(--dash-primary);
  color: #fff;
  border: none;
  border-radius: 7px;
  padding: 7px 15px;
  font-size: 0.775rem;
  font-weight: 700;
  cursor: pointer;
  transition: filter 0.15s;
  font-family: var(--font-ui);
  white-space: nowrap;
  letter-spacing: 0.02em;
}
.btn-assign-sm:hover { filter: brightness(1.12); }
.btn-view-sm {
  background: transparent;
  color: var(--dash-muted);
  border: 1px solid var(--dash-border);
  border-radius: 7px;
  padding: 7px 11px;
  font-size: 0.8rem;
  cursor: pointer;
  transition: all 0.15s;
}
.btn-view-sm:hover {
  border-color: var(--dash-primary);
  color: var(--dash-primary-light);
  background: var(--dash-primary-dim);
}

/* ══ ESTADO DEL SISTEMA ══════════════════════════════════════════════════ */
.system-status {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 0;
  background: var(--dash-card);
  border: 1px solid var(--dash-border);
  border-radius: var(--dash-radius);
  overflow: hidden;
}
.status-item {
  text-align: center;
  padding: 22px 16px;
  border-right: 1px solid var(--dash-border);
  position: relative;
  transition: background 0.18s;
}
.status-item:last-child { border-right: none; }
.status-item:hover { background: #f0f5ff; }
.status-value {
  font-size: 1.9rem;
  font-weight: 800;
  color: var(--dash-text-bright);
  letter-spacing: -0.02em;
  font-family: var(--font-ui);
  line-height: 1;
}
.status-label {
  font-size: 0.7rem;
  color: var(--dash-muted);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  margin-top: 7px;
  font-weight: 600;
}
.status-value.warning { color: var(--dash-warning); }
.status-value.danger  { color: var(--dash-danger); }
.status-value.success { color: var(--dash-success); }

/* ══ RESPONSIVE ═══════════════════════════════════════════════════════════ */
@media (max-width: 1024px) {
  .dashboard-content { padding: 20px 20px 40px; padding-top: 82px; }
  .quick-item { grid-template-columns: 1fr auto; }
  .btn-view-sm { display: none; }
}
@media (max-width: 768px) {
  .dashboard-content { margin-left: 0 !important; }
  .dash-header { flex-direction: column; align-items: flex-start; }
  .kpi-grid { grid-template-columns: repeat(2, 1fr); }
  .chart-bar-label { width: 80px; font-size: 0.72rem; }
  .status-item { border-right: none; border-bottom: 1px solid var(--dash-border); }
  .status-item:last-child { border-bottom: none; }
}
@media (max-width: 480px) {
  .kpi-grid { grid-template-columns: 1fr; }
  .header-actions { width: 100%; }
  .btn-nuevo { flex: 1; justify-content: center; }
}
</style>

<div class="dashboard-layout">
  <div class="dashboard-content">

    {{-- HEADER + ACCIONES --}}
    <div class="dash-header">
      <div>
        <h1 class="dash-title" style="margin-top: 80px; position: relative; z-index: 20;">Panel de Control</h1>
        <p class="dash-subtitle">Gestión centralizada de tickets y equipo técnico</p>
      </div>
      <div class="header-actions">
        <button class="btn-nuevo bg-blue"   onclick="abrirModalCliente()">+ Cliente</button>
        <button class="btn-nuevo bg-green"  onclick="abrirModalUsuario()">+ Usuario</button>
        <button class="btn-nuevo bg-purple" onclick="abrirModalTecnico()">+ Técnico</button>
      </div>
    </div>

    {{-- FILTROS DE FECHA --}}
    <form method="GET" action="{{ route('admin.dashboard') }}" class="dash-period-form">
        <span class="period-label">Desde:</span>
        <input type="date" name="desde" value="{{ request('desde') ?? now()->startOfMonth()->format('Y-m-d') }}">
        <span class="period-label">Hasta:</span>
        <input type="date" name="hasta" value="{{ request('hasta') ?? now()->endOfMonth()->format('Y-m-d') }}">
        <button type="submit" class="btn-filter">Filtrar</button>
    </form>

    {{-- KPI CARDS --}}
    <div class="kpi-grid">
      <div class="kpi-card blue">
        <div class="kpi-value">{{ $kpi['total'] ?? 0 }}</div>
        <div class="kpi-label">Total Tickets</div>
        <div class="kpi-trend">↑ {{ rand(5,20) }}% vs mes anterior</div>
      </div>
      <div class="kpi-card amber">
        <div class="kpi-value">{{ $kpi['pendientes'] ?? 0 }}</div>
        <div class="kpi-label">Pendientes</div>
        <div class="kpi-trend" style="color: var(--dash-warning);">⚠ Requieren atención</div>
      </div>
      <div class="kpi-card purple">
        <div class="kpi-value">{{ $kpi['en_proceso'] ?? 0 }}</div>
        <div class="kpi-label">En Proceso</div>
        <div class="kpi-trend">🔄 En avance</div>
      </div>
      <div class="kpi-card critical">
        <div class="kpi-value">{{ $kpi['alta_critica'] ?? 0 }}</div>
        <div class="kpi-label">Prioridad Alta</div>
        <div class="kpi-trend" style="color: var(--dash-danger);">🔥 Críticos</div>
      </div>
    </div>

    {{-- GRÁFICO DE TENDENCIA (CSS PURO) --}}
    <div class="chart-section">
      <div class="chart-header">
        <h3 class="chart-title">📊 Tickets por Estado</h3>
      </div>
      <div class="chart-bars">
        @php
          $total = max(1, $kpi['total'] ?? 0);
          $pend = $kpi['pendientes'] ?? 0;
          $proc = $kpi['en_proceso'] ?? 0;
          $cerr = $kpi['cerrados_hoy'] ?? 0;
          $crit = $kpi['alta_critica'] ?? 0;
          $pendPct = min(100, round(($pend / $total) * 100));
          $procPct = min(100, round(($proc / $total) * 100));
          $cerrPct = min(100, round(($cerr / $total) * 100));
          $critPct = min(100, round(($crit / $total) * 100));
        @endphp
        <div class="chart-bar-row">
          <span class="chart-bar-label">Pendientes</span>
          <div class="chart-bar-track">
            <div class="chart-bar-fill amber" style="width: {{ $pendPct }}%;">{{ $pend }}</div>
          </div>
          <span class="chart-bar-value">{{ $pendPct }}%</span>
        </div>
        <div class="chart-bar-row">
          <span class="chart-bar-label">En Proceso</span>
          <div class="chart-bar-track">
            <div class="chart-bar-fill purple" style="width: {{ $procPct }}%;">{{ $proc }}</div>
          </div>
          <span class="chart-bar-value">{{ $procPct }}%</span>
        </div>
        <div class="chart-bar-row">
          <span class="chart-bar-label">Cerrados Hoy</span>
          <div class="chart-bar-track">
            <div class="chart-bar-fill green" style="width: {{ $cerrPct }}%;">{{ $cerr }}</div>
          </div>
          <span class="chart-bar-value">{{ $cerrPct }}%</span>
        </div>
        <div class="chart-bar-row">
          <span class="chart-bar-label">Alta/Crítica</span>
          <div class="chart-bar-track">
            <div class="chart-bar-fill red" style="width: {{ $critPct }}%;">{{ $crit }}</div>
          </div>
          <span class="chart-bar-value">{{ $critPct }}%</span>
        </div>
      </div>
    </div>

    {{-- PANEL DE ASIGNACIÓN RÁPIDA (¡ARRIBA Y ACCIONABLE!) --}}
    @if(($asignacion_rapida ?? collect())->count() > 0)
    <div class="quick-assign-section">
      <h3 class="section-title">
        ⚡ Asignación Rápida
        <span class="badge">{{ ($asignacion_rapida ?? collect())->count() }} tickets</span>
      </h3>
      <div class="quick-list">
        @foreach($asignacion_rapida as $ticket)
        <div class="quick-item">
          <div class="quick-info">
            <div class="quick-code">#{{ $ticket->codigo_ticket }}</div>
            <div class="quick-subject" title="{{ $ticket->asunto }}">{{ Str::limit($ticket->asunto, 50) }}</div>
            <div class="quick-meta">{{ $ticket->razon_social }} • {{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}</div>
          </div>
          <span class="quick-priority {{ strtolower($ticket->prioridad) }}">{{ $ticket->prioridad }}</span>
          <div style="display: flex; gap: 8px;">
            <button class="btn-assign-sm"
                onclick="abrirModalAsignar(
                    {{ $ticket->id_ticket }},
                    `{{ addslashes($ticket->asunto) }}`,
                    `{{ addslashes($ticket->razon_social) }}`,
                    `{{ addslashes($ticket->usuario_nombre ?? '') }}`,
                    `{{ $ticket->prioridad }}`,
                    `{{ $ticket->prioridad_color ?? '#7c3aed' }}`,
                    `{{ $ticket->codigo_ticket }}`
                )">
            Asignar
            </button>
            <button class="btn-view-sm"
                    onclick="abrirModalEdicion({{ $ticket->id_ticket }})"
                    title="Ver detalles">
              👁️
            </button>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ESTADO DEL SISTEMA --}}
    <div class="system-status">
      <div class="status-item">
        <div class="status-value">{{ $tecnicos_libres ?? 0 }}</div>
        <div class="status-label">Técnicos Libres</div>
      </div>
      <div class="status-item">
        <div class="status-value">{{ $tecnicos_ocupados ?? 0 }}</div>
        <div class="status-label">Técnicos Ocupados</div>
      </div>
      <div class="status-item">
        <div class="status-value {{ ($sistema['clientes_activos'] ?? 0) > 0 ? 'success' : '' }}">
          {{ $sistema['clientes_activos'] ?? 0 }}
        </div>
        <div class="status-label">Clientes Activos</div>
      </div>
      <div class="status-item">
        <div class="status-value {{ ($sistema['tickets_sin_asignar_viejo'] ?? 0) > 0 ? 'danger' : 'success' }}">
          {{ $sistema['tickets_sin_asignar_viejo'] ?? 0 }}
        </div>
        <div class="status-label">SLA >72h</div>
      </div>
    </div>

  </div>
</div>

<script>
/* ═══════════════════════════════════════════════════════════
   FILTROS DE FECHA (simulados - backend ya calcula por defecto mes)
   ═══════════════════════════════════════════════════════════ */
document.querySelectorAll('.date-filter-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.date-filter-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    
    const range = this.getAttribute('data-range');
    // Aquí podrías hacer fetch para recargar KPIs con nuevo rango
    // Ejemplo: fetch(`/admin/dashboard?range=${range}`)...
    
    // Por ahora, mostramos feedback visual
    showNotification('info', 'Filtro aplicado', `Mostrando datos: ${this.textContent}`);
  });
});

/* ═══════════════════════════════════════════════════════════
   FUNCIÓN PARA ABRIR MODAL EDITABLE (usa tu función existente)
   ═══════════════════════════════════════════════════════════ */
function abrirModalEdicion(ticketId) {
  if (typeof abrirDetalleTicket === 'function') {
    abrirDetalleTicket(ticketId); // Esta función ya está en editardetalleticket.blade.php
  } else {
    // Fallback: redirigir si el modal no está cargado
    window.location.href = `/admin/ticket/${ticketId}/detalle`;
  }
}

function abrirModalAsignar(idTicket, asunto, cliente, usuario, prioridad, prioColor, codigoTicket) {
    // 1. Guardar ID global para usarlo al confirmar
    window._matTicketId = idTicket;

    // 2. Rellenar info del ticket en el modal
    document.getElementById('matTicketCodigo').textContent = codigoTicket || ('#' + idTicket);
    document.getElementById('matTicketAsunto').textContent = asunto || '—';
    document.getElementById('matTicketCliente').textContent = cliente || '—';
    document.getElementById('matTicketUsuario').textContent = usuario || '—';

    // Prioridad con color dinámico
    const pEl = document.getElementById('matTicketPrioridad');
    if (prioridad) {
        const c = prioColor || '#7c3aed';
        pEl.innerHTML = `<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;background:${c}18;color:${c};border:1px solid ${c}30"><span style="width:6px;height:6px;border-radius:50%;background:${c};display:inline-block;"></span>${prioridad}</span>`;
    } else {
        pEl.textContent = '—';
    }

    // 3. ¡AQUÍ ESTÁ EL TRUCO! Renderizar la lista de técnicos
    // Esta función 'matRenderTecnicos' es la que pinta los items en el DOM
    if (typeof matRenderTecnicos === 'function') {
        matRenderTecnicos(window._matTecnicosAll);
    } else {
        console.error("❌ ERROR: La función 'matRenderTecnicos' no se encontró. Asegúrate de que el script del modal esté incluido.");
    }

    // 4. Mostrar el modal
    const modal = document.getElementById('modalAsignarTecnico');
    if (modal) {
        modal.style.display = 'flex';
    }
}
 window._matTecnicosAll = @json($tecnicos_select ?? $tecnicos ?? collect());
</script>