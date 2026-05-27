{{-- 
  COMPONENT: Navbar Admin
  Ubicación: Izquierda (☰ + Accesos), Centro (Búsqueda), Derecha (Notificaciones)
  Estilo: Dark Blue Theme (Coherente con sidebar-admin.blade.php)
--}}

<style>
  /* ── Variables (Consistentes con tu sidebar) ────────────────── */
  :root {
    --nav-bg: linear-gradient(90deg, #0d1f3c 0%, #162d52 100%);
    --nav-border: rgba(43, 127, 255, 0.2);
    --nav-accent: #2b7fff;
    --nav-text: #e8edf5;
    --nav-muted: #7a92b4;
    --nav-height: 60px;
  }

  /* ── Layout Principal ───────────────────────────────────────── */
  .admin-navbar {
    position: fixed;
    top: 0; left: 0; right: 0;
    height: var(--nav-height);
    background: var(--nav-bg);
    border-bottom: 1px solid var(--nav-border);
    z-index: 300; /* Por encima de todo */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    display: flex;
    align-items: center;
    padding: 0 1.5rem;
    justify-content: space-between;
  }

  .dashboard-content,
  .main-content,
  .page-content,
  .content-wrapper,
  .container-fluid {
    padding-top: 30px !important; /* 60px navbar + 15px margen visual */
  }

  /* ── IZQUIERDA: Hamburguesa + Botones ───────────────────────── */
  .nav-left {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .nav-hamburger {
    background: transparent;
    border: 1px solid transparent;
    color: var(--nav-text);
    font-size: 1.2rem;
    padding: 8px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .nav-hamburger:hover {
    background: rgba(43, 127, 255, 0.15);
    border-color: var(--nav-accent);
    color: #fff;
  }

 .nav-quick-links {
  display: flex;
  align-items: center;
  gap: 4px;
    }

 .nav-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 8px;
  color: var(--nav-muted);
  text-decoration: none;
  transition: all 0.2s ease;
  white-space: nowrap;
 }

 .nav-link i {
  font-size: 1.1rem;
 }

 .nav-link:hover {
  color: #fff;
  background: rgba(43, 127, 255, 0.1);
 }

 .nav-link.active {
  color: #fff;
  background: rgba(43, 127, 255, 0.2);
  border: 1px solid rgba(43, 127, 255, 0.4);
  box-shadow: 0 0 0 1px rgba(43, 127, 255, 0.2);
 }

  /* ── CENTRO: Buscador Global ────────────────────────────────── */
  .nav-center {
    flex: 1;
    max-width: 500px;
    margin: 0 2rem;
    display: flex;
    justify-content: center;
  }

  .search-container {
    position: relative;
    width: 100%;
  }
  .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--nav-muted);
    font-size: 0.9rem;
    pointer-events: none;
  }
  .search-input {
    width: 100%;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid var(--nav-border);
    border-radius: 10px;
    padding: 10px 12px 10px 36px;
    color: var(--nav-text);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem;
    outline: none;
    transition: all 0.2s ease;
  }
  .search-input:focus {
    background: rgba(0, 0, 0, 0.3);
    border-color: var(--nav-accent);
    box-shadow: 0 0 0 3px rgba(43, 127, 255, 0.15);
  }
  .search-input::placeholder { color: var(--nav-muted); }
  .search-shortcut {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.1);
    color: var(--nav-muted);
    font-size: 0.7rem;
    padding: 3px 6px;
    border-radius: 4px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    pointer-events: none;
  }

  /* ── DERECHA: Notificaciones ────────────────────────────────── */
  .nav-right {
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
  }

  .notif-wrapper {
    position: relative;
  }

  .notif-btn {
    position: relative;
    background: transparent;
    border: none;
    color: var(--nav-text);
    font-size: 1.2rem;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .notif-btn:hover {
    background: rgba(43, 127, 255, 0.15);
    color: #fff;
  }
  .notif-btn.has-pending {
    animation: bellRing 2s ease-in-out infinite;
    color: #ffd700; /* Oro brillante */
  }
  @keyframes bellRing {
    0%, 100% { transform: rotate(0deg); }
    10%, 30%, 50%, 70%, 90% { transform: rotate(-10deg); }
    20%, 40%, 60%, 80% { transform: rotate(10deg); }
  }

  .notif-badge {
    position: absolute;
    top: 4px; right: 4px;
    background: #ef4444;
    color: #fff;
    font-size: 0.65rem;
    font-weight: 700;
    padding: 2px 5px;
    border-radius: 10px;
    border: 2px solid #0d1f3c;
    min-width: 16px;
    text-align: center;
    line-height: 1;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.5);
  }

  /* Dropdown Notificaciones */
  .notif-dropdown {
    position: absolute;
    top: calc(100% + 12px);
    right: 0;
    width: 340px;
    background: #162d52;
    border: 1px solid var(--nav-border);
    border-radius: 12px;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.6);
    display: none; /* Oculto por defecto */
    flex-direction: column;
    overflow: hidden;
    z-index: 400;
    transform-origin: top right;
    animation: slideIn 0.2s ease-out forwards;
  }
  .notif-dropdown.show { display: flex; }
  @keyframes slideIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }

  .notif-header {
    padding: 14px 16px;
    background: rgba(0, 0, 0, 0.2);
    border-bottom: 1px solid var(--nav-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .notif-title {
    color: #fff;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 0.9rem;
    margin: 0;
  }
  .notif-see-all {
    color: var(--nav-accent);
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 600;
  }
  .notif-see-all:hover { text-decoration: underline; }

  .notif-list {
    max-height: 320px;
    overflow-y: auto;
    padding: 0;
    margin: 0;
    scrollbar-width: thin;
    scrollbar-color: var(--nav-accent) transparent;
  }

  .notif-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 16px;
    border-bottom: 1px solid rgba(43, 127, 255, 0.1);
    transition: background 0.2s;
    text-decoration: none;
    cursor: pointer;
  }
  .notif-item:hover { background: rgba(43, 127, 255, 0.1); }
  .notif-item:last-child { border-bottom: none; }

  .notif-icon-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
  }

  .notif-content { flex: 1; min-width: 0; }
  .notif-text {
    color: #e8edf5;
    font-size: 0.85rem;
    font-weight: 500;
    margin: 0 0 4px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .notif-meta {
    color: var(--nav-muted);
    font-size: 0.75rem;
    margin: 0;
    display: flex;
    gap: 6px;
  }
  .notif-dot { color: var(--nav-accent); }

  .notif-empty {
    padding: 30px 20px;
    text-align: center;
    color: var(--nav-muted);
  }

  /* ── Responsive ─────────────────────────────────────────────── */
  @media (max-width: 1024px) {
    .nav-center { margin: 0 1rem; max-width: 300px; }
    .nav-link span { display: none; } /* Ocultar texto en pantallas medianas */
    .nav-link { padding: 8px; }
  }
  @media (max-width: 768px) {
    .nav-center { display: none; } /* Ocultar búsqueda en móvil */
    .nav-link { display: none; }
    .nav-left { gap: 0.25rem; }
    .nav-hamburger { font-size: 1.4rem; }
    .notif-dropdown { right: -50px; width: 280px; }
  }

  @media (max-width: 768px) {
    .dashboard-content,
    .main-content,
    .page-content,
    .container-fluid {
      padding-top: 40px !important; /* Un poco menos en pantallas pequeñas */
    }
  }
</style>

{{-- ESTRUCTURA HTML ──────────────────────────────────────────── --}}
<nav class="admin-navbar">
  
{{-- IZQUIERDA: ☰ + Accesos Rápidos (SOLO ICONOS) --}}
<div class="nav-left">
  <button class="nav-hamburger" id="navHamburgerBtn" title="Mostrar/Ocultar Menú">
    <i class="fa-solid fa-bars"></i>
  </button>

  <div class="nav-quick-links">
    <a href="{{ route('admin.mistickets') }}" class="nav-link {{ Route::is('admin.mistickets') ? 'active' : '' }}" title="Mis Tickets">
      <i class="fa-solid fa-ticket"></i>
    </a>
    <a href="{{ route('admin.datos') }}" class="nav-link {{ Route::is('admin.datos') ? 'active' : '' }}" title="Mis Datos">
      <i class="fa-solid fa-user-pen"></i>
    </a>
    <a href="{{ route('admin.asignarticket') }}" class="nav-link {{ Route::is('admin.asignarticket') ? 'active' : '' }}" title="Asignar Tickets">
      <i class="fa-solid fa-clipboard-check"></i>
    </a>
    <a href="{{ route('admin.clientes') }}" class="nav-link {{ Route::is('admin.clientes') ? 'active' : '' }}" title="Clientes">
      <i class="fa-solid fa-building"></i>
    </a>
  </div>
</div>

  {{-- CENTRO: Buscador Global --}}
  <div class="nav-center">
    <div class="search-container">
      <i class="fa-solid fa-magnifying-glass search-icon"></i>
      <input type="text" class="search-input" placeholder="Buscar...">
      <span class="search-shortcut">Ctrl + K</span>
    </div>
  </div>

  {{-- DERECHA: Notificaciones --}}
  <div class="nav-right">
    <div class="notif-wrapper" id="notifWrapper">
      @php
          // Simulación de lógica para tickets pendientes (ajusta según tus modelos reales)
          // Busca tickets con estado 'Pendiente' (usualmente id_estado = 1) o sin técnico asignado
          $pendingCount = \App\Models\Ticket::whereNull('id_tecnico_asignado')->count(); 
          $isPending = $pendingCount > 0;
      @endphp

      <button class="notif-btn {{ $isPending ? 'has-pending' : '' }}" id="notifBtn">
        <i class="fa-solid fa-bell"></i>
        @if($isPending)
          <span class="notif-badge">{{ $pendingCount }}</span>
        @endif
      </button>

      {{-- Dropdown de Notificaciones --}}
      <div class="notif-dropdown" id="notifDropdown">
        <div class="notif-header">
          <h4 class="notif-title">Tickets Pendientes</h4>
          <a href="{{ route('admin.asignarticket') }}" class="notif-see-all">Gestionar todo →</a>
        </div>
        
        <div class="notif-list">
          @php
            $pendingTickets = \App\Models\Ticket::whereNull('id_tecnico_asignado')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
          @endphp

          @forelse($pendingTickets as $ticket)
            <div class="notif-item" data-ticket-id="{{ $ticket->id_ticket }}" style="cursor:pointer;">
                <div class="notif-icon-circle">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="notif-content">
                    <p class="notif-text">{{ Str::limit($ticket->asunto, 40) }}</p>
                    <p class="notif-meta">
                        <span>{{ $ticket->codigo_ticket }}</span>
                        <span class="notif-dot">•</span>
                        <span>Hace {{ $ticket->created_at->diffForHumans() }}</span>
                    </p>
                </div>
            </div>
        @empty
            <div class="notif-empty">
                <i class="fa-solid fa-circle-check" style="font-size: 2rem; margin-bottom: 8px;"></i>
                <p>¡Todo al día! No hay tickets pendientes.</p>
            </div>
        @endforelse
        </div>
      </div>
    </div>
  </div>

</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
  
  /* ═══════════════════════════════════════════════════════════
     TOGGLE SIDEBAR DESDE NAVBAR (Desktop + Móvil + Tablet)
     ═══════════════════════════════════════════════════════════ */
  const navHamburger = document.getElementById('navHamburgerBtn');
  const sidebar = document.getElementById('jhs-sidebar');
  const overlay = document.getElementById('sb-overlay');
  
  if (navHamburger && sidebar) {
    navHamburger.addEventListener('click', function(e) {
      e.stopPropagation();
      
      const isMobile = window.innerWidth <= 1024; // Móvil + Tablet
      const isSidebarOpen = sidebar.classList.contains('sb-open');
      
      if (isMobile) {
        // ── MÓVIL/TABLET: Toggle drawer ──
        if (isSidebarOpen) {
          // Cerrar
          sidebar.classList.remove('sb-open');
          if (overlay) overlay.classList.remove('visible');
          document.body.style.overflow = '';
        } else {
          // Abrir
          sidebar.classList.add('sb-open');
          if (overlay) overlay.classList.add('visible');
          document.body.style.overflow = 'hidden';
        }
      } else {
        // ── DESKTOP: Toggle colapsado ──
        sidebar.classList.toggle('collapsed');
        document.body.classList.toggle('sb-collapsed');
      }
    });
  }

  /* ═══════════════════════════════════════════════════════════
     NOTIFICACIONES
     ═══════════════════════════════════════════════════════════ */
  const notifBtn = document.getElementById('notifBtn');
  const notifDropdown = document.getElementById('notifDropdown');

  if (notifBtn && notifDropdown) {
    notifBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      const isOpen = notifDropdown.classList.toggle('show');
      notifBtn.style.transform = isOpen ? 'scale(1.2)' : 'scale(1)';
      if (isOpen) notifBtn.classList.remove('has-pending');
    });

    document.addEventListener('click', function(e) {
      if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
        notifDropdown.classList.remove('show');
        notifBtn.style.transform = 'scale(1)';
      }
    });
  }

  /* ═══════════════════════════════════════════════════════════
     BUSCADOR DE MÓDULOS
     ═══════════════════════════════════════════════════════════ */
  const searchInput = document.querySelector('.search-input');
  
  if (searchInput) {
    const modulos = [
      { nombre: 'Dashboard', ruta: '{{ route("admin.dashboard") }}', icono: 'fa-gauge-high', desc: 'Panel principal' },
      { nombre: 'Mis Tickets', ruta: '{{ route("admin.mistickets") }}', icono: 'fa-ticket', desc: 'Tickets asignados' },
      { nombre: 'Mis Datos', ruta: '{{ route("admin.datos") }}', icono: 'fa-user-pen', desc: 'Editar perfil' },
      { nombre: 'Asignar Tickets', ruta: '{{ route("admin.asignarticket") }}', icono: 'fa-clipboard-check', desc: 'Gestionar tickets' },
      { nombre: 'Clientes', ruta: '{{ route("admin.clientes") }}', icono: 'fa-building', desc: 'Listado clientes' },
      { nombre: 'Contactos', ruta: '{{ route("admin.contactos") }}', icono: 'fa-envelope', desc: 'Mensajería' }
    ];

    let searchTimeout;
    
    searchInput.addEventListener('input', function(e) {
      clearTimeout(searchTimeout);
      const existing = document.querySelector('.module-search-dropdown');
      if (existing) existing.remove();
      
      const query = e.target.value.toLowerCase().trim();
      if (query.length < 2) return;
      
      const resultados = modulos.filter(m => 
        m.nombre.toLowerCase().includes(query) || m.desc.toLowerCase().includes(query)
      );
      if (resultados.length === 0) return;
      
      const dropdown = document.createElement('div');
      dropdown.className = 'module-search-dropdown';
      dropdown.style.cssText = `
        position: absolute; top: calc(100% + 8px); left: 0; right: 0;
        background: #122444; border: 1px solid rgba(43,127,255,0.3);
        border-radius: 10px; box-shadow: 0 8px 30px rgba(0,0,0,0.5);
        z-index: 1000; overflow: hidden; animation: slideDown 0.15s ease-out;
      `;
      
      if (!document.querySelector('#module-search-anim')) {
        const style = document.createElement('style');
        style.id = 'module-search-anim';
        style.textContent = `@keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); }}`;
        document.head.appendChild(style);
      }
      
      resultados.forEach((mod, index) => {
        const item = document.createElement('a');
        item.href = mod.ruta;
        item.style.cssText = `
          display: flex; align-items: center; gap: 12px; padding: 12px 16px;
          text-decoration: none; color: #e8edf5; transition: background 0.2s;
          border-bottom: ${index < resultados.length - 1 ? '1px solid rgba(255,255,255,0.05)' : 'none'};
        `;
        item.onmouseenter = () => item.style.background = 'rgba(43,127,255,0.2)';
        item.onmouseleave = () => item.style.background = 'transparent';
        item.innerHTML = `
          <div style="width:32px;height:32px;border-radius:8px;background:rgba(43,127,255,0.2);display:flex;align-items:center;justify-content:center;color:#60a5fa;">
            <i class="fa-solid ${mod.icono}"></i>
          </div>
          <div style="flex:1;min-width:0;">
            <div style="font-weight:600;font-size:0.9rem;">${mod.nombre}</div>
            <div style="font-size:0.75rem;color:#7a92b4;">${mod.desc}</div>
          </div>
          <i class="fa-solid fa-arrow-right" style="color:#5a6a8a;font-size:0.8rem;"></i>
        `;
        dropdown.appendChild(item);
      });
      
      searchInput.closest('.search-container').style.position = 'relative';
      searchInput.closest('.search-container').appendChild(dropdown);
    });

    document.addEventListener('click', function(e) {
      if (!searchInput.contains(e.target)) {
        const existing = document.querySelector('.module-search-dropdown');
        if (existing) existing.remove();
      }
    });
  }

  /* ═══════════════════════════════════════════════════════════
     ATAJOS DE TECLADO
     ═══════════════════════════════════════════════════════════ */
  document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
      e.preventDefault();
      const input = document.querySelector('.search-input');
      if (input) { input.focus(); input.select(); }
    }
  });

});

/* ═══════════════════════════════════════════════════════════
   NOTIFICACIONES → ABRIR MODAL (USA TU FUNCIÓN EXISTENTE)
   ═══════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.notif-item[data-ticket-id]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const ticketId = this.getAttribute('data-ticket-id');
            if (!ticketId) return;

            // Cerrar dropdown de notificaciones
            const dropdown = document.getElementById('notifDropdown');
            if (dropdown) dropdown.classList.remove('show');

            // 🟢 LLAMAR A LA FUNCIÓN NATIVA DE TU MODAL
            if (typeof abrirDetalleTicket === 'function') {
                abrirDetalleTicket(ticketId);
            } else {
                console.warn('⚠️ La función abrirDetalleTicket() no está disponible.');
                // Fallback seguro: redirigir si el modal no se cargó
                window.location.href = `/admin/ticket/${ticketId}/detalle`;
            }
        });
    });
});

</script>