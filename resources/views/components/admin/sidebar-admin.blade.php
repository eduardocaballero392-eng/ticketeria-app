{{-- ============================================================
   components/cliente/sidebar-cliente.blade.php
   Solo el sidebar izquierdo — incluir con @include(...)
   ============================================================ --}}

<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
  /* ── Variables ─────────────────────────────────────────────── */
  :root {
    --sb-bg-deep:    #0d1f3c;
    --sb-accent:     #2b7fff;
    --sb-accent2:    #00c8ff;
    --sb-text:       #e8edf5;
    --sb-muted:      #7a92b4;
    --sb-w:          260px;
    --sb-c:          70px;
    --sb-transition: 0.35s cubic-bezier(.4,0,.2,1);
  }

  /* ── Toast ─────────────────────────────────────────────────── */
  .sb-toast {
    position: fixed;
    top: 20px; right: 20px;
    padding: 12px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-family: 'DM Sans', sans-serif;
    z-index: 9999;
    display: none;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
  }
  .sb-toast.success { background: #1a4a8a; color: #e8edf5; display: flex; }
  .sb-toast.error   { background: #7f1d1d; color: #fca5a5; display: flex; }

  /* ── Overlay móvil ──────────────────────────────────────────── */
  #sb-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(6, 14, 28, 0.72);
    backdrop-filter: blur(2px);
    z-index: 199;
    opacity: 0;
    transition: opacity var(--sb-transition);
  }
  #sb-overlay.visible {
    display: block;
    opacity: 1;
  }

  /* ── Botón hamburguesa móvil ────────────────────────────────── */
  #sb-hamburger {
    display: none;
    position: fixed;
    top: 14px; left: 14px;
    width: 40px; height: 40px;
    border-radius: 10px;
    background: #162d52;
    border: 1px solid rgba(43,127,255,0.35);
    color: #7ec8ff;
    align-items: center; justify-content: center;
    cursor: pointer;
    z-index: 198;
    font-size: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.35);
    transition: background 0.2s;
  }
  #sb-hamburger:hover { background: rgba(43,127,255,0.25); color: #fff; }

  /* ── Aside ─────────────────────────────────────────────────── */
  #jhs-sidebar {
    position: fixed;
    top: 0; left: 0;
    width: var(--sb-w);
    height: 100vh;
    background: linear-gradient(180deg, #122444 0%, #162d52 55%, #0f1e38 100%);
    display: flex;
    flex-direction: column;
    overflow: visible;
    flex-shrink: 0;
    transition: width var(--sb-transition), transform var(--sb-transition);
    box-shadow: 4px 0 30px rgba(0,0,0,0.35), 1px 0 0 rgba(43,127,255,0.15);
    z-index: 200;
  }
  #jhs-sidebar.collapsed { width: var(--sb-c); }

  /* Cuadrícula decorativa sutil */
  #jhs-sidebar::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
      linear-gradient(rgba(43,127,255,0.04) 1px, transparent 1px),
      linear-gradient(90deg, rgba(43,127,255,0.04) 1px, transparent 1px);
    background-size: 24px 24px;
    pointer-events: none;
    border-radius: inherit;
  }

  /* Orbe decorativo */
  #jhs-sidebar::after {
    content: '';
    position: absolute;
    top: -50px; left: -50px;
    width: 180px; height: 180px;
    background: radial-gradient(circle, rgba(43,127,255,0.12) 0%, transparent 70%);
    pointer-events: none;
    animation: sbSpherePulse 4s ease-in-out infinite;
  }
  @keyframes sbSpherePulse {
    0%,100% { opacity: 0.4; transform: scale(1); }
    50%      { opacity: 0.8; transform: scale(1.1); }
  }

  /* ── Toggle btn (solo desktop) ──────────────────────────────── */
  .sb-toggle {
    position: absolute;
    top: 22px; right: -13px;
    width: 26px; height: 26px;
    border-radius: 50%;
    background: #1e4a8a;
    border: 2px solid rgba(43,127,255,0.8);
    color: #7ec8ff;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    z-index: 20;
    font-size: 10px;
    transition: background 0.2s, transform 0.35s;
    box-shadow: 0 0 10px rgba(43,127,255,0.5);
  }
  .sb-toggle:hover { background: rgba(43,127,255,0.4); color: #fff; }
  #jhs-sidebar.collapsed .sb-toggle { transform: rotate(180deg); }

  /* ── Header brand ───────────────────────────────────────────── */
  .sb-header {
    padding: 26px 20px 20px;
    display: flex; align-items: center; gap: 12px;
    flex-shrink: 0; overflow: hidden;
    transition: height var(--sb-transition), padding var(--sb-transition), opacity var(--sb-transition);
  }
  #jhs-sidebar.collapsed .sb-header { height: 0; padding: 0; opacity: 0; pointer-events: none; }

  .sb-brand-name {
    font-family: 'Syne', sans-serif;
    font-weight: 700; font-size: 13.5px;
    letter-spacing: 0.06em; color: var(--sb-text); white-space: nowrap;
  }
  .sb-brand-sub {
    font-size: 10px; color: var(--sb-muted);
    letter-spacing: 0.08em; white-space: nowrap;
  }

  /* ── Divider ────────────────────────────────────────────────── */
  .sb-divider {
    height: 1px; margin: 0 16px;
    background: linear-gradient(90deg, transparent, rgba(43,127,255,0.35), transparent);
    flex-shrink: 0;
  }

  /* ── Profile ────────────────────────────────────────────────── */
  .sb-profile {
    margin: 16px 12px; padding: 14px;
    border-radius: 14px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.10);
    display: flex; align-items: center; gap: 12px;
    flex-shrink: 0;
    transition: padding var(--sb-transition), margin var(--sb-transition),
                border-color var(--sb-transition), background var(--sb-transition);
  }
  #jhs-sidebar.collapsed .sb-profile {
    padding: 8px 6px; margin: 12px 6px;
    justify-content: center;
    background: transparent; border-color: transparent;
  }

  .sb-avatar-ring {
    flex-shrink: 0; width: 44px; height: 44px;
    border-radius: 50%;
    position: relative; display: flex; align-items: center; justify-content: center;
  }
  .sb-avatar-ring::before {
    content: ''; position: absolute; inset: -2px;
    border-radius: 50%;
    background: conic-gradient(#2b7fff,#00c8ff,#2b7fff,#00c8ff,#2b7fff);
    animation: sbRingRotate 3s linear infinite; z-index: 0;
  }
  .sb-avatar-ring::after {
    content: ''; position: absolute; inset: -4px;
    border-radius: 50%;
    background: conic-gradient(transparent 0deg,rgba(43,127,255,0.15) 90deg,transparent 180deg);
    animation: sbRingRotate 3s linear infinite; filter: blur(4px);
  }
  @keyframes sbRingRotate { to { transform: rotate(360deg); } }

  .sb-avatar-inner {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, #1a3a6e, #2255a4);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 13px;
    color: var(--sb-accent2); position: relative; z-index: 1;
    border: 2px solid #0d1f3c;
  }

  .sb-profile-info {
    overflow: hidden;
    transition: opacity var(--sb-transition), width var(--sb-transition);
  }
  #jhs-sidebar.collapsed .sb-profile-info { opacity: 0; width: 0; pointer-events: none; }

  .sb-profile-name {
    font-family: 'Syne', sans-serif; font-weight: 600; font-size: 12.5px;
    color: var(--sb-text); white-space: nowrap;
  }
  .sb-profile-email { font-size: 10.5px; color: var(--sb-muted); white-space: nowrap; }

  .sb-online-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 9.5px; color: #22d68a; margin-top: 3px;
    font-family: 'DM Sans', sans-serif;
  }
  .sb-online-dot {
    width: 6px; height: 6px; border-radius: 50%; background: #22d68a;
    animation: sbBlink 2s ease-in-out infinite;
  }
  @keyframes sbBlink {
    0%,100% { opacity: 1; box-shadow: 0 0 6px #22d68a; }
    50%      { opacity: 0.5; box-shadow: none; }
  }

  /* ── Nav ────────────────────────────────────────────────────── */
  .sb-nav {
    flex: 1; padding: 8px 10px;
    display: flex; flex-direction: column; gap: 4px;
    overflow-y: auto; overflow-x: hidden;
    scrollbar-width: thin; scrollbar-color: rgba(43,127,255,0.3) transparent;
  }
  .sb-nav::-webkit-scrollbar { width: 3px; }
  .sb-nav::-webkit-scrollbar-thumb { background: rgba(43,127,255,0.3); border-radius: 4px; }

  .sb-nav .sb-label {
    font-size: 9.5px; letter-spacing: 0.12em; color: var(--sb-muted);
    text-transform: uppercase; padding: 6px 8px 2px; font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    transition: opacity var(--sb-transition);
  }
  #jhs-sidebar.collapsed .sb-nav .sb-label { opacity: 0; height: 0; overflow: hidden; padding: 0; }

  /* Tooltip al colapsar */
  .sb-tooltip {
    position: absolute;
    left: calc(var(--sb-c) + 4px); top: 50%; transform: translateY(-50%);
    background: #1a3560; color: var(--sb-text); font-size: 12px;
    font-family: 'DM Sans', sans-serif;
    padding: 5px 10px; border-radius: 7px; white-space: nowrap;
    pointer-events: none; opacity: 0;
    border: 1px solid rgba(43,127,255,0.3);
    box-shadow: 0 4px 16px rgba(0,0,0,0.35);
    transition: opacity 0.15s ease; z-index: 300;
  }
  #jhs-sidebar.collapsed .sb-nav-item:hover .sb-tooltip,
  #jhs-sidebar.collapsed .sb-logout-btn:hover .sb-tooltip { opacity: 1; }

  /* Items */
  .sb-nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 12px; border-radius: 10px;
    cursor: pointer; position: relative;
    transition: all 0.22s ease;
    text-decoration: none; color: var(--sb-muted); overflow: hidden;
    font-family: 'DM Sans', sans-serif;
    animation: sbFadeUp 0.4s ease both;
    border: 1px solid transparent;
  }
  @keyframes sbFadeUp {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .sb-nav-item:nth-child(2){animation-delay:.12s}
  .sb-nav-item:nth-child(3){animation-delay:.18s}
  .sb-nav-item:nth-child(4){animation-delay:.24s}
  .sb-nav-item:nth-child(5){animation-delay:.30s}

  .sb-nav-item::before {
    content: ''; position: absolute; inset: 0;
    background: rgba(43,127,255,0.09);
    transform: translateX(-100%); transition: transform 0.22s ease;
    border-radius: 10px;
  }
  .sb-nav-item:hover::before { transform: translateX(0); }
  .sb-nav-item:hover { color: var(--sb-text); }
  .sb-nav-item:hover .sb-nav-icon { transform: translateX(2px); color: var(--sb-accent2); }

  .sb-nav-item.active {
    color: #fff;
    background: rgba(43,127,255,0.14);
    border-color: rgba(43,127,255,0.28);
    box-shadow: 0 2px 18px rgba(43,127,255,0.12);
  }
  .sb-nav-item.active::after {
    content: ''; position: absolute;
    left: 0; top: 20%; bottom: 20%; width: 3px;
    border-radius: 0 3px 3px 0;
    background: linear-gradient(180deg, var(--sb-accent), var(--sb-accent2));
    box-shadow: 0 0 8px var(--sb-accent);
  }
  .sb-nav-item.active .sb-nav-icon { color: var(--sb-accent2); }

  .sb-nav-icon {
    width: 18px; text-align: center; font-size: 15px;
    flex-shrink: 0; transition: transform 0.22s ease, color 0.22s ease;
    position: relative; z-index: 1;
  }
  .sb-nav-text {
    font-size: 13.5px; font-weight: 400; white-space: nowrap;
    transition: opacity var(--sb-transition), width var(--sb-transition);
    position: relative; z-index: 1;
  }
  #jhs-sidebar.collapsed .sb-nav-text { opacity: 0; width: 0; pointer-events: none; }

  .sb-badge {
    margin-left: auto;
    background: var(--sb-accent); color: #fff;
    font-size: 9px; font-weight: 600;
    padding: 2px 6px; border-radius: 20px; line-height: 1.4;
    position: relative; z-index: 1;
    transition: opacity var(--sb-transition);
  }
  #jhs-sidebar.collapsed .sb-badge { opacity: 0; }

  /* ── Bottom / Logout ────────────────────────────────────────── */
  .sb-bottom {
    padding: 12px 10px; flex-shrink: 0;
    display: flex; flex-direction: column; gap: 4px;
  }

  .sb-logout-btn {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 12px; border-radius: 10px;
    cursor: pointer; color: #e05b5b; font-size: 13.5px;
    font-family: 'DM Sans', sans-serif;
    transition: all 0.22s ease;
    position: relative; overflow: hidden;
    border: 1px solid transparent; background: none; width: 100%;
  }
  .sb-logout-btn:hover {
    background: rgba(224,91,91,0.1);
    border-color: rgba(224,91,91,0.28);
    box-shadow: 0 0 18px rgba(224,91,91,0.18);
    color: #ff7a7a;
  }
  .sb-logout-btn .sb-nav-icon { color: inherit; font-size: 14px; }
  .sb-logout-btn .sb-nav-text {
    transition: opacity var(--sb-transition), width var(--sb-transition);
    position: relative; z-index: 1;
  }
  #jhs-sidebar.collapsed .sb-logout-btn .sb-nav-text { opacity: 0; width: 0; pointer-events: none; }

  /* ── Margen para el contenido derecho ───────────────────────── */
  .dashboard-layout {
    display: flex;
    min-height: 100vh;
  }
  .dashboard-content {
    margin-left: var(--sb-w);
    flex: 1;
    transition: margin-left var(--sb-transition);
  }
  body.sb-collapsed .dashboard-content {
    margin-left: var(--sb-c);
  }

  /* ══════════════════════════════════════════════════════════════
     RESPONSIVE — móvil (≤ 768px)
     El sidebar se convierte en drawer deslizante desde la izquierda
     ══════════════════════════════════════════════════════════════ */
  @media (max-width: 768px) {

    /* Ocultar botón toggle de desktop */
    .sb-toggle { display: none !important; }

    /* Mostrar botón hamburguesa */
    #sb-hamburger { display: flex; }

    /* Sidebar fuera de pantalla por defecto */
    #jhs-sidebar {
      width: var(--sb-w) !important; /* siempre expandido en móvil */
      transform: translateX(-100%);
      /* Aseguramos que nunca esté colapsado en móvil */
    }

    /* Cuando está abierto */
    #jhs-sidebar.sb-open {
      transform: translateX(0);
    }

    /* En móvil nunca aplicar estado colapsado */
    #jhs-sidebar.collapsed {
      width: var(--sb-w) !important;
      transform: translateX(-100%);
    }
    #jhs-sidebar.collapsed.sb-open {
      transform: translateX(0);
    }
    /* Restaurar elementos ocultos por el colapso */
    #jhs-sidebar .sb-header { height: auto !important; padding: 26px 20px 20px !important; opacity: 1 !important; pointer-events: auto !important; }
    #jhs-sidebar .sb-profile { padding: 14px !important; margin: 16px 12px !important; justify-content: flex-start !important; background: rgba(255,255,255,0.06) !important; border-color: rgba(255,255,255,0.10) !important; }
    #jhs-sidebar .sb-profile-info { opacity: 1 !important; width: auto !important; pointer-events: auto !important; }
    #jhs-sidebar .sb-nav .sb-label { opacity: 1 !important; height: auto !important; overflow: visible !important; padding: 6px 8px 2px !important; }
    #jhs-sidebar .sb-nav-text { opacity: 1 !important; width: auto !important; pointer-events: auto !important; }
    #jhs-sidebar .sb-logout-btn .sb-nav-text { opacity: 1 !important; width: auto !important; pointer-events: auto !important; }
    #jhs-sidebar .sb-badge { opacity: 1 !important; }
    #jhs-sidebar .sb-tooltip { display: none !important; }

    /* El contenido ocupa todo el ancho */
    .dashboard-content {
      margin-left: 0 !important;
    }
    body.sb-collapsed .dashboard-content {
      margin-left: 0 !important;
    }

    /* Pequeño padding top para que el contenido no quede debajo del hamburger */
    .dashboard-content {
      padding-top: 60px;
    }
  }

  /* ── Tablet (769px – 1024px): sidebar colapsado por defecto ── */
