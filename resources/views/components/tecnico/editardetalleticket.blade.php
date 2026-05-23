    {{-- ══ MODAL TÉCNICO: VER + EDITAR TICKET ══ --}}
    <div class="tec-overlay" id="tecModalOverlay">
    <div class="tec-card" onclick="event.stopPropagation()">

        {{-- HEADER --}}
        <div class="tec-header">
            <div class="tec-header-left">
                <div class="tec-header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
                </div>
                <div>
                    <div class="tec-header-eyebrow">Detalle del ticket</div>
                    <div id="tecModalCode" class="tec-header-code"></div>
                </div>
            </div>
            <div class="tec-header-right">
                <div id="tecModalEstado"></div>
                <button class="tec-close-btn" onclick="tecCloseModal()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
        </div>

        <div class="tec-body">

            {{-- CLIENTE (solo lectura) --}}
            <div class="tec-section">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-blue">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    </div>
                    <span>Cliente</span>
                </div>
                <div class="tec-row-2">
                    <div class="tec-field"><div class="tec-label">Razón social</div><div id="tecRazonSocial" class="tec-val"></div></div>
                    <div class="tec-field"><div class="tec-label">RUC</div><div id="tecRuc" class="tec-val tec-mono"></div></div>
                </div>
            </div>

            {{-- USUARIO (solo lectura) --}}
            <div class="tec-section">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-indigo">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <span>Usuario solicitante</span>
                </div>
                <div class="tec-row-3">
                    <div class="tec-field"><div class="tec-label">Nombre completo</div><div id="tecUsuNombre" class="tec-val"></div></div>
                    <div class="tec-field"><div class="tec-label">Código usuario</div><div id="tecUsuCodigo" class="tec-val tec-mono"></div></div>
                    <div class="tec-field"><div class="tec-label">Teléfono</div><div id="tecUsuTelefono" class="tec-val tec-mono"></div></div>
                </div>
            </div>

            {{-- CLASIFICACIÓN (solo lectura) --}}
            <div class="tec-section">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-violet">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    </div>
                    <span>Clasificación</span>
                </div>
                <div class="tec-row-2">
                    <div class="tec-field"><div class="tec-label">Tipo de ticket</div><div id="tecTipo" class="tec-val"></div></div>
                    <div class="tec-field"><div class="tec-label">Prioridad</div><div id="tecPrioridad" class="tec-val"></div></div>
                </div>
            </div>

            {{-- EQUIPO (editable) --}}
            <div class="tec-section">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-cyan">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <span>Equipo</span>
                    <span class="tec-edit-badge">✏️ Editable</span>
                </div>
                <div class="tec-row-3">
                    <div class="tec-field">
                        <div class="tec-label">Tipo</div>
                        <input type="text" id="tecInpTipoEquipo" class="tec-input" placeholder="Tipo de equipo">
                    </div>
                    <div class="tec-field">
                        <div class="tec-label">Marca</div>
                        <input type="text" id="tecInpMarca" class="tec-input" placeholder="Marca">
                    </div>
                    <div class="tec-field">
                        <div class="tec-label">Modelo</div>
                        <input type="text" id="tecInpModelo" class="tec-input" placeholder="Modelo">
                    </div>
                </div>
                <div class="tec-row-1" style="margin-top:10px;">
                    <div class="tec-field">
                        <div class="tec-label">Serie / Serial</div>
                        <input type="text" id="tecInpSerial" class="tec-input tec-mono" placeholder="Número de serie">
                    </div>
                </div>
            </div>

            {{-- SOLICITUD (editable) --}}
            <div class="tec-section">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-blue">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <span>Solicitud</span>
                    <span class="tec-edit-badge">✏️ Editable</span>
                </div>
                <div class="tec-field" style="margin-bottom:10px;">
                    <div class="tec-label">Asunto</div>
                    <input type="text" id="tecInpAsunto" class="tec-input" placeholder="Asunto del ticket">
                </div>
                <div class="tec-field">
                    <div class="tec-label">Descripción del problema</div>
                    <textarea id="tecInpProblema" class="tec-textarea" placeholder="Describe el problema aquí..." rows="4"></textarea>
                </div>
                <div style="margin-top:12px;display:flex;justify-content:flex-end;">
                    <button class="tec-btn-save-fields" onclick="tecGuardarCampos()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Guardar cambios
                    </button>
                </div>
            </div>

            {{-- FECHAS (solo lectura) --}}
            <div class="tec-section">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-green">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <span>Fechas</span>
                </div>
                <div class="tec-dates-grid">
                    <div class="tec-date-item"><div class="tec-date-dot tec-dot-blue"></div><div><div class="tec-label">Creado</div><div id="tecFechaCreado" class="tec-date-val"></div></div></div>
                    <div class="tec-date-item"><div class="tec-date-dot tec-dot-violet"></div><div><div class="tec-label">Programado</div><div id="tecFechaProg" class="tec-date-val"></div></div></div>
                    <div class="tec-date-item"><div class="tec-date-dot tec-dot-orange"></div><div><div class="tec-label">En proceso</div><div id="tecFechaProc" class="tec-date-val"></div></div></div>
                    <div class="tec-date-item"><div class="tec-date-dot tec-dot-green"></div><div><div class="tec-label">Resuelto</div><div id="tecFechaRes" class="tec-date-val"></div></div></div>
                </div>
            </div>

            {{-- EVIDENCIA (solo lectura) --}}
            <div class="tec-section">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-indigo">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    </div>
                    <span>Evidencia del cliente</span>
                </div>
                <div id="tecEvidencia" class="tec-evidence-box"></div>
            </div>

            {{-- TÉCNICO ASIGNADO (solo lectura) --}}
            <div class="tec-section" id="tec-sec-tecnico" style="display:none;">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-orange">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                    </div>
                    <span>Técnico asignado</span>
                </div>
                <div class="tec-row-2">
                    <div class="tec-field"><div class="tec-label">Nombre</div><div id="tecTecnico" class="tec-val"></div></div>
                    <div class="tec-field"><div class="tec-label">Código</div><div id="tecTecnicoCod" class="tec-val tec-mono"></div></div>
                </div>
            </div>

            {{-- ACTIVIDAD TÉCNICA --}}
            <div class="tec-section" id="tec-sec-actividad" style="display:none;">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-orange">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <span>Actividad del técnico</span>
                </div>

                {{-- Comentarios existentes --}}
                <div id="tec-comentarios-lista" style="margin-bottom:14px;"></div>

                {{-- Reporte técnico existente --}}
                <div id="tec-reporte-existente" style="display:none;margin-bottom:14px;">
                    <div class="tec-label" style="margin-bottom:6px;">Reporte técnico adjunto</div>
                    <div id="tec-reporte-contenido" class="tec-evidence-box"></div>
                </div>
            </div>

            {{-- AGREGAR COMENTARIO --}}
            <div class="tec-section" id="tec-sec-nuevo-comentario" style="display:none;">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-cyan">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    </div>
                    <span>Agregar comentario</span>
                </div>
                <textarea id="tecNuevoComentario" class="tec-textarea" placeholder="Escribe un comentario sobre el ticket..." rows="3"></textarea>
                <div style="margin-top:10px;display:flex;justify-content:flex-end;">
                    <button class="tec-btn-comment" onclick="tecGuardarComentario()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg>
                        Agregar comentario
                    </button>
                </div>
            </div>

            {{-- REPORTE TÉCNICO (upload — solo 1) --}}
            <div class="tec-section" id="tec-sec-reporte-upload" style="display:none;">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-violet">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    </div>
                    <span>Reporte técnico</span>
                    <span style="font-size:10px;color:#64748b;font-weight:400;">(solo 1 archivo — foto o PDF)</span>
                </div>
                <div class="tec-upload-zone" id="tecUploadZone" onclick="document.getElementById('tecArchivoReporte').click()">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:#94a3b8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <span id="tecUploadLabel">Haz clic para subir imagen o PDF</span>
                    <span style="font-size:11px;color:#b0bec5;">JPG, PNG, PDF (máx. 5 MB)</span>
                </div>
                <input type="file" id="tecArchivoReporte" accept="image/*,.pdf" style="display:none" onchange="tecPreviewReporte(this)">
                <div id="tecReportePreview" style="display:none;margin-top:10px;"></div>
                <div style="margin-top:10px;display:flex;justify-content:flex-end;">
                    <button class="tec-btn-upload" onclick="tecSubirReporte()" id="tecBtnSubirReporte" disabled>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Subir reporte
                    </button>
                </div>
            </div>

            {{-- ACCIONES PRINCIPALES --}}
            <div class="tec-section" id="tec-sec-acciones" style="display:none;">
                <div class="tec-section-header">
                    <div class="tec-section-icon tec-icon-green">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <span>Acciones del ticket</span>
                </div>
                <div class="tec-acciones-grid">
                    <button class="tec-btn-cerrar" id="tecBtnCerrar" onclick="tecCerrarTicket()">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Cerrar ticket
                    </button>
                    <button class="tec-btn-cancelar-ticket" onclick="tecCancelarTicket()">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        Cancelar ticket
                    </button>
                </div>
                <div id="tec-cierre-aviso" class="tec-aviso-reporte" style="display:none;">
                    ⚠️ Para cerrar el ticket debes subir primero el reporte técnico.
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="tec-footer">
                <button class="tec-btn-ghost" onclick="tecCloseModal()">Cerrar</button>
            </div>

        </div>
    </div>
    </div>

    {{-- ── Lightbox técnico ── --}}
    <div id="tecLightbox" onclick="tecCloseLightbox()"
        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:9999;align-items:center;justify-content:center;cursor:zoom-out;">
        <img id="tecLightboxImg" src="" alt=""
            style="display:none;max-width:92vw;max-height:92vh;border-radius:12px;box-shadow:0 24px 80px rgba(0,0,0,.6);object-fit:contain;">
    </div>

    <style>
    @keyframes tecUp { from{opacity:0;transform:translateY(20px) scale(.98)} to{opacity:1;transform:translateY(0) scale(1)} }

    .tec-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(8,20,45,.6);
        backdrop-filter: blur(6px);
        z-index: 1100;
        align-items: center; justify-content: center;
        padding: 16px;
    }
    .tec-card {
        background: #fff;
        border-radius: 20px;
        width: 680px; max-width: 100%; max-height: 93vh;
        animation: tecUp .25s cubic-bezier(.16,1,.3,1);
        box-shadow: 0 32px 80px rgba(8,20,45,.28), 0 0 0 1px rgba(255,255,255,.08);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .tec-card::-webkit-scrollbar { width: 4px; }
    .tec-card::-webkit-scrollbar-thumb { background: #c8d8f0; border-radius: 99px; }

    .tec-header {
        background: linear-gradient(135deg, #0f4a8a 0%, #1a6ed8 50%, #0ea5e9 100%);
        padding: 20px 24px;
        display: flex; align-items: center; justify-content: space-between;
        flex-shrink: 0;
        border-radius: 20px 20px 0 0;
        position: sticky; top: 0; z-index: 2;
    }
    .tec-header-left  { display: flex; align-items: center; gap: 14px; }
    .tec-header-right { display: flex; align-items: center; gap: 10px; }
    .tec-header-icon {
        width: 42px; height: 42px; border-radius: 12px;
        background: rgba(255,255,255,.18);
        border: 1px solid rgba(255,255,255,.25);
        display: flex; align-items: center; justify-content: center;
        color: #fff; flex-shrink: 0;
    }
    .tec-header-eyebrow { font-size: 10px; color: rgba(255,255,255,.6); letter-spacing: .1em; text-transform: uppercase; margin-bottom: 3px; }
    .tec-header-code    { font-size: 16px; font-weight: 700; color: #fff; font-family: 'Courier New', monospace; letter-spacing: .04em; }
    .tec-close-btn {
        width: 34px; height: 34px; border-radius: 10px;
        background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.2);
        color: #fff; display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background .15s;
    }
    .tec-close-btn:hover { background: rgba(255,255,255,.28); }

    .tec-body    { 
        padding: 6px 0 0;
        overflow-y: auto;
        flex: 1;
        scrollbar-width: thin;
        scrollbar-color: #c8d8f0 transparent;
    }

    .tec-body::-webkit-scrollbar {
        width: 4px;
    }
    .tec-body::-webkit-scrollbar-thumb {
        background: #c8d8f0;
        border-radius: 99px;
    }
    .tec-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .tec-section { padding: 18px 24px; border-bottom: 1px solid #f0f4fa; }
    .tec-section-header {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 14px;
        font-size: 11px; font-weight: 700; color: #1e3a5f;
        text-transform: uppercase; letter-spacing: .08em;
    }
    .tec-section-icon {
        width: 24px; height: 24px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .tec-icon-blue   { background: #dbeafe; color: #1d4ed8; }
    .tec-icon-indigo { background: #e0e7ff; color: #4338ca; }
    .tec-icon-violet { background: #ede9fe; color: #7c3aed; }
    .tec-icon-cyan   { background: #cffafe; color: #0e7490; }
    .tec-icon-green  { background: #dcfce7; color: #15803d; }
    .tec-icon-orange { background: #ffedd5; color: #c2410c; }

    .tec-edit-badge {
        font-size: 9px; background: #fef9c3; color: #854d0e;
        border: 1px solid #fde68a; border-radius: 20px;
        padding: 2px 8px; font-weight: 600; margin-left: 4px;
        text-transform: none; letter-spacing: 0;
    }

    .tec-row-1 { display: grid; grid-template-columns: 1fr; gap: 10px; }
    .tec-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .tec-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }

    .tec-field { display: flex; flex-direction: column; gap: 5px; }
    .tec-label { font-size: 10px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: .06em; }
    .tec-val {
        font-size: 13.5px; color: #0f2a4a;
        background: #f8fafd; border: 1px solid #e8eef8;
        border-radius: 10px; padding: 9px 13px;
        min-height: 38px; word-break: break-word; line-height: 1.5;
    }
    .tec-mono { font-family: 'Courier New', monospace; font-size: 12.5px; color: #1e4080; }

    .tec-input {
        font-size: 13.5px; color: #0f2a4a;
        background: #fff; border: 1.5px solid #c7d8f0;
        border-radius: 10px; padding: 9px 13px;
        min-height: 38px; width: 100%; box-sizing: border-box;
        outline: none; transition: border-color .15s, box-shadow .15s;
        font-family: inherit;
    }
    .tec-input:focus { border-color: #1a6ed8; box-shadow: 0 0 0 3px rgba(26,110,216,.12); }
    .tec-input.tec-mono { font-family: 'Courier New', monospace; }

    .tec-textarea {
        font-size: 13px; color: #0f2a4a;
        background: #fff; border: 1.5px solid #c7d8f0;
        border-radius: 10px; padding: 10px 13px;
        width: 100%; box-sizing: border-box;
        outline: none; resize: vertical; min-height: 90px;
        font-family: inherit; line-height: 1.6;
        transition: border-color .15s, box-shadow .15s;
    }
    .tec-textarea:focus { border-color: #1a6ed8; box-shadow: 0 0 0 3px rgba(26,110,216,.12); }

    .tec-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 20px; }
    .tec-badge::before { content:''; width:7px; height:7px; border-radius:50%; }
    .tec-badge.pendiente  { background:#fef9c3; color:#854d0e; } .tec-badge.pendiente::before  { background:#f59e0b; }
    .tec-badge.en_proceso { background:#dbeafe; color:#1e40af; } .tec-badge.en_proceso::before { background:#3b82f6; }
    .tec-badge.resuelto   { background:#dcfce7; color:#14532d; } .tec-badge.resuelto::before   { background:#22c55e; }
    .tec-badge.cancelado  { background:#fee2e2; color:#7f1d1d; } .tec-badge.cancelado::before  { background:#ef4444; }
    .tec-badge.programado { background:#ede9fe; color:#4c1d95; } .tec-badge.programado::before { background:#8b5cf6; }

    .tec-dates-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .tec-date-item  { display: flex; align-items: flex-start; gap: 10px; background: #f8fafd; border: 1px solid #e8eef8; border-radius: 10px; padding: 10px 12px; }
    .tec-date-dot   { width: 8px; height: 8px; border-radius: 50%; margin-top: 4px; flex-shrink: 0; }
    .tec-dot-blue   { background: #3b82f6; box-shadow: 0 0 6px #3b82f680; }
    .tec-dot-violet { background: #8b5cf6; box-shadow: 0 0 6px #8b5cf680; }
    .tec-dot-orange { background: #f97316; box-shadow: 0 0 6px #f9731680; }
    .tec-dot-green  { background: #22c55e; box-shadow: 0 0 6px #22c55e80; }
    .tec-date-val   { font-size: 13px; font-weight: 600; color: #1e3a5f; margin-top: 2px; font-family: 'Courier New', monospace; }

    .tec-evidence-box {
        background: #f8fafd; border: 1px solid #e8eef8;
        border-radius: 12px; padding: 14px;
        min-height: 48px; display: flex; align-items: center; justify-content: center;
    }
    .tec-evidence-box.tec-empty-ev::before {
        content: '— Sin evidencia adjunta —';
        color: #c0cfe4; font-size: 13px; font-style: italic;
    }
    .tec-ev-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 10px; width: 100%;
    }
    .tec-ev-item {
        border: 1px solid #e8eef8; border-radius: 10px;
        overflow: hidden; background: #fff;
        display: flex; flex-direction: column; align-items: center;
    }
    .tec-ev-thumb { width: 100%; height: 90px; object-fit: cover; cursor: zoom-in; display: block; }
    .tec-ev-name {
        font-size: 10px; color: #64748b; padding: 5px 8px;
        text-align: center; white-space: nowrap; overflow: hidden;
        text-overflow: ellipsis; width: 100%; box-sizing: border-box;
        border-top: 1px solid #f0f4fa;
    }
    .tec-ev-file {
        width: 100%; height: 90px; display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 5px;
        color: #1a6ed8; text-decoration: none; background: #eff6ff;
    }
    .tec-ev-file span { font-size: 10px; font-weight: 600; text-transform: uppercase; color: #1e40af; }

    /* Comentarios lista */
    .tec-comentario-item {
        background: #f8fafd; border: 1px solid #e8eef8; border-radius: 10px;
        padding: 12px 14px; margin-bottom: 8px;
    }
    .tec-comentario-texto { font-size: 13px; color: #1e3a5f; line-height: 1.6; white-space: pre-line; }
    .tec-comentario-fecha { font-size: 11px; color: #94a3b8; margin-top: 6px; }

    /* Upload zone */
    .tec-upload-zone {
        border: 2px dashed #c7d8f0; border-radius: 12px;
        padding: 24px; text-align: center;
        cursor: pointer; transition: border-color .15s, background .15s;
        display: flex; flex-direction: column; align-items: center; gap: 8px;
        color: #94a3b8; font-size: 13px;
    }
    .tec-upload-zone:hover { border-color: #1a6ed8; background: #f0f7ff; color: #1a6ed8; }

    /* Buttons */
    .tec-btn-save-fields {
        background: linear-gradient(135deg, #0f4a8a, #1a6ed8);
        color: #fff; border: none; border-radius: 10px;
        padding: 9px 20px; font-size: 13px; font-weight: 600;
        cursor: pointer; display: flex; align-items: center; gap: 7px;
        box-shadow: 0 4px 12px rgba(26,110,216,.3); transition: opacity .15s;
    }
    .tec-btn-save-fields:hover { opacity: .88; }

    .tec-btn-comment {
        background: linear-gradient(135deg, #0e7490, #0ea5e9);
        color: #fff; border: none; border-radius: 10px;
        padding: 9px 20px; font-size: 13px; font-weight: 600;
        cursor: pointer; display: flex; align-items: center; gap: 7px;
        box-shadow: 0 4px 12px rgba(14,165,233,.3); transition: opacity .15s;
    }
    .tec-btn-comment:hover { opacity: .88; }

    .tec-btn-upload {
        background: linear-gradient(135deg, #4338ca, #7c3aed);
        color: #fff; border: none; border-radius: 10px;
        padding: 9px 20px; font-size: 13px; font-weight: 600;
        cursor: pointer; display: flex; align-items: center; gap: 7px;
        box-shadow: 0 4px 12px rgba(124,58,237,.3); transition: opacity .15s;
    }
    .tec-btn-upload:hover:not(:disabled) { opacity: .88; }
    .tec-btn-upload:disabled { opacity: .45; cursor: not-allowed; }

    .tec-acciones-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .tec-btn-cerrar {
        background: linear-gradient(135deg, #15803d, #22c55e);
        color: #fff; border: none; border-radius: 10px;
        padding: 12px 20px; font-size: 13px; font-weight: 600;
        cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 7px;
        box-shadow: 0 4px 12px rgba(34,197,94,.3); transition: opacity .15s;
    }
    .tec-btn-cerrar:hover:not(:disabled) { opacity: .88; }
    .tec-btn-cerrar:disabled { opacity: .45; cursor: not-allowed; }

    .tec-btn-cancelar-ticket {
        background: transparent; border: 1.5px solid #fca5a5;
        color: #dc2626; border-radius: 10px;
        padding: 12px 20px; font-size: 13px; font-weight: 600;
        cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 7px;
        transition: all .15s;
    }
    .tec-btn-cancelar-ticket:hover { background: #fee2e2; }

    .tec-aviso-reporte {
        margin-top: 12px; padding: 10px 14px;
        background: #fef9c3; border: 1px solid #fde68a;
        border-radius: 8px; font-size: 12px; color: #854d0e; font-weight: 500;
    }

    .tec-footer {
        display: flex; gap: 10px; justify-content: flex-end;
        padding: 16px 24px;
        border-top: 1px solid #f0f4fa;
        background: #fafbfd;
        border-radius: 0 0 20px 20px;
        position: sticky; bottom: 0;
    }
    .tec-btn-ghost {
        background: transparent; border: 1px solid #d1dce8;
        color: #64748b; border-radius: 10px;
        padding: 9px 20px; font-size: 13px; font-weight: 500;
        cursor: pointer; transition: all .15s;
    }
    .tec-btn-ghost:hover { background: #f1f5f9; border-color: #b0bec5; }

    /* Reporte preview */
    .tec-reporte-preview-item {
        display: flex; align-items: center; gap: 12px;
        background: #f0f7ff; border: 1px solid #bfdbfe;
        border-radius: 10px; padding: 10px 14px;
    }
    .tec-reporte-preview-item img { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; }
    .tec-reporte-preview-item .tec-rp-name { font-size: 12px; font-weight: 600; color: #1e40af; }
    .tec-reporte-preview-item .tec-rp-size { font-size: 11px; color: #64748b; }

    @media (max-width: 540px) {
        .tec-row-3, .tec-row-2 { grid-template-columns: 1fr; }
        .tec-dates-grid { grid-template-columns: 1fr; }
        .tec-section { padding-left: 14px; padding-right: 14px; }
        .tec-acciones-grid { grid-template-columns: 1fr; }
    }
    </style>

    <script>
    // ── Estado global del modal técnico ─────────────────────────────
    window._tecTicketId   = null;
    window._tecTienReporte = false;

    // ── Abrir modal técnico ──────────────────────────────────────────
    async function abrirDetalleTicket(id) {
        try {
            const res  = await fetch(`/tecnico/ticket/${id}/detalle`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || 'Error al cargar');

            window._tecTicketId = id;
            tecLlenarModal(data);

        } catch(e) {
            tecNotif('danger', 'Error', e.message);
        }
    }

    // ── Llenar modal con datos ───────────────────────────────────────
    function tecLlenarModal(t) {
        const estado = t.estado ?? 'PENDIENTE';
        const estadoMap = {
            'PENDIENTE':'pendiente','PROGRAMADO':'programado',
            'EN PROCESO':'en_proceso','CERRADO':'resuelto','CANCELADO':'cancelado'
        };
        const fase = {'PENDIENTE':1,'PROGRAMADO':2,'EN PROCESO':3,'CERRADO':4,'CANCELADO':5}[estado] ?? 1;
        const esFinal = ['CERRADO','CANCELADO'].includes(estado);

        // Código y estado
        document.getElementById('tecModalCode').textContent = t.codigo_ticket ?? '—';
        document.getElementById('tecModalEstado').innerHTML =
            `<span class="tec-badge ${estadoMap[estado] ?? 'pendiente'}">${estado}</span>`;

        // Solo lectura
        tecFill('tecRazonSocial', t.razon_social);
        tecFill('tecRuc',         t.ruc);
        tecFill('tecUsuNombre',   t.usuario_nombre);
        tecFill('tecUsuCodigo',   t.codigo_usuario);
        tecFill('tecUsuTelefono', t.usuario_telefono);
        tecFill('tecTipo',        t.tipo_ticket_nombre);

        const pColor = t.prioridad_color ?? '#1a6ed8';
        document.getElementById('tecPrioridad').innerHTML = t.prioridad_nombre
            ? `<span style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;background:${pColor}18;color:${pColor};border:1px solid ${pColor}30;">
                <span style="width:7px;height:7px;border-radius:50%;background:${pColor};display:inline-block;"></span>
                ${t.prioridad_nombre}</span>`
            : '<span style="color:#c0cfe4;font-style:italic;">—</span>';

        // Fechas
        tecFillDate('tecFechaCreado', t.created_at);
        tecFillDate('tecFechaProg',   t.fecha_programado);
        tecFillDate('tecFechaProc',   t.fecha_en_proceso);
        tecFillDate('tecFechaRes',    t.fecha_resuelto);

        // Campos editables equipo/solicitud
        document.getElementById('tecInpTipoEquipo').value = t.tipo_equipo   ?? '';
        document.getElementById('tecInpMarca').value      = t.marca          ?? '';
        document.getElementById('tecInpModelo').value     = t.modelo         ?? '';
        document.getElementById('tecInpSerial').value     = t.serie_serial   ?? '';
        document.getElementById('tecInpAsunto').value     = t.asunto         ?? '';
        document.getElementById('tecInpProblema').value   = t.problema       ?? '';

        // Desactivar edición si ticket ya cerrado/cancelado
        ['tecInpTipoEquipo','tecInpMarca','tecInpModelo','tecInpSerial','tecInpAsunto','tecInpProblema'].forEach(id => {
            document.getElementById(id).disabled = esFinal;
        });

        // Evidencias cliente
        tecRenderEvidencias('tecEvidencia', t.evidencias ?? []);

        // Sección técnico
        if (fase >= 2) {
            document.getElementById('tec-sec-tecnico').style.display = 'block';
            tecFill('tecTecnico',    t.tecnico_nombre);
            tecFill('tecTecnicoCod', t.tecnico_codigo);
        } else {
            document.getElementById('tec-sec-tecnico').style.display = 'none';
        }

        // Actividad existente
        const comentarios = t.comentarios ?? [];
        const reportes    = t.reportes    ?? [];
        window._tecTieneReporte = reportes.length > 0;

        if (fase >= 3 && (comentarios.length > 0 || reportes.length > 0)) {
            document.getElementById('tec-sec-actividad').style.display = 'block';
            tecRenderComentariosLista(comentarios);
            if (reportes.length > 0) {
                document.getElementById('tec-reporte-existente').style.display = 'block';
                tecRenderReporteExistente(reportes[reportes.length - 1]);
            } else {
                document.getElementById('tec-reporte-existente').style.display = 'none';
            }
        } else {
            document.getElementById('tec-sec-actividad').style.display = 'none';
        }

        // Acciones interactivas: solo si no está cerrado/cancelado y hay técnico
    if (!esFinal && fase >= 2) {
        document.getElementById('tec-sec-nuevo-comentario').style.display = 'block';
        document.getElementById('tec-sec-acciones').style.display         = 'block';

        // Botón cancelar: solo visible en estado PROGRAMADO
        const btnCancelar = document.querySelector('.tec-btn-cancelar-ticket');
        if (btnCancelar) {
            btnCancelar.style.display = estado === 'PROGRAMADO' ? 'flex' : 'none';
        }

        // Reporte upload: solo si aún no tiene uno
        if (!window._tecTieneReporte) {
            document.getElementById('tec-sec-reporte-upload').style.display = 'block';
            document.getElementById('tecBtnCerrar').disabled                = true;
            document.getElementById('tec-cierre-aviso').style.display       = 'block';
        } else {
            document.getElementById('tec-sec-reporte-upload').style.display = 'none';
            document.getElementById('tecBtnCerrar').disabled                = false;
            document.getElementById('tec-cierre-aviso').style.display       = 'none';
        }

    } else {
        document.getElementById('tec-sec-nuevo-comentario').style.display = 'none';
        document.getElementById('tec-sec-reporte-upload').style.display   = 'none';
        document.getElementById('tec-sec-acciones').style.display         = 'none';
    }

        // Limpiar campos de ingreso
        document.getElementById('tecNuevoComentario').value = '';
        document.getElementById('tecArchivoReporte').value  = '';
        document.getElementById('tecReportePreview').style.display = 'none';
        document.getElementById('tecBtnSubirReporte').disabled = true;
        document.getElementById('tecUploadLabel').textContent = 'Haz clic para subir imagen o PDF';

        document.getElementById('tecModalOverlay').style.display = 'flex';
    }

    // ── Guardar cambios equipo + solicitud ───────────────────────────
    async function tecGuardarCampos() {
        const id = window._tecTicketId;
        const body = {
            tipo_equipo:  document.getElementById('tecInpTipoEquipo').value.trim(),
            marca:        document.getElementById('tecInpMarca').value.trim(),
            modelo:       document.getElementById('tecInpModelo').value.trim(),
            serie_serial: document.getElementById('tecInpSerial').value.trim(),
            asunto:       document.getElementById('tecInpAsunto').value.trim(),
            problema:     document.getElementById('tecInpProblema').value.trim(),
        };

        try {
            const res  = await fetch(`/tecnico/ticket/${id}/editar-campos`, {
                method:  'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
                },
                body: JSON.stringify(body)
            });
            const data = await res.json();
            if (data.ok) {
                tecNotif('success', '¡Guardado!', 'Campos actualizados y ticket en proceso.');
                setTimeout(() => abrirDetalleTicket(id), 900);
            } else {
                tecNotif('danger', 'Error', data.message || 'No se pudo guardar.');
            }
        } catch(e) {
            tecNotif('danger', 'Error de conexión', e.message);
        }
    }

    // ── Guardar comentario ───────────────────────────────────────────
    async function tecGuardarComentario() {
        const id         = window._tecTicketId;
        const comentario = document.getElementById('tecNuevoComentario').value.trim();

        if (!comentario) {
            tecNotif('warning', 'Atención', 'Escribe un comentario antes de guardar.');
            return;
        }

        try {
            const res  = await fetch(`/tecnico/ticket/${id}/comentario`, {
                method:  'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
                },
                body: JSON.stringify({ comentario })
            });
            const data = await res.json();
            if (data.ok) {
                tecNotif('success', '¡Listo!', 'Comentario agregado y ticket en proceso.');
                setTimeout(() => abrirDetalleTicket(id), 900);
            } else {
                tecNotif('danger', 'Error', data.message || 'No se pudo guardar.');
            }
        } catch(e) {
            tecNotif('danger', 'Error', e.message);
        }
    }

    // ── Preview reporte ──────────────────────────────────────────────
    function tecPreviewReporte(input) {
        const file    = input.files[0];
        const preview = document.getElementById('tecReportePreview');
        const btn     = document.getElementById('tecBtnSubirReporte');
        const label   = document.getElementById('tecUploadLabel');

        if (!file) { preview.style.display = 'none'; btn.disabled = true; return; }

        const sizeMB = (file.size / 1024 / 1024).toFixed(2);
        label.textContent = file.name;

        let previewHTML = `<div class="tec-reporte-preview-item">`;
        if (file.type.startsWith('image/')) {
            const url = URL.createObjectURL(file);
            previewHTML += `<img src="${url}" alt="preview">`;
        } else {
            previewHTML += `<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>`;
        }
        previewHTML += `<div><div class="tec-rp-name">${file.name}</div><div class="tec-rp-size">${sizeMB} MB</div></div></div>`;
        preview.innerHTML = previewHTML;
        preview.style.display = 'block';
        btn.disabled = false;
    }

    // ── Subir reporte técnico ────────────────────────────────────────
    async function tecSubirReporte() {
        const id   = window._tecTicketId;
        const file = document.getElementById('tecArchivoReporte').files[0];

        if (!file) { tecNotif('warning', 'Atención', 'Selecciona un archivo primero.'); return; }

        const formData = new FormData();
        formData.append('archivo', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content ?? '');

        try {
            const res  = await fetch(`/tecnico/ticket/${id}/reporte`, {
                method: 'POST',
                body:   formData
            });
            const data = await res.json();
            if (data.ok) {
                tecNotif('success', '¡Subido!', 'Reporte técnico guardado y ticket en proceso.');
                setTimeout(() => abrirDetalleTicket(id), 900);
            } else {
                tecNotif('danger', 'Error', data.message || 'No se pudo subir.');
            }
        } catch(e) {
            tecNotif('danger', 'Error', e.message);
        }
    }

    // ── Cerrar ticket ────────────────────────────────────────────────
    async function tecCerrarTicket() {
        ModalSystem.show('question', {
            title: '¿Cerrar ticket?',
            text: '¿Estás seguro de marcar este ticket como RESUELTO?',
            confirmText: 'Sí, cerrar',
            cancelText: 'No, mantener',
            onConfirm: async () => {
                const id = window._tecTicketId;
                try {
                    const res = await fetch(`/tecnico/ticket/${id}/cerrar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
                        }
                    });
                    const data = await res.json();
                    if (data.ok) {
                        tecNotif('success', '¡Cerrado!', 'El ticket ha sido marcado como CERRADO.');
                        setTimeout(() => { tecCloseModal(); location.reload(); }, 1200);
                    } else {
                        tecNotif('danger', 'Error', data.message || 'No se pudo cerrar.');
                    }
                } catch(e) {
                    tecNotif('danger', 'Error', e.message);
                }
            }
        });
}

    // ── Cancelar ticket ──────────────────────────────────────────────
    function tecCancelarTicket() {
        ModalSystem.show('confirm', {
            title: '¿Cancelar ticket?',
            text: 'Esta acción cambiará el estado a CANCELADO y no se puede revertir.',
            confirmText: 'Sí, cancelar',
            cancelText: 'No, mantener',
            onConfirm: () => {
                const id = window._tecTicketId;
                
                fetch(`/tecnico/ticket/${id}/cancelar`, {
                    method:  'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.ok) {
                        tecNotif('success', '¡Cancelado!', 'El ticket fue cancelado correctamente.');
                        setTimeout(() => { tecCloseModal(); location.reload(); }, 1200);
                    } else {
                        tecNotif('danger', 'Error', data.message || 'No se pudo cancelar.');
                    }
                })
                .catch(e => tecNotif('danger', 'Error', e.message));
            }
        });
    }

    // ── Helpers UI ───────────────────────────────────────────────────
    function tecCloseModal() {
        document.getElementById('tecModalOverlay').style.display = 'none';
    }

    function tecFill(id, valor) {
        const el = document.getElementById(id);
        if (!el) return;
        el.textContent = (valor === null || valor === undefined || valor === '') ? '—' : valor;
    }

    function tecFillDate(id, fecha) {
        const el = document.getElementById(id);
        if (!el) return;
        el.textContent = fecha ? fecha.substring(0, 10) : '—';
    }

    function tecRenderEvidencias(id, evidencias) {
        const cont = document.getElementById(id);
        if (!cont) return;
        cont.innerHTML = '';
        cont.classList.remove('tec-empty-ev');
        cont.style.alignItems = cont.style.justifyContent = 'center';

        if (!evidencias || evidencias.length === 0) {
            cont.classList.add('tec-empty-ev'); return;
        }
        cont.style.alignItems = 'stretch'; cont.style.justifyContent = 'flex-start';

        let html = '<div class="tec-ev-grid">';
        evidencias.forEach(ev => {
            const url  = '/storage/' + ev.ruta_archivo;
            const nombre = ev.nombre_original ?? 'Archivo';
            const ext  = ev.ruta_archivo.split('.').pop().toLowerCase();

            if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
                html += `<div class="tec-ev-item"><img src="${url}" alt="${nombre}" class="tec-ev-thumb" onclick="tecOpenLightbox('${url}')"><div class="tec-ev-name" title="${nombre}">${nombre}</div></div>`;
            } else {
                html += `<div class="tec-ev-item"><a href="${url}" target="_blank" class="tec-ev-file"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span>${ext}</span></a><div class="tec-ev-name" title="${nombre}">${nombre}</div></div>`;
            }
        });
        html += '</div>';
        cont.innerHTML = html;
    }

    function tecRenderComentariosLista(comentarios) {
        const cont = document.getElementById('tec-comentarios-lista');
        if (!cont) return;
        if (!comentarios || comentarios.length === 0) { cont.innerHTML = ''; return; }

        let html = `<div class="tec-label" style="margin-bottom:8px;">Comentarios (${comentarios.length})</div>`;
        comentarios.forEach(c => {
            const fecha = c.created_at ? c.created_at.substring(0, 10) : '';
            html += `<div class="tec-comentario-item"><div class="tec-comentario-texto">${tecEscHtml(c.comentario)}</div><div class="tec-comentario-fecha">📅 ${fecha}</div></div>`;
        });
        cont.innerHTML = html;
    }

    function tecRenderReporteExistente(reporte) {
        const cont = document.getElementById('tec-reporte-contenido');
        if (!cont || !reporte) return;
        const url  = '/storage/' + reporte.archivo_reporte;
        const ext  = reporte.archivo_reporte.split('.').pop().toLowerCase();
        const nombre = reporte.nombre_original ?? 'reporte';

        if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
            cont.innerHTML = `<div class="tec-ev-grid"><div class="tec-ev-item"><img src="${url}" class="tec-ev-thumb" onclick="tecOpenLightbox('${url}')"><div class="tec-ev-name">${nombre}</div></div></div>`;
            cont.style.alignItems = 'stretch'; cont.style.justifyContent = 'flex-start';
        } else {
            cont.innerHTML = `<a href="${url}" target="_blank" class="tec-ev-file" style="width:100%;height:70px;border-radius:8px;"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><span>${ext} — ${nombre}</span></a>`;
        }
    }

    function tecEscHtml(str) {
        return (str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    function tecOpenLightbox(url) {
        const lb  = document.getElementById('tecLightbox');
        const img = document.getElementById('tecLightboxImg');
        img.src = url; img.style.display = 'block';
        lb.style.display = 'flex';
    }
    function tecCloseLightbox() {
        document.getElementById('tecLightbox').style.display = 'none';
    }

    // ── Notificación simple (usa showNotification si existe) ─────────
    function tecNotif(tipo, titulo, msg) {
        if (typeof showNotification === 'function') {
            showNotification(tipo, titulo, msg);
        } else {
            alert(`[${titulo}] ${msg}`);
        }
    }
    </script>