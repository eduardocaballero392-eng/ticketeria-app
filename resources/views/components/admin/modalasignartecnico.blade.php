{{-- ══ MODAL ASIGNAR TÉCNICO ══ --}}
<div class="mat-overlay" id="modalAsignarTecnico" onclick="cerrarModalAsignar()">
    <div class="mat-card" onclick="event.stopPropagation()">

        {{-- HEADER --}}
        <div class="mat-header">
            <div class="mat-header-left">
                <div class="mat-header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                </div>
                <div>
                    <div class="mat-header-eyebrow">Asignación de técnico</div>
                    <div class="mat-header-title">Ticket <span id="matTicketCodigo">—</span></div>
                </div>
            </div>
            <button class="mat-close-btn" onclick="cerrarModalAsignar()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- BODY --}}
        <div class="mat-body">

            {{-- Resumen del ticket --}}
            <div class="mat-ticket-info" id="matTicketInfo">
                <div class="mat-info-row">
                    <span class="mat-info-label">Asunto</span>
                    <span class="mat-info-val" id="matTicketAsunto">—</span>
                </div>
                <div class="mat-info-row">
                    <span class="mat-info-label">Cliente</span>
                    <span class="mat-info-val" id="matTicketCliente">—</span>
                </div>
                <div class="mat-info-row">
                    <span class="mat-info-label">Usuario</span>
                    <span class="mat-info-val" id="matTicketUsuario">—</span>
                </div>
                <div class="mat-info-row">
                    <span class="mat-info-label">Prioridad</span>
                    <span id="matTicketPrioridad">—</span>
                </div>
            </div>

            {{-- Selección de técnico --}}
            <div class="mat-section-label">Seleccionar técnico</div>

            <div class="mat-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="matBuscarTecnico" placeholder="Buscar por nombre o código..." oninput="matFiltrarTecnicos()">
            </div>

            <div class="mat-tecnico-list" id="matTecnicoList">
                {{-- Se rellena dinámicamente --}}
            </div>

            <div class="mat-empty" id="matTecnicoEmpty" style="display:none">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:#cbd5e0">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <p>No se encontraron técnicos</p>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="mat-footer">
            <button class="mat-btn-ghost" onclick="cerrarModalAsignar()">Cancelar</button>
            <button class="mat-btn-primary" id="matBtnConfirmar" onclick="confirmarAsignacion()" disabled>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Confirmar asignación
            </button>
        </div>

    </div>
</div>

<style>
@keyframes matUp {
    from { opacity:0; transform:translateY(18px) scale(.98) }
    to   { opacity:1; transform:translateY(0) scale(1) }
}

.mat-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(8,20,45,.55);
    backdrop-filter: blur(5px);
    z-index: 1100;
    align-items: center; justify-content: center;
    padding: 16px;
}

.mat-card {
    background: #fff;
    border-radius: 20px;
    width: 520px; max-width: 100%; max-height: 90vh;
    display: flex; flex-direction: column;
    overflow: hidden;
    animation: matUp .22s cubic-bezier(.16,1,.3,1);
    box-shadow: 0 28px 70px rgba(8,20,45,.24), 0 0 0 1px rgba(255,255,255,.06);
}

/* Header */
.mat-header {
    background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
    padding: 20px 24px;
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.mat-header-left  { display: flex; align-items: center; gap: 14px; }
.mat-header-icon  {
    width: 42px; height: 42px; border-radius: 12px;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.25);
    display: flex; align-items: center; justify-content: center;
    color: #fff; flex-shrink: 0;
}
.mat-header-eyebrow { font-size: 10px; color: rgba(255,255,255,.65); letter-spacing:.1em; text-transform:uppercase; margin-bottom:3px; }
.mat-header-title   { font-size: 16px; font-weight: 700; color: #fff; font-family:'Courier New',monospace; }
.mat-close-btn {
    width: 34px; height: 34px; border-radius: 10px;
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.2);
    color: #fff; display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .15s; flex-shrink: 0;
}
.mat-close-btn:hover { background: rgba(255,255,255,.28); }

