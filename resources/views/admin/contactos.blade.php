<div class="dashboard-layout">
    @include('components.admin.navbar-admin')
    @include('components.admin.sidebar-admin')
    @include('components.notificaciones.alertas')

    <main class="main-content">
        <div class="content-wrapper">

            <div class="header">
                <div class="header-left">
                    <h2>Contactos</h2>
                    <p>Consulta y comunícate con los usuarios registrados en el sistema</p>
                </div>
                <div class="header-stats">
                    <div class="stat-pill">
                        <span class="stat-num">{{ $usuarios->count() }}</span>
                        <span class="stat-label">usuarios</span>
                    </div>
                    <div class="stat-pill active">
                        <span class="stat-num">{{ $usuarios->where('activo', 1)->count() }}</span>
                        <span class="stat-label">activos</span>
                    </div>
                    <div class="stat-pill empresa">
                        <span class="stat-num">{{ $clientes->count() }}</span>
                        <span class="stat-label">empresas</span>
                    </div>
                </div>
            </div>

            {{-- Filtros --}}
            <div class="filters-bar">
                <div class="search-bar">
                    <svg viewBox="0 0 20 20"><path d="M12.9 14.32a8 8 0 111.41-1.41l4.09 4.1-1.42 1.41-4.08-4.1zM8 14A6 6 0 108 2a6 6 0 000 12z"/></svg>
                    <input type="text" id="buscador" placeholder="Buscar por nombre, código o teléfono...">
                </div>
                <div class="select-wrap">
                    <svg viewBox="0 0 20 20"><path d="M4 5h12M6 10h8M8 15h4"/></svg>
                    <select id="filtroEmpresa">
                        <option value="">Todas las empresas</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id_cliente }}">{{ $cliente->razon_social }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Grid de tarjetas --}}
            <div class="contacts-grid" id="contactsGrid">
                @forelse($usuarios as $usuario)
                @php
                    $codigoPais = $usuario->codigo_pais ?? '+51';
                    $telefono   = preg_replace('/\D/', '', $usuario->telefono ?? '');
                    $waLink     = 'https://wa.me/' . ltrim($codigoPais, '+') . $telefono;
                    $iniciales  = strtoupper(substr($usuario->nombre, 0, 1) . substr($usuario->apellido_paterno, 0, 1));
                    $colores    = ['#1a7fd4','#0f9e6e','#e07b1a','#9b3dd4','#d43d3d','#2e86c1','#1abc9c'];
                    $color      = $colores[crc32($usuario->codigo_usuario) % count($colores)];
                    $empresa    = $usuario->cliente->razon_social ?? 'Sin empresa';
                @endphp

                <div class="contact-card {{ $usuario->activo ? '' : 'inactive' }}"
                     data-nombre="{{ strtolower($usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno) }}"
                     data-codigo="{{ strtolower($usuario->codigo_usuario) }}"
                     data-telefono="{{ $usuario->telefono }}"
                     data-empresa="{{ $usuario->id_cliente }}">

                    <div class="card-top">
                        <div class="avatar" style="background: {{ $color }}1a; color: {{ $color }}; border-color: {{ $color }}33;">
                            {{ $iniciales }}
                        </div>
                        <div class="status-dot {{ $usuario->activo ? 'online' : 'offline' }}"
                             title="{{ $usuario->activo ? 'Activo' : 'Inactivo' }}"></div>
                    </div>

                    <div class="card-info">
                        <h3 class="user-name">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</h3>
                        <span class="user-code">{{ $usuario->codigo_usuario }}</span>
                        <span class="user-empresa">
                            <svg viewBox="0 0 20 20"><path d="M4 4h12a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1zm4 5H6v2h2V9zm4 0h-2v2h2V9zm2-3H6v1h8V6z"/></svg>
                            {{ $empresa }}
                        </span>
                    </div>

                    <div class="phone-section">
                        <div class="phone-box">
                            <svg viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h3.5a1 1 0 01.95.68l1 3a1 1 0 01-.27 1.05L6.91 7.96a11.05 11.05 0 004.13 4.13l1.23-1.27a1 1 0 011.05-.27l3 1a1 1 0 01.68.95V16a1 1 0 01-1 1C6.27 17 3 13.73 3 3z"/></svg>
                            <span>{{ $codigoPais }} {{ $usuario->telefono ?? 'Sin teléfono' }}</span>
                        </div>
                    </div>

                    @if($usuario->telefono)
                    <a href="{{ $waLink }}" target="_blank" class="btn-whatsapp">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Contactar por WhatsApp
                    </a>
                    @else
                    <div class="btn-whatsapp disabled">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Sin número registrado
                    </div>
                    @endif
                </div>
                @empty
                <div class="empty-state">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    <p>No hay usuarios registrados.</p>
                </div>
                @endforelse
            </div>

            <div class="no-results" id="noResults" style="display:none;">
                <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-2h2v2zm0-4H11V7h2v5z"/></svg>
                <p>No se encontraron usuarios con ese criterio.</p>
            </div>

        </div>
    </main>
