<div class="dashboard-layout">
    {{-- Sidebar del técnico --}}
    @include('components.tecnico.sidebar-tecnico')
    @include('components.notificaciones.alertas')

    <main class="main-content">
        <div class="content-wrapper">
            <div class="header">
                <h2>Mi Perfil de Técnico</h2>
                <p>Gestiona tu información personal y de contacto dentro de la plataforma</p>
            </div>

            <div class="profile-container">
                <form class="glass-form" id="perfil-form" method="POST" action="{{ route('tecnico.update') }}">
                    @csrf

                    {{-- Notificación de éxito --}}
                    @if(session('success'))
                        <script>
                            window.addEventListener('load', () => {
                                ModalSystem.show('success', {
                                    title: '¡Datos actualizados!',
                                    text: '{{ session('success') }}',
                                    confirmText: 'Entendido'
                                });
                            });
                        </script>
                    @endif

                    {{-- Notificación de error --}}
                    @if(session('error'))
                        <script>
                            window.addEventListener('load', () => {
                                if (typeof showNotification === 'function') {
                                    showNotification('danger', 'Error de validación', '{{ session('error') }}');
                                } else {
                                    alert('Error: {{ session('error') }}');
                                }
                            });
                        </script>
                    @endif

                    {{-- Sección: Información de Identidad --}}
                    <div class="section-label">
                        <div class="section-icon">
                            <svg viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                        </div>
                        <span>Información de Identidad</span>
                    </div>

                    <div class="form-grid">
                        <div class="input-group">
                            <label>Código de Técnico <small>(No editable)</small></label>
                            <input type="text" value="{{ $tecnico->codigo_tecnico ?? $tecnico->codigo_usuario }}" class="input-readonly" readonly>
                        </div>

                        <div class="input-group">
                            <label>DNI <small>(No editable)</small></label>
                            <input type="text" value="{{ $tecnico->dni }}" class="input-readonly" readonly>
                        </div>

                        <div class="input-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $tecnico->nombre) }}" required>
                        </div>

                        <div class="input-group">
                            <label>Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $tecnico->apellido_paterno) }}" required>
                        </div>

                        <div class="input-group">
                            <label>Apellido Materno</label>
                            <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $tecnico->apellido_materno) }}" required>
                        </div>

                        <div class="input-group">
                            <label>Estado de Cuenta</label>
                            <input type="text" value="{{ ($tecnico->activo ?? true) ? 'Activo' : 'Inactivo' }}" class="input-readonly" readonly>
                        </div>
                    </div>

                    {{-- Sección: Contacto y Seguridad --}}
                    <div class="section-label" style="margin-top: 30px;">
                        <div class="section-icon">
                            <svg viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.746 4.477a1 1 0 01-.769 1.134l-1.937.387a11.001 11.001 0 004.56 4.56l.387-1.937a1 1 0 011.134-.769l4.477.746a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                        </div>
                        <span>Contacto y Seguridad</span>
                    </div>

                    <div class="form-grid">
                        <div class="input-group">
                            <label>Correo Electrónico <small>(No editable)</small></label>
                            <input type="email" name="correo" value="{{ $tecnico->correo }}" class="input-readonly" readonly>
                        </div>

                        <div class="input-group-phone">
                            <label>Teléfono</label>
                            <div class="phone-container">
                                <input type="text" name="codigo_pais" value="{{ $tecnico->codigo_pais ?? '+51' }}" style="width: 60px; text-align: center;" placeholder="+51" required>
                                <input type="text" name="telefono" value="{{ old('telefono', $tecnico->telefono) }}" style="flex: 1;" required>
                            </div>
                        </div>
                    </div>

                    {{-- Footer del formulario --}}
                    <div class="form-footer">
                        <div class="footer-hint">
                            <svg viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16A8 8 0 0010 2zm1 11H9V9h2v4zm0-6H9V5h2v2z"/></svg>
                            Última actualización: {{ ($tecnico->updated_at ?? now())->format('d/m/Y H:i') }}
                        </div>
                        <div class="btn-actions">
                            <a href="{{ route('tecnico.datos') }}" class="btn-discard">Descartar</a>
                            <button type="submit" class="btn-save" id="btn-guardar" disabled>
                                <svg viewBox="0 0 20 20"><path d="M15.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.4L7 12.6l8.3-8.3a1 1 0 011.4 0z"/></svg>
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<style>
    /* REUTILIZANDO TU CSS BASE (IDÉNTICO AL DE USUARIO) */
    .dashboard-layout { display: flex; min-height: 100vh; }
    .main-content { flex: 1; margin-left: 260px; padding: 40px; background: #eef4fb; transition: margin-left 0.35s; min-width: 0; }
    body.sb-collapsed .main-content { margin-left: 70px; }

    .header { margin-bottom: 28px; }
    .header h2 { font-size: 22px; font-weight: 600; color: #0a2d4a; margin-bottom: 6px; }
    .header p { font-size: 13.5px; color: #5a8ab5; }

    .glass-form { background: white; padding: 32px; border-radius: 16px; border: 0.5px solid #c8def5; box-shadow: 0 4px 20px rgba(10, 61, 107, 0.06); }
    
    .section-label { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
    .section-icon { width: 30px; height: 30px; border-radius: 8px; background: #e6f1fb; display: flex; align-items: center; justify-content: center; }
    .section-icon svg { width: 15px; height: 15px; fill: #1a7fd4; }
    .section-label span { font-size: 13px; font-weight: 600; color: #0a3d6b; text-transform: uppercase; letter-spacing: 0.05em; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .input-group { display: flex; flex-direction: column; gap: 6px; }
    .input-group.full { grid-column: span 2; }
    .input-group label { font-size: 11.5px; font-weight: 600; color: #3a6a9a; text-transform: uppercase; }
    
    .input-group input { padding: 11px 14px; border: 1px solid #d0e6f7; border-radius: 9px; font-size: 13.5px; outline: none; transition: 0.2s; width: 100%; box-sizing: border-box;}
    .input-group input:focus { border-color: #1a7fd4; box-shadow: 0 0 0 3px rgba(26, 127, 212, 0.1); }
    
    .input-readonly { background: #f5f9fe !important; color: #8aaac8 !important; cursor: not-allowed; }

    /* Estilo para teléfono */
    .phone-container { display: flex; gap: 8px; }
    .phone-container input { padding: 11px 14px; border: 1px solid #d0e6f7; border-radius: 9px; font-size: 13.5px; }

    .form-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 28px; padding-top: 22px; border-top: 1px solid #e8f2fb; }
    .footer-hint { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #7aabcc; }
    .footer-hint svg { width: 13px; height: 13px; fill: #1a7fd4; }

    .btn-actions { display: flex; gap: 10px; }
    .btn-discard { padding: 10px 20px; border-radius: 8px; font-size: 13px; border: 1px solid #c8def5; color: #5a8ab5; text-decoration: none; font-weight: 500; font-family: inherit; transition: 0.2s; }
    .btn-discard:hover { background: #f0f6ff; color: #0a3d6b; }
    
    .btn-save { padding: 10px 24px; border-radius: 8px; font-size: 13px; background: #1a7fd4; color: white; border: none; display: flex; align-items: center; gap: 7px; cursor: pointer; font-weight: 500; font-family: inherit; transition: 0.2s; }
    .btn-save:hover { background: #0f5ea3; transform: translateY(-1px); }
    .btn-save svg { width: 13px; height: 13px; fill: white; }

    /* Responsivo */
    @media (max-width: 768px) {
        .main-content { margin-left: 0 !important; padding: 20px 16px; padding-top: 80px; }
        .form-grid { grid-template-columns: 1fr; }
        .input-group.full { grid-column: span 1; }
        .form-footer { flex-direction: column; gap: 20px; align-items: flex-start; }
        .btn-actions { width: 100%; }
        .btn-save, .btn-discard { width: 100%; justify-content: center; }
    }

    @media (max-width: 480px) {
        .main-content { padding: 15px 12px; padding-top: 68px; }
        .btn-actions { flex-direction: column; width: 100%; }
    }
</style>

<script>
    (function () {
        const form    = document.getElementById('perfil-form');
        const btnSave = document.getElementById('btn-guardar');

        // Captura los valores originales al cargar la página
        const originales = {};
        form.querySelectorAll('input:not([readonly])').forEach(input => {
            originales[input.name] = input.value;
        });

        // Detecta si algo cambió
        function verificarCambios() {
            const hayCambio = Array.from(form.querySelectorAll('input:not([readonly])')).some(input => {
                return input.value !== originales[input.name];
            });

            btnSave.disabled = !hayCambio;
            btnSave.style.opacity  = hayCambio ? '1'   : '0.45';
            btnSave.style.cursor   = hayCambio ? 'pointer' : 'not-allowed';
        }

        form.querySelectorAll('input:not([readonly])').forEach(input => {
            input.addEventListener('input', verificarCambios);
        });

        // Llamada inicial para aplicar estado deshabilitado
        verificarCambios();
    })();
</script>