@media (min-width: 769px) and (max-width: 1024px) {

  /* Ocultar toggle de escritorio */
  .sb-toggle { display: none !important; }

  /* Mostrar hamburguesa */
  #sb-hamburger { display: flex !important; }

  /* Sidebar tipo drawer (oculto) */
  #jhs-sidebar {
    width: var(--sb-w) !important;
    transform: translateX(-100%);
  }

  /* Cuando se abre */
  #jhs-sidebar.sb-open {
    transform: translateX(0);
  }

  /* Evitar colapsado en tablet */
  #jhs-sidebar.collapsed {
    width: var(--sb-w) !important;
    transform: translateX(-100%);
  }

  #jhs-sidebar.collapsed.sb-open {
    transform: translateX(0);
  }

  /* Mostrar contenido normal */
  #jhs-sidebar .sb-header,
  #jhs-sidebar .sb-profile,
  #jhs-sidebar .sb-profile-info,
  #jhs-sidebar .sb-nav-text,
  #jhs-sidebar .sb-label {
    opacity: 1 !important;
    width: auto !important;
    pointer-events: auto !important;
  }

  /* Contenido full ancho */
  .dashboard-content,
  .main-content {
    margin-left: 0 !important;
    padding-top: 60px;
  }

  body.sb-collapsed .dashboard-content,
  body.sb-collapsed .main-content {
    margin-left: 0 !important;
  }

  /* Overlay activo */
  #sb-overlay {
    display: none;
  }

  #sb-overlay.visible {
    display: block;
  }
}
</style>


