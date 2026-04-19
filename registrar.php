<?php
$afiliado = isset($_GET['ref']) ? $_GET['ref'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Criar Conta | Nuvem Cloud</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/theme.css">
</head>
<body class="site-body">
    <div class="ambient one"></div>
    <div class="ambient two"></div>

    <?php if(isset($erro) && !empty($erro)): ?>
        <div id="toast" class="toast toast-error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="brand">
                <img src="/assets/nuvem-logo.svg" class="brand-logo" alt="Nuvem Cloud">
                <h1>Nuvem Cloud</h1>
                <p>Crie sua conta e comece a disparar em minutos.</p>
            </div>

            <form action="/registrar" method="POST">
                <input type="hidden" name="ref" value="<?php echo htmlspecialchars($afiliado); ?>">

                <div class="form-group">
                    <label class="form-label">Usuário de Acesso</label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" name="usuario" class="form-control" placeholder="Ex: Nando" required autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Senha de Segurança</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="senha" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirmar Senha</label>
                    <div class="input-wrap">
                        <i class="fas fa-check-circle"></i>
                        <input type="password" name="senha_confirma" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    CRIAR CONTA <i class="fas fa-user-plus"></i>
                </button>
            </form>

            <div class="auth-links">
                Já tem uma conta?<br>
                <a href="/login">Entrar</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('toast');
            if (!toast) {
                return;
            }
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        });
    </script>
</body>
</html>
