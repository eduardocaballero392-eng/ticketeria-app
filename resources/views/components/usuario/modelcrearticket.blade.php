{{-- ══ ESTILOS RESPONSIVE MODAL TICKET ══ --}}
<style>
@keyframes mcSpin { to { transform: rotate(360deg); } }
@keyframes slideUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}

#modalCrearTicket .mc-card {
    background: #fff;
    border-radius: 20px;
    width: 600px;
    max-width: 96vw;
    max-height: 92vh;
    overflow: hidden; 
    display: flex;
    flex-direction: column;
    box-shadow: 0 24px 64px rgba(10,37,80,.25);
    animation: slideUp .22s ease;
}
#modalCrearTicket .mc-card::-webkit-scrollbar { width: 6px; }
#modalCrearTicket .mc-card::-webkit-scrollbar-thumb { background: #b8d0f0; border-radius: 99px; }
#modalCrearTicket .mc-body::-webkit-scrollbar { 
    width: 6px; 
}
#modalCrearTicket .mc-body::-webkit-scrollbar-thumb { 
    background: #b8d0f0; 
    border-radius: 99px; 
}

#modalCrearTicket .mc-header {
    background: linear-gradient(135deg, #1254a0 0%, #1a6ed8 100%);
    padding: 22px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0; 
    border-radius: 20px 20px 0 0; 
}

#modalCrearTicket .mc-header .mc-subtitle {
    font-size: 11px; color: rgba(255,255,255,.65);
    letter-spacing: .07em; text-transform: uppercase; margin-bottom: 4px;
}
#modalCrearTicket .mc-header .mc-title {
    font-size: 17px; font-weight: 700; color: #fff;
}
#modalCrearTicket .mc-btn-close {
    background: rgba(255,255,255,.18); border: none; color: #fff;
    border-radius: 9px; width: 36px; height: 36px; font-size: 20px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: background .15s; flex-shrink: 0;
}
#modalCrearTicket .mc-btn-close:hover { background: rgba(255,255,255,.32); }

#modalCrearTicket .mc-body { 
    padding: 28px;
    overflow-y: auto; 
    flex: 1; 
    scrollbar-width: thin;
    scrollbar-color: #b8d0f0 transparent;
}

#modalCrearTicket .mc-label {
    display: block; font-size: 13px; font-weight: 600;
    color: #0a2550; margin-bottom: 7px;
}
#modalCrearTicket .mc-label .req  { color: #1a6ed8; }
#modalCrearTicket .mc-label .hint { font-size: 11px; color: #7ba8d8; font-weight: 400; }

#modalCrearTicket .mc-field { margin-bottom: 18px; }

#modalCrearTicket .mc-input {
    width: 100%; border: 1.5px solid #c8dcf5; border-radius: 10px;
    padding: 11px 14px; font-size: 14px; color: #0a2550; outline: none;
    background: #f7faff; transition: border-color .15s, box-shadow .15s;
    font-family: inherit; box-sizing: border-box;
}
#modalCrearTicket .mc-input:focus {
    border-color: #1a6ed8;
    box-shadow: 0 0 0 3px rgba(26,110,216,.12);
    background: #fff;
}
#modalCrearTicket .mc-input::placeholder { color: #9ab8d8; }
#modalCrearTicket textarea.mc-input     { resize: vertical; }

#modalCrearTicket #prioridadGroup {
    display: grid; grid-template-columns: repeat(3,1fr); gap: 10px;
}
#modalCrearTicket #prioridadGroup label {
    border: 1.5px solid #c8dcf5; border-radius: 12px; padding: 13px 10px;
    cursor: pointer; transition: border-color .15s, background .15s, box-shadow .15s;
    display: flex; flex-direction: column; gap: 4px; background: #f7faff;
}
#modalCrearTicket #prioridadGroup label:hover { border-color: #1a6ed8; background: #eef5ff; }

#modalCrearTicket .mc-equip-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 18px;
}

#modalCrearTicket #dropZone {
    border: 2px dashed #aacbee; border-radius: 12px; padding: 28px 20px;
    text-align: center; cursor: pointer;
    transition: border-color .15s, background .15s; background: #f7faff;
}
#modalCrearTicket #dropZone:hover { border-color: #1a6ed8; background: #eef5ff; }
#modalCrearTicket #dropLabel { font-size: 13px; color: #5a82b0; }

