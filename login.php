<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Acesso Restrito | Nuvem Cloud</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ==========================================
           RESET E RESPONSIVIDADE 101%
           ========================================== */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            /* Fundo Escuro e Card */
            --bg-deep: #030712; 
            --bg-card: #0f172a; 
            --bg-input: #1e293b; 
            --border-color: #334155;
            
            /* Textos */
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
            
            /* Tons de Azul */
            --blue-light: #38bdf8; 
            --blue-mid: #0284c7;   
            --blue-dark: #1e3a8a;  
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-deep);
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(56, 189, 248, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(2, 132, 199, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(30, 58, 138, 0.08) 0%, transparent 60%);
            color: var(--text-main);
            min-height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
        }

        /* Container Principal */
        .auth-container {
            width: 100%;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* O Cartão de Login */
        .auth-card {
            width: 100%;
            max-width: 400px; 
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            animation: slideUp 0.5s ease-out forwards;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Cabeçalho do Card */
        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-header i {
            font-size: 48px;
            background: linear-gradient(135deg, var(--blue-light), var(--blue-mid));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 10px rgba(56,189,248,0.3));
        }

        .brand-header h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 5px;
        }

        .brand-header p {
            font-size: 14px;
            color: var(--text-dim);
        }

        /* Formulários e Inputs */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dim);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .form-control {
            width: 100%;
            background-color: var(--bg-input);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            padding: 15px 15px 15px 45px;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--blue-light);
            background-color: rgba(30, 41, 59, 0.8);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
        }

        .form-control:focus + i, .form-control:not(:placeholder-shown) + i {
            color: var(--blue-light);
        }

        /* Hack para preenchimento automático do Chrome não ficar branco */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px var(--bg-input) inset !important;
            -webkit-text-fill-color: var(--text-main) !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Botão de Ação */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--blue-mid), var(--blue-dark));
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            box-shadow: 0 10px 20px rgba(2, 132, 199, 0.3);
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(2, 132, 199, 0.5);
            background: linear-gradient(135deg, var(--blue-light), var(--blue-mid));
        }

        /* Rodapé de Links */
        .auth-links {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: var(--text-dim);
        }

        .auth-links a {
            color: var(--blue-light);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .auth-links a:hover {
            color: #fff;
            text-decoration: underline;
        }

        /* Notificações (Toasts) */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--bg-card);
            border-left: 4px solid #ef4444;
            padding: 16px 24px;
            border-radius: 12px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.5);
            transform: translateX(150%);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 9999;
        }
        .toast.show { transform: translateX(0); }
        .toast-success { border-left-color: #10b981; }

        @media (max-width: 380px) {
            .auth-card { padding: 30px 20px; }
            .brand-header i { font-size: 40px; }
            .brand-header h1 { font-size: 22px; }
        }
    </style>
</head>
<body>

    <?php if(isset($erro) && !empty($erro)): ?>
        <div id="toast-error" class="toast">
            <i class="fas fa-exclamation-circle" style="color: #ef4444; font-size: 18px;"></i> <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <?php if(isset($sucesso) && !empty($sucesso)): ?>
        <div id="toast-success" class="toast toast-success">
            <i class="fas fa-check-circle" style="color: #10b981; font-size: 18px;"></i> <?php echo $sucesso; ?>
        </div>
    <?php endif; ?>

    <div class="auth-container">
        <div class="auth-card">
            
            <div class="brand-header">
                <i class="fas fa-cloud"></i>
                <h1>Nuvem Cloud</h1>
                <p>Acesse a sua conta</p>
            </div>

            <form action="/login" method="POST">
                <div class="form-group">
                    <label class="form-label">Usuário</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="usuario" class="form-control" placeholder="O seu login" required autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Senha</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="senha" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    INICIAR SESSÃO <i class="fas fa-sign-in-alt"></i>
                </button>
            </form>

            <div class="auth-links">
                Ainda não tem acesso? <br>
                <a href="/registrar" style="display: inline-block; margin-top: 5px;">Criar conta</a>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => { toast.classList.add('show'); }, 100);
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 500); 
                }, 4000);
            });
        });
    </script>
</body>
</html>