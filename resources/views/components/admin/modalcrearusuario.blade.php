{{-- ══ MODAL CREAR USUARIO (ADMIN) ══ --}}
{{-- Requiere que el controlador pase $clientes a la vista --}}
<div id="modalCrearUsuario" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(5,15,10,0.72);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="width:100%;max-width:560px;margin:16px;animation:uSlideIn .3s cubic-bezier(.16,1,.3,1)">
        <div style="background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 30px 60px rgba(0,0,0,.35)">

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#064e3b,#059669);padding:22px 28px;display:flex;align-items:center;justify-content:space-between">
                <div style="display:flex;align-items:center;gap:14px">
                    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px">👤</div>
                    <div>
                        <div style="color:#fff;font-weight:700;font-size:1.1rem;font-family:'Segoe UI',sans-serif">Registrar Usuario</div>
                        <div style="color:rgba(255,255,255,.75);font-size:.75rem" id="usu_cliente_header_sub">Selecciona primero el cliente</div>
                    </div>
                </div>
                <button onclick="cerrarModalUsuario()" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:32px;height:32px;border-radius:8px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:.2s" onmouseover="this.style.background='rgba(239,68,68,.7)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">✕</button>
            </div>

            {{-- Indicador de paso --}}
            <div style="display:flex;background:#f0fdf4;border-bottom:1px solid #d1fae5;padding:0">
                <div id="usu_step_ind_1" style="flex:1;text-align:center;padding:10px;font-size:.78rem;font-weight:700;color:#059669;border-bottom:3px solid #059669;transition:.2s">1 · Seleccionar Cliente</div>
                <div id="usu_step_ind_2" style="flex:1;text-align:center;padding:10px;font-size:.78rem;font-weight:600;color:#9ca3af;border-bottom:3px solid transparent;transition:.2s">2 · Datos del Usuario</div>
            </div>

            {{-- PASO 1: Seleccionar cliente --}}
            <div id="usu_paso1" style="padding:26px 28px;font-family:'Segoe UI',sans-serif">
                <div style="font-size:.85rem;color:#374151;font-weight:600;margin-bottom:12px">¿A qué cliente pertenece este usuario?</div>

                {{-- Búsqueda --}}
                <div style="position:relative;margin-bottom:14px">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:16px">🔍</span>
                    <input id="usu_busca_cliente" type="text" placeholder="Buscar cliente por razón social o RUC…"
                           oninput="filtrarClientesModal()"
                           style="width:100%;padding:10px 13px 10px 38px;border:2px solid #d1fae5;border-radius:10px;font-size:.9rem;outline:none;box-sizing:border-box;background:#f0fdf4;color:#065f46"
                           onfocus="this.style.borderColor='#059669'" onblur="this.style.borderColor='#d1fae5'">
                </div>

                {{-- Lista de clientes --}}
                <div id="usu_lista_clientes" style="max-height:220px;overflow-y:auto;display:flex;flex-direction:column;gap:8px;scrollbar-width:thin;scrollbar-color:#6ee7b7 transparent">
                    @foreach($clientes as $c)
                    <div class="usu-cli-item"
                         data-id="{{ $c->id_cliente }}"
                         data-rs="{{ strtolower($c->razon_social) }}"
                         data-ruc="{{ $c->ruc }}"
                         data-correo-base="{{ strtolower(preg_replace('/[^a-z0-9]/i', '', $c->razon_social)) }}"
                         onclick="seleccionarClienteModal(this)"
                         style="display:flex;align-items:center;gap:14px;padding:12px 14px;border:2px solid #e5e7eb;border-radius:12px;cursor:pointer;transition:.15s;background:#fff"
                         onmouseover="if(!this.classList.contains('selected'))this.style.borderColor='#6ee7b7',this.style.background='#f0fdf4'"
                         onmouseout="if(!this.classList.contains('selected'))this.style.borderColor='#e5e7eb',this.style.background='#fff'">
                        <div style="width:38px;height:38px;background:linear-gradient(135deg,#d1fae5,#a7f3d0);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:700;color:#065f46;font-size:1rem;flex-shrink:0">
                            {{ strtoupper(substr($c->razon_social, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;color:#111827;font-size:.9rem">{{ $c->razon_social }}</div>
                            <div style="font-size:.75rem;color:#6b7280">RUC: {{ $c->ruc }}</div>
                        </div>
                        <div class="usu-cli-check" style="margin-left:auto;display:none;color:#059669;font-size:20px">✔</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- PASO 2: Datos usuario (oculto inicialmente) --}}
            <div id="usu_paso2" style="display:none;padding:24px 28px 10px;font-family:'Segoe UI',sans-serif">

                {{-- Badge cliente seleccionado --}}
                <div id="usu_badge_cliente" style="display:flex;align-items:center;gap:10px;background:#f0fdf4;border:1px solid #6ee7b7;border-radius:10px;padding:10px 14px;margin-bottom:18px">
                    <div style="width:32px;height:32px;background:#d1fae5;border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:700;color:#065f46;font-size:.9rem" id="usu_badge_inicial">?</div>
                    <div>
                        <div style="font-size:.8rem;color:#065f46;font-weight:700" id="usu_badge_nombre">—</div>
                        <div style="font-size:.72rem;color:#6b7280" id="usu_badge_ruc">RUC: —</div>
                    </div>
                    <button onclick="volverPaso1()" style="margin-left:auto;background:none;border:1px solid #6ee7b7;color:#059669;padding:4px 10px;border-radius:6px;font-size:.75rem;cursor:pointer;font-weight:600">Cambiar</button>
                </div>

                {{-- Nombre + Apellido Paterno --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Nombre <span style="color:#059669">*</span></label>
                        <input id="usu_nombre" type="text" placeholder="Ej. María" maxlength="100"
                               style="width:100%;padding:10px 13px;border:2px solid #d1fae5;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#f0fdf4;color:#111827"
                               onfocus="this.style.borderColor='#059669';this.style.background='#fff'"
                               onblur="this.style.borderColor='#d1fae5';this.style.background='#f0fdf4'"
                               onkeypress="return soloLetras(event)"
                               oninput="if(this.value.length >= 100) { showNotification('danger', 'Error', 'Solo se permite un máximo de 100 caracteres'); } this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''); generarDatosUsuario()">
                    </div>
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Apellido Paterno <span style="color:#059669">*</span></label>
                        <input id="usu_apellido_paterno" type="text" placeholder="Ej. Torres" maxlength="100"
                               style="width:100%;padding:10px 13px;border:2px solid #d1fae5;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#f0fdf4;color:#111827"
                               onfocus="this.style.borderColor='#059669';this.style.background='#fff'"
                               onblur="this.style.borderColor='#d1fae5';this.style.background='#f0fdf4'"
                               onkeypress="return soloLetras(event)"
                               oninput="if(this.value.length >= 100) { showNotification('danger', 'Error', 'Solo se permite un máximo de 100 caracteres'); } this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''); generarDatosUsuario()">
                    </div>
                </div>

                {{-- Apellido Materno + DNI --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Apellido Materno <span style="color:#059669">*</span></label>
                        <input id="usu_apellido_materno" type="text" placeholder="Ej. Quispe" maxlength="100"
                               style="width:100%;padding:10px 13px;border:2px solid #d1fae5;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#f0fdf4;color:#111827"
                               onfocus="this.style.borderColor='#059669';this.style.background='#fff'"
                               onblur="this.style.borderColor='#d1fae5';this.style.background='#f0fdf4'"
                               onkeypress="return soloLetras(event)"
                               oninput="if(this.value.length >= 100) { showNotification('danger', 'Error', 'Solo se permite un máximo de 100 caracteres'); } this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, ''); generarDatosUsuario()">
                    </div>
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">DNI / Documento <span style="color:#059669">*</span></label>
                        <input id="usu_dni" type="text" placeholder="Máx. 15 dígitos" maxlength="15" autocomplete="off"
                               oninput="if(this.value.length >= 15) { showNotification('danger', 'Error', 'Solo se permite un máximo de 15 dígitos'); } this.value=this.value.replace(/[^0-9]/g,'');generarDatosUsuario()"
                               style="width:100%;padding:10px 13px;border:2px solid #d1fae5;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#f0fdf4;color:#111827"
                               onfocus="this.style.borderColor='#059669';this.style.background='#fff'"
                               onblur="this.style.borderColor='#d1fae5';this.style.background='#f0fdf4'">
                    </div>
                </div>

                {{-- Teléfono --}}
                <div style="margin-bottom:16px">
                    <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">
                        Teléfono <span style="color:#059669">*</span>
                    </label>

                    <input
                        id="usu_telefono"
                        type="tel"
                        placeholder="Ej: 987654321"
                        maxlength="15"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        style="padding-left:52px !important;width:100%;padding:10px 13px;border:2px solid #d1fae5;border-radius:10px;font-size:.9rem;outline:none;box-sizing:border-box;background:#f0fdf4;color:#111827"
                        onfocus="this.style.borderColor='#059669';this.style.background='#fff'"
                        onblur="this.style.borderColor='#d1fae5';this.style.background='#f0fdf4'"
                    >

                    <input type="hidden" id="usu_codigo_pais" value="+51">
                </div>

                {{-- Datos autogenerados --}}
                <div style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1px solid #86efac;border-radius:12px;padding:14px 18px;margin-bottom:6px">
                    <div style="font-size:.72rem;font-weight:700;color:#15803d;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px">⚡ Datos autogenerados</div>
                    <div style="display:grid;grid-template-columns:auto 1fr;gap:12px">
                        <div>
                            <div style="font-size:.72rem;color:#6b7280;font-weight:600;margin-bottom:4px">🪪 Código</div>
                            <div id="usu_codigo_preview" style="font-size:.85rem;color:#166534;font-weight:700;background:#fff;padding:7px 10px;border-radius:8px;border:1px solid #86efac;letter-spacing:.05em;white-space:nowrap">———</div>
                        </div>
                        <div>
                            <div style="font-size:.72rem;color:#6b7280;font-weight:600;margin-bottom:4px">📧 Correo</div>
                            <div id="usu_correo_preview" style="font-size:.78rem;color:#166534;font-weight:600;background:#fff;padding:7px 10px;border-radius:8px;border:1px solid #86efac;word-break:break-all">———</div>
                        </div>
                    </div>
                    <div style="margin-top:10px">
                        <div style="font-size:.72rem;color:#6b7280;font-weight:600;margin-bottom:4px">🔑 Contraseña inicial (= DNI)</div>
                        <div id="usu_pass_preview" style="font-size:.82rem;color:#166534;font-weight:600;background:#fff;padding:7px 10px;border-radius:8px;border:1px solid #86efac;letter-spacing:.1em">———</div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div style="padding:14px 28px 24px;display:flex;gap:10px;justify-content:flex-end">
                <button onclick="cerrarModalUsuario()" style="padding:10px 22px;border-radius:10px;border:2px solid #d1fae5;background:#fff;color:#6b7280;font-weight:600;cursor:pointer;font-size:.9rem;transition:.2s" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='#fff'">Cancelar</button>
                <button id="btnSiguientePaso" onclick="irPaso2()" style="padding:10px 26px;border-radius:10px;border:none;background:linear-gradient(135deg,#064e3b,#059669);color:#fff;font-weight:700;cursor:pointer;font-size:.9rem;box-shadow:0 4px 12px rgba(5,150,105,.3);transition:.2s" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">Siguiente →</button>
                <button id="btnGuardarUsuario" onclick="guardarUsuario()" style="display:none;padding:10px 26px;border-radius:10px;border:none;background:linear-gradient(135deg,#064e3b,#059669);color:#fff;font-weight:700;cursor:pointer;font-size:.9rem;box-shadow:0 4px 12px rgba(5,150,105,.3);transition:.2s" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">Guardar Usuario</button>
            </div>

        </div>
    </div>
</div>

<style>
@keyframes uSlideIn { from{transform:translateY(-20px) scale(.97);opacity:0} to{transform:none;opacity:1} }
.usu-cli-item.selected { border-color:#059669 !important; background:#f0fdf4 !important; }

/* ── PARCHE CSS PARA MOVER LA ALERTA FLOTANTE AL FRENTE ── */
div[class*="notification"], 
div[class*="alert"], 
div[class*="toast"],
div[id*="notification"], 
div[id*="alert"] {
    z-index: 100005 !important; /* Fuerza a la alerta a estar al frente del fondo oscuro */
    right: 24px !important;     /* La empuja hacia adentro de la pantalla para que no se corte */
    top: 24px !important;       /* Separación del techo de la pantalla */
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>


<script>
// Función para evitar la escritura de números en campos de texto
function soloLetras(e) {
    const tecla = e.key;
    // Permite letras minusculas, mayusculas, acentos, la ñ y espacios
    return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/.test(tecla) || tecla === 'Backspace' || tecla === 'Tab';
}

// ── Inicializar intlTelInput ──────────────────────────────────────────
let _usuPhoneInput = null;

// Se inicializa cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
    const telEl = document.getElementById('usu_telefono');
    if (telEl) {
        _usuPhoneInput = window.intlTelInput(telEl, {
            initialCountry: "pe",
            preferredCountries: ["pe", "cl", "co"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        telEl.addEventListener('countrychange', function () {
            document.getElementById('usu_codigo_pais').value =
                '+' + _usuPhoneInput.getSelectedCountryData().dialCode;
        });
    }
});


let _usuClienteSeleccionado = null;

function abrirModalUsuario() {
    const m = document.getElementById('modalCrearUsuario');
    m.style.display = 'flex';
    _usuClienteSeleccionado = null;

    // Limpiar selección de clientes
    document.querySelectorAll('.usu-cli-item').forEach(el => {
        el.classList.remove('selected');
        el.style.borderColor = '#e5e7eb';
        el.style.background  = '#fff';
        el.querySelector('.usu-cli-check').style.display = 'none';
    });

    document.getElementById('usu_busca_cliente').value = '';
    filtrarClientesModal();
    mostrarPaso(1);

    // Limpiar campos de texto
    ['usu_nombre','usu_apellido_paterno','usu_apellido_materno','usu_dni'].forEach(id => {
        const el = document.getElementById(id); if(el) el.value = '';
    });

    // Reset intlTelInput
    if (_usuPhoneInput) {
        _usuPhoneInput.setNumber('');
        _usuPhoneInput.setCountry('pe');
        document.getElementById('usu_codigo_pais').value = '+51';
    } else {
        const tel = document.getElementById('usu_telefono');
        if (tel) tel.value = '';
        document.getElementById('usu_codigo_pais').value = '+51';
    }

    // Limpiar previews
    ['usu_codigo_preview','usu_correo_preview','usu_pass_preview'].forEach(id =>
        document.getElementById(id).textContent = '———');

    // Restaurar botón
    const btn = document.getElementById('btnGuardarUsuario');
    btn.disabled         = false;
    btn.textContent      = 'Guardar Usuario';
    btn.style.background = 'linear-gradient(135deg,#064e3b,#059669)';
}

function cerrarModalUsuario() {
    document.getElementById('modalCrearUsuario').style.display = 'none';
}

function filtrarClientesModal() {
    const q = document.getElementById('usu_busca_cliente').value.toLowerCase();
    document.querySelectorAll('.usu-cli-item').forEach(el => {
        const match = el.dataset.rs.includes(q) || el.dataset.ruc.includes(q);
        el.style.display = match ? 'flex' : 'none';
    });
}

function seleccionarClienteModal(el) {
    document.querySelectorAll('.usu-cli-item').forEach(item => {
        item.classList.remove('selected');
        item.style.borderColor = '#e5e7eb';
        item.style.background  = '#fff';
        item.querySelector('.usu-cli-check').style.display = 'none';
    });
    el.classList.add('selected');
    el.querySelector('.usu-cli-check').style.display = 'block';
    _usuClienteSeleccionado = {
        id:         el.dataset.id,
        rs:         el.querySelector('div > div > div:first-child').textContent.trim(),
        ruc:        el.dataset.ruc,
        correoBase: el.dataset.correoBase,
        inicial:    el.querySelector('div:first-child').textContent.trim()
    };
}

function irPaso2() {
    if (!_usuClienteSeleccionado) {
        showNotification('warning', 'Atención', 'Selecciona un cliente primero.');
        return;
    }
    document.getElementById('usu_badge_inicial').textContent = _usuClienteSeleccionado.inicial;
    document.getElementById('usu_badge_nombre').textContent  = _usuClienteSeleccionado.rs;
    document.getElementById('usu_badge_ruc').textContent     = 'RUC: ' + _usuClienteSeleccionado.ruc;
    document.getElementById('usu_cliente_header_sub').textContent = _usuClienteSeleccionado.rs;
    mostrarPaso(2);
}

function volverPaso1() { mostrarPaso(1); }

function mostrarPaso(n) {
    document.getElementById('usu_paso1').style.display        = n===1 ? 'block' : 'none';
    document.getElementById('usu_paso2').style.display        = n===2 ? 'block' : 'none';
    document.getElementById('btnSiguientePaso').style.display = n===1 ? 'inline-flex' : 'none';
    document.getElementById('btnGuardarUsuario').style.display = n===2 ? 'inline-flex' : 'none';

    const s1 = document.getElementById('usu_step_ind_1');
    const s2 = document.getElementById('usu_step_ind_2');
    if (n===1) {
        s1.style.color='#059669'; s1.style.borderBottomColor='#059669';
        s2.style.color='#9ca3af'; s2.style.borderBottomColor='transparent';
    } else {
        s1.style.color='#6b7280'; s1.style.borderBottomColor='#6ee7b7';
        s2.style.color='#059669'; s2.style.borderBottomColor='#059669';
    }
}

function normUsu(str) {
    return str.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/[^a-z]/g,'');
}

function generarDatosUsuario() {
    if (!_usuClienteSeleccionado) return;
    const n   = document.getElementById('usu_nombre').value.trim();
    const ap  = document.getElementById('usu_apellido_paterno').value.trim();
    const am  = document.getElementById('usu_apellido_materno').value.trim();
    const dni = document.getElementById('usu_dni').value.trim();

    if (!n || !ap || !am || dni.length < 3) {
        ['usu_codigo_preview','usu_correo_preview','usu_pass_preview'].forEach(id =>
            document.getElementById(id).textContent = '———');
        return;
    }

    const i1     = normUsu(n).charAt(0).toUpperCase();
    const i2     = normUsu(ap).charAt(0).toUpperCase();
    const i3     = normUsu(am).charAt(0).toUpperCase();
    const d3     = dni.substring(0,3).toUpperCase();
    const codigo = i1 + i2 + i3 + d3;
    const correo = normUsu(n) + codigo.toLowerCase() + '@' + _usuClienteSeleccionado.correoBase + '.com';

    document.getElementById('usu_codigo_preview').textContent = codigo;
    document.getElementById('usu_correo_preview').textContent = correo;
    document.getElementById('usu_pass_preview').textContent   = dni;
}

async function guardarUsuario() {
    const btn = document.getElementById('btnGuardarUsuario');
    const n   = document.getElementById('usu_nombre').value.trim();
    const ap  = document.getElementById('usu_apellido_paterno').value.trim();
    const am  = document.getElementById('usu_apellido_materno').value.trim();
    const dni = document.getElementById('usu_dni').value.trim();
    const tel = document.getElementById('usu_telefono').value.trim();
    const cp  = document.getElementById('usu_codigo_pais').value.trim();

    // ── Validaciones de longitud en JS antes del envío ──────────────────────
    const errores = [];
    if (!n)                           errores.push('El nombre es obligatorio.');
    else if (n.length > 100)          errores.push('El nombre no puede superar los 100 caracteres.');
    
    if (!ap)                          errores.push('El apellido paterno es obligatorio.');
    else if (ap.length > 100)         errores.push('El apellido paterno no puede superar los 100 caracteres.');
    
    if (!am)                          errores.push('El apellido materno es obligatorio.');
    else if (am.length > 100)         errores.push('El apellido materno no puede superar los 100 caracteres.');
    
    if (!dni)                         errores.push('El documento es obligatorio.');
    else if (dni.length > 15)         errores.push('El documento no puede superar los 15 dígitos.');
    
    if (!tel)                         errores.push('El teléfono es obligatorio.');

    if (errores.length > 0) {
        errores.forEach(e => showNotification('danger', 'Error', e));
        return;
    }

    const codigo = document.getElementById('usu_codigo_preview').textContent;
    const correo = document.getElementById('usu_correo_preview').textContent;

    if (codigo === '———') {
        showNotification('danger', 'Error', 'Completa los datos para generar el código.');
        return;
    }

    const datos = {
        id_cliente:       _usuClienteSeleccionado.id,
        codigo_usuario:   codigo,
        nombre:           n,
        apellido_paterno: ap,
        apellido_materno: am,
        dni,
        codigo_pais:      cp,
        telefono:         tel,
        correo,
        contrasena:       dni
    };

    btn.disabled    = true;
    btn.textContent = 'Guardando…';

    try {
        const res  = await fetch('{{ route("admin.usuario.guardar") }}', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                                ?? '{{ csrf_token() }}'
            },
            body: JSON.stringify(datos)
        });

        const data = await res.json();

        if (!res.ok) {
            if (data.errors) {
                Object.values(data.errors).flat()
                      .forEach(e => showNotification('danger', 'Error', e));
            } else {
                showNotification('danger', 'Error', data.message || 'Error desconocido.');
            }
            return;
        }

        if (data.ok) {
            cerrarModalUsuario();
            setTimeout(() => {
                ModalSystem.show('success', {
                    title:       '¡Usuario registrado!',
                    text:        `El usuario <strong>${n} ${ap}</strong> fue creado correctamente.`,
                    confirmText: 'Aceptar',
                    onConfirm:   () => location.reload()
                });
            }, 300);
        }

    } catch (err) {
        showNotification('danger', 'Error de conexión', 'No se pudo conectar con el servidor.');
    } finally {
        btn.disabled         = false;
        btn.textContent      = 'Guardar Usuario';
        btn.style.background = 'linear-gradient(135deg,#064e3b,#059669)';
    }
}
</script>