#modalCrearTicket .mc-footer {
    display: flex; gap: 10px; justify-content: flex-end;
    margin-top: 8px; flex-wrap: wrap;
}
#modalCrearTicket .mc-btn-cancel {
    background: #eaf1fc; color: #3a6499; border: none; border-radius: 10px;
    padding: 11px 22px; font-size: 13px; font-weight: 600;
    cursor: pointer; transition: background .15s;
}
#modalCrearTicket .mc-btn-cancel:hover { background: #d4e6f8; }
#modalCrearTicket .mc-btn-submit {
    background: linear-gradient(135deg, #1254a0, #1a6ed8);
    color: #fff; border: none; border-radius: 10px;
    padding: 11px 28px; font-size: 13px; font-weight: 700;
    cursor: pointer; transition: opacity .15s, transform .1s;
    box-shadow: 0 4px 14px rgba(26,110,216,.35);
}
#modalCrearTicket .mc-btn-submit:hover  { opacity: .92; transform: translateY(-1px); }
#modalCrearTicket .mc-btn-submit:active { transform: translateY(0); }

/* ── Tablet ── */
@media (max-width: 640px) {
    #modalCrearTicket .mc-body   { padding: 20px 18px; }
    #modalCrearTicket .mc-header { padding: 18px 20px; }
    #modalCrearTicket .mc-equip-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
}

/* ── Móvil ── */
@media (max-width: 420px) {
    #modalCrearTicket .mc-header .mc-title { font-size: 15px; }
    #modalCrearTicket .mc-body   { padding: 16px 14px; }
    #modalCrearTicket #prioridadGroup { grid-template-columns: 1fr 1fr 1fr; gap: 7px; }
    #modalCrearTicket #prioridadGroup label { padding: 9px 6px; }
    #modalCrearTicket #prioridadGroup label span:first-of-type { font-size: 12px; }
    #modalCrearTicket #prioridadGroup label span:last-of-type  { font-size: 10px; }
    #modalCrearTicket .mc-equip-grid { grid-template-columns: 1fr; }
    #modalCrearTicket .mc-footer { flex-direction: column-reverse; }
    #modalCrearTicket .mc-btn-cancel,
    #modalCrearTicket .mc-btn-submit { width: 100%; text-align: center; }
}
</style>
@include('components.notificaciones.alertas')