{{-- ── Overlay (solo móvil) ────────────────────────────────────── --}}
<div id="sb-overlay"></div>

{{-- ── Botón hamburguesa (solo móvil) ─────────────────────────── --}}
<button id="sb-hamburger" title="Abrir menú" aria-label="Abrir menú">
  <i class="fa-solid fa-bars"></i>
</button>

{{-- ── Sidebar ─────────────────────────────────────────────────── --}}
<aside id="jhs-sidebar">

  <button class="sb-toggle" id="sb-toggle" title="Colapsar/Expandir">
    <i class="fa-solid fa-chevron-left"></i>
  </button>

  <div class="sb-header">
    <div>
      <div class="sb-brand-name">JHARDSYSTEX</div>
      <div class="sb-brand-sub">SOLUCIONES DE IT S.A.C.</div>
    </div>
  </div>

  <div class="sb-divider"></div>

  <div class="sb-profile">
    <div class="sb-avatar-ring">
      <div class="sb-avatar-inner">
        {{ strtoupper(substr(session('nombre', 'JH'), 0, 2)) }}
      </div>
    </div>
    <div class="sb-profile-info">
      <div class="sb-profile-name">{{ session('nombre', 'Usuario') }}</div>
      <div class="sb-profile-email">{{ session('correo', '') }}</div>
      <div class="sb-online-badge">
        <span class="sb-online-dot"></span>Online
      </div>
    </div>
  </div>

  <div class="sb-divider"></div>

  <nav class="sb-nav">
    <div class="sb-label">Menú principal</div>

    <a href="{{ route('admin.datos') }}"
       class="sb-nav-item {{ Route::is('admin.datos') ? 'active' : '' }}">
      <span class="sb-nav-icon"><i class="fa-solid fa-user"></i></span>
      <span class="sb-nav-text">Mis Datos</span>
      <span class="sb-tooltip">Mis Datos</span>
    </a>

    <a href="{{ route('admin.dashboard') }}"
        class="sb-nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
        <span class="sb-nav-icon"><i class="fa-solid fa-gauge-high"></i></span>
        <span class="sb-nav-text">Dashboard</span>
        <span class="sb-tooltip">Dashboard</span>
    </a>

    <a href="{{ route('admin.asignarticket') }}"
        class="sb-nav-item {{ Route::is('admin.asignarticket') ? 'active' : '' }}">
        <span class="sb-nav-icon"><i class="fa-solid fa-gauge-high"></i></span>
        <span class="sb-nav-text">Tickets Generales</span>
        <span class="sb-tooltip">Tickets Generales</span>
    </a>


    <a href="{{ route('admin.mistickets') }}"
        class="sb-nav-item {{ Route::is('admin.mistickets') ? 'active' : '' }}">
        <span class="sb-nav-icon"><i class="fa-solid fa-ticket"></i></span>
        <span class="sb-nav-text">Mis Tickets</span>
        <span class="sb-tooltip">Mis Tickets</span>
    </a>

    <a href="#"
       class="sb-nav-item {{ Route::is('admin.mail') ? 'active' : '' }}">
      <span class="sb-nav-icon"><i class="fa-solid fa-envelope"></i></span>
      <span class="sb-nav-text">Mail</span>
      <span class="sb-tooltip">Mail</span>
    </a>

  </nav>

  <div class="sb-bottom">
    <div class="sb-divider"></div>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="sb-logout-btn">
        <span class="sb-nav-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
        <span class="sb-nav-text">Cerrar Sesión</span>
        <span class="sb-tooltip">Cerrar Sesión</span>
      </button>
    </form>
  </div>

