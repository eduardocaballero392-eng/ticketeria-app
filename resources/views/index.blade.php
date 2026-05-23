<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JHARDSYSTEX - Acceso</title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&family=Poppins:wght@300;400&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0a192f, #020c1b);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px; /* Espacio para móviles */
            color: white;
            position: relative;
            overflow-x: hidden;
        }

        /* Fondo animado */
        body::before {
            content: "";
            position: absolute;
            width: 200%;
            height: 200%;
            background: linear-gradient(120deg, transparent, rgba(0, 200, 255, 0.1), transparent);
            animation: moveBg 12s linear infinite;
            z-index: -1;
        }

        @keyframes moveBg {
            0% { transform: translateX(-30%) translateY(-30%); }
            100% { transform: translateX(20%) translateY(20%); }
        }

        .login-container {
            position: relative;
            width: 100%;
            max-width: 480px; /* Responsivo */
            padding: 30px 25px;
            border-radius: 20px;
            background: rgba(10, 25, 47, 0.9);
            backdrop-filter: blur(15px);
            box-shadow: 0 0 40px rgba(0, 200, 255, 0.3);
            text-align: center;
            z-index: 1;
            border: 1px solid rgba(0, 234, 255, 0.2);
        }

        .login-container h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(20px, 5vw, 28px); /* Tamaño de fuente fluido */
            color: #00eaff;
            margin-bottom: 8px;
            letter-spacing: 3px;
        }

        .login-container h2 {
            font-size: 14px;
            color: #8892b0;
            margin-bottom: 20px;
        }

        .mode-selector {
            display: flex;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            padding: 5px;
            margin-bottom: 25px;
            gap: 5px;
        }

        .mode-btn {
            flex: 1;
            padding: 10px;
            border: none;
            background: transparent;
            color: #8892b0;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            font-size: 14px;
        }

        .mode-btn.active {
            background: linear-gradient(90deg, #00eaff, #0072ff);
            color: #000;
            font-weight: bold;
        }

        .auth-form { display: none; }
        .auth-form.active { display: block; }

        /* Grid responsivo */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 12px;
        }

        .input-group { margin-bottom: 15px; text-align: left; }
        .input-group.full { grid-column: span 2; }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid rgba(0, 200, 255, 0.3);
            background: rgba(2, 12, 27, 0.5);
            color: white;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #00eaff;
            box-shadow: 0 0 10px rgba(0, 234, 255, 0.3);
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            margin-top: 10px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(90deg, #00eaff, #0072ff);
            color: #000;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 234, 255, 0.4);
        }

        /* Password Wrapper Responsivo */
        .password-wrapper { position: relative; }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #8892b0;
            z-index: 2;
        }

        /* Requisitos Responsivos */
        .password-requirements {
            background: rgba(0, 0, 0, 0.3);
            padding: 12px;
            border-radius: 10px;
            font-size: 11px;
            margin-bottom: 15px;
        }

        #password-rules {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px;
            list-style: none;
        }

        #password-rules li {
            color: #8892b0;
            position: relative;
            padding-left: 18px;
        }

        #password-rules li.valid { color: #00ff88; }

        /* --- MEDIA QUERIES PARA RESPONSIVE --- */
        @media (max-width: 480px) {
            .form-grid {
                grid-template-columns: 1fr; /* Una columna en celulares */
            }
            .input-group.full { grid-column: span 1; }
            .login-container { padding: 25px 15px; }
            #password-rules { grid-template-columns: 1fr; } /* Reglas una debajo de otra */
        }

        .footer { margin-top: 20px; font-size: 11px; color: #495670; }

       

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
@include('components.notificaciones.alertas')
    <div class="login-container">
        <h1>JHARDSYSTEX</h1>
        <h2 id="title">Acceso Seguro al Sistema</h2>

        @if ($errors->any())
            <script>
                @foreach ($errors->all() as $error)
                    showNotification(
                        'danger',
                        'Error',
                        '{{ $error }}'
                    );
                @endforeach
            </script>
        @endif

        @if (session('success'))
            <script>
                showNotification(
                    'success',
                    'Correcto',
                    '{{ session("success") }}'
                );
            </script>
        @endif

        <!-- Selector de Modo -->
        <div class="mode-selector">
            <button type="button" class="mode-btn active" id="btn-login" onclick="switchMode('login')">Ingresar</button>
            <button type="button" class="mode-btn" id="btn-register" onclick="switchMode('register')">Empresa</button>
        </div>

        <!-- LOGIN FORM -->
        <form id="login-form" class="auth-form active" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group">
                <input type="email" name="correo" placeholder="Correo electrónico" required>
            </div>
            <div class="input-group password-wrapper">
                <input type="password" id="login-pass" name="password" placeholder="Contraseña" required>
                <span class="toggle-password" onclick="togglePassword('login-pass', this)">👁</span>
            </div>
            <button type="submit">ACCEDER</button>
        </form>

        <!-- REGISTER FORM (Campos Tabla Cliente) -->
        <form id="register-form" class="auth-form" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-grid">
                <div class="input-group full">
                    <input type="text" name="razon_social" placeholder="Nombre de la Empresa / Razón Social" required>
                </div>
                <div class="input-group">
                    <input type="text" name="ruc" maxlength="11" placeholder="RUC" onkeypress="return onlyNumbers(event)" required>
                </div>
                <div class="input-group">
                    <input type="text" name="rubro" placeholder="Rubro" required>
                </div>
                <div class="input-group full">
                    <input type="text" name="sedes" placeholder="Dirección Fiscal / Sede" required>
                </div>
                <div class="input-group full">
                    <input type="email" name="correo" placeholder="Correo electrónico oficial" required>
                </div>
            </div>

            <div class="input-group password-wrapper">
                <input type="password" id="pass" name="password" placeholder="Contraseña de seguridad" required>
                <span class="toggle-password" onclick="togglePassword('pass', this)">👁</span>
            </div>

            <!-- Reglas visuales -->
            <div class="password-requirements">
                <ul id="password-rules">
                    <li id="rule-length">8+ caracteres</li>
                    <li id="rule-upper">Mayúscula</li>
                    <li id="rule-lower">Minúscula</li>
                    <li id="rule-num">Número</li>
                    <li id="rule-symbol">Signo (!@#$%&*)</li>
                </ul>
            </div>

            <div class="input-group password-wrapper">
                <input type="password" id="confirm-pass" name="password_confirmation" placeholder="Confirmar contraseña" required>
                <span class="toggle-password" onclick="togglePassword('confirm-pass', this)">👁</span>
            </div>

            <button type="submit">REGISTRAR EMPRESA</button>
        </form>

        <div class="footer">
            © 2026 JHARDSYSTEX | Infraestructura Crítica
        </div>
    </div>

<script>
    /**
     * Alterna entre los formularios de Login y Registro.
     */
    function switchMode(mode) {
        const isLogin = mode === 'login';
        
        // Actualizar título con transición suave
        document.getElementById('title').textContent = isLogin 
            ? 'Acceso Seguro al Sistema' 
            : 'Registro de Nueva Empresa';

        // Alternar formularios
        document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
        document.getElementById(`${mode}-form`).classList.add('active');

        // Actualizar estado de los botones del selector
        document.getElementById('btn-login').classList.toggle('active', isLogin);
        document.getElementById('btn-register').classList.toggle('active', isLogin === false);
    }

    /**
     * Restringe la entrada a solo números (útil para el RUC).
     */
    function onlyNumbers(e) { 
        return /[0-9]/.test(e.key) || e.ctrlKey || e.metaKey || e.key === 'Backspace'; 
    }

    /**
     * Muestra u oculta el texto de la contraseña.
     */
    function togglePassword(id, el) {
        const input = document.getElementById(id);
        const isSecret = input.type === "password";
        
        input.type = isSecret ? "text" : "password";
        el.textContent = isSecret ? "🙈" : "👁";
        
        // Efecto visual de brillo al cambiar
        el.style.color = isSecret ? "#00ff88" : "#8892b0";
    }

    /**
     * Validación de requisitos de seguridad y coincidencia de contraseñas.
     */
    document.addEventListener('DOMContentLoaded', () => {
        const pass = document.getElementById('pass');
        const confirmPass = document.getElementById('confirm-pass');

        // Mapeo de reglas para optimizar el código
        const rules = {
            'rule-length': (v) => v.length >= 8,
            'rule-upper':  (v) => /[A-Z]/.test(v),
            'rule-lower':  (v) => /[a-z]/.test(v),
            'rule-num':    (v) => /[0-9]/.test(v),
            'rule-symbol': (v) => /[!@#$%&*]/.test(v)
        };

        const validatePasswords = () => {
            const v1 = pass.value;
            const v2 = confirmPass.value;

            // Validar cada regla de la lista
            Object.keys(rules).forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.classList.toggle('valid', rules[id](v1));
                }
            });

            // Validar coincidencia entre campos (Bordes visuales)
            if (v2.length > 0) {
                const match = v1 === v2;
                confirmPass.style.borderColor = match ? "#00ff88" : "#ff6666";
                confirmPass.style.boxShadow = match ? "0 0 10px rgba(0, 255, 136, 0.2)" : "0 0 10px rgba(255, 102, 102, 0.2)";
            } else {
                confirmPass.style.borderColor = "rgba(0, 200, 255, 0.3)";
                confirmPass.style.boxShadow = "none";
            }
        };

        pass.addEventListener('input', validatePasswords);
        confirmPass.addEventListener('input', validatePasswords);
    });
</script>
</body>
</html>