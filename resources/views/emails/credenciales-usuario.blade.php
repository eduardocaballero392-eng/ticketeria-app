<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bienvenido al Sistema de Tickets</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            padding: 40px 16px;
        }
        .email-card {
            max-width: 580px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .em-header {
            background: #13294b;
            padding: 36px 32px 28px;
            text-align: center;
        }
        .em-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 12px;
            color: rgba(255,255,255,0.85);
            margin-bottom: 16px;
        }
        .em-divider {
            width: 32px;
            height: 2px;
            background: rgba(255,255,255,0.3);
            margin: 0 auto 18px;
            border-radius: 2px;
        }
        .em-header h1 {
            font-size: 22px;
            font-weight: 500;
            color: #ffffff;
            margin-bottom: 6px;
        }
        .em-header p {
            font-size: 14px;
            color: rgba(255,255,255,0.6);
        }
        .em-body {
            padding: 28px 32px;
        }
        .em-greeting {
            font-size: 17px;
            font-weight: 600;
            color: #13294b;
            margin-bottom: 8px;
        }
        .em-subtext {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .em-creds {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .em-creds-header {
            background: #f8fafc;
            padding: 10px 16px;
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid #e2e8f0;
        }
        .em-cred-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
        }
        .em-cred-row:last-child {
            border-bottom: none;
        }
        .em-cred-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 17px;
        }
        .em-cred-label {
            font-size: 11px;
            color: #94a3b8;
            margin-bottom: 2px;
        }
        .em-cred-val {
            font-size: 14px;
            font-weight: 500;
            color: #13294b;
            font-family: 'Courier New', monospace;
        }
        .em-notice {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            background: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 28px;
        }
        .em-notice-icon {
            font-size: 17px;
            margin-top: 1px;
            flex-shrink: 0;
        }
        .em-notice p {
            font-size: 13px;
            color: #92400e;
            line-height: 1.5;
        }
        .em-btn-wrap {
            text-align: center;
        }
        .em-btn {
            display: inline-block;
            background: #13294b;
            color: #ffffff;
            padding: 13px 32px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
        }
        .em-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 18px 32px;
            text-align: center;
        }
        .em-footer p {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.7;
        }
    </style>
</head>
<body>
    <div class="email-card">

        <div class="em-header">
            <div class="em-badge">🎫 Sistema de Tickets</div>
            <div class="em-divider"></div>
            <h1>Bienvenido al sistema</h1>
            <p>Tus credenciales de acceso están listas</p>
        </div>

        <div class="em-body">
            <p class="em-greeting">¡Hola, {{ $usuario->nombre }} {{ $usuario->apellido_paterno }}!</p>
            <p class="em-subtext">Tu cuenta ha sido creada exitosamente. A continuación encontrarás tus datos de acceso para ingresar al portal de soporte técnico.</p>

            <div class="em-creds">
                <div class="em-creds-header">Credenciales de acceso</div>
                <div class="em-cred-row">
                    <div class="em-cred-icon">📧</div>
                    <div>
                        <div class="em-cred-label">Correo electrónico</div>
                        <div class="em-cred-val">{{ $usuario->correo }}</div>
                    </div>
                </div>
                <div class="em-cred-row">
                    <div class="em-cred-icon">🔑</div>
                    <div>
                        <div class="em-cred-label">Contraseña temporal</div>
                        <div class="em-cred-val">{{ $password }}</div>
                    </div>
                </div>
            </div>

            <div class="em-notice">
                <div class="em-notice-icon">⚠️</div>
                <p><strong>Importante:</strong> Por seguridad, te recomendamos cambiar tu contraseña al realizar tu primer inicio de sesión.</p>
            </div>

            <div class="em-btn-wrap">
                <a href="{{ url('/login') }}" class="em-btn">Iniciar sesión →</a>
            </div>
        </div>

        <div class="em-footer">
            <p>Este es un correo automático, por favor no responder.</p>
            <p>&copy; {{ date('Y') }} Sistema de Tickets · Todos los derechos reservados.</p>
        </div>

    </div>
</body>
</html>