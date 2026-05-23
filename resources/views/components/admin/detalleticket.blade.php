{{-- ══ MODAL DETALLE TICKET ══ --}}
<div class="dtk-overlay" id="modalOverlay">
<div class="dtk-card" onclick="event.stopPropagation()">

    {{-- HEADER --}}
    <div class="dtk-header">
        <div class="dtk-header-left">
            <div class="dtk-header-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
            </div>
            <div>
                <div class="dtk-header-eyebrow">Detalle del ticket</div>
                <div id="modalCode" class="dtk-header-code"></div>
            </div>
        </div>
        <div class="dtk-header-right">
            <div id="modalEstado"></div>
            <button class="dtk-close-btn" onclick="closeModal()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>

    <div class="dtk-body">

        {{-- CLIENTE --}}
        <div class="dtk-section">
            <div class="dtk-section-header">
                <div class="dtk-section-icon dtk-icon-blue">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                </div>
                <span>Cliente</span>
            </div>
            <div class="dtk-row-2">
                <div class="dtk-field"><div class="dtk-label">Razón social</div><div id="mRazonSocial" class="dtk-val"></div></div>
                <div class="dtk-field"><div class="dtk-label">RUC</div><div id="mRuc" class="dtk-val dtk-mono"></div></div>
            </div>
        </div>

        {{-- USUARIO --}}
        <div class="dtk-section">
            <div class="dtk-section-header">
                <div class="dtk-section-icon dtk-icon-indigo">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <span>Usuario solicitante</span>
            </div>
            <div class="dtk-row-3">
                <div class="dtk-field"><div class="dtk-label">Nombre completo</div><div id="mUsuNombre" class="dtk-val"></div></div>
                <div class="dtk-field"><div class="dtk-label">Código usuario</div><div id="mUsuCodigo" class="dtk-val dtk-mono"></div></div>
                <div class="dtk-field"><div class="dtk-label">Teléfono</div><div id="mUsuTelefono" class="dtk-val dtk-mono"></div></div></div>
        </div>

        {{-- CLASIFICACIÓN --}}
        <div class="dtk-section">
            <div class="dtk-section-header">
                <div class="dtk-section-icon dtk-icon-violet">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                </div>
                <span>Clasificación</span>
            </div>
            <div class="dtk-row-2">
                <div class="dtk-field"><div class="dtk-label">Tipo de ticket</div><div id="mTipo" class="dtk-val"></div></div>
                <div class="dtk-field"><div class="dtk-label">Prioridad</div><div id="mPrioridad" class="dtk-val"></div></div>
            </div>
        </div>

        {{-- EQUIPO --}}
        <div class="dtk-section">
            <div class="dtk-section-header">
                <div class="dtk-section-icon dtk-icon-cyan">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <span>Equipo</span>
            </div>
            <div class="dtk-row-3">
                <div class="dtk-field"><div class="dtk-label">Tipo</div><div id="mTipoEquipo" class="dtk-val"></div></div>
                <div class="dtk-field"><div class="dtk-label">Marca</div><div id="mMarca" class="dtk-val"></div></div>
                <div class="dtk-field"><div class="dtk-label">Modelo</div><div id="mModelo" class="dtk-val"></div></div>
            </div>
            <div class="dtk-row-1" style="margin-top:10px;">
                <div class="dtk-field"><div class="dtk-label">Serie / Serial</div><div id="mSerial" class="dtk-val dtk-mono"></div></div>
            </div>
        </div>

        {{-- SOLICITUD --}}
        <div class="dtk-section">
            <div class="dtk-section-header">
                <div class="dtk-section-icon dtk-icon-blue">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <span>Solicitud</span>
            </div>
            <div class="dtk-field" style="margin-bottom:10px;"><div class="dtk-label">Asunto</div><div id="mAsunto" class="dtk-val"></div></div>
            <div class="dtk-field"><div class="dtk-label">Descripción del problema</div><div id="mProblema" class="dtk-val dtk-area"></div></div>
        </div>

        {{-- FECHAS --}}
        <div class="dtk-section">
            <div class="dtk-section-header">
                <div class="dtk-section-icon dtk-icon-green">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <span>Fechas</span>
            </div>
            <div class="dtk-dates-grid">
                <div class="dtk-date-item">
                    <div class="dtk-date-dot dtk-dot-blue"></div>
                    <div><div class="dtk-label">Creado</div><div id="mFechaCreado" class="dtk-date-val"></div></div>
                </div>
                <div class="dtk-date-item">
                    <div class="dtk-date-dot dtk-dot-violet"></div>
                    <div><div class="dtk-label">Programado</div><div id="mFechaProg" class="dtk-date-val"></div></div>
                </div>
                <div class="dtk-date-item">
                    <div class="dtk-date-dot dtk-dot-orange"></div>
                    <div><div class="dtk-label">En proceso</div><div id="mFechaProc" class="dtk-date-val"></div></div>
                </div>
                <div class="dtk-date-item">
                    <div class="dtk-date-dot dtk-dot-green"></div>
                    <div><div class="dtk-label">Resuelto</div><div id="mFechaRes" class="dtk-date-val"></div></div>
                </div>
            </div>
        </div>

        {{-- EVIDENCIA --}}
        <div class="dtk-section">
            <div class="dtk-section-header">
                <div class="dtk-section-icon dtk-icon-indigo">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                </div>
                <span>Evidencia</span>
            </div>
            <div id="mEvidencia" class="dtk-evidence-box"></div>
        </div>

        {{-- TÉCNICO — solo visible desde PROGRAMADO en adelante --}}
        <div class="dtk-section" id="sec-tecnico" style="display:none;">
            <div class="dtk-section-header">
                <div class="dtk-section-icon dtk-icon-orange">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                </div>
                <span>Técnico asignado</span>
            </div>
            <div class="dtk-row-2">
                <div class="dtk-field">
                    <div class="dtk-label">Nombre</div>
                    <div id="mTecnico" class="dtk-val"></div>
                </div>
                <div class="dtk-field">
                    <div class="dtk-label">Código</div>
                    <div id="mTecnicoCod" class="dtk-val dtk-mono"></div>
                </div>
            </div>
        </div>

        {{-- ACTIVIDAD DEL TÉCNICO — solo visible desde EN PROCESO en adelante --}}
        <div class="dtk-section" id="sec-proceso" style="display:none;">
            <div class="dtk-section-header">
                <div class="dtk-section-icon dtk-icon-orange">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <span>Actividad del técnico</span>
            </div>

            {{-- Primer comentario --}}
            <div id="sec-comentario-inicial" style="display:none; margin-bottom:14px;">
                <div class="dtk-label" style="margin-bottom:6px;">Primer comentario</div>
                <div id="mComentarioInicial" class="dtk-val dtk-area" style="white-space:pre-line;line-height:1.6;"></div>
                <div id="mComentarioInicialFecha" style="font-size:11px;color:#94a3b8;margin-top:4px;"></div>
            </div>

            {{-- Reporte técnico --}}
            <div id="sec-reporte" style="display:none; margin-bottom:14px;">
                <div class="dtk-label" style="margin-bottom:6px;">Reporte técnico</div>
                <div id="mReporteTecnico" class="dtk-evidence-box"></div>
            </div>

            {{-- Comentario final --}}
            <div id="sec-comentario-final" style="display:none;">
                <div class="dtk-label" style="margin-bottom:6px;">Comentario de cierre</div>
                <div id="mComentarioFinal" class="dtk-val dtk-area" style="white-space:pre-line;line-height:1.6;"></div>
                <div id="mComentarioFinalFecha" style="font-size:11px;color:#94a3b8;margin-top:4px;"></div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="dtk-footer">
            <button class="dtk-btn-ghost" onclick="closeModal()">Cerrar</button>
        </div>

    </div>
