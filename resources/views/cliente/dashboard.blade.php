@include('components.cliente.sidebar-cliente')
@include('components.cliente.nuevousuario')
@include('components.notificaciones.alertas')



<div class="main-content">
    <div class="container-fluid">

        <!-- HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Gestión de Personal</h1>
                <p class="page-subtitle">{{ $usuarios->count() }} usuarios registrados en total</p>
            </div>
            <button class="btn-nuevo" onclick="openModal()">+ Nuevo Usuario</button>
        </div>

        <!-- STATS / FILTROS -->
        <div class="stats-container">
            <div class="stat-card active" onclick="filtrarEstado('todos')" id="btn-todos">
                <div class="stat-icon">👥</div>
                <div class="stat-info">
                    <span class="stat-label">Total</span>
                    <span class="stat-number">{{ $usuarios->count() }}</span>
                </div>
            </div>
            <div class="stat-card" onclick="filtrarEstado('activo')" id="btn-activos">
                <div class="stat-icon icon-success">✔️</div>
                <div class="stat-info">
                    <span class="stat-label">Activos</span>
                    <span class="stat-number">{{ $usuarios->where('activo', 1)->count() }}</span>
                </div>
            </div>
            <div class="stat-card" onclick="filtrarEstado('inactivo')" id="btn-inactivos">
                <div class="stat-icon icon-danger">❌</div>
                <div class="stat-info">
                    <span class="stat-label">Inactivos</span>
                    <span class="stat-number">{{ $usuarios->where('activo', 0)->count() }}</span>
                </div>
            </div>
        </div>

        <!-- BÚSQUEDA + CONTEO -->
        <div class="search-section">
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input type="text" id="inputBusqueda" onkeyup="buscarUsuario()"
                       placeholder="Buscar por nombre, correo o DNI...">
            </div>
            <p class="conteo-text" id="conteo-visible">Mostrando 0 de {{ $usuarios->count() }}</p>
        </div>

        <!-- GRID -->
        <div class="user-grid" id="contenedorUsuarios">
            @forelse($usuarios as $user)
            <div class="user-card-wrapper"
                 data-estado="{{ $user->activo ? 'activo' : 'inactivo' }}"
                data-search="{{ strtolower($user->nombre . ' ' . $user->apellido_paterno . ' ' . $user->dni . ' ' . $user->correo . ' ' . $user->codigo_usuario) }}">
                <div class="user-card {{ $user->activo ? 'card-active' : 'card-inactive' }}">
                    <div class="status-indicator">
                        <span class="dot"></span>
                        {{ $user->activo ? 'Activo' : 'Inactivo' }}
                    </div>
                    <div class="card-body">
                        <div class="avatar-circle">{{ strtoupper(substr($user->nombre, 0, 1)) }}</div>
                        <div class="user-info">
                            <h3>{{ $user->nombre }} {{ $user->apellido_paterno }}</h3>
                            <p class="user-code">Cod: {{ $user->codigo_usuario }}</p>
                            <div class="detail-row"><span class="label">DNI:</span><span class="value">{{ $user->dni }}</span></div>
                            <div class="detail-row"><span class="label">Email:</span><span class="value truncate">{{ $user->correo }}</span></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn-view-detail">🔍 Ver Detalles</button>
                        <button class="btn-action-status {{ $user->activo ? 'btn-deactivate' : 'btn-activate' }}"
                                onclick="toggleActivo({{ $user->id_usuario }}, {{ $user->activo }})">
                            {{ $user->activo ? 'Desactivar' : 'Activar' }}
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state"><p>No hay usuarios registrados aún.</p></div>
            @endforelse
        </div>

        <!-- MOSTRAR MÁS -->
        <div class="load-more-wrapper" id="load-more-wrapper">
            <button class="btn-load-more" id="btn-load-more" onclick="mostrarMas()">
                Mostrar más <span id="restantes"></span>
            </button>
        </div>

    </div>
