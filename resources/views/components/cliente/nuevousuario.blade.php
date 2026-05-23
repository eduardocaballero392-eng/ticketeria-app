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

                @if (session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            showNotification('success', 'Correcto', '{{ session("success") }}');
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

                    <div class="form-group">
                        <label>Correo Institucional</label>
                        <div class="auto-gen-box">✨ Autogenerado por sistema</div>
                    </div>
                    <div class="form-group">
                        <label>Acceso inicial</label>
                        <div class="auto-gen-box">🔑 Password = Documento</div>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<style>
    .modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 999; display: flex; align-items: center; justify-content: center; padding: 16px; }
    .modal-box      { background: white; border-radius: 16px; width: 100%; max-width: 540px; max-height: 92vh; overflow-y: auto; overflow-x: visible; margin: 0; scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
    .modal-box::-webkit-scrollbar { width: 5px; }
    .modal-box::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
    .modal-header   { background: #13294b; padding: 18px 24px; border-radius: 16px 16px 0 0; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 1; }
    .modal-header span { color: white; font-size: 16px; font-weight: 500; }
    .modal-close    { color: rgba(255,255,255,.7); background: none; border: none; font-size: 18px; cursor: pointer; flex-shrink: 0; }
    .modal-body     { padding: 24px; }
    .form-grid      { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-group     { display: flex; flex-direction: column; gap: 5px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .04em; }
    .label-hint     { font-size: 10px; font-weight: 400; color: #94a3b8; text-transform: none; letter-spacing: 0; }
    .form-group input { padding: 10px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none; transition: border-color .15s; width: 100%; box-sizing: border-box; }
    .form-group input:focus { border-color: #13294b; }
    .auto-gen-box   { background: #f8fafc; border: 1px dashed #cbd5e1; padding: 10px; border-radius: 8px; font-size: 12px; color: #475569; display: flex; align-items: center; gap: 8px; height: 41px; }
    .iti            { width: 100%; }
    #phone          { padding-left: 52px !important; width: 100%; box-sizing: border-box; }
    .codigo-preview { background: #13294b; border-radius: 10px; padding: 15px; margin-top: 16px; color: white; }
    .cp-text        { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
    .cp-label       { font-size: 11px; text-transform: uppercase; opacity: 0.8; }
    .cp-value       { font-size: 18px; font-weight: 700; letter-spacing: 2px; }
    .modal-footer   { padding: 16px 24px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap; }
    .btn-cancel     { padding: 10px 20px; border-radius: 8px; border: 1px solid #e2e8f0; background: none; cursor: pointer; color: #64748b; }
    .btn-save       { padding: 10px 25px; border-radius: 8px; background: #13294b; color: white; border: none; cursor: pointer; font-weight: 500; }

    /* ── Tablet (≤ 600px) ── */
    @media (max-width: 600px) {
        .modal-body   { padding: 18px 16px; }
        .modal-header { padding: 16px 18px; }
        .modal-footer { padding: 14px 16px; }
        .form-grid    { grid-template-columns: 1fr 1fr; gap: 10px; }
    }

    /* ── Móvil (≤ 420px) ── */
    @media (max-width: 420px) {
        .modal-backdrop { padding: 10px; }
        .modal-header span { font-size: 14px; }
        .modal-body   { padding: 14px 12px; }
        .modal-footer { padding: 12px; flex-direction: column-reverse; }
        .btn-cancel, .btn-save { width: 100%; text-align: center; }
        .form-grid    { grid-template-columns: 1fr; gap: 10px; }
        .form-group.full { grid-column: 1; }
        .cp-value     { font-size: 15px; letter-spacing: 1px; }
    }
</style>

<script>
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
    const phone  = phoneInput.getNumber();

    if (!nombre)             errores.push('El nombre es obligatorio.');
    if (!pat)                errores.push('El apellido paterno es obligatorio.');
    if (!mat)                errores.push('El apellido materno es obligatorio.');
    if (!dni)                errores.push('El documento es obligatorio.');
    else if (dni.length < 3) errores.push('El documento debe tener al menos 3 caracteres.');
    if (!phone)              errores.push('El teléfono es obligatorio.');

    if (errores.length > 0) {
        errores.forEach(error => showNotification('danger', 'Error', error));
        return;
    }

    // Guardar código de país
    document.getElementById('codigo_pais').value =
        '+' + phoneInput.getSelectedCountryData().dialCode;

    const form = this;
    const formData = new FormData(form);
    const btn = form.querySelector('.btn-save');

    // Desactivar botón
    btn.disabled = true;
    btn.textContent = 'Creando usuario...';

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

            setTimeout(() => {
                ModalSystem.show('success', {
                    title: 'Usuario creado',
                    text: `Código: ${data.codigo} - 
                    Correo: ${data.correo}`,    
                    confirmText: 'Aceptar',
                    onConfirm: () => {
                        location.reload();
                    }
                });
            }, 300);
        } else {
            if (data.errors) {
                Object.values(data.errors).flat().forEach(error => {
                    showNotification('danger', 'Error', error);
                });
            } else {
                showNotification(
                    'danger',
                    'Error',
                    data.message || 'No se pudo crear el usuario.'
                );
            }
        }

    } catch (error) {
        showNotification(
            'danger',
            'Error de conexión',
            'No se pudo conectar con el servidor.'
        );
    } finally {
        btn.disabled = false;
        btn.textContent = 'Crear usuario';
    }
});

    function soloLetras(e) {
        const tecla = e.key;
        return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/.test(tecla) || tecla === 'Backspace' || tecla === 'Tab';
    }

    // ── Helpers ───────────────────────────────────────────────────────────
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

    // ── Generar código usuario ────────────────────────────────────────────
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

    // ── Abrir / cerrar modal ──────────────────────────────────────────────
    function closeModalBtn() {
        document.getElementById('modal-backdrop').style.display = 'none';
    }

    @if ($errors->any())
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('modal-backdrop').style.display = 'flex';
        // Regenerar código con los valores que old() ya restauró en los inputs
        generarCodigo();
    });
    @endif
</script>