</div>
</div>

{{-- ── Lightbox ── --}}
<div id="dtkLightbox" onclick="closeLightbox()"
    style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:9999;align-items:center;justify-content:center;cursor:zoom-out;">
    <img id="dtkLightboxImg" src="" alt=""
        style="display:none;max-width:92vw;max-height:92vh;border-radius:12px;box-shadow:0 24px 80px rgba(0,0,0,.6);object-fit:contain;">
    <video id="dtkLightboxVideo" controls
        style="display:none;max-width:92vw;max-height:92vh;border-radius:12px;box-shadow:0 24px 80px rgba(0,0,0,.6);">
        <source id="dtkLightboxVideoSrc" src="">
    </video>
</div>

<style>
@keyframes dtkUp { from{opacity:0;transform:translateY(20px) scale(.98)} to{opacity:1;transform:translateY(0) scale(1)} }

.dtk-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(8,20,45,.6);
    backdrop-filter: blur(6px);
    z-index: 1000;
    align-items: center; justify-content: center;
    padding: 16px;
}
.dtk-card {
    background: #fff;
    border-radius: 20px;
    width: 660px; max-width: 100%; max-height: 92vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: dtkUp .25s cubic-bezier(.16,1,.3,1);
    box-shadow: 0 32px 80px rgba(8,20,45,.28), 0 0 0 1px rgba(255,255,255,.08);
}
.dtk-card::-webkit-scrollbar { width: 4px; }
.dtk-card::-webkit-scrollbar-thumb { background: #c8d8f0; border-radius: 99px; }

.dtk-header {
    background: linear-gradient(135deg, #0f4a8a 0%, #1a6ed8 50%, #0ea5e9 100%);
    padding: 20px 24px;
    display: flex; align-items: center; justify-content: space-between;
    border-radius: 20px 20px 0 0;
    position: sticky; top: 0; z-index: 2;
    flex-shrink: 0;
}
.dtk-header-left  { display: flex; align-items: center; gap: 14px; }
.dtk-header-right { display: flex; align-items: center; gap: 10px; }
.dtk-header-icon {
    width: 42px; height: 42px; border-radius: 12px;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.25);
    display: flex; align-items: center; justify-content: center;
    color: #fff; flex-shrink: 0;
}
.dtk-header-eyebrow { font-size: 10px; color: rgba(255,255,255,.6); letter-spacing: .1em; text-transform: uppercase; margin-bottom: 3px; }
.dtk-header-code    { font-size: 16px; font-weight: 700; color: #fff; font-family: 'Courier New', monospace; letter-spacing: .04em; }
.dtk-close-btn {
    width: 34px; height: 34px; border-radius: 10px;
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.2);
    color: #fff; display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .15s;
}
.dtk-close-btn:hover { background: rgba(255,255,255,.28); }

.dtk-body    { 
    padding: 6px 0 0;
    overflow-y: auto;      
    flex: 1;               
    scrollbar-width: thin;
    scrollbar-color: #c8d8f0 transparent; 
}

.dtk-body::-webkit-scrollbar {
    width: 4px;
}
.dtk-body::-webkit-scrollbar-thumb {
    background: #c8d8f0;
    border-radius: 99px;
}
.dtk-body::-webkit-scrollbar-track {
    background: transparent;
}

.dtk-section { padding: 18px 24px; border-bottom: 1px solid #f0f4fa; }
.dtk-section-header {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 14px;
    font-size: 11px; font-weight: 700; color: #1e3a5f;
    text-transform: uppercase; letter-spacing: .08em;
}
.dtk-section-icon {
    width: 24px; height: 24px; border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.dtk-icon-blue   { background: #dbeafe; color: #1d4ed8; }
.dtk-icon-indigo { background: #e0e7ff; color: #4338ca; }
.dtk-icon-violet { background: #ede9fe; color: #7c3aed; }
.dtk-icon-cyan   { background: #cffafe; color: #0e7490; }
.dtk-icon-green  { background: #dcfce7; color: #15803d; }
.dtk-icon-orange { background: #ffedd5; color: #c2410c; }

.dtk-row-1 { display: grid; grid-template-columns: 1fr; gap: 10px; }
.dtk-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.dtk-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }

.dtk-field { display: flex; flex-direction: column; gap: 5px; }
.dtk-label { font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .06em; }
.dtk-val {
    font-size: 13.5px; color: #0f2a4a;
    background: #f8fafd;
    border: 1px solid #e8eef8;
    border-radius: 10px;
    padding: 9px 13px;
    min-height: 38px;
    word-break: break-word; line-height: 1.5;
    transition: border-color .15s;
}
.dtk-val.dtk-empty::before { content: '—'; color: #c0cfe4; font-style: italic; }
.dtk-mono { font-family: 'Courier New', monospace; font-size: 12.5px; color: #1e4080; }
.dtk-area { min-height: 80px; }

.dtk-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 20px; }
.dtk-badge::before { content:''; width:7px; height:7px; border-radius:50%; }
.dtk-badge.pendiente  { background:#fef9c3; color:#854d0e; } .dtk-badge.pendiente::before  { background:#f59e0b; }
.dtk-badge.en_proceso { background:#dbeafe; color:#1e40af; } .dtk-badge.en_proceso::before { background:#3b82f6; }
.dtk-badge.resuelto   { background:#dcfce7; color:#14532d; } .dtk-badge.resuelto::before   { background:#22c55e; }
.dtk-badge.cancelado  { background:#fee2e2; color:#7f1d1d; } .dtk-badge.cancelado::before  { background:#ef4444; }
.dtk-badge.programado { background:#ede9fe; color:#4c1d95; } .dtk-badge.programado::before { background:#8b5cf6; }

.dtk-dates-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.dtk-date-item  { display: flex; align-items: flex-start; gap: 10px; background: #f8fafd; border: 1px solid #e8eef8; border-radius: 10px; padding: 10px 12px; }
.dtk-date-dot   { width: 8px; height: 8px; border-radius: 50%; margin-top: 4px; flex-shrink: 0; }
.dtk-dot-blue   { background: #3b82f6; box-shadow: 0 0 6px #3b82f680; }
.dtk-dot-violet { background: #8b5cf6; box-shadow: 0 0 6px #8b5cf680; }
.dtk-dot-orange { background: #f97316; box-shadow: 0 0 6px #f9731680; }
.dtk-dot-green  { background: #22c55e; box-shadow: 0 0 6px #22c55e80; }
.dtk-date-val   { font-size: 13px; font-weight: 600; color: #1e3a5f; margin-top: 2px; font-family: 'Courier New', monospace; }

.dtk-evidence-box {
    background: #f8fafd; border: 1px solid #e8eef8;
    border-radius: 12px; padding: 14px;
    min-height: 48px; display: flex; align-items: center; justify-content: center;
}
.dtk-evidence-box.dtk-empty-ev::before {
    content: '— Sin evidencia adjunta —';
    color: #c0cfe4; font-size: 13px; font-style: italic;
}
.dtk-ev-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 10px; width: 100%;
}
.dtk-ev-item {
    border: 1px solid #e8eef8; border-radius: 10px;
    overflow: hidden; background: #fff;
    display: flex; flex-direction: column; align-items: center;
}
.dtk-ev-thumb {
    width: 100%; height: 100px; object-fit: cover;
    cursor: zoom-in; transition: opacity .15s; display: block;
}
.dtk-ev-thumb:hover { opacity: .85; }
.dtk-ev-name {
    font-size: 10px; color: #64748b;
    padding: 6px 8px; text-align: center;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    width: 100%; box-sizing: border-box;
    border-top: 1px solid #f0f4fa;
}
.dtk-ev-file {
    width: 100%; height: 100px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 6px; color: #1a6ed8; text-decoration: none;
    background: #eff6ff; transition: background .15s;
}
.dtk-ev-file:hover { background: #dbeafe; }
.dtk-ev-file span  { font-size: 10px; font-weight: 600; text-transform: uppercase; color: #1e40af; }

.dtk-footer {
    display: flex; gap: 10px; justify-content: flex-end;
    padding: 16px 24px;
    border-top: 1px solid #f0f4fa;
    background: #fafbfd;
    border-radius: 0 0 20px 20px;
    position: sticky; bottom: 0;
}
.dtk-btn-ghost {
    background: transparent; border: 1px solid #d1dce8;
    color: #64748b; border-radius: 10px;
    padding: 9px 20px; font-size: 13px; font-weight: 500;
    cursor: pointer; transition: all .15s;
}
.dtk-btn-ghost:hover { background: #f1f5f9; border-color: #b0bec5; }
.dtk-btn-primary {
    background: linear-gradient(135deg, #1254a0, #1a6ed8);
    color: #fff; border: none; border-radius: 10px;
    padding: 9px 22px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: flex; align-items: center; gap: 7px;
    box-shadow: 0 4px 14px rgba(26,110,216,.35);
    transition: opacity .15s;
}
.dtk-btn-primary:hover { opacity: .9; }

@media (max-width: 540px) {
    .dtk-row-3, .dtk-row-2 { grid-template-columns: 1fr; }
    .dtk-dates-grid { grid-template-columns: 1fr; }
    .dtk-body, .dtk-section { padding-left: 14px; padding-right: 14px; }
}
@media (max-width: 380px) {
    .dtk-footer { flex-direction: column-reverse; }
    .dtk-btn-ghost, .dtk-btn-primary { width: 100%; justify-content: center; }
}
</style>
<script>
function secShow(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = 'block';
}

function secHide(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = 'none';
}

function dtkFill(id, valor) {
    const el = document.getElementById(id);
    if (!el) return;

    if (valor === null || valor === undefined || valor === '') {
        el.textContent = '—';
        el.classList.add('dtk-empty');
    } else {
        el.textContent = valor;
        el.classList.remove('dtk-empty');
    }
}

function closeModal() {
    const modal = document.getElementById('modalOverlay');
    if (modal) modal.style.display = 'none';
}

function closeLightbox() {
    const box = document.getElementById('dtkLightbox');
    if (box) box.style.display = 'none';
}

function renderEvidencias(id, evidencias) {
    const cont = document.getElementById(id);
    if (!cont) return;

    cont.innerHTML = '';
    cont.classList.remove('dtk-empty-ev');
    cont.style.alignItems     = 'center';
    cont.style.justifyContent = 'center';

    if (!evidencias || evidencias.length === 0) {
        cont.classList.add('dtk-empty-ev');
        return;
    }

    cont.style.alignItems     = 'stretch';
    cont.style.justifyContent = 'flex-start';

    let html = '<div class="dtk-ev-grid">';
    evidencias.forEach(ev => {
        const url    = '/storage/' + ev.ruta_archivo;
        const nombre = ev.nombre_original ?? 'Archivo';
        const ext    = ev.ruta_archivo.split('.').pop().toLowerCase();

        if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
            html += `
            <div class="dtk-ev-item">
                <img src="${url}" alt="${nombre}" class="dtk-ev-thumb"
                     onclick="openLightbox('${url}','image')">
                <div class="dtk-ev-name" title="${nombre}">${nombre}</div>
            </div>`;
        } else if (['mp4','mov','webm'].includes(ext)) {
            html += `
            <div class="dtk-ev-item">
                <video style="width:100%;height:100px;object-fit:cover;display:block;cursor:pointer;"
                       onclick="openLightbox('${url}','video')" muted>
                    <source src="${url}">
                </video>
                <div class="dtk-ev-name" title="${nombre}">${nombre}</div>
            </div>`;
        } else {
            html += `
            <div class="dtk-ev-item">
                <a href="${url}" target="_blank" class="dtk-ev-file">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    <span>${ext}</span>
                </a>
                <div class="dtk-ev-name" title="${nombre}">${nombre}</div>
            </div>`;
        }
    });
    html += '</div>';
    cont.innerHTML = html;
}
function openLightbox(url, type) {
    const lb    = document.getElementById('dtkLightbox');
    const img   = document.getElementById('dtkLightboxImg');
    const video = document.getElementById('dtkLightboxVideo');
    const vsrc  = document.getElementById('dtkLightboxVideoSrc');
    if (type === 'video') {
        img.style.display   = 'none';
        video.style.display = 'block';
        vsrc.src = url; video.load(); video.play();
    } else {
        video.pause(); video.style.display = 'none';
        img.style.display = 'block'; img.src = url;
    }
    lb.style.display = 'flex';
}
function renderReporte(reportes) {
    const cont = document.getElementById('mReporteTecnico');
    if (!cont) return;

    if (!reportes || reportes.length === 0) {
        cont.innerHTML = '—';
        return;
    }

    const ultimo = reportes[reportes.length - 1];
    cont.innerHTML = ultimo.reporte || ultimo.descripcion || '—';
}
</script>
<script>
    
// ── Abrir detalle ticket desde admin ─────────────────────────────
async function abrirDetalleTicket(id) {
    try {
        const res  = await fetch(`/admin/ticket/${id}/detalle`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Error al cargar');

        // Guardar id actual para editar/cancelar
        window._ticketActualId     = id;

        // Mostrar/ocultar botón editar según estado
        const btnEditar = document.getElementById('dtk-btn-editar');
        if (btnEditar) {
            btnEditar.style.display = data.estado === 'PENDIENTE' ? 'flex' : 'none';
        }

        // Llamar al openModal del modal base pasando los datos
        openModalConDatos(data);

    } catch(e) {
        showNotification('danger', 'Error', e.message);
    }
}

// ── openModal adaptado para recibir objeto directo ────────────────
function openModalConDatos(t) {
    const estado = t.estado ?? 'PENDIENTE';

    secHide('sec-tecnico');
    secHide('sec-proceso');
    secHide('sec-comentario-inicial');
    secHide('sec-reporte');
    secHide('sec-comentario-final');
    cerrarPanelEdicion();

    document.getElementById('modalCode').textContent = t.codigo_ticket ?? '—';

    const estadoMap = {
        'PENDIENTE':'pendiente','PROGRAMADO':'programado',
        'EN PROCESO':'en_proceso','CERRADO':'resuelto','CANCELADO':'cancelado'
    };
    document.getElementById('modalEstado').innerHTML =
        `<span class="dtk-badge ${estadoMap[estado] ?? 'pendiente'}">${estado}</span>`;

    dtkFill('mRazonSocial', t.razon_social);
    dtkFill('mRuc',         t.ruc);
    dtkFill('mUsuNombre',   t.usuario_nombre);
    dtkFill('mUsuCodigo',   t.codigo_usuario);
    dtkFill('mUsuTelefono', t.usuario_telefono);
    dtkFill('mTipo',        t.tipo_ticket_nombre);

    const pColor = t.prioridad_color ?? '#1a6ed8';
    document.getElementById('mPrioridad').innerHTML = t.prioridad_nombre
        ? `<span style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;background:${pColor}18;color:${pColor};border:1px solid ${pColor}30;">
               <span style="width:7px;height:7px;border-radius:50%;background:${pColor};display:inline-block;"></span>
               ${t.prioridad_nombre}</span>`
        : '<span style="color:#c0cfe4;font-style:italic;">—</span>';

    dtkFill('mTipoEquipo', t.tipo_equipo);
    dtkFill('mMarca',      t.marca);
    dtkFill('mModelo',     t.modelo);
    dtkFill('mSerial',     t.serie_serial);
    dtkFill('mAsunto',     t.asunto);
    dtkFill('mProblema',   t.problema);

    dtkFill('mFechaCreado', t.created_at?.substring(0,10)       ?? null);
    dtkFill('mFechaProg',   t.fecha_programado?.substring(0,10) ?? null);
    dtkFill('mFechaProc',   t.fecha_en_proceso?.substring(0,10) ?? null);
    dtkFill('mFechaRes',    t.fecha_resuelto?.substring(0,10)   ?? null);

    renderEvidencias('mEvidencia', t.evidencias ?? []);

    const fase = {'PENDIENTE':1,'PROGRAMADO':2,'EN PROCESO':3,'CERRADO':4,'CANCELADO':5}[estado] ?? 1;

    if (fase >= 2) {
        secShow('sec-tecnico');
        dtkFill('mTecnico',    t.tecnico_nombre);
        dtkFill('mTecnicoCod', t.tecnico_codigo);
    }
    if (fase >= 3) {
        const comentarios = t.comentarios ?? [];
        const reportes    = t.reportes    ?? [];
        let   hayAlgo     = false;
        if (comentarios.length >= 1) {
            secShow('sec-comentario-inicial');
            dtkFill('mComentarioInicial', comentarios[0].comentario);
            document.getElementById('mComentarioInicialFecha').textContent = comentarios[0].created_at?.substring(0,10) ?? '';
            hayAlgo = true;
        }
        if (reportes.length >= 1) { secShow('sec-reporte'); renderReporte(reportes); hayAlgo = true; }
        if (comentarios.length >= 2) {
            secShow('sec-comentario-final');
            const ultimo = comentarios[comentarios.length - 1];
            dtkFill('mComentarioFinal', ultimo.comentario);
            document.getElementById('mComentarioFinalFecha').textContent = ultimo.created_at?.substring(0,10) ?? '';
            hayAlgo = true;
        }
        if (hayAlgo) secShow('sec-proceso');
    }

    document.getElementById('modalOverlay').style.display = 'flex';
}

// ── Cancelar ticket ───────────────────────────────────────────────
function cancelarTicket(id) {
    const tickets = TICKETS_POR_USUARIO[usuarioActual] || [];
    const t = tickets.find(x => x.id_ticket == id);
    
    if (!t || t.estado !== 'PROGRAMADO') {
        alert('Solo se pueden cancelar tickets en estado PROGRAMADO.');
        return;
    }
    ModalSystem.show('confirm', {
        title:       '¿Cancelar este ticket?',
        text:        'Esta acción cambiará el estado a CANCELADO y no se puede revertir fácilmente.',
        confirmText: 'Sí, cancelar',
        cancelText:  'No',
        onConfirm: async () => {
            try {
                const res  = await fetch(`/admin/ticket/${id}/cancelar`, {
                    method:  'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();
                if (data.ok) {
                    showNotification('success','¡Listo!','Ticket cancelado correctamente.');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    showNotification('danger','Error', data.message || 'No se pudo cancelar.');
                }
            } catch(e) {
                showNotification('danger','Error de conexión','No se pudo conectar con el servidor.');
            }
        }
    });
}
</script>

{{-- Inserta el panel y el botón editar dentro del modal base --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Insertar panel de edición dentro del dtk-card
    const card = document.querySelector('.dtk-card');
    if (!card) return;

    card.style.position = 'relative';

});
</script>