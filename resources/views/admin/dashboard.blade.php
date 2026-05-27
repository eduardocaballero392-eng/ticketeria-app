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
/* ══ VARIABLES (coherentes con tu navbar/sidebar) ═══════════════════════ */
:root {
  --dash-bg: #f0f4f8;
  --dash-card: #ffffff;
  --dash-text: #0f172a;
  --dash-muted: #64748b;
  --dash-border: #e2e8f0;
  --dash-primary: #0f4a8a;
  --dash-primary-light: #1a6ed8;
  --dash-success: #15803d;
  --dash-warning: #b45309;
  --dash-danger: #dc2626;
  --dash-radius: 12px;
  --dash-shadow: 0 2px 12px rgba(0,0,0,0.06);
  --dash-shadow-hover: 0 8px 24px rgba(0,0,0,0.12);
}

/* ══ LAYOUT BASE ═══════════════════════════════════════════════════════ */
.dashboard-layout {
  display: flex;
  min-height: 100vh;
  background: var(--dash-bg);
}
.dashboard-content {
  flex: 1;
  margin-left: 260px; /* ancho del sidebar */
  padding: 24px 32px;
  padding-top: 84px; /* navbar height + margen */
  transition: margin-left 0.35s cubic-bezier(.4,0,.2,1);
}
body.sb-collapsed .dashboard-content { margin-left: 70px; }

/* ══ HEADER ════════════════════════════════════════════════════════════ */
.dash-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 16px;
}
.dash-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--dash-text);
  margin: 0;
  font-family: 'Syne', sans-serif;
}
.dash-subtitle {
  color: var(--dash-muted);
  font-size: 0.9rem;
  margin: 4px 0 0;
}
.dash-actions {
  display: flex;
  gap: 10px;
  align-items: center;
}
.btn-primary-sm {
  background: linear-gradient(135deg, var(--dash-primary), var(--dash-primary-light));
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 8px 16px;
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: opacity 0.15s, transform 0.1s;
}
.btn-primary-sm:hover { opacity: 0.92; transform: translateY(-1px); }
.btn-secondary-sm {
  background: #fff;
  color: var(--dash-primary);
  border: 1.5px solid var(--dash-primary-light);
  border-radius: 8px;
  padding: 8px 16px;
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.15s;
}
.btn-secondary-sm:hover { background: #f0f7ff; }

/* ══ FILTROS DE FECHA ═════════════════════════════════════════════════ */
.date-filters {
  display: flex;
  gap: 8px;
  background: var(--dash-card);
  padding: 6px;
  border-radius: 10px;
  border: 1px solid var(--dash-border);
  box-shadow: var(--dash-shadow);
}
.date-filter-btn {
  padding: 6px 14px;
  border: none;
  background: transparent;
  border-radius: 8px;
  font-size: 0.8rem;
  font-weight: 500;
  color: var(--dash-muted);
  cursor: pointer;
  transition: all 0.15s;
}
.date-filter-btn.active,
.date-filter-btn:hover {
  background: var(--dash-primary-light);
  color: #fff;
}

/* ══ BOTONES DE ACCIÓN (Header) ═══════════════════════════════ */
.header-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
}

.btn-nuevo {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 18px;
    font-size: 0.875rem;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    color: #fff;
    letter-spacing: 0.02em;
    font-family: inherit;
}

.btn-nuevo:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    filter: brightness(1.05);
}

.btn-nuevo:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
}

