@include('components.usuario.sidebar-usuario')
@include('components.usuario.modelcrearticket')
@include('components.usuario.detalleticket')
@include('components.notificaciones.alertas')


<style>
    /* ══ LAYOUT ══ */
    .tk-main {
        margin-left: 260px;
        background: #f0f4f8;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        transition: margin-left var(--sb-transition, .35s);
        box-sizing: border-box;
    }
    /* Cuando el sidebar se colapsa a 70px */
    body.sb-collapsed .tk-main { margin-left: 70px; }
    .tk-inner { padding: 28px 32px; }

    /* ══ HEADER ══ */
    .tk-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        gap: 12px;
        flex-wrap: wrap;
    }
    .tk-header h1 { font-size: 22px; font-weight: 700; color: #0a2540; margin: 0; }
    .tk-btn-new {
        background: #185FA5; color: #fff; border: none;
        border-radius: 8px; padding: 10px 20px;
        font-size: 14px; font-weight: 500; cursor: pointer;
        white-space: nowrap;
    }

    /* ══ TARJETAS RESUMEN ══ */
    .tk-cards {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }
    .tk-card {
        background: #fff;
        border: 1px solid #dbe4f0;
        border-radius: 12px;
        padding: 16px;
        cursor: pointer;
        transition: box-shadow .15s;
    }
    .tk-card:hover   { box-shadow: 0 4px 12px rgba(10,37,80,.08); }
    .tk-card.card-active { border: 2px solid #185FA5 !important; }
    .tk-card-label   { font-size: 12px; color: #64748b; margin-bottom: 6px; }
    .tk-card-num     { font-size: 26px; font-weight: 700; color: #0a2540; }
    .tk-card-badge   { font-size: 11px; padding: 2px 8px; border-radius: 20px; margin-top: 6px; display: inline-block; }

    /* ══ BARRA BÚSQUEDA ══ */
    .tk-search-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }
    .tk-search-input {
        display: flex; align-items: center; gap: 10px;
        background: #fff; border: 1px solid #dbe4f0;
        border-radius: 8px; padding: 8px 14px;
        flex: 1; min-width: 0;
    }
    .tk-search-input input {
        border: none; outline: none; font-size: 14px;
        width: 100%; background: transparent; color: #0a2540;
    }
    .tk-date-wrap {
        display: flex; align-items: center; gap: 6px;
        background: #fff; border: 1px solid #dbe4f0;
        border-radius: 8px; padding: 6px 12px;
        white-space: nowrap;
    }
    .tk-date-wrap input {
        border: none; outline: none; font-size: 13px;
        color: #0a2540; background: transparent; cursor: pointer;
    }
    .tk-btn-clear {
        background: #f1f5f9; border: 1px solid #dbe4f0;
        border-radius: 8px; padding: 6px 14px;
        font-size: 13px; color: #64748b; cursor: pointer;
        white-space: nowrap;
    }

    /* ══ TABLA ══ */
    .tk-table-wrap {
        background: #fff;
        border: 1px solid #dbe4f0;
        border-radius: 12px;
        overflow: hidden;
    }
    .tk-table-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        max-height: 487px;
        overflow-y: auto;
    }
    .tk-table-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
    .tk-table-scroll::-webkit-scrollbar-track { background: #f4f7fa; }
    .tk-table-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .tk-table-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    .tk-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 560px;
    }
    .tk-table thead { background: #f4f7fa; position: sticky; top: 0; z-index: 1; }
    .tk-table th {
        padding: 10px 14px; text-align: left;
        font-size: 12px; font-weight: 500; color: #64748b;
        border-bottom: 1px solid #dbe4f0;
    }
    .tk-table td { padding: 10px 14px; border-bottom: 1px solid #dbe4f0; }
    .tk-table tr:hover td { background: #f4f7fa; }

    .btn-detalle {
        background: #E6F1FB; color: #185FA5; border: none;
        border-radius: 6px; padding: 5px 12px;
        font-size: 12px; font-weight: 500; cursor: pointer;
        transition: background .15s;
    }
    .btn-detalle:hover { background: #185FA5; color: #fff; }



    @keyframes tkSlideUp {
        from { opacity:0; transform: translateY(18px); }
        to   { opacity:1; transform: translateY(0); }
    }
    input[type="date"]::-webkit-calendar-picker-indicator { opacity:.5; cursor:pointer; }

    /* ══════════════════════════════
       TABLET  769px – 1024px
    ══════════════════════════════ */
    @media (min-width: 769px) and (max-width: 1024px) {
        .tk-main    { margin-left: 0; padding-top: 68px; }
        .tk-inner   { padding: 20px; }
        .tk-cards   { grid-template-columns: repeat(3, 1fr); }
    }

    /* ══════════════════════════════
       MÓVIL  ≤ 768px
    ══════════════════════════════ */
    @media (max-width: 768px) {
        .tk-main  { margin-left: 0 !important; padding-top: 64px; }
        .tk-inner { padding: 14px; }

        .tk-header { flex-direction: column; align-items: stretch; }
        .tk-btn-new { width: 100%; text-align: center; }

        .tk-cards { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .tk-card-num { font-size: 20px; }

        .tk-search-bar { flex-direction: column; align-items: stretch; }
        .tk-search-input { width: 100%; box-sizing: border-box; }
        .tk-date-wrap    { width: 100%; box-sizing: border-box; }
        .tk-btn-clear    { width: 100%; text-align: center; }

        .tk-modal-grid { grid-template-columns: 1fr; }
    }

    /* ══════════════════════════════
       MÓVIL PEQUEÑO  ≤ 420px
    ══════════════════════════════ */
    @media (max-width: 420px) {
        .tk-cards { grid-template-columns: 1fr 1fr; gap: 6px; }
        .tk-card  { padding: 10px; }
        .tk-card-label { font-size: 10px; }
        .tk-card-num   { font-size: 18px; }
        .tk-card-badge { font-size: 10px; }
    }
</style>

<div class="tk-main">
<div class="tk-inner">

    {{-- Header --}}
    <div class="tk-header">
        <h1>Mis Tickets</h1>
        <button type="button" class="tk-btn-new" onclick="abrirModalTicket()">
            + Crear ticket
        </button>
    </div>

    {{-- Alertas Blade --}}
    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:8px;padding:12px 16px;margin-bottom:16px;font-size:13px;">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;border-radius:8px;padding:12px 16px;margin-bottom:16px;font-size:13px;">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- Tarjetas de resumen --}}
    <div class="tk-cards">

        <div class="tk-card card-active" id="card-all" onclick="setFilter('all')">
            <div class="tk-card-label">Total de tickets</div>
            <div class="tk-card-num">{{ $tickets->count() }}</div>
            <span class="tk-card-badge" style="background:#EEEDFE;color:#3C3489;">Todos</span>
        </div>

        <div class="tk-card" id="card-PENDIENTE" onclick="setFilter('PENDIENTE')">
            <div class="tk-card-label">Pendientes</div>
            <div class="tk-card-num">{{ $tickets->where('estado','PENDIENTE')->count() }}</div>
            <span class="tk-card-badge" style="background:#EEEDFE;color:#7c3aed;">Pendiente</span>
        </div>

        <div class="tk-card" id="card-PROGRAMADO" onclick="setFilter('PROGRAMADO')">
            <div class="tk-card-label">Programados</div>
            <div class="tk-card-num">{{ $tickets->where('estado','PROGRAMADO')->count() }}</div>
            <span class="tk-card-badge" style="background:#DDE9FF;color:#3B82F6;">Programado</span>
        </div>

        <div class="tk-card" id="card-EN PROCESO" onclick="setFilter('EN PROCESO')">
            <div class="tk-card-label">En proceso</div>
            <div class="tk-card-num">{{ $tickets->where('estado','EN PROCESO')->count() }}</div>
            <span class="tk-card-badge" style="background:#FAEEDA;color:#854F0B;">Proceso</span>
        </div>

        <div class="tk-card" id="card-CERRADO" onclick="setFilter('CERRADO')">
            <div class="tk-card-label">Cerrados</div>
            <div class="tk-card-num">{{ $tickets->where('estado','CERRADO')->count() }}</div>
            <span class="tk-card-badge" style="background:#EAF3DE;color:#3B6D11;">Cerrado</span>
        </div>

        <div class="tk-card" id="card-CANCELADO" onclick="setFilter('CANCELADO')">
            <div class="tk-card-label">Cancelados</div>
            <div class="tk-card-num">{{ $tickets->where('estado','CANCELADO')->count() }}</div>
            <span class="tk-card-badge" style="background:#fef2f2;color:#991b1b;">Cancelado</span>
        </div>

    </div>

    {{-- Barra búsqueda --}}
    <div class="tk-search-bar">
        <div class="tk-search-input">
            <span>&#128269;</span>
            <input type="text" id="searchInput" placeholder="Buscar por código de ticket..." oninput="renderTable()">
        </div>
        <div class="tk-date-wrap">
            <span style="font-size:13px;color:#64748b;">&#128197;</span>
            <input type="date" id="dateFilter" onchange="renderTable()">
        </div>
        <button class="tk-btn-clear" onclick="clearDate()">&#x2715; Limpiar</button>
    </div>

    {{-- Tabla --}}
    <div class="tk-table-wrap">
        <div class="tk-table-scroll">
            <table class="tk-table">
                <thead>
                    <tr>
                        <th style="width:180px;">Código</th>
                        <th>Asunto</th>
                        <th style="width:110px;">Estado</th>
                        <th style="width:100px;">Prioridad</th>
                        <th style="width:100px;">Fecha</th>
                        <th style="width:90px;text-align:center;">Detalle</th>
                    </tr>
                </thead>
                <tbody id="ticketBody"></tbody>
            </table>
        </div>
    </div>

</div>


<script>
    const tickets = @json($tickets->values());
    let filtro = 'all';

    function clearDate() {
        document.getElementById('dateFilter').value = '';
        renderTable();
    }

    function setFilter(s) {
        filtro = s;
        document.querySelectorAll('[id^="card-"]').forEach(el => el.classList.remove('card-active'));
        document.getElementById('card-' + s)?.classList.add('card-active');
        renderTable();
    }

    function badge(s) {
        const map = {
            'PENDIENTE':  'background:#EEEDFE;color:#7c3aed;',
            'PROGRAMADO': 'background:#E6F1FB;color:#185FA5;',
            'EN PROCESO': 'background:#FAEEDA;color:#854F0B;',
            'CERRADO':    'background:#EAF3DE;color:#3B6D11;',
            'CANCELADO':  'background:#fef2f2;color:#991b1b;',
        };
        const style = map[s] ?? 'background:#f1f5f9;color:#64748b;';
        return `<span style="${style}font-size:11px;font-weight:500;padding:3px 10px;border-radius:20px;">${s}</span>`;
    }

    function priorityBadge(p) {
        const map = {
            'ALTA':  'color:#dc2626;font-weight:600;',
            'MEDIA': 'color:#854F0B;font-weight:500;',
            'BAJA':  'color:#3B6D11;font-weight:500;',
        };
        return `<span style="${map[p] ?? ''}">${p ?? '—'}</span>`;
    }

   
    function renderTable() {
        const q          = document.getElementById('searchInput').value.trim().toLowerCase();
        const dateFilter = document.getElementById('dateFilter').value;

        let pool = tickets.map((t, i) => ({ ...t, _idx: i }));

        if (filtro !== 'all') pool = pool.filter(t => t.estado === filtro);
        if (dateFilter)       pool = pool.filter(t => (t.created_at ?? '').substring(0,10) === dateFilter);
        if (q)                pool = pool.filter(t => t.codigo_ticket.toLowerCase().includes(q));

        const tbody = document.getElementById('ticketBody');

        if (!pool.length) {
            tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:2rem;color:#94a3b8;font-size:13px;">Sin tickets que mostrar</td></tr>`;
            return;
        }

        tbody.innerHTML = pool.map(t => `
            <tr>
                <td style="font-family:monospace;font-size:12px;color:#185FA5;">${t.codigo_ticket}</td>
                <td style="color:#0a2540;">${t.asunto}</td>
                <td>${badge(t.estado)}</td>
                <td>${priorityBadge(t.prioridad_nombre)}</td>
                <td style="color:#64748b;">${(t.created_at ?? '').substring(0,10)}</td>
                <td style="text-align:center;">
                    <button class="btn-detalle" onclick="openModal(${t._idx})">Ver detalle</button>
                </td>
            </tr>`).join('');
    }

    renderTable();
</script>