<div class="dashboard-layout">
    @include('components.admin.detalleticket')
    @include('components.admin.navbar-admin')
    @include('components.admin.sidebar-admin')
    @include('components.notificaciones.alertas')
    @include('components.admin.modalcrearusuario')
    @include('components.admin.modalcrearcliente')
    @include('components.admin.modalcreartecnico')
    @include('components.admin.modalverdetalle')

    <main class="main-content">

        {{-- HEADER --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">Panel de Control Maestro</h1>
                <p class="page-subtitle">Gestión centralizada de infraestructura y personal</p>
            </div>
            <div class="header-actions">
                <button class="btn-nuevo bg-blue"   onclick="abrirModalCliente()">+ Cliente</button>
                <button class="btn-nuevo bg-green"  onclick="abrirModalUsuario()">+ Usuario</button>
                <button class="btn-nuevo bg-purple" onclick="abrirModalTecnico()">+ Técnico</button>
            </div>
        </div>

        {{-- STATS --}}
        <div class="stats-container">
            <div class="stat-card active" onclick="filtrarEstado('todos')" id="btn-todos">
                <div class="stat-icon">📊</div>
                <div class="stat-info">
                    <span class="stat-label">Total Global</span>
                    <span class="stat-number">{{ $clientes->count() + $tecnicos->count() + $usuarios_lista->count() }}</span>
                </div>
            </div>
            <div class="stat-card" onclick="filtrarEstado('activo')" id="btn-activos">
                <div class="stat-icon icon-success">✔️</div>
                <div class="stat-info">
                    <span class="stat-label">Activos</span>
                    <span class="stat-number">
                        {{ $clientes->where('activo',1)->count() + $tecnicos->where('activo',1)->count() + $usuarios_lista->where('activo',1)->count() }}
                    </span>
                </div>
            </div>
            <div class="stat-card" onclick="filtrarEstado('inactivo')" id="btn-inactivos">
                <div class="stat-icon icon-danger">❌</div>
                <div class="stat-info">
                    <span class="stat-label">Inactivos</span>
                    <span class="stat-number">
                        {{ $clientes->where('activo',0)->count() + $tecnicos->where('activo',0)->count() + $usuarios_lista->where('activo',0)->count() }}
                    </span>
                </div>
            </div>
        </div>

        {{-- FILTROS TIPO --}}
        <div class="category-filters">
            <button class="filter-chip active" onclick="filtrarTipo('todos',this)">Todos</button>
            <button class="filter-chip" onclick="filtrarTipo('cliente',this)">🏢 Clientes</button>
            <button class="filter-chip" onclick="filtrarTipo('usuario',this)">👤 Usuarios</button>
            <button class="filter-chip" onclick="filtrarTipo('tecnico',this)">🔧 Técnicos</button>
        </div>

        {{-- BÚSQUEDA --}}
        <div class="search-section">
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input type="text" id="inputBusqueda" onkeyup="buscarGlobal()"
                       placeholder="Buscar por nombre, RUC, DNI o código...">
            </div>
            <p class="conteo-text" id="conteo-visible">Mostrando registros...</p>
        </div>

        {{-- GRID --}}
        <div class="user-grid" id="contenedorMaestro">

            {{-- CLIENTES --}}
            @foreach($clientes as $cliente)
            <div class="user-card-wrapper item-entidad item-cliente"
                 data-estado="{{ $cliente->activo ? 'activo' : 'inactivo' }}"
                 data-search="{{ strtolower($cliente->razon_social . ' ' . $cliente->ruc) }}">
                <div class="user-card {{ $cliente->activo ? 'card-active' : 'card-inactive' }}">
                    <div class="status-tag tag-cliente">🏢 Cliente</div>
                    <div class="card-body">
                        <div class="avatar-circle avatar-blue">{{ strtoupper(substr($cliente->razon_social,0,1)) }}</div>
                        <div class="user-info">
                            <h3 title="{{ $cliente->razon_social }}">{{ Str::limit($cliente->razon_social,24) }}</h3>
                            <p class="user-code">RUC: {{ $cliente->ruc }}</p>
                            <div class="detail-row">
                                <span class="label">Correo:</span>
                                <span class="value" title="{{ $cliente->correo }}">{{ Str::limit($cliente->correo,22) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn-view-detail" onclick="abrirDetalle('cliente', {{ $cliente->id_cliente }})">
                            🔍 Detalle
                        </button>
                        <button class="btn-action-status {{ $cliente->activo ? 'btn-deactivate' : 'btn-activate' }}"
                                onclick="cambiarEstado('cliente',{{ $cliente->id_cliente }},{{ $cliente->activo }})">
                            {{ $cliente->activo ? 'Suspender' : 'Activar' }}
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- USUARIOS --}}
            @foreach($usuarios_lista as $u)
            <div class="user-card-wrapper item-entidad item-usuario"
                 data-estado="{{ $u->activo ? 'activo' : 'inactivo' }}"
                 data-search="{{ strtolower($u->nombre . ' ' . $u->apellido_paterno . ' ' . $u->dni) }}">
                <div class="user-card {{ $u->activo ? 'card-active' : 'card-inactive' }}">
                    <div class="status-tag tag-usuario">👤 Usuario</div>
                    <div class="card-body">
                        <div class="avatar-circle avatar-green">{{ strtoupper(substr($u->nombre,0,1)) }}</div>
                        <div class="user-info">
                            <h3 title="{{ $u->nombre }} {{ $u->apellido_paterno }}">{{ Str::limit($u->nombre.' '.$u->apellido_paterno,24) }}</h3>
                            <p class="user-code">{{ $u->codigo_usuario }}</p>
                            <div class="detail-row">
                                <span class="label">Correo:</span>
                                <span class="value" title="{{ $u->correo }}">{{ Str::limit($u->correo,22) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn-view-detail" onclick="abrirDetalle('usuario', {{ $u->id_usuario }})">
                            🔍 Detalle
                        </button>
                        <button class="btn-action-status {{ $u->activo ? 'btn-deactivate' : 'btn-activate' }}"
                                onclick="cambiarEstado('usuario',{{ $u->id_usuario }},{{ $u->activo }})">
                            {{ $u->activo ? 'Bloquear' : 'Activar' }}
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- TÉCNICOS --}}
            @foreach($tecnicos as $t)
            <div class="user-card-wrapper item-entidad item-tecnico"
                 data-estado="{{ $t->activo ? 'activo' : 'inactivo' }}"
                 data-search="{{ strtolower($t->nombre . ' ' . $t->apellido_paterno . ' ' . $t->codigo_tecnico) }}">
                <div class="user-card {{ $t->activo ? 'card-active' : 'card-inactive' }}">
                    <div class="status-tag tag-tecnico">🔧 Técnico</div>
                    <div class="card-body">
                        <div class="avatar-circle avatar-purple">{{ strtoupper(substr($t->nombre,0,1)) }}</div>
                        <div class="user-info">
                            <h3 title="{{ $t->nombre }} {{ $t->apellido_paterno }}">{{ Str::limit($t->nombre.' '.$t->apellido_paterno,24) }}</h3>
                            <p class="user-code">{{ $t->codigo_tecnico }}</p>
                            <div class="detail-row">
                                <span class="label">Correo:</span>
                                <span class="value" title="{{ $t->correo }}">{{ Str::limit($t->correo,22) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn-view-detail" onclick="abrirDetalle('tecnico', {{ $t->id_tecnico }})">
                            🔍 Detalle
                        </button>
                        <button class="btn-action-status {{ $t->activo ? 'btn-deactivate' : 'btn-activate' }}"
                                onclick="cambiarEstado('tecnico',{{ $t->id_tecnico }},{{ $t->activo }})">
                            {{ $t->activo ? 'Baja' : 'Activar' }}
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        {{-- CARGAR MÁS --}}
        <div class="load-more-wrapper" id="load-more-wrapper">
            <button class="btn-load-more" onclick="mostrarMas()">Cargar más registros...</button>
        </div>

    </main>
</div>

<style>
/* ── Layout ─────────────────────────────────────────────────────── */
.dashboard-layout {
    display: flex;
    min-height: 100vh;
    padding-top: 60px;
}

.main-content {
    flex: 1;
    margin-left: 260px;
    padding: 36px 40px;
    background: #f0f4f8;
    min-height: 100vh;
    min-width: 0;
    font-family: 'Poppins', sans-serif;
    transition: margin-left 0.35s cubic-bezier(.4,0,.2,1);
}

body.sb-collapsed .main-content { margin-left: 70px; }

/* ── Header ─────────────────────────────────────────────────────── */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    gap: 16px;
    flex-wrap: wrap;
}
.page-title   { font-size: 22px; font-weight: 700; color: #13294b; margin: 0; }
.page-subtitle{ font-size: 13px; color: #64748b; margin: 4px 0 0; }

.header-actions { display: flex; gap: 10px; flex-wrap: wrap; }
.btn-nuevo {
    color: white; padding: 10px 16px; border-radius: 10px; border: none;
    cursor: pointer; font-size: 13px; font-weight: 600; transition: 0.2s;
    white-space: nowrap;
}
.bg-blue   { background: #3b82f6; }
.bg-green  { background: #10b981; }
.bg-purple { background: #8b5cf6; }
.btn-nuevo:hover { filter: brightness(1.1); transform: translateY(-1px); }

/* ── Stats ──────────────────────────────────────────────────────── */
.stats-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    background: white; padding: 18px 20px; border-radius: 14px;
    display: flex; align-items: center; gap: 14px;
    cursor: pointer; transition: .2s; border: 2px solid transparent;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.stat-card.active  { border-color: #2b6cb0; background: #ebf8ff; }
.stat-card:hover:not(.active) { box-shadow: 0 4px 12px rgba(0,0,0,.08); }
.stat-icon {
    width: 44px; height: 44px; background: #edf2f7; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; font-size: 20px;
    flex-shrink: 0;
}
.icon-success { background: #e6fffa; }
.icon-danger  { background: #fff5f5; }
.stat-number  { font-size: 22px; font-weight: 700; color: #2d3748; display: block; }
.stat-label   { font-size: 11px; color: #718096; text-transform: uppercase; letter-spacing: .5px; }

/* ── Filtros tipo ────────────────────────────────────────────────── */
.category-filters {
    display: flex; gap: 8px; flex-wrap: wrap;
    margin-bottom: 20px;
}
.filter-chip {
    padding: 8px 16px; border-radius: 20px; border: 1px solid #e2e8f0;
    background: white; color: #64748b; font-size: 13px; font-weight: 500;
    cursor: pointer; transition: .2s; white-space: nowrap;
}
.filter-chip:hover  { background: #f8fafc; border-color: #cbd5e1; }
.filter-chip.active {
    background: #13294b; color: white; border-color: #13294b;
    box-shadow: 0 4px 10px rgba(19,41,75,.2);
}

/* ── Búsqueda ────────────────────────────────────────────────────── */
.search-section {
    display: flex; align-items: center; gap: 16px;
    margin-bottom: 24px; flex-wrap: wrap;
}
.search-box {
    background: white; display: flex; align-items: center;
    padding: 11px 18px; border-radius: 12px; border: 1px solid #e2e8f0;
    flex: 1; min-width: 200px; gap: 10px;
}
.search-box input { border: none; width: 100%; outline: none; font-size: 14px; }
.search-icon { font-size: 16px; flex-shrink: 0; }
.conteo-text { font-size: 12px; color: #94a3b8; white-space: nowrap; margin: 0; }

/* ── Grid de cards ───────────────────────────────────────────────── */
.user-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 18px;
}

.user-card-wrapper { display: none; }
.user-card-wrapper.visible { display: block; }
.user-card-wrapper.filtro-hidden { display: none !important; }

.user-card {
    background: white; border-radius: 14px; border: 1px solid #e2e8f0;
    position: relative; overflow: hidden; transition: .25s; height: 100%;
    display: flex; flex-direction: column;
}
.user-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.09); transform: translateY(-4px); }
.card-active  { border-left: 3px solid #10b981; }
.card-inactive{ border-left: 3px solid #e2e8f0; opacity: .85; }

.status-tag {
    position: absolute; top: 10px; left: 10px; font-size: 9px;
    font-weight: 800; padding: 3px 9px; border-radius: 20px; text-transform: uppercase;
}
.tag-cliente { background: #eff6ff; color: #2563eb; }
.tag-usuario { background: #ecfdf5; color: #059669; }
.tag-tecnico { background: #f5f3ff; color: #7c3aed; }

.card-body {
    padding: 38px 18px 16px; text-align: center; flex: 1;
}
.avatar-circle {
    width: 60px; height: 60px; font-size: 22px; font-weight: 700;
    margin: 0 auto 12px; display: flex; align-items: center;
    justify-content: center; border-radius: 50%;
}
.avatar-blue   { background: #ebf4ff; color: #2b6cb0; }
.avatar-green  { background: #e6fffa; color: #047857; }
.avatar-purple { background: #f5f3ff; color: #6d28d9; }

.user-info h3 {
    font-size: 14px; font-weight: 700; margin: 0 0 4px; color: #1a202c;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.user-code {
    font-size: 12px; color: #a0aec0; margin-bottom: 10px; font-family: monospace;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.detail-row {
    display: flex; justify-content: space-between; align-items: center;
    gap: 6px; font-size: 12px; margin-top: 4px;
}
.detail-row .label { font-weight: 600; color: #666; flex-shrink: 0; }
.detail-row .value {
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    max-width: 150px; text-align: right; color: #444;
}

.card-footer {
    padding: 12px 14px; border-top: 1px solid #f1f5f9;
    display: flex; gap: 8px; background: #fafafa;
}
.btn-view-detail, .btn-action-status {
    flex: 1; padding: 7px 6px; border-radius: 8px; font-size: 11px;
    font-weight: 600; border: none; cursor: pointer; text-align: center; text-decoration: none;
    transition: .15s;
}
.btn-view-detail  { background: #edf2f7; color: #4a5568; }
.btn-view-detail:hover { background: #e2e8f0; }
.btn-deactivate   { background: #fff5f5; color: #c53030; }
.btn-deactivate:hover { background: #fed7d7; }
.btn-activate     { background: #f0fff4; color: #2f855a; }
.btn-activate:hover { background: #c6f6d5; }

/* ── Cargar más ──────────────────────────────────────────────────── */
.load-more-wrapper {
    display: flex; justify-content: center; margin-top: 28px;
}
.btn-load-more {
    padding: 11px 28px; border-radius: 10px; border: 2px solid #e2e8f0;
    background: white; color: #475569; font-size: 13px; font-weight: 600;
    cursor: pointer; transition: .2s;
}
.btn-load-more:hover { background: #f8fafc; border-color: #cbd5e1; }

/* ── Responsive ──────────────────────────────────────────────────── */
@media (min-width: 769px) and (max-width: 1024px) {
    .main-content { margin-left: 70px; }
}

@media (max-width: 768px) {
    .main-content {
        margin-left: 0 !important;
        padding: 20px 16px;
        padding-top: 72px;
    }
    body.sb-collapsed .main-content { margin-left: 0 !important; }

    .stats-container { grid-template-columns: 1fr; gap: 10px; }
    .stat-card { padding: 14px 16px; }
    .stat-number { font-size: 18px; }

    .page-header { flex-direction: column; align-items: flex-start; }
    .header-actions { width: 100%; }
    .btn-nuevo { flex: 1; text-align: center; }

    .search-section { flex-direction: column; align-items: stretch; }
    .conteo-text { text-align: center; }

    .user-grid { grid-template-columns: 1fr; }
}

@media (max-width: 480px) {
    .main-content { padding: 14px 12px; padding-top: 68px; }
    .page-title { font-size: 18px; }
    .filter-chip { font-size: 12px; padding: 6px 12px; }
    .stats-container { grid-template-columns: 1fr 1fr; }
    .stat-number { font-size: 16px; }
    .stat-label { font-size: 10px; }
}
</style>

<script>
    const LOTE = 12;
    let mostrados = LOTE;
    let filtroEstadoActual = 'todos';
    let filtroTipoActual = 'todos';

    /**
     * Filtra las tarjetas combinando:
     * 1. Texto de búsqueda (inputBusqueda)
     * 2. Estado (Activo/Inactivo)
     * 3. Tipo de entidad (Cliente/Usuario/Tecnico)
     */
    function cardsVisibles() {
        const q = document.getElementById('inputBusqueda').value.toLowerCase();
        
        return Array.from(document.querySelectorAll('.item-entidad')).filter(card => {
            // Filtro por Estado
            const estadoOk = filtroEstadoActual === 'todos' || card.dataset.estado === filtroEstadoActual;
            
            // Filtro por Tipo (usa las clases item-cliente, item-usuario, item-tecnico)
            const tipoOk = filtroTipoActual === 'todos' || card.classList.contains('item-' + filtroTipoActual);
            
            // Filtro por Búsqueda
            const searchOk = card.dataset.search.includes(q);
            
            return estadoOk && tipoOk && searchOk;
        });
    }

    /**
     * Maneja la visibilidad física en el DOM y la paginación (Lotes)
     */
    function actualizarVista() {
        const cards = cardsVisibles();
        const total = cards.length;

        // Ocultar todas primero
        document.querySelectorAll('.item-entidad').forEach(c => {
            c.classList.remove('visible');
            c.classList.add('filtro-hidden');
        });

        // Mostrar solo las que cumplen filtros y están dentro del lote actual
        cards.slice(0, mostrados).forEach(card => {
            card.classList.remove('filtro-hidden');
            card.classList.add('visible');
        });

        // Actualizar contador
        document.getElementById('conteo-visible').textContent = 
            `Mostrando ${Math.min(mostrados, total)} de ${total} registros encontrados`;

        // Mostrar/Ocultar botón de "Cargar más"
        const btnLoadMore = document.getElementById('load-more-wrapper');
        if (btnLoadMore) {
            btnLoadMore.style.display = (mostrados >= total) ? 'none' : 'flex';
        }
    }

    /**
     * Filtro por Categoría (Chips)
     */
    function filtrarTipo(tipo, btn) {
        filtroTipoActual = tipo;
        mostrados = LOTE; // Reiniciar paginación al filtrar
        
        // UI: Cambiar estado activo de los botones de tipo
        document.querySelectorAll('.filter-chip').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        actualizarVista();
    }

    /**
     * Filtro por Estado (Cards superiores)
     */
    function filtrarEstado(estado) {
        filtroEstadoActual = estado;
        mostrados = LOTE; // Reiniciar paginación al filtrar
        
        // UI: Cambiar estado activo de las cards de stats
        document.querySelectorAll('.stat-card').forEach(b => b.classList.remove('active'));
        const btnId = estado === 'todos' ? 'btn-todos' : (estado === 'activo' ? 'btn-activos' : 'btn-inactivos');
        const btnElement = document.getElementById(btnId);
        if (btnElement) btnElement.classList.add('active');
        
        actualizarVista();
    }

    /**
     * Búsqueda en tiempo real
     */
    function buscarGlobal() {
        mostrados = LOTE;
        actualizarVista();
    }

    function mostrarMas() {
        mostrados += LOTE;
        actualizarVista();
    }

    /**
     * Acción de cambio de estado (AJAX)
     */
    function cambiarEstado(tipo, id, estadoActual) {
        const nuevoEstado = estadoActual ? 0 : 1;
        const textoAccion = nuevoEstado ? 'activar' : 'desactivar/suspender';
        const url = `/admin/cambiar-estado-${tipo}/${id}`; 
        
        if(confirm(`¿Estás seguro de que deseas ${textoAccion} este ${tipo}?`)) {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ estado: nuevoEstado })
            })
            .then(res => res.json())
            .then(data => {
                if(data.ok) {
                    location.reload();
                } else {
                    alert('Error al actualizar el estado: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error de conexión con el servidor.');
            });
        }
    }

    // Inicializar la vista al cargar la página
    document.addEventListener('DOMContentLoaded', actualizarVista);
</script>