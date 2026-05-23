    <div class="dashboard-layout">
        @include('components.cliente.sidebar-cliente')
@include('components.notificaciones.alertas')

        <main class="main-content">
            <div class="content-wrapper">
                <div class="header">
                    <h2>Mi Perfil de Cliente</h2>
                    <p>Gestiona la información oficial de tu organización en JHARDSYSTEX</p>
                </div>

                <div class="profile-container">
                    <form class="glass-form" method="POST" action="{{ route('cliente.update') }}">
                        @csrf

                        @if($errors->any())
                            <div class="alert-error">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <script>
                                window.addEventListener('load', () => {
                                    ModalSystem.show('success', {
                                        title: '¡Datos actualizados!',
                                        text: 'Los datos de la empresa se actualizaron correctamente.',
                                        confirmText: 'Entendido'
                                    });
                                });
                            </script>
                        @endif

                        <div class="section-label">
                            <div class="section-icon">
                                <svg viewBox="0 0 20 20"><path d="M4 3h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1zm8 3H8v2h4V6zm0 4H8v2h4v-2z"/></svg>
                            </div>
                            <span>Datos de la Organización</span>
                        </div>

                        <div class="form-grid">
                            <div class="input-group full">
                                <label>Razón Social</label>
                                <input type="text" name="razon_social" value="{{ old('razon_social', $cliente->razon_social) }}" maxlength="100" required>
                            </div>

                            <div class="input-group">
                                <label>RUC <small>(No editable)</small></label>
                                <input type="text" name="ruc" value="{{ $cliente->ruc }}" class="input-readonly" readonly title="El RUC es un dato único y no puede ser modificado">
                            </div>

                            <div class="input-group">
                                <label>Correo<small>(No editable)</small></label>
                                <input type="email" name="correo" value="{{ $cliente->correo }}" class="input-readonly" readonly title="El correo principal no puede ser modificado">
                            </div>

                            <div class="input-group">
                                <label>Rubro</label>
                                <input type="text" name="rubro" value="{{ old('rubro', $cliente->rubro) }}" maxlength="100" required>
                            </div>

                            <div class="input-group">
                                <label>Sede</label>
                                <input type="text" name="sedes" value="{{ old('sedes', $cliente->sedes) }}" maxlength="100" required>
                            </div>
                        </div>

                        <div class="form-footer">
                            <div class="footer-hint">
                                <svg viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16A8 8 0 0010 2zm1 11H9V9h2v4zm0-6H9V5h2v2z"/></svg>
                                Ciertos datos están protegidos por seguridad
                            </div>
                            <div class="btn-actions">
                                <a href="{{ route('cliente.datos') }}" class="btn-discard">Descartar</a>
                                <button type="submit" class="btn-save" id="btnGuardar">
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
            min-width: 0; /* evita overflow en flex */
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

        .input-group.full {
            grid-column: span 2;
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

        /* ══════════════════════════════════════════
        TABLET (769px – 1024px)
        Sidebar colapsado → margen de 70px
        ══════════════════════════════════════════ */
        @media (min-width: 769px) and (max-width: 1024px) {
            .main-content {
                margin-left: 70px;
            }
        }

        /* ══════════════════════════════════════════
        MÓVIL (≤ 768px)
        Sidebar es drawer oculto → margin-left: 0
        El contenido ocupa TODO el ancho
        ══════════════════════════════════════════ */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0 !important;  /* sidebar fuera de pantalla, no ocupa espacio */
                padding: 20px 16px;
                padding-top: 68px; /* espacio para el botón hamburguesa */
            }

            body.sb-collapsed .main-content {
                margin-left: 0 !important;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .input-group.full {
                grid-column: span 1;
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

        /* ══════════════════════════════════════════
        MÓVIL PEQUEÑO (≤ 480px)
        ══════════════════════════════════════════ */
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