</div>



<style>
    .main-content {
        margin-left: 260px;
        padding: 40px;
        background: #f0f4f8;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        transition: margin-left 0.35s ease;
    }

    body.sb-collapsed .main-content { margin-left: 70px; }

    /* Header */
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .page-title  { font-size: 24px; font-weight: 700; color: #1a202c; margin: 0; }
    .page-subtitle { font-size: 14px; color: #718096; margin: 4px 0 0; }
    .btn-nuevo { background: #13294b; color: white; padding: 12px 22px; border-radius: 10px; border: none; cursor: pointer; font-size: 14px; font-weight: 500; white-space: nowrap; }
    .btn-nuevo:hover { background: #1a3a6b; }

    /* Stats */
    .stats-container { display: flex; gap: 20px; margin-bottom: 28px; }
    .stat-card { background: white; flex: 1; padding: 20px; border-radius: 15px; display: flex; align-items: center; gap: 15px; cursor: pointer; transition: .2s; border: 2px solid transparent; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.06); }
    .stat-card.active { border-color: #2b6cb0; background: #ebf8ff; }
    .stat-icon { width: 45px; height: 45px; background: #edf2f7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .icon-success { background: #e6fffa; }
    .icon-danger  { background: #fff5f5; }
    .stat-label  { display: block; font-size: 13px; color: #718096; font-weight: 500; }
    .stat-number { font-size: 24px; font-weight: 700; color: #2d3748; }

    /* Búsqueda */
    .search-section { display: flex; align-items: center; gap: 16px; margin-bottom: 28px; }
    .search-box { background: white; display: flex; align-items: center; padding: 12px 20px; border-radius: 12px; border: 1px solid #e2e8f0; flex: 1; }
    .search-icon { margin-right: 12px; color: #a0aec0; }
    .search-box input { border: none; width: 100%; outline: none; font-size: 15px; color: #4a5568; }
    .conteo-text { font-size: 13px; color: #718096; white-space: nowrap; }

    /* Grid */
    .user-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; margin-bottom: 30px; }
    .user-card-wrapper { display: none; }
    .user-card-wrapper.visible { display: block; }
    .user-card-wrapper.filtro-hidden { display: none !important; }

    .user-card { background: white; border-radius: 15px; border: 1px solid #e2e8f0; position: relative; overflow: hidden; transition: box-shadow .2s; }
    .user-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.07); }
    .card-body { padding: 30px 20px 20px; text-align: center; }
    .avatar-circle { width: 60px; height: 60px; background: #ebf4ff; color: #2b6cb0; font-size: 24px; font-weight: bold; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto 15px; }
    .status-indicator { position: absolute; top: 14px; right: 14px; font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; }
    .card-active  .status-indicator { background: #ebfbee; color: #2f855a; }
    .card-inactive .status-indicator { background: #fff5f5; color: #c53030; }
    .dot { width: 8px; height: 8px; border-radius: 50%; }
    .card-active  .dot { background: #48bb78; }
    .card-inactive .dot { background: #f56565; }
    .user-info h3 { font-size: 15px; font-weight: 600; color: #2d3748; margin: 0 0 4px; }
    .user-code { font-size: 12px; color: #a0aec0; background: #f7fafc; display: inline-block; padding: 2px 10px; border-radius: 20px; margin-bottom: 12px; }
    .detail-row { display: flex; justify-content: space-between; font-size: 13px; padding: 5px 0; border-bottom: 1px solid #f7fafc; }
    .detail-row .label { color: #a0aec0; font-weight: 500; }
    .detail-row .value { color: #4a5568; }
    .truncate { max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .card-footer { display: grid; grid-template-columns: 1fr 1fr; background: #f7fafc; border-top: 1px solid #edf2f7; }
    .btn-view-detail, .btn-action-status { padding: 12px; border: none; background: transparent; font-size: 13px; font-weight: 500; cursor: pointer; }
    .btn-view-detail { color: #3182ce; border-right: 1px solid #edf2f7; }
    .btn-deactivate { color: #e53e3e; }
    .btn-activate   { color: #38a169; }
    .empty-state { grid-column: 1/-1; text-align: center; padding: 60px 0; color: #a0aec0; }

    /* Mostrar más */
    .load-more-wrapper { display: flex; justify-content: center; padding: 10px 0 40px; }
    .btn-load-more { background: white; color: #13294b; border: 2px solid #13294b; padding: 12px 36px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: .2s; }
    .btn-load-more:hover { background: #13294b; color: white; }

    /* ═══════════════════════════════
       TABLET (769px – 1024px)
       Sidebar es drawer → margin 0
    ═══════════════════════════════ */
    /* ═══════════════════════════════
       TABLET (769px – 1024px)
    ═══════════════════════════════ */
    @media (min-width: 769px) and (max-width: 1024px) {
        .main-content {
            margin-left: 0 !important;
            padding: 24px 20px;
            padding-top: 68px;
            width: 100%;
            box-sizing: border-box;
            overflow-x: hidden;
        }
        body.sb-collapsed .main-content { margin-left: 0 !important; }

        .stats-container { gap: 12px; }
        .stat-card { padding: 14px; }
        .stat-number { font-size: 20px; }

        .user-grid {
            grid-template-columns: repeat(2, 1fr); /* exactamente 2 columnas, sin minmax fijo */
            gap: 16px;
        }
    }

    /* ═══════════════════════════════
       MÓVIL (≤ 768px)
    ═══════════════════════════════ */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0 !important;
            padding: 16px;
            padding-top: 68px;
            width: 100%;
            box-sizing: border-box;
            overflow-x: hidden;   /* ← esto corta el scroll horizontal */
        }
        body.sb-collapsed .main-content { margin-left: 0 !important; }

        /* evita que hijos se salgan */
        .container-fluid { width: 100%; box-sizing: border-box; }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 16px;
        }
        .btn-nuevo { width: 100%; text-align: center; box-sizing: border-box; }

        .stats-container {
            flex-direction: row;
            gap: 8px;
            margin-bottom: 16px;
        }
        .stat-card { padding: 10px 8px; gap: 8px; min-width: 0; } /* min-width:0 evita overflow en flex */
        .stat-icon { width: 32px; height: 32px; font-size: 14px; border-radius: 8px; flex-shrink: 0; }
        .stat-label { font-size: 10px; }
        .stat-number { font-size: 17px; }

        .search-section {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            margin-bottom: 16px;
        }
        .search-box { box-sizing: border-box; width: 100%; }
        .conteo-text { text-align: right; }

        /* ← el cambio más importante: 1fr en vez de minmax(300px,1fr) */
        .user-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        /* la tarjeta no puede ser más ancha que su contenedor */
        .user-card-wrapper,
        .user-card { width: 100%; box-sizing: border-box; }

        .truncate { max-width: 100%; }
    }

    /* ═══════════════════════════════
       MÓVIL PEQUEÑO (≤ 480px)
    ═══════════════════════════════ */
    @media (max-width: 480px) {
        .main-content { padding: 12px; padding-top: 68px; box-sizing: border-box; }

        .stats-container { flex-direction: column; }
        .stat-card { padding: 12px; min-width: 0; }

        .user-grid { grid-template-columns: 1fr; gap: 12px; }

        .card-body { padding: 22px 14px 14px; }
        .avatar-circle { width: 48px; height: 48px; font-size: 20px; }
        .user-info h3 { font-size: 14px; }
        .detail-row { font-size: 12px; }
        .btn-view-detail, .btn-action-status { padding: 10px; font-size: 12px; }
    }
</style>

<script>
    const LOTE = 16;
    let mostrados = 0;
    let filtroActual = 'todos';

    // Devuelve todas las cards que pasan el filtro activo y la búsqueda
    function cardsVisibles() {
        const q = document.getElementById('inputBusqueda').value.toLowerCase();
        return Array.from(document.querySelectorAll('.user-card-wrapper')).filter(card => {
            const estadoOk  = filtroActual === 'todos' || card.dataset.estado === filtroActual;
            const searchOk  = card.dataset.search.includes(q);
            return estadoOk && searchOk;
        });
    }

    function actualizarVista() {
        const cards = cardsVisibles();
        const total = cards.length;

        // Ocultar todas primero
        document.querySelectorAll('.user-card-wrapper').forEach(c => {
            c.classList.remove('visible');
            c.classList.add('filtro-hidden');
        });

        // Mostrar solo las que pasan filtro, hasta el límite actual
        cards.forEach((card, i) => {
            card.classList.remove('filtro-hidden');
            if (i < mostrados) card.classList.add('visible');
        });

        // Conteo
        const mostrando = Math.min(mostrados, total);
        document.getElementById('conteo-visible').textContent =
            `Mostrando ${mostrando} de ${total}`;

        // Botón mostrar más
        const wrapper = document.getElementById('load-more-wrapper');
        const btn     = document.getElementById('btn-load-more');
        if (mostrados < total) {
            wrapper.style.display = 'flex';
            const quedan = Math.min(LOTE, total - mostrados);
            btn.innerHTML = `Mostrar más <span style="background:#ebf4ff;color:#2b6cb0;padding:2px 10px;border-radius:20px;font-size:12px;margin-left:8px;">+${quedan}</span>`;
        } else {
            wrapper.style.display = 'none';
        }
    }

    function mostrarMas() {
        mostrados += LOTE;
        actualizarVista();
    }

    function filtrarEstado(estado) {
        filtroActual = estado;
        mostrados = LOTE; // reinicia al cambiar filtro
        document.querySelectorAll('.stat-card').forEach(b => b.classList.remove('active'));
        const mapa = { todos: 'btn-todos', activo: 'btn-activos', inactivo: 'btn-inactivos' };
        document.getElementById(mapa[estado]).classList.add('active');
        actualizarVista();
    }

    function buscarUsuario() {
        mostrados = LOTE; // reinicia al buscar
        actualizarVista();
    }

    // Modal
    function openModal()     { document.getElementById('modal-backdrop').style.display = 'flex'; }
    function closeModalBtn() { document.getElementById('modal-backdrop').style.display = 'none'; }
    function closeModal(e)   { if (e.target.id === 'modal-backdrop') closeModalBtn(); }

    // Código automático
    function limpiar(str) {
        return str.normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/[^a-zA-Z]/g,'');
    }
    function generarCodigo() {
        const n = limpiar(document.getElementById('inp-nombre').value).charAt(0).toUpperCase();
        const p = limpiar(document.getElementById('inp-pat').value).charAt(0).toUpperCase();
        const m = limpiar(document.getElementById('inp-mat').value).charAt(0).toUpperCase();
        const d = document.getElementById('inp-dni').value.substring(0, 3);
        const codigo = (n && p && m && d.length === 3) ? n + p + m + d : '';
        document.getElementById('codigo-display').textContent = codigo || '———';
        document.getElementById('codigo-hidden').value = codigo;
    }

    function toggleActivo(id, activo) {
        if (!confirm(activo ? '¿Desactivar este usuario?' : '¿Activar este usuario?')) return;

        fetch(`/cliente/usuarios/${id}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la petición');
            }
            return response.json();
        })
        .then(data => {
            // Cambiar estado sin recargar
            location.reload(); // (opcional, luego lo mejoras)
        })
        .catch(error => {
            console.error(error);

            showNotification(
                'danger',
                'Error',
                'Ocurrió un error'
            );
        });
    }
    // Arranque
    mostrados = LOTE;
    actualizarVista();
</script>