{{-- ══ MODAL CREAR USUARIO ══ --}}
<div class="modal-backdrop" id="modal-backdrop" style="display:none;">
    <div class="modal-box">
        <div class="modal-header">
            <span>Crear nuevo usuario</span>
            <button class="modal-close" onclick="closeModalBtn()">&#x2715;</button>
        </div>
        <form id="form-nuevo-usuario" method="POST" action="{{ route('cliente.usuarios.store') }}">
            @csrf
            <div class="modal-body">

                @if ($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            @foreach ($errors->all() as $error)
                                showNotification('danger', 'Error', '{{ $error }}');
                            @endforeach
                            document.getElementById('modal-backdrop').style.display = 'flex';
                        });
                    </script>
                @endif

                <div class="form-grid">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="inp-nombre"
                               value="{{ old('nombre') }}"
                               required
                               oninput="generarCodigo()"
                               onkeypress="return soloLetras(event)">
                    </div>
                    <div class="form-group">
                        <label>DNI / Documento <span class="label-hint">(mín. 3 caracteres)</span></label>
                        <input type="text" name="dni" id="inp-dni"
                               maxlength="15"
                               value="{{ old('dni') }}"
                               required oninput="generarCodigo()">
                    </div>
                    <div class="form-group">
                        <label>Apellido paterno</label>
                        <input type="text" name="apellido_paterno" id="inp-pat"
                               value="{{ old('apellido_paterno') }}"
                               required
                               oninput="generarCodigo()"
                               onkeypress="return soloLetras(event)">
                    </div>
                    <div class="form-group">
                        <label>Apellido materno</label>
                        <input type="text" name="apellido_materno" id="inp-mat"
                               value="{{ old('apellido_materno') }}"
                               required
                               oninput="generarCodigo()"
                               onkeypress="return soloLetras(event)">
                    </div>

                    <div class="form-group full">
                        <label>Teléfono móvil</label>
                        <input type="tel" id="phone" name="telefono" required
                               placeholder="Ej: 987654321"
                               maxlength="15"
                               value="{{ old('telefono') }}"
                               oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,15)">
                        <input type="hidden" name="codigo_pais" id="codigo_pais">
                    </div>

                    <div class="form-group full">
                        <label>Correo institucional</label>
                        <input type="email" name="correo" id="inp-correo"
                               value="{{ old('correo') }}"
                               required 
                               placeholder="usuario@institucion.com">
                    </div>
                </div>

                <div class="codigo-preview">
                    <div class="cp-text">
                        <span class="cp-label">Código de Usuario</span>
                        <span class="cp-value" id="codigo-display">———</span>
                    </div>
                    <input type="hidden" name="codigo_usuario" id="codigo-hidden">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModalBtn()">Cancelar</button>
                <button type="submit" class="btn-save">Crear usuario</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL DE ÉXITO PROFESIONAL --}}
