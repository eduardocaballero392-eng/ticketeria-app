@include('components.cliente.sidebar-cliente')
@include('components.cliente.nuevousuario')
@include('components.notificaciones.alertas')

<div class="main-content">
    <div class="container-fluid">

        <!-- HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-user-shield"></i> Gestión de Personal
                </h1>
                <p class="page-subtitle">
                    <i class="fas fa-database"></i> {{ $usuarios->count() }} usuarios registrados en total
                </p>
            </div>
            <button class="btn-nuevo" onclick="openModal()">
                <i class="fas fa-plus-circle"></i> Nuevo Usuario
            </button>
        </div>

        <!-- STATS / FILTROS -->
        <div class="stats-container">
            <div class="stat-card active" onclick="filtrarEstado('todos')" id="btn-todos">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Total</span>
                    <span class="stat-number">{{ $usuarios->count() }}</span>
                </div>
            </div>
            <div class="stat-card" onclick="filtrarEstado('activo')" id="btn-activos">
                <div class="stat-icon icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Activos</span>
                    <span class="stat-number">{{ $usuarios->where('activo', 1)->count() }}</span>
                </div>
            </div>
            <div class="stat-card" onclick="filtrarEstado('inactivo')" id="btn-inactivos">
                <div class="stat-icon icon-danger">
                    <i class="fas fa-ban"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Inactivos</span>
                    <span class="stat-number">{{ $usuarios->where('activo', 0)->count() }}</span>
                </div>
            </div>
        </div>

        <!-- BÚSQUEDA + CONTEO -->
        <div class="search-section">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="inputBusqueda" onkeyup="buscarUsuario()"
                       placeholder="Buscar por nombre, correo o DNI...">
            </div>
            <p class="conteo-text" id="conteo-visible">
                <i class="fas fa-eye"></i> Mostrando 0 de {{ $usuarios->count() }}
            </p>
        </div>

        <!-- GRID -->
        <div class="user-grid" id="contenedorUsuarios">
            @forelse($usuarios as $user)
            <div class="user-card-wrapper"
                 data-estado="{{ $user->activo ? 'activo' : 'inactivo' }}"
                 data-id="{{ $user->id_usuario }}"
                 data-nombre="{{ $user->nombre }}"
                 data-apellido_paterno="{{ $user->apellido_paterno }}"
                 data-apellido_materno="{{ $user->apellido_materno ?? '' }}"
                 data-dni="{{ $user->dni }}"
                 data-correo="{{ $user->correo }}"
                 data-codigo="{{ $user->codigo_usuario }}"
                 data-activo="{{ $user->activo }}"
                 data-search="{{ strtolower($user->nombre . ' ' . $user->apellido_paterno . ' ' . $user->dni . ' ' . $user->correo . ' ' . $user->codigo_usuario) }}">
                <div class="user-card {{ $user->activo ? 'card-active' : 'card-inactive' }}">
                    <div class="status-indicator">
                        <i class="fas fa-circle dot"></i>
                        {{ $user->activo ? 'Activo' : 'Inactivo' }}
                    </div>
                    <div class="card-body">
                        <div class="avatar-circle">
                            {{ strtoupper(substr($user->nombre, 0, 1)) }}{{ strtoupper(substr($user->apellido_paterno, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <h3>{{ $user->nombre }} {{ $user->apellido_paterno }}</h3>
                            <p class="user-code">
                                <i class="fas fa-id-card"></i> {{ $user->codigo_usuario }}
                            </p>
                            <div class="detail-row">
                                <span class="label"><i class="fas fa-id-card"></i> DNI:</span>
                                <span class="value">{{ $user->dni }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="label"><i class="fas fa-envelope"></i> Email:</span>
                                <span class="value truncate">{{ $user->correo }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn-view-detail" onclick="verDetalles({{ $loop->index }})">
                            <i class="fas fa-eye"></i> Ver Detalles
                        </button>
                        <button class="btn-action-status {{ $user->activo ? 'btn-deactivate' : 'btn-activate' }}"
                                onclick="toggleActivo({{ $user->id_usuario }}, {{ $user->activo }})">
                            <i class="fas {{ $user->activo ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                            {{ $user->activo ? 'Desactivar' : 'Activar' }}
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-user-slash" style="font-size: 48px; margin-bottom: 16px;"></i>
                <p>No hay usuarios registrados aún.</p>
            </div>
            @endforelse
        </div>

        <!-- MOSTRAR MÁS -->
        <div class="load-more-wrapper" id="load-more-wrapper">
            <button class="btn-load-more" id="btn-load-more" onclick="mostrarMas()">
                <i class="fas fa-arrow-down"></i> Mostrar más <span id="restantes"></span>
            </button>
        </div>

    </div>
</div>

<!-- MODAL DE DETALLES MEJORADO -->
<div id="modal-detalles" class="modal-detalles" style="display: none;">
    <div class="modal-detalles-content">
        <div class="modal-detalles-header">
            <h3><i class="fas fa-user-circle"></i> Detalles del Usuario</h3>
            <button class="modal-close" onclick="cerrarModalDetalles()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-detalles-body" id="modal-detalles-body">
            <!-- Contenido dinámico -->
        </div>
        <div class="modal-detalles-footer">
            <button class="btn-cerrar" onclick="cerrarModalDetalles()">
                <i class="fas fa-times"></i> Cerrar
            </button>
        </div>
    </div>
</div>

<!-- NOTIFICACIÓN PROFESIONAL (POSICIÓN ORIGINAL - ARRIBA DERECHA) -->
<div id="notificacion-toast" class="toast-notification" style="display: none;">
    <div class="toast-icon" id="toast-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="toast-content">
        <strong id="toast-title">Éxito</strong>
        <p id="toast-message">Operación realizada</p>
    </div>
</div>

<!-- MODAL DE CONFIRMACIÓN PROFESIONAL -->
<div id="modal-confirmacion" class="modal-confirmacion" style="display: none;">
    <div class="modal-confirmacion-content">
        <div class="modal-confirmacion-header" id="confirm-icon">
            <i class="fas fa-question-circle"></i>
        </div>
        <div class="modal-confirmacion-body">
            <h3 id="confirm-titulo">Confirmar acción</h3>
            <p id="confirm-mensaje">¿Estás seguro de realizar esta acción?</p>
        </div>
        <div class="modal-confirmacion-footer">
            <button class="btn-cancelar" onclick="cerrarModalConfirmacion()">
                <i class="fas fa-times"></i> Cancelar
            </button>
            <button class="btn-confirmar" id="btn-confirmar-accion">
                <i class="fas fa-check"></i> Confirmar
            </button>
        </div>
    </div>
</div>

<!-- MODAL DE ÉXITO PROFESIONAL PARA CREACIÓN DE USUARIO -->
<div id="modal-exito" class="modal-exito" style="display: none;">
    <div class="modal-exito-content">
        <div class="modal-exito-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="modal-exito-body">
            <h3>¡Usuario creado exitosamente!</h3>
            <p>Las credenciales han sido enviadas al correo del usuario</p>
            <div class="exito-detalle">
                <div class="exito-correo">
                    <i class="fas fa-envelope"></i>
                    <span id="exito-correo">correo@ejemplo.com</span>
                </div>
                <div class="exito-nota">
                    <i class="fas fa-info-circle"></i>
                    <small>El usuario recibirá sus credenciales de acceso por correo electrónico</small>
                </div>
            </div>
        </div>
        <div class="modal-exito-footer">
            <button class="btn-entendido" onclick="cerrarModalExito()">
                <i class="fas fa-check"></i> Entendido
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
    .page-title i { color: #2b6cb0; margin-right: 10px; }
    .page-subtitle { font-size: 14px; color: #718096; margin: 4px 0 0; }
    .page-subtitle i { margin-right: 6px; }
    .btn-nuevo { background: #13294b; color: white; padding: 12px 22px; border-radius: 10px; border: none; cursor: pointer; font-size: 14px; font-weight: 500; white-space: nowrap; transition: all 0.3s; }
    .btn-nuevo i { margin-right: 8px; }
    .btn-nuevo:hover { background: #1a3a6b; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(19,41,75,0.2); }

    /* Stats */
    .stats-container { display: flex; gap: 20px; margin-bottom: 28px; }
    .stat-card { background: white; flex: 1; padding: 20px; border-radius: 15px; display: flex; align-items: center; gap: 15px; cursor: pointer; transition: all 0.3s; border: 2px solid transparent; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.06); }
    .stat-card.active { border-color: #2b6cb0; background: linear-gradient(135deg, #ebf8ff 0%, #ffffff 100%); }
    .stat-icon { width: 45px; height: 45px; background: #edf2f7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .stat-icon i { font-size: 22px; color: #4a5568; }
    .icon-success { background: linear-gradient(135deg, #e6fffa 0%, #ffffff 100%); }
    .icon-success i { color: #38a169; }
    .icon-danger { background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); }
    .icon-danger i { color: #e53e3e; }
    .stat-label  { display: block; font-size: 13px; color: #718096; font-weight: 500; }
    .stat-number { font-size: 24px; font-weight: 700; color: #2d3748; }

    /* Búsqueda */
    .search-section { display: flex; align-items: center; gap: 16px; margin-bottom: 28px; }
    .search-box { background: white; display: flex; align-items: center; padding: 12px 20px; border-radius: 12px; border: 1px solid #e2e8f0; flex: 1; transition: all 0.3s; }
    .search-box:focus-within { border-color: #2b6cb0; box-shadow: 0 0 0 3px rgba(43,108,176,0.1); }
    .search-icon { margin-right: 12px; color: #a0aec0; font-size: 16px; }
    .search-box input { border: none; width: 100%; outline: none; font-size: 15px; color: #4a5568; }
    .search-box input::placeholder { color: #cbd5e0; }
    .conteo-text { font-size: 13px; color: #718096; white-space: nowrap; }
    .conteo-text i { margin-right: 6px; }

    /* Grid */
    .user-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; margin-bottom: 30px; }
    .user-card-wrapper { display: none; }
    .user-card-wrapper.visible { display: block; }
    .user-card-wrapper.filtro-hidden { display: none !important; }

    .user-card { background: white; border-radius: 15px; border: 1px solid #e2e8f0; position: relative; overflow: hidden; transition: all 0.3s; }
    .user-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
    .card-body { padding: 30px 20px 20px; text-align: center; }
    .avatar-circle { width: 70px; height: 70px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 26px; font-weight: bold; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin: 0 auto 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .status-indicator { position: absolute; top: 14px; right: 14px; font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; }
    .status-indicator i { font-size: 8px; }
    .card-active  .status-indicator { background: #ebfbee; color: #2f855a; }
    .card-inactive .status-indicator { background: #fff5f5; color: #c53030; }
    .user-info h3 { font-size: 16px; font-weight: 600; color: #2d3748; margin: 0 0 4px; }
    .user-code { font-size: 12px; color: #a0aec0; background: #f7fafc; display: inline-block; padding: 4px 12px; border-radius: 20px; margin-bottom: 12px; }
    .user-code i { margin-right: 4px; }
    .detail-row { display: flex; justify-content: space-between; font-size: 13px; padding: 6px 0; border-bottom: 1px solid #f7fafc; }
    .detail-row .label { color: #a0aec0; font-weight: 500; }
    .detail-row .label i { margin-right: 6px; width: 16px; }
    .detail-row .value { color: #4a5568; }
    .truncate { max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .card-footer { display: grid; grid-template-columns: 1fr 1fr; background: #f7fafc; border-top: 1px solid #edf2f7; }
    .btn-view-detail, .btn-action-status { padding: 12px; border: none; background: transparent; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.3s; }
    .btn-view-detail { color: #3182ce; border-right: 1px solid #edf2f7; }
    .btn-view-detail:hover { background: #ebf8ff; }
    .btn-deactivate { color: #e53e3e; }
    .btn-deactivate:hover { background: #fff5f5; }
    .btn-activate   { color: #38a169; }
    .btn-activate:hover { background: #ebfbee; }
    .empty-state { grid-column: 1/-1; text-align: center; padding: 60px 0; color: #a0aec0; }

    /* Modal de detalles profesional */
    .modal-detalles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .modal-detalles-content {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 500px;
        animation: slideUp 0.3s ease;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    @keyframes slideUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .modal-detalles-header {
        background: linear-gradient(135deg, #13294b 0%, #1a3a6b 100%);
        color: white;
        padding: 20px 24px;
        border-radius: 20px 20px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-detalles-header h3 {
        margin: 0;
        font-size: 20px;
    }
    .modal-detalles-header h3 i {
        margin-right: 10px;
    }
    .modal-close {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s;
    }
    .modal-close:hover {
        background: rgba(255,255,255,0.4);
        transform: rotate(90deg);
    }
    .modal-detalles-body {
        padding: 24px;
        max-height: 400px;
        overflow-y: auto;
    }
    .detalle-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #edf2f7;
    }
    .detalle-icon {
        width: 40px;
        height: 40px;
        background: #ebf4ff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    .detalle-icon i {
        font-size: 18px;
        color: #2b6cb0;
    }
    .detalle-info {
        flex: 1;
    }
    .detalle-label {
        font-size: 12px;
        color: #a0aec0;
        display: block;
    }
    .detalle-valor {
        font-size: 15px;
        font-weight: 600;
        color: #2d3748;
    }
    .modal-detalles-footer {
        padding: 16px 24px;
        border-top: 1px solid #edf2f7;
        text-align: right;
    }
    .btn-cerrar {
        background: #edf2f7;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-cerrar:hover {
        background: #e2e8f0;
    }

    /* Toast notification - Posición original arriba derecha */
    .toast-notification {
        position: fixed;
        top: 30px;
        right: 30px;
        background: white;
        border-radius: 12px;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        z-index: 1100;
        animation: slideInRight 0.3s ease;
        border-left: 4px solid;
    }
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .toast-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .toast-icon.success { background: #ebfbee; color: #38a169; }
    .toast-icon.error { background: #fff5f5; color: #e53e3e; }
    .toast-content strong {
        display: block;
        font-size: 14px;
        margin-bottom: 4px;
    }
    .toast-content p {
        font-size: 12px;
        margin: 0;
        color: #718096;
    }

    /* Modal de confirmación profesional */
    .modal-confirmacion {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1001;
        animation: fadeIn 0.3s ease;
    }
    .modal-confirmacion-content {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 400px;
        text-align: center;
        animation: slideUp 0.3s ease;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .modal-confirmacion-header {
        padding: 30px 0 0 0;
    }
    .modal-confirmacion-header i {
        font-size: 64px;
    }
    .modal-confirmacion-header.warning i { color: #ed8936; }
    .modal-confirmacion-header.success i { color: #38a169; }
    .modal-confirmacion-body {
        padding: 20px 30px;
    }
    .modal-confirmacion-body h3 {
        margin: 0 0 10px 0;
        color: #2d3748;
    }
    .modal-confirmacion-body p {
        margin: 0;
        color: #718096;
    }
    .modal-confirmacion-footer {
        padding: 20px 30px;
        display: flex;
        gap: 12px;
        border-top: 1px solid #edf2f7;
    }
    .btn-cancelar, .btn-confirmar {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-cancelar {
        background: #edf2f7;
        color: #4a5568;
    }
    .btn-cancelar:hover {
        background: #e2e8f0;
    }
    .btn-confirmar {
        background: #e53e3e;
        color: white;
    }
    .btn-confirmar:hover {
        background: #c53030;
        transform: translateY(-2px);
    }

    /* Modal de éxito para creación de usuario */
    .modal-exito {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1002;
        animation: fadeIn 0.3s ease;
    }
    .modal-exito-content {
        background: white;
        border-radius: 24px;
        width: 90%;
        max-width: 420px;
        text-align: center;
        animation: bounceIn 0.4s ease;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.3);
    }
    @keyframes bounceIn {
        0% { transform: scale(0.8); opacity: 0; }
        80% { transform: scale(1.05); }
        100% { transform: scale(1); opacity: 1; }
    }
    .modal-exito-icon {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        width: 70px;
        height: 70px;
        border-radius: 50%;
        margin: -35px auto 0;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(56,161,105,0.4);
    }
    .modal-exito-icon i {
        font-size: 36px;
        color: white;
    }
    .modal-exito-body {
        padding: 30px 28px 20px;
    }
    .modal-exito-body h3 {
        margin: 0 0 10px 0;
        font-size: 20px;
        font-weight: 700;
        color: #1a202c;
    }
    .modal-exito-body p {
        margin: 0 0 20px 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.5;
    }
    .exito-detalle {
        background: #f0fff4;
        border-radius: 12px;
        padding: 16px;
        margin-top: 8px;
        border: 1px solid #c6f6d5;
    }
    .exito-correo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #2f855a;
        background: white;
        padding: 10px;
        border-radius: 8px;
    }
    .exito-correo i {
        font-size: 16px;
    }
    .exito-nota {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 11px;
        color: #38a169;
    }
    .exito-nota i {
        font-size: 12px;
    }
    .modal-exito-footer {
        padding: 16px 28px 28px;
    }
    .btn-entendido {
        background: linear-gradient(135deg, #13294b 0%, #1a3a6b 100%);
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 40px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: all 0.2s;
    }
    .btn-entendido:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(19,41,75,0.3);
    }

    .load-more-wrapper { display: flex; justify-content: center; padding: 10px 0 40px; }
    .btn-load-more { background: white; color: #13294b; border: 2px solid #13294b; padding: 12px 36px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: .2s; }
    .btn-load-more i { margin-right: 8px; }
    .btn-load-more:hover { background: #13294b; color: white; transform: translateY(-2px); }

    /* Responsive */
    @media (min-width: 769px) and (max-width: 1024px) {
        .main-content { margin-left: 0 !important; padding: 24px 20px; padding-top: 68px; }
        .user-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
    }
    @media (max-width: 768px) {
        .main-content { margin-left: 0 !important; padding: 16px; padding-top: 68px; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .btn-nuevo { width: 100%; text-align: center; }
        .stats-container { flex-direction: row; gap: 8px; }
        .user-grid { grid-template-columns: 1fr; gap: 14px; }
    }
</style>

<script>
    const LOTE = 16;
    let mostrados = 0;
    let filtroActual = 'todos';
    let usuariosData = @json($usuarios);
    let confirmCallback = null;

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
        document.querySelectorAll('.user-card-wrapper').forEach(c => {
            c.classList.remove('visible');
            c.classList.add('filtro-hidden');
        });
        cards.forEach((card, i) => {
            card.classList.remove('filtro-hidden');
            if (i < mostrados) card.classList.add('visible');
        });
        const mostrando = Math.min(mostrados, total);
        document.getElementById('conteo-visible').innerHTML = '<i class="fas fa-eye"></i> Mostrando ' + mostrando + ' de ' + total;
        const wrapper = document.getElementById('load-more-wrapper');
        if (mostrados < total) {
            wrapper.style.display = 'flex';
            const quedan = Math.min(LOTE, total - mostrados);
            document.getElementById('btn-load-more').innerHTML = '<i class="fas fa-arrow-down"></i> Mostrar más <span style="background:#ebf4ff;color:#2b6cb0;padding:2px 10px;border-radius:20px;font-size:12px;margin-left:8px;">+' + quedan + '</span>';
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
        mostrados = LOTE;
        document.querySelectorAll('.stat-card').forEach(b => b.classList.remove('active'));
        const mapa = { todos: 'btn-todos', activo: 'btn-activos', inactivo: 'btn-inactivos' };
        document.getElementById(mapa[estado]).classList.add('active');
        actualizarVista();
    }

    function buscarUsuario() {
        mostrados = LOTE;
        actualizarVista();
    }

    function verDetalles(index) {
        const user = usuariosData[index];
        const modalBody = document.getElementById('modal-detalles-body');
        modalBody.innerHTML = `
            <div class="detalle-item">
                <div class="detalle-icon"><i class="fas fa-user"></i></div>
                <div class="detalle-info">
                    <span class="detalle-label">Nombre completo</span>
                    <span class="detalle-valor">${user.nombre} ${user.apellido_paterno} ${user.apellido_materno || ''}</span>
                </div>
            </div>
            <div class="detalle-item">
                <div class="detalle-icon"><i class="fas fa-id-card"></i></div>
                <div class="detalle-info">
                    <span class="detalle-label">Código de usuario</span>
                    <span class="detalle-valor">${user.codigo_usuario}</span>
                </div>
            </div>
            <div class="detalle-item">
                <div class="detalle-icon"><i class="fas fa-credit-card"></i></div>
                <div class="detalle-info">
                    <span class="detalle-label">DNI</span>
                    <span class="detalle-valor">${user.dni}</span>
                </div>
            </div>
            <div class="detalle-item">
                <div class="detalle-icon"><i class="fas fa-envelope"></i></div>
                <div class="detalle-info">
                    <span class="detalle-label">Correo electrónico</span>
                    <span class="detalle-valor">${user.correo}</span>
                </div>
            </div>
            <div class="detalle-item">
                <div class="detalle-icon"><i class="fas ${user.activo ? 'fa-check-circle' : 'fa-ban'}"></i></div>
                <div class="detalle-info">
                    <span class="detalle-label">Estado</span>
                    <span class="detalle-valor" style="color: ${user.activo ? '#38a169' : '#e53e3e'}">
                        ${user.activo ? 'Activo' : 'Inactivo'}
                    </span>
                </div>
            </div>
        `;
        document.getElementById('modal-detalles').style.display = 'flex';
    }

    function cerrarModalDetalles() {
        document.getElementById('modal-detalles').style.display = 'none';
    }

    function mostrarModalConfirmacion(options) {
        const modal = document.getElementById('modal-confirmacion');
        const iconContainer = document.getElementById('confirm-icon');
        const titulo = document.getElementById('confirm-titulo');
        const mensaje = document.getElementById('confirm-mensaje');
        const confirmBtn = document.getElementById('btn-confirmar-accion');
        
        iconContainer.className = 'modal-confirmacion-header';
        if (options.icono === 'warning') {
            iconContainer.classList.add('warning');
            iconContainer.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
        } else {
            iconContainer.classList.add('success');
            iconContainer.innerHTML = '<i class="fas fa-check-circle"></i>';
        }
        
        titulo.textContent = options.titulo;
        mensaje.textContent = options.mensaje;
        confirmCallback = options.onConfirm;
        
        modal.style.display = 'flex';
        
        const newConfirmBtn = confirmBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
        newConfirmBtn.addEventListener('click', () => {
            if (confirmCallback) confirmCallback();
            cerrarModalConfirmacion();
        });
    }

    function cerrarModalConfirmacion() {
        document.getElementById('modal-confirmacion').style.display = 'none';
        confirmCallback = null;
    }

    function showNotification(type, title, message) {
        const toast = document.getElementById('notificacion-toast');
        const icon = document.getElementById('toast-icon');
        const titleEl = document.getElementById('toast-title');
        const messageEl = document.getElementById('toast-message');
        
        if (type === 'success') {
            icon.innerHTML = '<i class="fas fa-check-circle"></i>';
            icon.className = 'toast-icon success';
            toast.style.borderLeftColor = '#38a169';
        } else {
            icon.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
            icon.className = 'toast-icon error';
            toast.style.borderLeftColor = '#e53e3e';
        }
        
        titleEl.textContent = title;
        messageEl.textContent = message;
        toast.style.display = 'flex';
        
        setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }

    function toggleActivo(id, activo) {
        mostrarModalConfirmacion({
            titulo: activo ? 'Desactivar usuario' : 'Activar usuario',
            mensaje: activo ? '¿Estás seguro de que deseas desactivar este usuario?' : '¿Estás seguro de que deseas activar este usuario?',
            icono: 'warning',
            onConfirm: () => {
                fetch('/cliente/usuarios/' + id + '/toggle', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    showNotification('success', 'Éxito', activo ? 'Usuario desactivado correctamente' : 'Usuario activado correctamente');
                    setTimeout(() => location.reload(), 1500);
                })
                .catch(error => {
                    showNotification('error', 'Error', 'Ocurrió un error al procesar la solicitud');
                });
            }
        });
    }

    // Función para mostrar modal de éxito al crear usuario
    function mostrarModalExito(correo) {
        const modal = document.getElementById('modal-exito');
        const correoElement = document.getElementById('exito-correo');
        correoElement.textContent = correo;
        modal.style.display = 'flex';
    }

    function cerrarModalExito() {
        const modal = document.getElementById('modal-exito');
        modal.style.display = 'none';
        location.reload();
    }

    function openModal() {
        const modalBackdrop = document.getElementById('modal-backdrop');
        if (modalBackdrop) {
            modalBackdrop.style.display = 'flex';
        } else {
            console.error('Modal no encontrado');
        }
    }

    document.getElementById('modal-detalles')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalDetalles();
    });
    
    document.getElementById('modal-confirmacion')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalConfirmacion();
    });

    document.getElementById('modal-exito')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalExito();
    });

    // Exponer funciones globalmente para que el modal de creación las use
    window.mostrarModalExito = mostrarModalExito;
    window.cerrarModalExito = cerrarModalExito;

    mostrados = LOTE;
    actualizarVista();
</script>