/* Body */
.mat-body {
    padding: 20px 24px 4px;
    overflow-y: auto; flex: 1;
    scrollbar-width: thin; scrollbar-color: #c8d8f0 transparent;
}
.mat-body::-webkit-scrollbar { width: 4px; }
.mat-body::-webkit-scrollbar-thumb { background: #c8d8f0; border-radius: 99px; }

/* Ticket info */
.mat-ticket-info {
    background: #f8fafd;
    border: 1px solid #e8eef8;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 20px;
    display: flex; flex-direction: column; gap: 8px;
}
.mat-info-row   { display: flex; justify-content: space-between; align-items: center; font-size: 13px; }
.mat-info-label { color: #94a3b8; font-weight: 500; flex-shrink: 0; margin-right: 12px; }
.mat-info-val   { color: #1e3a5f; font-weight: 500; text-align: right; }

/* Sección label */
.mat-section-label {
    font-size: 11px; font-weight: 700; color: #7c3aed;
    text-transform: uppercase; letter-spacing: .07em;
    margin-bottom: 10px;
}

/* Buscador */
.mat-search-box {
    display: flex; align-items: center; gap: 8px;
    background: #f8fafd;
    border: 1px solid #e8eef8;
    border-radius: 10px;
    padding: 10px 14px;
    margin-bottom: 12px;
    color: #94a3b8;
}
.mat-search-box input {
    border: none; outline: none; background: transparent;
    font-size: 13px; color: #2d3748; width: 100%;
}
.mat-search-box input::placeholder { color: #b0bec5; }

/* Lista técnicos */
.mat-tecnico-list {
    display: flex; flex-direction: column; gap: 8px;
    max-height: 280px; overflow-y: auto;
    margin-bottom: 8px;
    scrollbar-width: thin; scrollbar-color: #c8d8f0 transparent;
}
.mat-tecnico-list::-webkit-scrollbar { width: 4px; }
.mat-tecnico-list::-webkit-scrollbar-thumb { background: #c8d8f0; border-radius: 99px; }

.mat-tecnico-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 14px;
    border: 1.5px solid #e8eef8;
    border-radius: 12px;
    cursor: pointer;
    transition: border-color .15s, background .15s;
    background: #fff;
}
.mat-tecnico-item:hover { background: #faf5ff; border-color: #c4b5fd; }
.mat-tecnico-item.mat-selected {
    border-color: #7c3aed;
    background: #f5f3ff;
}

.mat-tec-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: #ede9fe; color: #7c3aed;
    font-size: 15px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.mat-selected .mat-tec-avatar { background: #7c3aed; color: #fff; }

.mat-tec-info { flex: 1; min-width: 0; }
.mat-tec-nombre  { font-size: 14px; font-weight: 600; color: #1e3a5f; }
.mat-tec-codigo  { font-size: 11px; color: #94a3b8; font-family:'Courier New',monospace; }

.mat-check {
    width: 22px; height: 22px; border-radius: 50%;
    border: 1.5px solid #c4b5fd;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: .15s;
    color: transparent;
}
.mat-selected .mat-check {
    background: #7c3aed; border-color: #7c3aed; color: #fff;
}

/* Empty */
.mat-empty {
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; gap: 10px; padding: 32px 0;
    color: #94a3b8; font-size: 13px;
}

/* Footer */
.mat-footer {
    display: flex; gap: 10px; justify-content: flex-end;
    padding: 16px 24px;
    border-top: 1px solid #f0f4fa;
    background: #fafbfd;
    flex-shrink: 0;
}
.mat-btn-ghost {
    background: transparent; border: 1px solid #d1dce8;
    color: #64748b; border-radius: 10px;
    padding: 9px 20px; font-size: 13px; font-weight: 500;
    cursor: pointer; transition: all .15s;
}
.mat-btn-ghost:hover { background: #f1f5f9; border-color: #b0bec5; }

.mat-btn-primary {
    background: #7c3aed;
    color: #fff; border: none; border-radius: 10px;
    padding: 9px 22px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: flex; align-items: center; gap: 7px;
    transition: opacity .15s, background .15s;
}
.mat-btn-primary:hover:not(:disabled) { background: #6d28d9; }
.mat-btn-primary:disabled {
    opacity: .45; cursor: not-allowed;
}

@media (max-width: 540px) {
    .mat-body { padding: 16px; }
    .mat-footer { flex-direction: column-reverse; }
    .mat-btn-ghost, .mat-btn-primary { width: 100%; justify-content: center; }
}
</style>

<script>
// ── Estado interno ────────────────────────────────────────────────
window._matTicketId    = null;
window._matTecnicoSel  = null;
window._matTecnicosAll = [];

// ── Abrir modal ───────────────────────────────────────────────────
function abrirModalAsignar(idTicket, asunto, cliente, usuario, prioridad, prioColor, codigoTicket) {
    window._matTicketId   = idTicket;
    window._matTecnicoSel = null;

    // Rellenar info del ticket
    document.getElementById('matTicketCodigo').textContent  = codigoTicket  || ('#' + idTicket);
    document.getElementById('matTicketAsunto').textContent  = asunto   || '—';
    document.getElementById('matTicketCliente').textContent = cliente  || '—';
    document.getElementById('matTicketUsuario').textContent = usuario  || '—';

    const pEl = document.getElementById('matTicketPrioridad');
    if (prioridad) {
        const c = prioColor || '#7c3aed';
        pEl.innerHTML = `<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;background:${c}18;color:${c};border:1px solid ${c}30">
            <span style="width:6px;height:6px;border-radius:50%;background:${c};display:inline-block;"></span>${prioridad}</span>`;
    } else {
        pEl.textContent = '—';
    }

    // Resetear búsqueda y selección
    document.getElementById('matBuscarTecnico').value = '';
    document.getElementById('matBtnConfirmar').disabled = true;

    // Cargar técnicos desde el JSON global (ya pasado por PHP)
    matRenderTecnicos(window._matTecnicosAll);

    document.getElementById('modalAsignarTecnico').style.display = 'flex';
}

function cerrarModalAsignar() {
    document.getElementById('modalAsignarTecnico').style.display = 'none';
    window._matTicketId   = null;
    window._matTecnicoSel = null;
}

// ── Render lista de técnicos ──────────────────────────────────────
function matRenderTecnicos(lista) {
    const cont  = document.getElementById('matTecnicoList');
    const empty = document.getElementById('matTecnicoEmpty');

    if (!lista || lista.length === 0) {
        cont.innerHTML = '';
        empty.style.display = 'flex';
        return;
    }

    empty.style.display = 'none';
    cont.innerHTML = lista.map(t => {
        const iniciales = ((t.nombre || '?').charAt(0) + (t.apellido_paterno || '').charAt(0)).toUpperCase();
        const nombre    = (t.nombre || '') + ' ' + (t.apellido_paterno || '');
        const esSel     = window._matTecnicoSel == t.id_tecnico;
        return `
        <div class="mat-tecnico-item ${esSel ? 'mat-selected' : ''}"
             onclick="matSeleccionarTecnico(${t.id_tecnico}, this)"
             data-search="${(nombre + ' ' + (t.codigo_tecnico || '')).toLowerCase()}">
            <div class="mat-tec-avatar">${iniciales}</div>
            <div class="mat-tec-info">
                <div class="mat-tec-nombre">${nombre}</div>
                <div class="mat-tec-codigo">${t.codigo_tecnico || '—'}</div>
            </div>
            <div class="mat-check">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
        </div>`;
    }).join('');
}

// ── Seleccionar técnico ───────────────────────────────────────────
function matSeleccionarTecnico(idTecnico, el) {
    window._matTecnicoSel = idTecnico;

    document.querySelectorAll('.mat-tecnico-item').forEach(i => i.classList.remove('mat-selected'));
    el.classList.add('mat-selected');

    document.getElementById('matBtnConfirmar').disabled = false;
}

// ── Filtrar por búsqueda ──────────────────────────────────────────
function matFiltrarTecnicos() {
    const q     = document.getElementById('matBuscarTecnico').value.toLowerCase().trim();
    const items = document.querySelectorAll('.mat-tecnico-item');
    let   vis   = 0;

    items.forEach(item => {
        const match = item.dataset.search.includes(q);
        item.style.display = match ? '' : 'none';
        if (match) vis++;
    });

    document.getElementById('matTecnicoEmpty').style.display = vis === 0 ? 'flex' : 'none';
}

// ── Confirmar asignación ──────────────────────────────────────────
async function confirmarAsignacion() {
    const idTicket  = window._matTicketId;
    const idTecnico = window._matTecnicoSel;

    if (!idTicket || !idTecnico) return;

    const btn = document.getElementById('matBtnConfirmar');
    btn.disabled    = true;
    btn.textContent = 'Asignando…';

    try {
        const res  = await fetch(`/admin/ticket/${idTicket}/asignar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id_tecnico: idTecnico })
        });
        const data = await res.json();

        if (data.ok) {
            cerrarModalAsignar();

            // Notificación de éxito
            if (typeof showNotification === 'function') {
                showNotification('success', '¡Técnico asignado!', `El ticket pasó a estado PROGRAMADO.`);
            }

            // Actualizar en memoria el array de tickets para reflejar cambio sin reload
            if (typeof TICKETS_POR_USUARIO !== 'undefined' && window._matTicketUserId) {
                const lista = TICKETS_POR_USUARIO[window._matTicketUserId] || [];
                const t     = lista.find(x => x.id_ticket == idTicket);
                if (t) {
                    t.estado          = 'PROGRAMADO';
                    t.tecnico_nombre  = data.tecnico || '';
                }
                renderTickets(lista, filtroTicketActual);
            } else {
                setTimeout(() => location.reload(), 900);
            }
        } else {
            if (typeof showNotification === 'function') {
                showNotification('danger', 'Error', data.message || 'No se pudo asignar.');
            } else {
                alert(data.message || 'Error al asignar.');
            }
        }
    } catch (e) {
        if (typeof showNotification === 'function') {
            showNotification('danger', 'Error de conexión', 'No se pudo conectar con el servidor.');
        }
    } finally {
        btn.disabled    = false;
        btn.innerHTML   = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Confirmar asignación`;
    }
}
</script>