</aside>

<script>
  (function () {
    const sidebar    = document.getElementById('jhs-sidebar');
    const toggle     = document.getElementById('sb-toggle');
    const hamburger  = document.getElementById('sb-hamburger');
    const overlay    = document.getElementById('sb-overlay');

    /* ── Detectar si estamos en móvil ── */
    const isMobile = () => window.innerWidth <= 768;

    /* ── Toggle DESKTOP: colapsar/expandir ── */
    toggle.addEventListener('click', () => {
      if (isMobile()) return; // en móvil no hace nada el toggle de desktop
      sidebar.classList.toggle('collapsed');
      document.body.classList.toggle('sb-collapsed');
    });

    /* ── Hamburger MÓVIL: abrir drawer ── */
    function openDrawer() {
      sidebar.classList.add('sb-open');
      overlay.classList.add('visible');
      hamburger.innerHTML = '<i class="fa-solid fa-xmark"></i>';
      document.body.style.overflow = 'hidden'; // evitar scroll fondo
    }

    function closeDrawer() {
      sidebar.classList.remove('sb-open');
      overlay.classList.remove('visible');
      hamburger.innerHTML = '<i class="fa-solid fa-bars"></i>';
      document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', () => {
      if (sidebar.classList.contains('sb-open')) {
        closeDrawer();
      } else {
        openDrawer();
      }
    });

    /* Cerrar al tocar el overlay */
    overlay.addEventListener('click', closeDrawer);

    /* Cerrar drawer si se hace clic en un nav-item en móvil */
    sidebar.querySelectorAll('.sb-nav-item').forEach(function(item) {
      item.addEventListener('click', function() {
        if (isMobile()) closeDrawer();
      });
    });

    /* Al redimensionar ventana: limpiar estado móvil si pasamos a desktop */
    window.addEventListener('resize', function() {
      if (!isMobile()) {
        closeDrawer();
        document.body.style.overflow = '';
      }
    });

  })();
</script>