</div>

<style>
    .dashboard-layout { display: flex; min-height: 100vh; }

    .main-content {
        flex: 1;
        margin-left: 260px;
        padding: 40px;
        background: #eef4fb;
        transition: margin-left 0.35s cubic-bezier(.4,0,.2,1);
        min-width: 0;
    }

    body.sb-collapsed .main-content { margin-left: 70px; }

    .header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 24px;
    }

    .header h2 { font-size: 22px; font-weight: 600; color: #0a2d4a; margin-bottom: 4px; }
    .header p  { font-size: 13.5px; color: #5a8ab5; }

    .header-stats { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

    .stat-pill {
        display: flex; flex-direction: column; align-items: center;
        padding: 8px 16px; border-radius: 10px;
        background: white; border: 1px solid #d0e6f7; min-width: 60px;
    }
    .stat-pill.active  { background: #e8f5ee; border-color: #a8d5b8; }
    .stat-pill.empresa { background: #f0eaff; border-color: #c9b3f5; }

    .stat-num  { font-size: 18px; font-weight: 700; color: #0a2d4a; line-height: 1; }
    .stat-pill.active .stat-num  { color: #1a7a45; }
    .stat-pill.empresa .stat-num { color: #6b3fd4; }
    .stat-label { font-size: 10px; color: #7aabcc; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 2px; }
    .stat-pill.active .stat-label  { color: #2e9e5e; }
    .stat-pill.empresa .stat-label { color: #9b6fe0; }

    /* Filtros */
    .filters-bar {
        display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;
    }

    .search-bar {
        display: flex; align-items: center; gap: 10px;
        background: white; border: 1px solid #d0e6f7;
        border-radius: 10px; padding: 11px 16px;
        box-shadow: 0 2px 8px rgba(10,61,107,0.04);
        flex: 1; min-width: 200px;
    }
    .search-bar svg { width: 16px; height: 16px; fill: #7aabcc; flex-shrink: 0; }
    .search-bar input {
        border: none; outline: none; font-size: 13.5px;
        color: #0a2d4a; width: 100%; font-family: inherit; background: transparent;
    }
    .search-bar input::placeholder { color: #a8c8e8; }

    .select-wrap {
        display: flex; align-items: center; gap: 10px;
        background: white; border: 1px solid #d0e6f7;
        border-radius: 10px; padding: 11px 16px;
        box-shadow: 0 2px 8px rgba(10,61,107,0.04);
        min-width: 200px;
    }
    .select-wrap svg { width: 16px; height: 16px; stroke: #7aabcc; fill: none; stroke-width: 2; flex-shrink: 0; }
    .select-wrap select {
        border: none; outline: none; font-size: 13.5px;
        color: #0a2d4a; font-family: inherit; background: transparent;
        cursor: pointer; width: 100%;
    }

    /* Grid */
    .contacts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 18px;
    }

    /* Tarjeta */
    .contact-card {
        background: white; border-radius: 16px;
        border: 1px solid #d8eaf7; padding: 24px 20px 20px;
        display: flex; flex-direction: column; align-items: center;
        gap: 12px; box-shadow: 0 2px 12px rgba(10,61,107,0.05);
        transition: transform 0.2s, box-shadow 0.2s; position: relative;
    }
    .contact-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(10,61,107,0.10); }
    .contact-card.inactive { opacity: 0.55; }

    .card-top { position: relative; }
    .avatar {
        width: 64px; height: 64px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; font-weight: 700; border: 2px solid; letter-spacing: 1px;
    }
    .status-dot {
        width: 12px; height: 12px; border-radius: 50%;
        border: 2px solid white; position: absolute; bottom: 2px; right: 2px;
    }
    .status-dot.online  { background: #25d366; }
    .status-dot.offline { background: #c0c8d4; }

    .card-info { text-align: center; width: 100%; }
    .user-name { font-size: 14px; font-weight: 600; color: #0a2d4a; margin: 0 0 4px; line-height: 1.3; }
    .user-code {
        font-size: 11px; color: #7aabcc; background: #f0f7ff;
        padding: 2px 8px; border-radius: 20px; font-weight: 500;
        letter-spacing: 0.04em; display: inline-block; margin-bottom: 6px;
    }
    .user-empresa {
        display: flex; align-items: center; justify-content: center;
        gap: 4px; font-size: 11.5px; color: #5a8ab5; margin-top: 2px;
    }
    .user-empresa svg { width: 12px; height: 12px; fill: #7aabcc; flex-shrink: 0; }

    .phone-section { width: 100%; }
    .phone-box {
        display: flex; align-items: center; gap: 8px;
        background: #f5f9fe; border: 1px solid #d8eaf7;
        border-radius: 8px; padding: 9px 12px;
        font-size: 13px; color: #0a3d6b; font-weight: 500;
    }
    .phone-box svg { width: 14px; height: 14px; fill: #1a7fd4; flex-shrink: 0; }

    .btn-whatsapp {
        width: 100%; display: flex; align-items: center; justify-content: center;
        gap: 8px; padding: 11px 16px; background: #25d366; color: white;
        border-radius: 10px; font-size: 13px; font-weight: 600;
        text-decoration: none; transition: background 0.2s, transform 0.15s;
        font-family: inherit; cursor: pointer; border: none;
    }
    .btn-whatsapp svg { width: 16px; height: 16px; flex-shrink: 0; }
    .btn-whatsapp:hover { background: #1ebe5a; transform: translateY(-1px); color: white; }
    .btn-whatsapp.disabled {
        background: #e8f0f7; color: #a0bad0;
        cursor: not-allowed; pointer-events: none;
    }

    .empty-state, .no-results {
        grid-column: 1 / -1; display: flex; flex-direction: column;
        align-items: center; gap: 12px; padding: 60px 20px; color: #7aabcc;
    }
    .empty-state svg, .no-results svg {
        width: 48px; height: 48px; stroke: #a8c8e8; fill: none; stroke-width: 1.5;
    }
    .empty-state p, .no-results p { font-size: 14px; }

    /* Responsive */
    @media (min-width: 769px) and (max-width: 1024px) {
        .main-content { margin-left: 70px; }
    }

    @media (max-width: 768px) {
        .main-content { margin-left: 0 !important; padding: 20px 16px; padding-top: 68px; }
        body.sb-collapsed .main-content { margin-left: 0 !important; }
        .contacts-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
        .filters-bar { flex-direction: column; }
        .select-wrap { min-width: unset; }
    }

    @media (max-width: 480px) {
        .contacts-grid { grid-template-columns: 1fr; }
        .header { flex-direction: column; }
        .header-stats { width: 100%; justify-content: flex-start; }
    }
</style>

<script>
    const buscador     = document.getElementById('buscador');
    const filtroEmpresa = document.getElementById('filtroEmpresa');
    const cards        = document.querySelectorAll('.contact-card');
    const noResult     = document.getElementById('noResults');

    function filtrar() {
        const q       = buscador.value.toLowerCase().trim();
        const empresa = filtroEmpresa.value;
        let visible   = 0;

        cards.forEach(card => {
            const nombre   = card.dataset.nombre   || '';
            const codigo   = card.dataset.codigo   || '';
            const telefono = card.dataset.telefono || '';
            const cardEmp  = card.dataset.empresa  || '';

            const matchTexto  = nombre.includes(q) || codigo.includes(q) || telefono.includes(q);
            const matchEmpresa = empresa === '' || cardEmp === empresa;

            const show = matchTexto && matchEmpresa;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        noResult.style.display = visible === 0 ? 'flex' : 'none';
    }

    buscador.addEventListener('input', filtrar);
    filtroEmpresa.addEventListener('change', filtrar);
</script>
