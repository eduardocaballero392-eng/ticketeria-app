{{-- ══ MODAL CREAR TÉCNICO (ADMIN) ══ --}}
<div id="modalCrearTecnico" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(10,5,25,0.72);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="width:100%;max-width:540px;margin:16px;animation:tSlideIn .3s cubic-bezier(.16,1,.3,1)">
        <div style="background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 30px 60px rgba(0,0,0,.35)">

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#4c1d95,#7c3aed);padding:22px 28px;display:flex;align-items:center;justify-content:space-between">
                <div style="display:flex;align-items:center;gap:14px">
                    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px">🔧</div>
                    <div>
                        <div style="color:#fff;font-weight:700;font-size:1.1rem;font-family:'Segoe UI',sans-serif">Registrar Técnico</div>
                        <div style="color:rgba(255,255,255,.7);font-size:.75rem">Código y correo autogenerados</div>
                    </div>
                </div>
                <button onclick="cerrarModalTecnico()" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:32px;height:32px;border-radius:8px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:.2s" onmouseover="this.style.background='rgba(239,68,68,.7)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">✕</button>
            </div>

            {{-- Body --}}
            <div style="padding:26px 28px 10px;font-family:'Segoe UI',sans-serif">

                {{-- Nombre + Apellido Paterno --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Nombre <span style="color:#7c3aed">*</span></label>
                        <input id="tec_nombre" type="text" placeholder="Ej. Carlos"
                               style="width:100%;padding:10px 13px;border:2px solid #ede9fe;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#faf8ff;color:#1e1b4b"
                               onfocus="this.style.borderColor='#7c3aed';this.style.background='#fff'"
                               onblur="this.style.borderColor='#ede9fe';this.style.background='#faf8ff'"
                               oninput="generarDatosTecnico()">
                    </div>
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Apellido Paterno <span style="color:#7c3aed">*</span></label>
                        <input id="tec_apellido_paterno" type="text" placeholder="Ej. García"
                               style="width:100%;padding:10px 13px;border:2px solid #ede9fe;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#faf8ff;color:#1e1b4b"
                               onfocus="this.style.borderColor='#7c3aed';this.style.background='#fff'"
                               onblur="this.style.borderColor='#ede9fe';this.style.background='#faf8ff'"
                               oninput="generarDatosTecnico()">
                    </div>
                </div>

                {{-- Apellido Materno + DNI --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">Apellido Materno <span style="color:#7c3aed">*</span></label>
                        <input id="tec_apellido_materno" type="text" placeholder="Ej. López"
                               style="width:100%;padding:10px 13px;border:2px solid #ede9fe;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#faf8ff;color:#1e1b4b"
                               onfocus="this.style.borderColor='#7c3aed';this.style.background='#fff'"
                               onblur="this.style.borderColor='#ede9fe';this.style.background='#faf8ff'"
                               oninput="generarDatosTecnico()">
                    </div>
                    <div>
                        <label style="font-size:.78rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">DNI <span style="color:#7c3aed">*</span></label>
                        <input id="tec_dni" type="text" placeholder="8 dígitos" maxlength="8"
                               oninput="this.value=this.value.replace(/[^0-9]/g,'');generarDatosTecnico()"
                               style="width:100%;padding:10px 13px;border:2px solid #ede9fe;border-radius:10px;font-size:.9rem;outline:none;transition:.2s;box-sizing:border-box;background:#faf8ff;color:#1e1b4b"
                               onfocus="this.style.borderColor='#7c3aed';this.style.background='#fff'"
                               onblur="this.style.borderColor='#ede9fe';this.style.background='#faf8ff'">
                    </div>
                </div>

                {{-- Datos autogenerados --}}
                <div style="background:linear-gradient(135deg,#f5f0ff,#ede9fe);border:1px solid #ddd6fe;border-radius:12px;padding:14px 18px;margin-bottom:6px">
                    <div style="font-size:.72rem;font-weight:700;color:#6d28d9;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px">⚡ Datos autogenerados</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px">
                        <div>
                            <div style="font-size:.72rem;color:#6b7280;font-weight:600;margin-bottom:4px">🪪 Código</div>
                            <div id="tec_codigo_preview" style="font-size:.85rem;color:#5b21b6;font-weight:700;background:#fff;padding:7px 10px;border-radius:8px;border:1px solid #ddd6fe;letter-spacing:.05em">———</div>
                        </div>
                        <div style="grid-column:span 2">
                            <div style="font-size:.72rem;color:#6b7280;font-weight:600;margin-bottom:4px">📧 Correo</div>
                            <div id="tec_correo_preview" style="font-size:.78rem;color:#5b21b6;font-weight:600;background:#fff;padding:7px 10px;border-radius:8px;border:1px solid #ddd6fe;word-break:break-all">———</div>
                        </div>
                    </div>
                    <div style="margin-top:10px">
                        <div style="font-size:.72rem;color:#6b7280;font-weight:600;margin-bottom:4px">🔑 Contraseña inicial</div>
                        <div id="tec_pass_preview" style="font-size:.82rem;color:#5b21b6;font-weight:600;background:#fff;padding:7px 10px;border-radius:8px;border:1px solid #ddd6fe;letter-spacing:.08em">———</div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div style="padding:14px 28px 24px;display:flex;gap:10px;justify-content:flex-end">
                <button onclick="cerrarModalTecnico()" style="padding:10px 22px;border-radius:10px;border:2px solid #ede9fe;background:#fff;color:#6b7280;font-weight:600;cursor:pointer;font-size:.9rem;transition:.2s" onmouseover="this.style.background='#f5f3ff'" onmouseout="this.style.background='#fff'">Cancelar</button>
                <button id="btnGuardarTecnico" onclick="guardarTecnico()" style="padding:10px 26px;border-radius:10px;border:none;background:linear-gradient(135deg,#4c1d95,#7c3aed);color:#fff;font-weight:700;cursor:pointer;font-size:.9rem;box-shadow:0 4px 12px rgba(124,58,237,.3);transition:.2s" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">Guardar Técnico</button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes tSlideIn { from{transform:translateY(-20px) scale(.97);opacity:0} to{transform:none;opacity:1} }
</style>

<script>
const _tecCodigosUsados = new Set();

function abrirModalTecnico() {
    const m = document.getElementById('modalCrearTecnico');
    m.style.display = 'flex';
    ['tec_nombre','tec_apellido_paterno','tec_apellido_materno','tec_dni'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    ['tec_codigo_preview','tec_correo_preview','tec_pass_preview'].forEach(id => {
        document.getElementById(id).textContent = '———';
    });
    const btn = document.getElementById('btnGuardarTecnico');
    btn.disabled         = false;
    btn.textContent      = 'Guardar Técnico';
    btn.style.background = 'linear-gradient(135deg,#4c1d95,#7c3aed)';
}

function cerrarModalTecnico() {
    document.getElementById('modalCrearTecnico').style.display = 'none';
}

function normStr(str) {
    return str.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/[^a-z]/g,'');
}

function generarDatosTecnico() {
    const n   = document.getElementById('tec_nombre').value.trim();
    const ap  = document.getElementById('tec_apellido_paterno').value.trim();
    const am  = document.getElementById('tec_apellido_materno').value.trim();
    const dni = document.getElementById('tec_dni').value.trim();

    if (!n || !ap || !am || dni.length < 3) {
        ['tec_codigo_preview','tec_correo_preview','tec_pass_preview'].forEach(id =>
            document.getElementById(id).textContent = '———');
        return;
    }

    const i1 = normStr(n).charAt(0).toUpperCase();
    const i2 = normStr(ap).charAt(0).toUpperCase();
    const i3 = normStr(am).charAt(0).toUpperCase();
    const d3 = dni.substring(0, 3);

    let codigo = i1 + i2 + i3 + d3;
    let idx = 3;
    while (_tecCodigosUsados.has(codigo) && idx < dni.length) {
        codigo = i1 + i2 + i3 + dni.substring(0, idx + 1);
        idx++;
    }

    const correo = normStr(n) + codigo.toLowerCase() + '@gmail.com';

    document.getElementById('tec_codigo_preview').textContent = codigo;
    document.getElementById('tec_correo_preview').textContent = correo;
    document.getElementById('tec_pass_preview').textContent   = dni;
}

async function guardarTecnico() {
    const btn = document.getElementById('btnGuardarTecnico');
    const n   = document.getElementById('tec_nombre').value.trim();
    const ap  = document.getElementById('tec_apellido_paterno').value.trim();
    const am  = document.getElementById('tec_apellido_materno').value.trim();
    const dni = document.getElementById('tec_dni').value.trim();

    // ── Validaciones ──────────────────────────────────────────────────────
    const errores = [];
    if (!n)                errores.push('El nombre es obligatorio.');
    if (!ap)               errores.push('El apellido paterno es obligatorio.');
    if (!am)               errores.push('El apellido materno es obligatorio.');
    if (!dni)              errores.push('El DNI es obligatorio.');
    else if (dni.length !== 8) errores.push('El DNI debe tener 8 dígitos.');

    if (errores.length > 0) {
        errores.forEach(e => showNotification('danger', 'Error', e));
        return;
    }

    const codigo = document.getElementById('tec_codigo_preview').textContent;
    const correo = document.getElementById('tec_correo_preview').textContent;

    if (codigo === '———') {
        showNotification('danger', 'Error', 'Completa los datos para generar el código.');
        return;
    }

    const datos = {
        nombre:           n,
        apellido_paterno: ap,
        apellido_materno: am,
        dni,
        correo,
        contrasena:       dni,
        codigo_tecnico:   codigo
    };

    btn.disabled    = true;
    btn.textContent = 'Guardando…';

    try {
        const res  = await fetch('{{ route("admin.tecnico.guardar") }}', {
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
            cerrarModalTecnico();
            setTimeout(() => {
                ModalSystem.show('success', {
                    title:       '¡Técnico registrado!',
                    text:        `El técnico <strong>${n} ${ap}</strong> fue creado correctamente.`,
                    confirmText: 'Aceptar',
                    onConfirm:   () => location.reload()
                });
            }, 300);
        }

    } catch (err) {
        showNotification('danger', 'Error de conexión', 'No se pudo conectar con el servidor.');
    } finally {
        btn.disabled         = false;
        btn.textContent      = 'Guardar Técnico';
        btn.style.background = 'linear-gradient(135deg,#4c1d95,#7c3aed)';
    }
}
</script>