{{-- ══ MODAL ══ --}}
<div id="modalCrearTicket" style="display:none;position:fixed;inset:0;background:rgba(10,37,80,.55);backdrop-filter:blur(4px);z-index:2000;align-items:center;justify-content:center;padding:16px;">
    <div class="mc-card" onclick="event.stopPropagation()">

        {{-- Cabecera --}}
        <div class="mc-header">
            <div>
                <div class="mc-subtitle">Nuevo ticket</div>
                <div class="mc-title">Crear solicitud de soporte</div>
            </div>
            <button class="mc-btn-close" onclick="cerrarModalTicket()">&#215;</button>
        </div>

        {{-- Formulario --}}
        <div class="mc-body">

            {{-- Tipo de ticket --}}
            <div class="mc-field">
                <label class="mc-label">Tipo de ticket</label>
                <select id="t_tipo" class="mc-input" onchange="mostrarDescripcionTipoTicket()">
                    <option value="">— Selecciona un tipo —</option>
                    @foreach(\DB::table('tipo_ticket')->where('activo', 1)->get() as $tipo)
                        <option value="{{ $tipo->id_tipo_ticket }}" data-descripcion="{{ $tipo->descripcion }}">
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>

                {{-- Descripción del tipo seleccionado --}}
                <div id="descripcionTipoTicket" style="display:none;margin-top:8px;padding:10px 12px;background:#eef5ff;border:1px solid #c8dcf5;border-radius:10px;font-size:12px;color:#3a6499;line-height:1.5;"></div>
            </div>

            {{-- Prioridad --}}
            <div class="mc-field">
                <label class="mc-label">Prioridad</label>
                <div id="prioridadGroup">
                    @foreach(\DB::table('prioridad')->orderBy('nivel')->get() as $p)
                    <label id="prio-label-{{ $p->id_prioridad }}">
                        <input type="radio" name="t_prioridad" value="{{ $p->id_prioridad }}" onchange="seleccionarPrioridad({{ $p->id_prioridad }}, '{{ $p->color_hex }}')" style="display:none;">
                        <span style="font-size:13px;font-weight:700;color:{{ $p->color_hex }};">{{ $p->nombre }}</span>
                        <span style="font-size:11px;color:#5a82b0;line-height:1.4;">{{ $p->descripcion }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Asunto --}}
            <div class="mc-field">
                <label class="mc-label">Asunto</label>
                <input type="text" id="t_asunto" class="mc-input" placeholder="Ej: Computadora no enciende">
            </div>

            {{-- Descripción --}}
            <div class="mc-field">
                <label class="mc-label">
                    Descripción del problema <span class="req">*</span>
                </label>
                <textarea id="t_problema" class="mc-input" rows="4" placeholder="Describe detalladamente el problema..."></textarea>
            </div>

            {{-- Equipo --}}
            <div class="mc-equip-grid">
                <div>
                    <label class="mc-label">Tipo de equipo</label>
                    <input type="text" id="t_tipo_equipo" class="mc-input" placeholder="Ej: Laptop, Desktop...">
                </div>
                <div>
                    <label class="mc-label">Marca</label>
                    <input type="text" id="t_marca" class="mc-input" placeholder="Ej: HP, Dell, Lenovo...">
                </div>
                <div>
                    <label class="mc-label">Modelo</label>
                    <input type="text" id="t_modelo" class="mc-input" placeholder="Ej: EliteBook 840...">
                </div>
                <div>
                    <label class="mc-label">Serie / Serial</label>
                    <input type="text" id="t_serie" class="mc-input" placeholder="Número de serie...">
                </div>
            </div>

            {{-- Evidencia --}}
            <div class="mc-field">
                <label class="mc-label">
                    Evidencia <span class="hint">(foto, video o PDF — máx. 5 archivos, 20MB c/u)</span>
                </label>
                <div id="dropZone" onclick="document.getElementById('t_evidencia').click()"
                    ondragover="event.preventDefault();this.style.borderColor='#1a6ed8';this.style.background='#eef5ff';"
                    ondragleave="this.style.borderColor='#aacbee';this.style.background='#f7faff';"
                    ondrop="handleDrop(event)">
                    <div style="font-size:32px;margin-bottom:8px;">📎</div>
                    <div id="dropLabel">Haz clic o arrastra tu archivo aquí</div>
                </div>
                <input type="file" id="t_evidencia" accept=".jpg,.jpeg,.png,.pdf,.mp4,.mov" onchange="mostrarArchivo(this)" multiple style="display:none;">
            </div>

            {{-- Botones --}}
            <div class="mc-footer">
                <button class="mc-btn-cancel" onclick="cerrarModalTicket()">Cancelar</button>
                <button class="mc-btn-submit" id="btnEnviarTicket" onclick="enviarTicket()">
                    🎫 Crear ticket
                </button>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let prioridadSeleccionada = null;

    // ─────────────────────────────────────────────
    // Abrir modal
    // ─────────────────────────────────────────────
    window.abrirModalTicket = function () {
        const modal = document.getElementById('modalCrearTicket');

        if (!modal) {
            console.error('No se encontró el modal con id="modalCrearTicket"');
            return;
        }

        modal.style.display = 'flex';
        document.getElementById('descripcionTipoTicket').style.display = 'none';
        document.getElementById('descripcionTipoTicket').innerHTML = '';
        limpiarFormTicket();
    };

    // ─────────────────────────────────────────────
    // Cerrar modal
    // ─────────────────────────────────────────────
    window.cerrarModalTicket = function () {
        const modal = document.getElementById('modalCrearTicket');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    // ─────────────────────────────────────────────
    // Limpiar formulario
    // ─────────────────────────────────────────────
    window.limpiarFormTicket = function () {
        document.getElementById('t_tipo').value = '';
        document.getElementById('t_asunto').value = '';
        document.getElementById('t_problema').value = '';
        document.getElementById('t_tipo_equipo').value = '';
        document.getElementById('t_marca').value = '';
        document.getElementById('t_modelo').value = '';
        document.getElementById('t_serie').value = '';
        document.getElementById('t_evidencia').value = '';

        document.getElementById('dropLabel').textContent = 'Haz clic o arrastra tu archivo aquí';
        document.getElementById('dropZone').style.borderColor = '#aacbee';
        document.getElementById('dropZone').style.background = '#f7faff';

        document.querySelectorAll('#prioridadGroup label').forEach(label => {
            label.style.borderColor = '#c8dcf5';
            label.style.background = '#f7faff';
            label.style.boxShadow = '';
        });

        document.querySelectorAll('input[name="t_prioridad"]').forEach(radio => {
            radio.checked = false;
        });

        prioridadSeleccionada = null;
    };

    // ─────────────────────────────────────────────
    // Seleccionar prioridad
    // ─────────────────────────────────────────────
    window.seleccionarPrioridad = function (id, color) {
        prioridadSeleccionada = id;

        document.querySelectorAll('#prioridadGroup label').forEach(label => {
            label.style.borderColor = '#c8dcf5';
            label.style.background = '#f7faff';
            label.style.boxShadow = '';
        });

        const label = document.getElementById('prio-label-' + id);
        if (label) {
            label.style.borderColor = color;
            label.style.background = color + '15';
            label.style.boxShadow = '0 0 0 3px ' + color + '22';
        }
    };

    // ─────────────────────────────────────────────
    // Mostrar descripción del tipo de ticket (Movida aquí adentro para estabilidad)
    // ─────────────────────────────────────────────
    window.mostrarDescripcionTipoTicket = function () {
        const select = document.getElementById('t_tipo');
        const descripcionBox = document.getElementById('descripcionTipoTicket');

        if (!select || !descripcionBox) return;

        const opcionSeleccionada = select.options[select.selectedIndex];
        const descripcion = opcionSeleccionada.getAttribute('data-descripcion');

        if (descripcion && descripcion.trim() !== '') {
            descripcionBox.style.display = 'block';
            descripcionBox.innerHTML = 'ℹ️ ' + descripcion;
        } else {
            descripcionBox.style.display = 'none';
            descripcionBox.innerHTML = '';
        }
    };

    // ─────────────────────────────────────────────
    // Mostrar archivos seleccionados
    // ─────────────────────────────────────────────
    window.mostrarArchivo = function (input) {
        if (input.files && input.files.length > 0) {
            const cantidad = input.files.length;

            document.getElementById('dropLabel').textContent =
                cantidad === 1
                    ? '📄 ' + input.files[0].name
                    : '📦 ' + cantidad + ' archivos seleccionados';

            document.getElementById('dropZone').style.borderColor = '#1a6ed8';
            document.getElementById('dropZone').style.background = '#eef5ff';
        }
    };

    // ─────────────────────────────────────────────
    // Drag and drop
    // ─────────────────────────────────────────────
    window.handleDrop = function (event) {
        event.preventDefault();
        const input = document.getElementById('t_evidencia');
        const dt = new DataTransfer();

        Array.from(event.dataTransfer.files).forEach(file => {
            dt.items.add(file);
        });

        input.files = dt.files;
        mostrarArchivo(input);

        document.getElementById('dropZone').style.borderColor = '#aacbee';
        document.getElementById('dropZone').style.background = '#f7faff';
    };

    // ─────────────────────────────────────────────
    // Enviar ticket
    // ─────────────────────────────────────────────
    window.enviarTicket = async function () {
        const tipoTicket = document.getElementById('t_tipo').value;
        const problema   = document.getElementById('t_problema').value.trim();
        const archivos   = document.getElementById('t_evidencia').files;

        if (!tipoTicket) {
            showNotification('warning', 'Campo requerido', 'Debes seleccionar un tipo de ticket.');
            return;
        }
        if (!prioridadSeleccionada) {
            showNotification('warning', 'Campo requerido', 'Debes seleccionar una prioridad.');
            return;
        }
        if (!problema) {
            showNotification('warning', 'Campo requerido', 'La descripción del problema es obligatoria.');
            return;
        }
        if (archivos.length === 0) {
            showNotification('warning', 'Campo requerido', 'Debes adjuntar al menos una evidencia.');
            return;
        }
        if (archivos.length > 5) {
            showNotification('warning', 'Límite excedido', 'Máximo 5 archivos de evidencia permitidos.');
            return;
        }

        const btn = document.getElementById('btnEnviarTicket');
        btn.disabled = true;
        btn.style.opacity = '.7';
        btn.style.cursor = 'not-allowed';
        btn.innerHTML = `<span style="display:inline-flex;align-items:center;gap:8px;">
            <svg style="animation:mcSpin 1s linear infinite" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            Subiendo archivo...
        </span>`;

        const formData = new FormData();
        formData.append('id_tipo_ticket', tipoTicket);
        formData.append('id_prioridad', prioridadSeleccionada);
        formData.append('problema', problema);
        formData.append('asunto', document.getElementById('t_asunto').value.trim());
        formData.append('tipo_equipo', document.getElementById('t_tipo_equipo').value.trim());
        formData.append('marca', document.getElementById('t_marca').value.trim());
        formData.append('modelo', document.getElementById('t_modelo').value.trim());
        formData.append('serie_serial', document.getElementById('t_serie').value.trim());
        formData.append('_token', '{{ csrf_token() }}');

        Array.from(archivos).forEach(archivo => {
            formData.append('evidencia[]', archivo);
        });

        try {
            const res = await fetch('{{ route("usuario.ticket.store") }}', {
                method: 'POST',
                body: formData
            });

            const data = await res.json();

            if (data.ok) {
                cerrarModalTicket();
                ModalSystem.show('success', {
                    title: '¡Ticket creado!',
                    text: data.message || 'El ticket fue registrado correctamente.',
                    confirmText: 'Entendido'
                });

                const observer = new MutationObserver(() => {
                    const modal = document.querySelector('.modal-system-overlay');
                    if (!modal) {
                        observer.disconnect();
                        location.reload();
                    }
                });

                observer.observe(document.body, { childList: true, subtree: true });
            } else {
                showNotification('danger', 'Error', data.message || 'No se pudo crear el ticket.');
            }
        } catch (error) {
            showNotification('danger', 'Error de conexión', 'No se pudo conectar con el servidor.');
        } finally {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
            btn.innerHTML = '🎫 Crear ticket';
        }
    };
});
</script>