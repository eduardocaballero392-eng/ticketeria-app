{{-- ══ MODAL VER / EDITAR DETALLE ══ --}}
<div id="modalVerDetalle" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(10,15,30,0.7);backdrop-filter:blur(6px);align-items:center;justify-content:center;" onclick="if(event.target===this)cerrarModalDetalle()">
    <div style="width:100%;max-width:560px;margin:16px;animation:dtSlideIn .3s cubic-bezier(.16,1,.3,1);max-height:90vh;overflow-y:auto">
        <div style="background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 30px 60px rgba(0,0,0,.3)">

            {{-- Header dinámico --}}
            <div id="dt_header" style="padding:22px 28px;display:flex;align-items:center;justify-content:space-between">
                <div style="display:flex;align-items:center;gap:14px">
                    <div id="dt_header_icon" style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px"></div>
                    <div>
                        <div id="dt_header_titulo" style="color:#fff;font-weight:700;font-size:1.1rem;font-family:'Segoe UI',sans-serif"></div>
                        <div id="dt_header_sub"    style="color:rgba(255,255,255,.7);font-size:.75rem"></div>
                    </div>
                </div>
                <button onclick="cerrarModalDetalle()" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:32px;height:32px;border-radius:8px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center" onmouseover="this.style.background='rgba(239,68,68,.7)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">✕</button>
            </div>

            {{-- Body --}}
            <div style="padding:24px 28px 10px;font-family:'Segoe UI',sans-serif">

                {{-- Badge estado --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                    <div id="dt_badge_estado" style="display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:20px;font-size:.78rem;font-weight:700"></div>
                    <div id="dt_codigo_badge" style="font-size:.78rem;color:#6b7280;font-family:monospace;font-weight:600"></div>
                </div>

                {{-- Campos editables --}}
                <div id="dt_campos" style="display:grid;grid-template-columns:1fr 1fr;gap:14px"></div>

                {{-- Campo readonly info --}}
                <div style="background:#f8fafc;border:1px dashed #cbd5e1;border-radius:10px;padding:12px 16px;margin-top:14px;font-size:.78rem;color:#64748b">
                    🔒 Correo, código y documento no son editables por seguridad.
                </div>

            </div>

            {{-- Footer --}}
            <div style="padding:14px 28px 24px;display:flex;gap:10px;justify-content:flex-end">
                <button onclick="cerrarModalDetalle()" style="padding:10px 22px;border-radius:10px;border:2px solid #e5e7eb;background:#fff;color:#6b7280;font-weight:600;cursor:pointer;font-size:.9rem" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#fff'">Cancelar</button>
                <button id="btnGuardarDetalle" onclick="guardarDetalle()" style="padding:10px 26px;border-radius:10px;border:none;color:#fff;font-weight:700;cursor:pointer;font-size:.9rem;transition:.2s" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='none'">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes dtSlideIn { from{transform:translateY(-20px) scale(.97);opacity:0} to{transform:none;opacity:1} }
</style>

<script>
let _dtTipo = null;
let _dtId   = null;

// ── Configuración por tipo ────────────────────────────────────────
const _dtConfig = {
    cliente: {
        icon:       '🏢',
        gradient:   'linear-gradient(135deg,#0f4c81,#1a73e8)',
        btnColor:   'linear-gradient(135deg,#0f4c81,#1a73e8)',
        titulo:     'Detalle Cliente',
        url:        (id) => `/admin/detalle/cliente/${id}`,
        urlGuardar: (id) => `/admin/editar/cliente/${id}`,
        campos: [
            { id:'dt_razon_social', label:'Razón Social',  key:'razon_social', editable:true,  full:true },
            { id:'dt_ruc',         label:'RUC',            key:'ruc',          editable:false },
            { id:'dt_sedes',       label:'Sedes',          key:'sedes',        editable:true  },
            { id:'dt_rubro',       label:'Rubro',          key:'rubro',        editable:true  },
            { id:'dt_correo',      label:'Correo',         key:'correo',       editable:false, full:true },
        ],
        codigo: (d) => `RUC: ${d.ruc}`,
        sub:    (d) => d.razon_social,
    },
    usuario: {
        icon:       '👤',
        gradient:   'linear-gradient(135deg,#064e3b,#059669)',
        btnColor:   'linear-gradient(135deg,#064e3b,#059669)',
        titulo:     'Detalle Usuario',
        url:        (id) => `/admin/detalle/usuario/${id}`,
        urlGuardar: (id) => `/admin/editar/usuario/${id}`,
        campos: [
            { id:'dt_nombre',    label:'Nombre',           key:'nombre',           editable:true  },
            { id:'dt_ap',        label:'Apellido Paterno', key:'apellido_paterno', editable:true  },
            { id:'dt_am',        label:'Apellido Materno', key:'apellido_materno', editable:true  },
            { id:'dt_dni',       label:'DNI',              key:'dni',              editable:false },
            { id:'dt_telefono',  label:'Teléfono',         key:'telefono',         editable:true  },
            { id:'dt_correo',    label:'Correo',           key:'correo',           editable:false, full:true },
            { id:'dt_codigo',    label:'Código Usuario',   key:'codigo_usuario',   editable:false },
        ],
        codigo: (d) => d.codigo_usuario,
        sub:    (d) => `${d.nombre} ${d.apellido_paterno}`,
    },
    tecnico: {
        icon:       '🔧',
        gradient:   'linear-gradient(135deg,#4c1d95,#7c3aed)',
        btnColor:   'linear-gradient(135deg,#4c1d95,#7c3aed)',
        titulo:     'Detalle Técnico',
        url:        (id) => `/admin/detalle/tecnico/${id}`,
        urlGuardar: (id) => `/admin/editar/tecnico/${id}`,
        campos: [
            { id:'dt_nombre',    label:'Nombre',           key:'nombre',           editable:true  },
            { id:'dt_ap',        label:'Apellido Paterno', key:'apellido_paterno', editable:true  },
            { id:'dt_am',        label:'Apellido Materno', key:'apellido_materno', editable:true  },
            { id:'dt_dni',       label:'DNI',              key:'dni',              editable:false },
            { id:'dt_correo',    label:'Correo',           key:'correo',           editable:false, full:true },
            { id:'dt_codigo',    label:'Código Técnico',   key:'codigo_tecnico',   editable:false },
        ],
        codigo: (d) => d.codigo_tecnico,
        sub:    (d) => `${d.nombre} ${d.apellido_paterno}`,
    },
};

// ── Abrir modal ───────────────────────────────────────────────────
async function abrirDetalle(tipo, id) {
    _dtTipo = tipo;
    _dtId   = id;

    const cfg = _dtConfig[tipo];

    // Header
    document.getElementById('dt_header').style.background      = cfg.gradient;
    document.getElementById('dt_header_icon').textContent      = cfg.icon;
    document.getElementById('dt_header_titulo').textContent    = cfg.titulo;
    document.getElementById('dt_header_sub').textContent       = 'Cargando…';
    document.getElementById('btnGuardarDetalle').style.background = cfg.btnColor;

    // Mostrar modal con spinner
    document.getElementById('dt_campos').innerHTML = `
        <div style="grid-column:1/-1;text-align:center;padding:20px;color:#94a3b8">
            ⏳ Cargando datos…
        </div>`;
    document.getElementById('modalVerDetalle').style.display = 'flex';

    try {
        const res  = await fetch(cfg.url(id), {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Error al cargar');

        // Header sub
        document.getElementById('dt_header_sub').textContent = cfg.sub(data);
        document.getElementById('dt_codigo_badge').textContent = cfg.codigo(data);

        // Badge estado
        const badge = document.getElementById('dt_badge_estado');
        if (data.activo) {
            badge.style.background = '#dcfce7';
            badge.style.color      = '#15803d';
            badge.textContent      = '✔ Activo';
        } else {
            badge.style.background = '#fee2e2';
            badge.style.color      = '#dc2626';
            badge.textContent      = '✖ Inactivo';
        }

        // Renderizar campos
        renderCampos(cfg.campos, data);

    } catch(e) {
        showNotification('danger', 'Error', e.message);
        cerrarModalDetalle();
    }
}

// ── Renderizar campos ─────────────────────────────────────────────
function renderCampos(campos, data) {
    const container = document.getElementById('dt_campos');
    container.innerHTML = '';

    campos.forEach(campo => {
        const valor = data[campo.key] ?? '';
        const full  = campo.full ? 'grid-column:1/-1;' : '';

        if (campo.editable) {
            container.insertAdjacentHTML('beforeend', `
                <div style="${full}">
                    <label style="font-size:.75rem;font-weight:600;color:#374151;display:block;margin-bottom:5px">
                        ${campo.label}
                    </label>
                    <input id="${campo.id}" type="text" value="${valor}"
                           style="width:100%;padding:10px 13px;border:2px solid #e5e7eb;border-radius:10px;font-size:.88rem;outline:none;transition:.2s;box-sizing:border-box;background:#f9fafb;color:#111827"
                           onfocus="this.style.borderColor='#6366f1';this.style.background='#fff'"
                           onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                </div>
            `);
        } else {
            container.insertAdjacentHTML('beforeend', `
                <div style="${full}">
                    <label style="font-size:.75rem;font-weight:600;color:#9ca3af;display:block;margin-bottom:5px">
                        ${campo.label} <span style="font-size:.7rem">(no editable)</span>
                    </label>
                    <div style="width:100%;padding:10px 13px;border:1px solid #f1f5f9;border-radius:10px;font-size:.88rem;box-sizing:border-box;background:#f8fafc;color:#94a3b8;cursor:not-allowed">
                        ${valor || '—'}
                    </div>
                </div>
            `);
        }
    });
}

// ── Guardar cambios ───────────────────────────────────────────────
async function guardarDetalle() {
    const btn = document.getElementById('btnGuardarDetalle');
    const cfg = _dtConfig[_dtTipo];

    // Recolectar solo campos editables
    const datos = {};
    cfg.campos.filter(c => c.editable).forEach(campo => {
        const el = document.getElementById(campo.id);
        if (el) datos[campo.key] = el.value.trim();
    });

    // Validar que no estén vacíos
    const vacio = Object.entries(datos).find(([k,v]) => !v);
    if (vacio) {
        showNotification('warning', 'Atención', 'Todos los campos son obligatorios.');
        return;
    }

    btn.disabled    = true;
    btn.textContent = 'Guardando…';

    try {
        const res  = await fetch(cfg.urlGuardar(_dtId), {
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
            cerrarModalDetalle();
            setTimeout(() => {
                ModalSystem.show('success', {
                    title:       '¡Cambios guardados!',
                    text:        'Los datos fueron actualizados correctamente.',
                    confirmText: 'Entendido',
                    onConfirm:   () => location.reload()
                });
            }, 300);
        }

    } catch(e) {
        showNotification('danger', 'Error de conexión', 'No se pudo conectar con el servidor.');
    } finally {
        btn.disabled        = false;
        btn.textContent     = 'Guardar Cambios';
        btn.style.background = cfg.btnColor;
    }
}

function cerrarModalDetalle() {
    document.getElementById('modalVerDetalle').style.display = 'none';
    _dtTipo = null;
    _dtId   = null;
}
</script>