<div id="modal-exito" class="modal-exito" style="display: none;">
    <div class="modal-exito-content">
        <div class="modal-exito-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="modal-exito-body">
            <h3>¡Usuario creado exitosamente!</h3>
            <p id="exito-mensaje">Las credenciales han sido enviadas al correo del usuario</p>
            <div class="exito-detalle" id="exito-detalle">
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<style>
    .modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,.45); backdrop-filter: blur(4px); z-index: 999; display: flex; align-items: center; justify-content: center; padding: 16px; }
    .modal-box      { background: white; border-radius: 20px; width: 100%; max-width: 560px; max-height: 92vh; overflow-y: auto; overflow-x: visible; margin: 0; scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
    .modal-box::-webkit-scrollbar { width: 5px; }
    .modal-box::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
    .modal-header   { background: linear-gradient(135deg, #13294b 0%, #1a3a6b 100%); padding: 18px 24px; border-radius: 20px 20px 0 0; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 1; }
    .modal-header span { color: white; font-size: 16px; font-weight: 600; }
    .modal-close    { color: rgba(255,255,255,.7); background: none; border: none; font-size: 18px; cursor: pointer; flex-shrink: 0; transition: all 0.2s; width: 30px; height: 30px; border-radius: 50%; }
    .modal-close:hover { background: rgba(255,255,255,0.1); color: white; }
    .modal-body     { padding: 24px; }
    .form-grid      { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group     { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label { font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: .05em; }
    .label-hint     { font-size: 9px; font-weight: 400; color: #94a3b8; text-transform: none; letter-spacing: 0; }
    .form-group input { padding: 11px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; outline: none; transition: all 0.2s; width: 100%; box-sizing: border-box; }
    .form-group input:focus { border-color: #13294b; box-shadow: 0 0 0 3px rgba(19,41,75,0.1); }
    .iti            { width: 100%; }
    #phone          { padding-left: 52px !important; width: 100%; box-sizing: border-box; }
    .codigo-preview { background: linear-gradient(135deg, #13294b 0%, #1a3a6b 100%); border-radius: 12px; padding: 16px 20px; margin-top: 20px; color: white; }
    .cp-text        { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
    .cp-label       { font-size: 11px; text-transform: uppercase; opacity: 0.7; letter-spacing: 1px; }
    .cp-value       { font-size: 20px; font-weight: 700; letter-spacing: 2px; font-family: monospace; }
    .modal-footer   { padding: 20px 24px; border-top: 1px solid #edf2f7; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap; background: #fafcff; border-radius: 0 0 20px 20px; }
    .btn-cancel     { padding: 10px 24px; border-radius: 10px; border: 1.5px solid #e2e8f0; background: white; cursor: pointer; color: #64748b; font-weight: 500; transition: all 0.2s; }
    .btn-cancel:hover { background: #f8fafc; border-color: #cbd5e1; }
    .btn-save       { padding: 10px 28px; border-radius: 10px; background: linear-gradient(135deg, #13294b 0%, #1a3a6b 100%); color: white; border: none; cursor: pointer; font-weight: 600; transition: all 0.2s; }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(19,41,75,0.3); }

    /* Modal de éxito profesional */
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
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes bounceIn {
        0% { transform: scale(0.8); opacity: 0; }
        80% { transform: scale(1.05); }
        100% { transform: scale(1); opacity: 1; }
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

    /* Responsive */
    @media (max-width: 600px) {
        .modal-body   { padding: 18px 16px; }
        .modal-header { padding: 16px 18px; }
        .modal-footer { padding: 16px; }
        .form-grid    { grid-template-columns: 1fr 1fr; gap: 12px; }
        .modal-exito-body { padding: 25px 20px 15px; }
        .modal-exito-footer { padding: 12px 20px 20px; }
    }
    @media (max-width: 420px) {
        .modal-backdrop { padding: 10px; }
        .modal-header span { font-size: 14px; }
        .modal-body   { padding: 14px 12px; }
        .modal-footer { padding: 14px; flex-direction: column; }
        .btn-cancel, .btn-save { width: 100%; text-align: center; }
        .form-grid    { grid-template-columns: 1fr; gap: 12px; }
        .form-group.full { grid-column: 1; }
        .cp-value     { font-size: 16px; letter-spacing: 1px; }
    }
</style>

<script>
    let exitoCallback = null;

    // ── Teléfono ──────────────────────────────────────────────────────────
    const phoneInput = window.intlTelInput(document.querySelector("#phone"), {
        initialCountry: "pe",
        preferredCountries: ["pe", "cl", "co"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    document.querySelector("#phone").addEventListener('countrychange', function() {
        document.getElementById('codigo_pais').value = '+' + phoneInput.getSelectedCountryData().dialCode;
    });

    // ── Validación frontend y submit ──────────────────────────────────────
    document.getElementById("form-nuevo-usuario").addEventListener("submit", async function(e) {
        e.preventDefault();

        const errores = [];

        const nombre = document.getElementById('inp-nombre').value.trim();
        const pat    = document.getElementById('inp-pat').value.trim();
        const mat    = document.getElementById('inp-mat').value.trim();
        const dni    = document.getElementById('inp-dni').value.trim();
        const correo = document.getElementById('inp-correo').value.trim();
        const phone  = phoneInput.getNumber();
        
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!nombre)             errores.push('El nombre es obligatorio.');
        if (!pat)                errores.push('El apellido paterno es obligatorio.');
        if (!mat)                errores.push('El apellido materno es obligatorio.');
        if (!dni)                errores.push('El documento es obligatorio.');
        else if (dni.length < 3) errores.push('El documento debe tener al menos 3 caracteres.');
        if (!correo)             errores.push('El correo institucional es obligatorio.');
        else if (!regexEmail.test(correo)) errores.push('Ingrese un correo electrónico válido.');
        if (!phone)              errores.push('El teléfono es obligatorio.');

        if (errores.length > 0) {
            errores.forEach(error => showNotification('danger', 'Error', error));
            return;
        }

        document.getElementById('codigo_pais').value = '+' + phoneInput.getSelectedCountryData().dialCode;

        const form = this;
        const formData = new FormData(form);
        const btn = form.querySelector('.btn-save');

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando usuario...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.ok) {
                closeModalBtn();
                
                // Mostrar modal de éxito profesional
                mostrarModalExito(correo);
                
            } else {
                if (data.errors) {
                    Object.values(data.errors).flat().forEach(error => {
                        showNotification('danger', 'Error', error);
                    });
                } else {
                    showNotification('danger', 'Error', data.message || 'No se pudo crear el usuario.');
                }
            }

        } catch (error) {
            showNotification('danger', 'Error de conexión', 'No se pudo conectar con el servidor.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Crear usuario';
        }
    });

    // ── Modal de éxito profesional ─────────────────────────────────────────
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

    // Cerrar modal con click fuera
    document.getElementById('modal-exito')?.addEventListener('click', function(e) {
        if (e.target === this) cerrarModalExito();
    });

    function soloLetras(e) {
        const tecla = e.key;
        return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/.test(tecla) || tecla === 'Backspace' || tecla === 'Tab';
    }

    function limpiar(str) {
        return str
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/[^a-z0-9]/g, "");
    }

    function primeraInicial(campoId) {
        const val = document.getElementById(campoId).value.trim();
        if (!val) return '';
        return limpiar(val.split(/\s+/)[0]).charAt(0).toUpperCase();
    }

    function generarCodigo() {
        const iN     = primeraInicial('inp-nombre');
        const iP     = primeraInicial('inp-pat');
        const iM     = primeraInicial('inp-mat');
        const dni    = document.getElementById('inp-dni').value.trim();
        const prefijo = limpiar(dni).substring(0, 3).toUpperCase();

        if (iN && iP && iM && prefijo.length === 3) {
            const code = `${iN}${iP}${iM}-${prefijo}`;
            document.getElementById('codigo-display').innerText = code;
            document.getElementById('codigo-hidden').value      = code;
        } else {
            document.getElementById('codigo-display').innerText = '———';
            document.getElementById('codigo-hidden').value      = '';
        }
    }

    function closeModalBtn() {
        document.getElementById('modal-backdrop').style.display = 'none';
    }
    
    function openModal() {
        document.getElementById('modal-backdrop').style.display = 'flex';
        generarCodigo();
    }

    @if ($errors->any())
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('modal-backdrop').style.display = 'flex';
        generarCodigo();
    });
    @endif
</script>