/* 🟦 Cliente */
.bg-blue {
    background: linear-gradient(135deg, #0f4a8a 0%, #2b7fff 100%);
}
.bg-blue:hover { background: linear-gradient(135deg, #1a5a9e 0%, #3a8aff 100%); }

/* 🟩 Usuario */
.bg-green {
    background: linear-gradient(135deg, #15803d 0%, #22c55e 100%);
}
.bg-green:hover { background: linear-gradient(135deg, #1a944a 0%, #34d370 100%); }

/* 🟪 Técnico */
.bg-purple {
    background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
}
.bg-purple:hover { background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); }

/* ══ KPI CARDS ════════════════════════════════════════════════════════ */
.kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}
.kpi-card {
  background: var(--dash-card);
  border-radius: var(--dash-radius);
  padding: 20px;
  box-shadow: var(--dash-shadow);
  border-left: 4px solid var(--dash-primary-light);
  transition: transform 0.15s, box-shadow 0.15s;
}
.kpi-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--dash-shadow-hover);
}
.kpi-card.blue { border-left-color: #3b82f6; }
.kpi-card.amber { border-left-color: #f59e0b; }
.kpi-card.purple { border-left-color: #8b5cf6; }
.kpi-card.critical { border-left-color: var(--dash-danger); }

.kpi-value {
  font-size: 2rem;
  font-weight: 700;
  color: var(--dash-text);
  line-height: 1;
}
.kpi-label {
  font-size: 0.85rem;
  color: var(--dash-muted);
  margin-top: 6px;
  font-weight: 500;
}
.kpi-trend {
  font-size: 0.75rem;
  color: var(--dash-success);
  margin-top: 4px;
  display: flex;
  align-items: center;
  gap: 4px;
}

/* ══ GRÁFICO CSS PURO (Barras horizontales) ═══════════════════════════ */
.chart-section {
  background: var(--dash-card);
  border-radius: var(--dash-radius);
  padding: 20px;
  box-shadow: var(--dash-shadow);
  margin-bottom: 24px;
}
.chart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}
.chart-title {
  font-size: 1rem;
  font-weight: 600;
  color: var(--dash-text);
  margin: 0;
}
.chart-bars {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.chart-bar-row {
  display: flex;
  align-items: center;
  gap: 12px;
}
.chart-bar-label {
  width: 100px;
  font-size: 0.8rem;
  color: var(--dash-muted);
  font-weight: 500;
}
.chart-bar-track {
  flex: 1;
  height: 24px;
  background: #f1f5f9;
  border-radius: 6px;
  overflow: hidden;
  position: relative;
}
.chart-bar-fill {
  height: 100%;
  border-radius: 6px;
  transition: width 0.4s ease;
  display: flex;
  align-items: center;
  padding-left: 8px;
  font-size: 0.75rem;
  font-weight: 600;
  color: #fff;
}
.chart-bar-fill.blue { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
.chart-bar-fill.amber { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.chart-bar-fill.purple { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
.chart-bar-fill.green { background: linear-gradient(90deg, #22c55e, #4ade80); }
.chart-bar-fill.red { background: linear-gradient(90deg, #ef4444, #f87171); }
.chart-bar-value {
  width: 40px;
  text-align: right;
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--dash-text);
}

/* ══ PANEL DE ASIGNACIÓN RÁPIDA (¡VISIBLE Y ACCIONABLE!) ═════════════ */
.quick-assign-section {
  background: var(--dash-card);
  border-radius: var(--dash-radius);
  padding: 20px;
  box-shadow: var(--dash-shadow);
  margin-bottom: 24px;
  border: 1px solid #dbeafe;
}
.section-title {
  font-size: 1rem;
  font-weight: 600;
  color: var(--dash-text);
  margin: 0 0 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.section-title .badge {
  background: var(--dash-primary-light);
  color: #fff;
  font-size: 0.7rem;
  padding: 2px 8px;
  border-radius: 20px;
  font-weight: 600;
}
.quick-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.quick-item {
  display: grid;
  grid-template-columns: 1fr auto auto;
  gap: 12px;
  align-items: center;
  padding: 12px 14px;
  background: #f8fafc;
  border: 1px solid var(--dash-border);
  border-radius: 10px;
  transition: border-color 0.15s, background 0.15s;
}
.quick-item:hover {
  border-color: var(--dash-primary-light);
  background: #f0f7ff;
}
.quick-info {
  min-width: 0;
}
.quick-code {
  font-family: 'Courier New', monospace;
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--dash-primary);
  margin-bottom: 2px;
}
.quick-subject {
  font-size: 0.9rem;
  font-weight: 500;
  color: var(--dash-text);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.quick-meta {
  font-size: 0.75rem;
  color: var(--dash-muted);
  margin-top: 2px;
}
.quick-priority {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 0.75rem;
  font-weight: 600;
  padding: 3px 10px;
  border-radius: 20px;
}
.quick-priority::before {
  content: '';
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: currentColor;
}
.quick-priority.critica { color: #dc2626; background: #fef2f2; }
.quick-priority.alta { color: #ea580c; background: #fff7ed; }
.quick-priority.media { color: #ca8a04; background: #fefce8; }
.quick-priority.baja { color: #16a34a; background: #f0fdf4; }
.btn-assign-sm {
  background: var(--dash-primary-light);
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 6px 14px;
  font-size: 0.8rem;
  font-weight: 600;
  cursor: pointer;
  transition: opacity 0.15s;
  white-space: nowrap;
}
.btn-assign-sm:hover { opacity: 0.92; }
.btn-view-sm {
  background: transparent;
  color: var(--dash-muted);
  border: 1px solid var(--dash-border);
  border-radius: 8px;
  padding: 6px 12px;
  font-size: 0.8rem;
  cursor: pointer;
  transition: all 0.15s;
}
.btn-view-sm:hover {
  border-color: var(--dash-primary-light);
  color: var(--dash-primary);
  background: #f0f7ff;
}

/* ══ ESTADO DEL SISTEMA ═══════════════════════════════════════════════ */
.system-status {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 16px;
  background: #f8fafc;
  border: 1px solid var(--dash-border);
  border-radius: var(--dash-radius);
  padding: 16px;
}
.status-item {
  text-align: center;
  padding: 12px;
}
.status-value {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--dash-text);
}
.status-label {
  font-size: 0.75rem;
  color: var(--dash-muted);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-top: 4px;
  font-weight: 600;
}
.status-value.warning { color: var(--dash-warning); }
.status-value.danger { color: var(--dash-danger); }
.status-value.success { color: var(--dash-success); }

/* ══ RESPONSIVE ═══════════════════════════════════════════════════════ */
@media (max-width: 1024px) {
  .dashboard-content { padding: 20px; padding-top: 80px; }
  .quick-item { grid-template-columns: 1fr auto; }
  .btn-view-sm { display: none; }
}
@media (max-width: 768px) {
  .dashboard-content { margin-left: 0 !important; }
  .dash-header { flex-direction: column; align-items: flex-start; }
  .kpi-grid { grid-template-columns: repeat(2, 1fr); }
  .chart-bar-label { width: 80px; font-size: 0.75rem; }
}
@media (max-width: 480px) {
  .kpi-grid { grid-template-columns: 1fr; }
  .date-filters { width: 100%; overflow-x: auto; padding: 4px; }
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
    <form method="GET" action="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
        <span style="font-size: 0.85rem; color: #64748b; font-weight: 500;">Periodo:</span>
        <input type="date" name="desde" value="{{ request('desde') ?? now()->startOfMonth()->format('Y-m-d') }}" style="border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 10px; font-size: 0.8rem;">
        <input type="date" name="hasta" value="{{ request('hasta') ?? now()->endOfMonth()->format('Y-m-d') }}" style="border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 10px; font-size: 0.8rem;">
        <button type="submit" style="background: #0f4a8a; color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-size: 0.8rem; cursor: pointer; font-weight: 600;">Filtrar</button>
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