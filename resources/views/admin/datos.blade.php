<div class="dashboard-layout">
    @include('components.admin.sidebar-admin')
    @include('components.notificaciones.alertas')

    <main class="main-content">
        <div class="content-wrapper">

            <div class="header">
                <h2>Mi Perfil de Administrador</h2>
                <p>Gestiona la información principal del administrador en JHARDSYSTEX</p>
            </div>

            <div class="profile-container">

                <form class="glass-form" id="perfil-form" method="POST" action="{{ route('admin.update') }}">
                    @csrf

                    {{-- Notificación de ÉXITO --}}
                        @if(session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const successMsg = {!! json_encode(session('success'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
                                
                                function mostrarExito() {
                                    if (typeof ModalSystem !== 'undefined' && ModalSystem.show) {
                                        ModalSystem.show('success', {
                                            title: '¡Perfil actualizado!',
                                            text: successMsg,
                                            confirmText: 'Entendido'
                                        });
                                    } else {
                                        alert('Éxito: ' + successMsg);
                                    }
                                }
                                
                                // Si las funciones ya están listas, mostrar ahora; si no, esperar un poco
                                if (typeof ModalSystem !== 'undefined' || typeof showNotification !== 'undefined') {
                                    mostrarExito();
                                } else {
                                    window.addEventListener('load', mostrarExito);
                                }
                            });
                        </script>
                        @endif

                        {{-- Notificación de ERROR --}}
                        @if(session('error'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const errorMsg = {!! json_encode(session('error'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
                                
                                function mostrarError() {
                                    if (typeof showNotification === 'function') {
                                        showNotification('danger', 'Error de validación', errorMsg);
                                    } else {
                                        alert('Error: ' + errorMsg);
                                    }
                                }
                                
                                if (typeof showNotification === 'function') {
                                    mostrarError();
                                } else {
                                    window.addEventListener('load', mostrarError);
                                }
                            });
                        </script>
                        @endif

                    <div class="section-label">
                        <div class="section-icon">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 2a4 4 0 100 8 4 4 0 000-8zm0 10c-3.33 0-6 2.67-6 6h12c0-3.33-2.67-6-6-6z"/>
                            </svg>
                        </div>
                        <span>Datos del Administrador</span>
                    </div>

                    <div class="form-grid">

                        <div class="input-group">
                            <label>Código de Administrador <small>(No editable)</small></label>
                            <input
                                type="text"
                                name="codigo_tecnico"
                                value="{{ $tecnico->codigo_tecnico }}"
                                class="input-readonly"
                                readonly
                            >
                        </div>

                        <div class="input-group">
                            <label>DNI <small>(No editable)</small></label>
                            <input
                                type="text"
                                name="dni"
                                value="{{ $tecnico->dni }}"
                                class="input-readonly"
                                readonly
                            >
                        </div>

                        <div class="input-group">
                            <label>Nombre</label>
                            <input
                                type="text"
                                name="nombre"
                                value="{{ old('nombre', $tecnico->nombre) }}"
                                maxlength="100"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label>Apellido Paterno</label>
                            <input
                                type="text"
                                name="apellido_paterno"
                                value="{{ old('apellido_paterno', $tecnico->apellido_paterno) }}"
                                maxlength="100"
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label>Apellido Materno</label>
                            <input
                                type="text"
                                name="apellido_materno"
                                value="{{ old('apellido_materno', $tecnico->apellido_materno) }}"
                                maxlength="100"
                            >
                        </div>

                        <div class="input-group">
                            <label>Correo Electrónico<small>(No editable)</small></label>
                            <input
                                type="email"
                                name="correo"
                                value="{{ old('correo', $tecnico->correo) }}"
                                maxlength="120"
                                required
                                class="input-readonly"
                                readonly
                            >
                        </div>

                    </div>

                    <div class="form-footer">

                        <div class="footer-hint">
                            <svg viewBox="0 0 20 20">
                                <path d="M10 2a8 8 0 100 16A8 8 0 0010 2zm1 11H9V9h2v4zm0-6H9V5h2v2z"/>
                            </svg>
                            Algunos datos están protegidos por seguridad
                        </div>

                        <div class="btn-actions">

                            <a href="{{ route('admin.dashboard') }}" class="btn-discard">
                                Cancelar
                            </a>

                            <button type="submit" class="btn-save" id="btn-guardar" disabled>

                                <svg viewBox="0 0 20 20">
                                    <path d="M15.7 5.3a1 1 0 010 1.4l-8 8a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.4L7 12.6l8.3-8.3a1 1 0 011.4 0z"/>
                                </svg>

                                <span>Guardar Cambios</span>

                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </main>
</div>

<style>

.dashboard-layout {
    display: flex;
    min-height: 100vh;
}

.main-content {
    flex: 1;
    margin-left: 260px;
    padding: 40px;
    background: #eef4fb;
    transition: margin-left 0.35s cubic-bezier(.4,0,.2,1);
    min-width: 0;
}

body.sb-collapsed .main-content {
    margin-left: 70px;
}

.content-wrapper {
    width: 100%;
}

.header {
    margin-bottom: 28px;
}

.header h2 {
    font-size: 22px;
    font-weight: 600;
    color: #0a2d4a;
    margin-bottom: 6px;
}

.header p {
    font-size: 13.5px;
    color: #5a8ab5;
}

.glass-form {
    background: white;
    padding: 32px;
    border-radius: 16px;
    border: 0.5px solid #c8def5;
    box-shadow: 0 4px 20px rgba(10, 61, 107, 0.06);
}

.section-label {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.section-icon {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    background: #e6f1fb;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.section-icon svg {
    width: 15px;
    height: 15px;
    fill: #1a7fd4;
}

.section-label span {
    font-size: 13px;
    font-weight: 600;
    color: #0a3d6b;
    letter-spacing: 0.01em;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.input-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.input-group label {
    font-size: 11.5px;
    font-weight: 600;
    color: #3a6a9a;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 6px;
}

.input-group input {
    padding: 11px 14px;
    border: 1px solid #d0e6f7;
    border-radius: 9px;
    font-size: 13.5px;
    color: #0a2d4a;
    background: white;
    outline: none;
    font-family: inherit;
    transition: border-color 0.2s, box-shadow 0.2s;
    width: 100%;
    box-sizing: border-box;
}

.input-group input:focus {
    border-color: #1a7fd4;
    box-shadow: 0 0 0 3px rgba(26, 127, 212, 0.1);
}

.input-readonly {
    background: #f5f9fe !important;
    color: #8aaac8 !important;
    cursor: not-allowed;
}

.form-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-top: 28px;
    padding-top: 22px;
    border-top: 1px solid #e8f2fb;
}

.footer-hint {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #7aabcc;
}

.footer-hint svg {
    width: 13px;
    height: 13px;
    fill: #1a7fd4;
}

.btn-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn-discard {
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    background: transparent;
    border: 1px solid #c8def5;
    color: #5a8ab5;
    font-family: inherit;
    text-decoration: none;
    transition: 0.2s;
}

.btn-discard:hover {
    background: #f0f6ff;
    color: #0a3d6b;
}

.btn-save {
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    background: #1a7fd4;
    border: none;
    color: white;
    font-family: inherit;
    transition: 0.2s;
    display: flex;
    align-items: center;
    gap: 7px;
}

.btn-save svg {
    width: 13px;
    height: 13px;
    fill: white;
}

.btn-save:hover {
    background: #0f5ea3;
    transform: translateY(-1px);
}

@media (min-width: 769px) and (max-width: 1024px) {
    .main-content {
        margin-left: 70px;
    }
}

@media (max-width: 768px) {

    .main-content {
        margin-left: 0 !important;
        padding: 20px 16px;
        padding-top: 68px;
    }

    body.sb-collapsed .main-content {
        margin-left: 0 !important;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .glass-form {
        padding: 20px 16px;
    }

    .header h2 {
        font-size: 18px;
    }

    .header p {
        font-size: 12px;
    }
}

@media (max-width: 480px) {

    .main-content {
        padding: 15px 12px;
        padding-top: 68px;
    }

    .btn-actions {
        flex-direction: column;
        width: 100%;
    }

    .btn-save,
    .btn-discard {
        width: 100%;
        justify-content: center;
        text-align: center;
    }

    .form-footer {
        flex-direction: column;
        align-items: flex-start;
    }
}

</style>

<script>
    (function () {
        const form    = document.getElementById('perfil-form');
        const btnSave = document.getElementById('btn-guardar');
        if (!form || !btnSave) return;

        // 1. Guardar valores originales al cargar
        const originales = {};
        form.querySelectorAll('input:not([readonly])').forEach(input => {
            originales[input.name] = input.value;
        });

        // 2. Función que verifica cambios
        function verificarCambios() {
            const hayCambio = Array.from(form.querySelectorAll('input:not([readonly])')).some(input => {
                return input.value !== originales[input.name];
            });

            // Activar/desactivar botón
            btnSave.disabled = !hayCambio;
            btnSave.style.opacity      = hayCambio ? '1'   : '0.45';
            btnSave.style.cursor       = hayCambio ? 'pointer' : 'not-allowed';
            btnSave.style.pointerEvents = hayCambio ? 'auto' : 'none';
        }

        // 3. Escuchar cambios en tiempo real
        form.querySelectorAll('input:not([readonly])').forEach(input => {
            input.addEventListener('input', verificarCambios);
        });

        // 4. Aplicar estado inicial
        verificarCambios();
    })();
    </script>   