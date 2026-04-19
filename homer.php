<?php
$usuarioNome = 'Operador';
if (isset($usuario_nome) && !empty($usuario_nome)) {
    $usuarioNome = $usuario_nome;
} elseif (isset($usuario['usuario']) && !empty($usuario['usuario'])) {
    $usuarioNome = $usuario['usuario'];
} elseif (isset($usuario) && is_string($usuario) && !empty($usuario)) {
    $usuarioNome = $usuario;
}

$saldoAtual = 0;
if (isset($saldo)) {
    $saldoAtual = (float)$saldo;
} elseif (isset($carteira_saldo)) {
    $saldoAtual = (float)$carteira_saldo;
}

$enviosDisponiveis = 0;
if (isset($envios_disponiveis)) {
    $enviosDisponiveis = (int)$envios_disponiveis;
} elseif (isset($total_envios)) {
    $enviosDisponiveis = (int)$total_envios;
}

$campanhas = (isset($campanhas) && is_array($campanhas)) ? $campanhas : [];

$esquema = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$linkIndicacao = $esquema . '://' . $host . '/registrar?ref=' . urlencode($usuarioNome);
if (isset($link_indicacao) && !empty($link_indicacao)) {
    $linkIndicacao = $link_indicacao;
}

$afiliadosIndicados = 0;
if (isset($afiliados_indicados)) {
    $afiliadosIndicados = (int)$afiliados_indicados;
} elseif (isset($total_indicados)) {
    $afiliadosIndicados = (int)$total_indicados;
}

$depositosIndicados = 0.0;
if (isset($depositos_indicados)) {
    $depositosIndicados = (float)$depositos_indicados;
} elseif (isset($total_depositos_indicados)) {
    $depositosIndicados = (float)$total_depositos_indicados;
}

$bonusAfiliadoSaldo = isset($bonus_afiliado_saldo) ? (float)$bonus_afiliado_saldo : ($depositosIndicados * 0.25);
$bonusAfiliadoMensagens = isset($bonus_afiliado_mensagens) ? (int)$bonus_afiliado_mensagens : (int)floor($bonusAfiliadoSaldo / 0.02);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Painel | Nuvem Cloud</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/theme.css">
</head>
<body class="site-body">
    <div class="ambient one"></div>
    <div class="ambient two"></div>

    <div id="toast-notificacao" class="toast-global">
        <i id="toast-icone" class="fas fa-check-circle"></i>
        <span id="toast-texto">Tudo pronto.</span>
    </div>

    <div id="dopamina-confirmacao" class="modal-success">
        <div class="box">
            <i class="fas fa-circle-check" style="font-size: 48px; color: #22c55e;"></i>
            <h3 style="margin: 14px 0 6px;">Pagamento confirmado</h3>
            <p class="u-muted">Seu saldo foi atualizado. Atualizando painel...</p>
        </div>
    </div>

    <div class="app-shell">
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-brand">
                <img src="/assets/logo.png" alt="Nuvem Cloud">
                <p>Infraestrutura moderna de disparos</p>
            </div>

            <nav class="nav-links">
                <div class="nav-links-main">
                    <a href="#" class="tab-link active" data-tab="aba-dashboard" data-title="Dashboard" onclick="mudarAba(event, 'aba-dashboard')">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                    <a href="#" class="tab-link" data-tab="aba-notificacoes" data-title="Notificações" onclick="mudarAba(event, 'aba-notificacoes')">
                        <i class="fas fa-bell"></i> Notificações
                    </a>
                    <a href="#" class="tab-link" data-tab="aba-afiliados" data-title="Afiliados" onclick="mudarAba(event, 'aba-afiliados')">
                        <i class="fas fa-user-group"></i> Afiliados
                    </a>
                    <a href="#" class="tab-link" data-tab="aba-disparo" data-title="Disparo" onclick="mudarAba(event, 'aba-disparo')">
                        <i class="fas fa-paper-plane"></i> Novo Disparo
                    </a>
                    <a href="#" class="tab-link" data-tab="aba-historico" data-title="Histórico" onclick="mudarAba(event, 'aba-historico')">
                        <i class="fas fa-clock-rotate-left"></i> Histórico
                    </a>
                    <a href="#" class="tab-link" data-tab="aba-loja" data-title="Loja" onclick="mudarAba(event, 'aba-loja')">
                        <i class="fas fa-store"></i> Loja / PIX
                    </a>
                </div>

                <a href="/logout" class="logout-link">
                    <i class="fas fa-right-from-bracket"></i> Sair
                </a>
            </nav>
        </aside>

        <section class="main-area">
            <header class="topbar">
                <div class="u-flex u-gap">
                    <button class="menu-toggle" onclick="toggleMenu()" aria-label="Abrir menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 id="titulo-topo">Dashboard</h2>
                </div>
                <span class="pill"><i class="fas fa-user"></i> <?php echo htmlspecialchars($usuarioNome); ?></span>
            </header>

            <main class="content">
                <section id="aba-dashboard" class="tab-content active">
                    <div class="cards-grid">
                        <article class="stat-card">
                            <p class="stat-title">Saldo da carteira</p>
                            <p class="stat-value">R$ <?php echo number_format($saldoAtual, 2, ',', '.'); ?></p>
                        </article>
                        <article class="stat-card">
                            <p class="stat-title">Envios disponíveis</p>
                            <p class="stat-value"><?php echo number_format($enviosDisponiveis, 0, ',', '.'); ?></p>
                        </article>
                        <article class="stat-card">
                            <p class="stat-title">Campanhas</p>
                            <p class="stat-value"><?php echo count($campanhas); ?></p>
                        </article>
                    </div>

                    <div class="main-grid">
                        <article class="form-card">
                            <h3 style="margin: 0 0 12px;">Visão geral da conta</h3>
                            <p class="u-muted" style="margin-bottom: 12px;">Resumo rápido para acompanhar saúde e capacidade do painel.</p>
                            <div style="display: grid; gap: 10px;">
                                <div class="glass-card">
                                    <div class="u-flex" style="justify-content: space-between;">
                                        <span class="u-muted">Saldo disponível</span>
                                        <strong>R$ <?php echo number_format($saldoAtual, 2, ',', '.'); ?></strong>
                                    </div>
                                </div>
                                <div class="glass-card">
                                    <div class="u-flex" style="justify-content: space-between;">
                                        <span class="u-muted">Mensagens prontas para disparo</span>
                                        <strong><?php echo number_format($enviosDisponiveis, 0, ',', '.'); ?></strong>
                                    </div>
                                </div>
                                <div class="glass-card">
                                    <div class="u-flex" style="justify-content: space-between;">
                                        <span class="u-muted">Campanhas no histórico</span>
                                        <strong><?php echo number_format(count($campanhas), 0, ',', '.'); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="form-card">
                            <h3 style="margin: 0 0 12px;">Resumo em tempo real</h3>
                            <p class="u-muted" style="margin-bottom: 8px;">Dados globais da nuvem:</p>
                            <div class="cards-grid" style="margin-bottom: 0;">
                                <div class="glass-card">
                                    <p class="stat-title">Grupos</p>
                                    <p class="stat-value" id="display-grupos">0</p>
                                </div>
                                <div class="glass-card">
                                    <p class="stat-title">Alcance</p>
                                    <p class="stat-value" id="display-alcance">0</p>
                                </div>
                                <div class="glass-card">
                                    <p class="stat-title">Bots online</p>
                                    <p class="stat-value" id="display-bots">0</p>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>

                <section id="aba-notificacoes" class="tab-content">
                    <div class="main-grid">
                        <article class="form-card">
                            <h3 style="margin: 0 0 12px;"><i class="fas fa-bell"></i> Atualizações importantes</h3>
                            <p class="u-muted" style="margin-bottom: 12px;">Resumo das informações da sua conta e do programa de afiliados.</p>

                            <div style="display: grid; gap: 10px;">
                                <div class="glass-card">
                                    <p class="stat-title">Programa de afiliados</p>
                                    <p class="u-muted">Cada depósito confirmado de um indicado gera <strong style="color:#93c5fd;">25% de retorno</strong> para você.</p>
                                </div>
                                <div class="glass-card">
                                    <p class="stat-title">Conversão automática</p>
                                    <p class="u-muted">O bônus recebido é convertido em mensagens para disparo com base de <strong style="color:#93c5fd;">R$ 0,02 por mensagem</strong>.</p>
                                </div>
                                <div class="glass-card">
                                    <p class="stat-title">Seu status atual</p>
                                    <div class="u-flex" style="justify-content: space-between; margin-bottom: 6px;">
                                        <span class="u-muted">Indicados</span>
                                        <strong><?php echo number_format($afiliadosIndicados, 0, ',', '.'); ?></strong>
                                    </div>
                                    <div class="u-flex" style="justify-content: space-between; margin-bottom: 6px;">
                                        <span class="u-muted">Bônus acumulado (saldo)</span>
                                        <strong>R$ <?php echo number_format($bonusAfiliadoSaldo, 2, ',', '.'); ?></strong>
                                    </div>
                                    <div class="u-flex" style="justify-content: space-between;">
                                        <span class="u-muted">Bônus convertido em envios</span>
                                        <strong style="color:#60a5fa;"><?php echo number_format($bonusAfiliadoMensagens, 0, ',', '.'); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </article>

                        <article class="form-card">
                            <h3 style="margin: 0 0 12px;"><i class="fa-brands fa-whatsapp"></i> Suporte</h3>
                            <p class="u-muted" style="margin-bottom: 14px;">Canal oficial para dúvidas, orientações e acompanhamento de ocorrências.</p>
                            <a href="https://chat.whatsapp.com/IYA1NqFGsNw8QFZ4P8cQJl?mode=gi_t" target="_blank" rel="noopener noreferrer" class="btn-primary" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none;">
                                <i class="fa-brands fa-whatsapp"></i> Abrir canal de suporte
                            </a>
                            <p class="u-muted" style="margin-top: 12px; font-size: 12px;">Atendimento e avisos importantes em um único lugar.</p>
                        </article>
                    </div>
                </section>

                <section id="aba-afiliados" class="tab-content">
                    <div class="cards-grid">
                        <article class="stat-card">
                            <p class="stat-title">Indicados</p>
                            <p class="stat-value"><?php echo number_format($afiliadosIndicados, 0, ',', '.'); ?></p>
                        </article>
                        <article class="stat-card">
                            <p class="stat-title">Depósitos dos indicados</p>
                            <p class="stat-value">R$ <?php echo number_format($depositosIndicados, 2, ',', '.'); ?></p>
                        </article>
                        <article class="stat-card">
                            <p class="stat-title">Bônus em saldo (25%)</p>
                            <p class="stat-value">R$ <?php echo number_format($bonusAfiliadoSaldo, 2, ',', '.'); ?></p>
                        </article>
                        <article class="stat-card">
                            <p class="stat-title">Bônus convertido em envios</p>
                            <p class="stat-value"><?php echo number_format($bonusAfiliadoMensagens, 0, ',', '.'); ?></p>
                        </article>
                    </div>

                    <div class="main-grid">
                        <article class="form-card">
                            <h3 style="margin: 0 0 12px;">Link de indicação</h3>
                            <p class="u-muted" style="margin-bottom: 12px;">Compartilhe seu link para cadastrar novos usuários sob sua referência.</p>
                            <input id="link-indicacao" type="text" class="input-dark" readonly value="<?php echo htmlspecialchars($linkIndicacao); ?>">
                            <button class="btn-primary" onclick="copiarLinkAfiliado()" style="margin-top: 12px;">
                                <i class="fas fa-copy"></i> Copiar Link
                            </button>
                        </article>

                        <article class="form-card">
                            <h3 style="margin: 0 0 12px;">Regra de bonificação</h3>
                            <p class="u-muted" style="margin-bottom: 12px;">
                                Cada depósito confirmado de um indicado gera <strong style="color:#93c5fd;">25% de retorno</strong> para você.
                                Esse retorno entra como saldo de afiliado e é convertido em mensagens para disparo.
                            </p>

                            <div class="glass-card" style="margin-bottom: 12px;">
                                <div class="u-flex" style="justify-content: space-between; margin-bottom: 8px;">
                                    <span class="u-muted">Depósito do indicado</span>
                                    <input id="simulador-deposito-indicado" type="number" class="input-dark" value="100" min="0" step="0.01" oninput="calcularSimuladorAfiliado()" style="max-width: 160px;">
                                </div>
                                <div class="u-flex" style="justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 8px; margin-top: 8px;">
                                    <span class="u-muted">Seu bônus (25%)</span>
                                    <strong id="sim-afiliado-saldo">R$ 25,00</strong>
                                </div>
                                <div class="u-flex" style="justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 8px; margin-top: 8px;">
                                    <span class="u-muted">Mensagens recebidas</span>
                                    <strong id="sim-afiliado-envios" style="color:#60a5fa;">1250 envios</strong>
                                </div>
                            </div>

                            <p class="u-muted" style="font-size: 12px;">
                                Conversão usada no simulador: R$ 0,02 por mensagem.
                            </p>
                        </article>
                    </div>
                </section>

                <section id="aba-disparo" class="tab-content">
                    <div class="main-grid">
                        <article class="form-card">
                            <h3 style="margin: 0 0 14px;">Criar campanha de disparo</h3>
                            <label class="form-label">Quantidade de disparos</label>
                            <input type="number" id="qtd-disparos" class="input-dark" value="1000" min="1">

                            <label class="form-label" style="margin-top: 12px;">Mensagem</label>
                            <textarea id="texto-nuvem" class="input-dark" placeholder="Digite sua mensagem..."></textarea>

                            <div id="box-upload" class="upload-box" style="margin-top: 12px;">
                                <div id="upload-texto" class="u-muted">
                                    <i class="fas fa-image"></i> Adicione uma imagem para a campanha (opcional)
                                </div>
                                <input type="file" id="foto-campanha" accept="image/*" onchange="previewImagem(this)">
                                <img id="preview-img" class="preview-image" alt="Pré-visualização">
                                <button id="btn-remover-img" type="button" class="btn-secondary" style="display:none; margin-top: 10px;" onclick="removerImagem()">
                                    Remover imagem
                                </button>
                            </div>

                            <div class="u-flex u-gap" style="margin: 14px 0; justify-content: space-between;">
                                <span class="u-muted">Modo turbo</span>
                                <label>
                                    <input type="checkbox" id="check-turbo"> <span class="u-muted">Mais velocidade</span>
                                </label>
                            </div>

                            <button class="btn-primary" id="btn-disparar-nuvem" onclick="iniciarDisparoNuvem()">
                                <i class="fas fa-paper-plane"></i> Lançar campanha
                            </button>
                        </article>

                        <article class="form-card">
                            <h3 style="margin: 0 0 12px;">Dicas de performance</h3>
                            <ul style="margin: 0; padding-left: 18px; line-height: 1.8; color: #dbeafe; font-size: 14px;">
                                <li>Use textos diretos com CTA no final.</li>
                                <li>Evite imagens muito pesadas para maior entrega.</li>
                                <li>Teste grupos menores antes de escalar.</li>
                                <li>Acompanhe o histórico para ajustar próximas campanhas.</li>
                            </ul>
                        </article>
                    </div>
                </section>

                <section id="aba-historico" class="tab-content">
                    <h3 style="margin: 0 0 12px;">Histórico de campanhas</h3>
                    <?php if (empty($campanhas)): ?>
                        <article class="form-card">
                            <p class="u-muted">Nenhuma campanha registrada até agora.</p>
                        </article>
                    <?php else: ?>
                        <div style="display: grid; gap: 14px;">
                            <?php foreach($campanhas as $c):
                                $metaEnvios = isset($c['meta_envios']) ? (int)$c['meta_envios'] : 0;
                                $realizados = isset($c['envios_realizados']) ? (int)$c['envios_realizados'] : 0;
                                $perc = ($metaEnvios > 0) ? ($realizados / $metaEnvios) * 100 : 0;
                                $status = $c['status'] ?? 'pendente';
                                $statusCor = $status === 'concluida' ? '#22c55e' : ($status === 'rodando' ? '#60a5fa' : '#94a3b8');
                            ?>
                                <article class="campaign-item">
                                    <div class="u-flex" style="justify-content: space-between; margin-bottom: 10px; gap: 10px;">
                                        <h4 style="margin: 0; font-size: 16px;">Campanha #<?php echo isset($c['id']) ? (int)$c['id'] : 0; ?></h4>
                                        <span class="pill" style="color: <?php echo $statusCor; ?>; border-color: <?php echo $statusCor; ?>;">
                                            <?php echo strtoupper($status); ?>
                                        </span>
                                    </div>
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: <?php echo max(0, min(100, $perc)); ?>%; background: <?php echo $statusCor; ?>;"></div>
                                    </div>
                                    <div class="u-flex" style="justify-content: space-between; margin-top: 10px; flex-wrap: wrap; gap: 10px;">
                                        <span class="u-muted">Progresso: <strong style="color: #fff;"><?php echo $realizados; ?> / <?php echo $metaEnvios; ?></strong></span>
                                        <span class="u-muted">
                                            <i class="far fa-calendar-alt"></i>
                                            <?php echo isset($c['criado_em']) ? date('d/m/Y H:i', strtotime($c['criado_em'])) : '-'; ?>
                                        </span>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>

                <section id="aba-loja" class="tab-content">
                    <div class="main-grid">
                        <article class="form-card">
                            <h3 style="margin: 0 0 12px;" class="u-center"><i class="fas fa-shopping-cart"></i> Loja de envios</h3>
                            <div class="promo-box">
                                <h4 style="margin: 0 0 4px; color: #fb923c;"><i class="fas fa-fire"></i> Promoção ativa</h4>
                                <p style="font-size: 13px; color: #f8fafc;">A cada <strong>R$ 10,00</strong> convertidos, você ganha <strong style="color:#22c55e;">+500 disparos grátis</strong>.</p>
                            </div>

                            <label class="form-label">Quantidade de mensagens</label>
                            <input type="number" id="qtd-comprar" class="input-dark" value="1000" oninput="calcularCompra()">

                            <div class="glass-card" style="margin-top: 12px;">
                                <div class="u-flex" style="justify-content: space-between; margin-bottom: 8px;">
                                    <span class="u-muted">Preço por disparo</span>
                                    <strong>R$ 0,02</strong>
                                </div>
                                <div id="display-bonus" class="u-flex" style="display:none; justify-content: space-between; margin-bottom: 8px;">
                                    <span class="u-muted">Bônus</span>
                                    <strong id="valor-bonus" style="color:#22c55e;">+500 GRÁTIS</strong>
                                </div>
                                <div class="u-flex" style="justify-content: space-between; margin-bottom: 8px; border-top: 1px dashed var(--border-color); padding-top: 8px;">
                                    <span class="u-muted">Total de envios</span>
                                    <strong id="total-receber" style="color:#60a5fa;">1000 envios</strong>
                                </div>
                                <div class="u-flex" style="justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 8px;">
                                    <span class="u-muted">Custo final</span>
                                    <strong id="custo-compra" style="color:#f87171;">R$ 20,00</strong>
                                </div>
                            </div>

                            <button class="btn-primary" style="margin-top: 12px;" onclick="comprarCreditosSaldo()">
                                <i class="fas fa-exchange-alt"></i> Converter em envios
                            </button>
                        </article>

                        <article class="form-card">
                            <h3 style="margin: 0 0 12px;" class="u-center"><i class="fas fa-wallet"></i> Injetar saldo</h3>

                            <label class="form-label">Valor desejado (R$)</label>
                            <input type="number" id="valor-compra" class="input-dark" value="20" oninput="calcularCheckout()">

                            <div class="glass-card" style="margin-top: 12px;">
                                <div class="u-flex" style="justify-content: space-between; margin-bottom: 8px;">
                                    <span class="u-muted">Valor depositado</span>
                                    <strong id="resumo-valor">R$ 20,00</strong>
                                </div>
                                <div class="u-flex" style="justify-content: space-between; margin-bottom: 8px;">
                                    <span class="u-muted">Taxa do gateway</span>
                                    <strong>R$ 1,00</strong>
                                </div>
                                <div class="u-flex" style="justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 8px;">
                                    <span class="u-muted">Total a pagar</span>
                                    <strong id="resumo-total" style="color:#34d399;">R$ 21,00</strong>
                                </div>
                            </div>

                            <button class="btn-primary" id="btn-gerar-pix" style="margin-top: 12px;" onclick="gerarPagamentoPix()">
                                <i class="fab fa-pix"></i> Gerar PIX agora
                            </button>

                            <div id="area-pagamento" style="display:none; margin-top: 14px;">
                                <p class="u-muted u-center" style="margin-bottom: 8px;">Escaneie o QR Code ou copie o código abaixo.</p>
                                <div class="u-center">
                                    <div style="display:inline-flex; background:#fff; border-radius:14px; padding:10px;">
                                        <img src="" id="img-qrcode" alt="QR Code" style="width:180px; height:180px; display:block;">
                                    </div>
                                </div>
                                <input type="text" id="input-copiacola" readonly class="input-dark" style="margin-top: 12px;">
                                <button class="btn-secondary" style="margin-top: 10px;" onclick="copiarPix()">
                                    <i class="fas fa-copy"></i> Copiar código PIX
                                </button>
                                <p class="u-muted u-center" style="margin-top:10px; color:#fb923c;">
                                    <i class="fas fa-circle-notch fa-spin"></i> Aguardando confirmação do pagamento...
                                </p>
                            </div>
                        </article>
                    </div>
                </section>
            </main>

            <footer class="footer">
                <p class="footer-main">Nuvem Cloud • 2026 • Todos os direitos reservados.</p>
                <p class="footer-credit">
                    Feito por
                    <a class="footer-creator-hint" href="https://discord.gg/3XAsBetXE" target="_blank" rel="noopener noreferrer">
                        <span class="neon-dasorte">DASORTE</span>
                        <i class="fa-brands fa-discord" aria-hidden="true"></i>
                    </a>
                </p>
            </footer>
        </section>
    </div>

    <script>
        let fotoBase64 = "";
        let loopPix;
        const titulosAba = {
            'aba-dashboard': 'Dashboard',
            'aba-notificacoes': 'Notificações',
            'aba-afiliados': 'Afiliados',
            'aba-disparo': 'Novo Disparo',
            'aba-historico': 'Histórico',
            'aba-loja': 'Loja / PIX'
        };

        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        function mostrarNotificacao(msg, tipo = 'sucesso') {
            const t = document.getElementById('toast-notificacao');
            const i = document.getElementById('toast-icone');
            t.className = 'toast-global show ' + (tipo === 'sucesso' ? 'toast-success' : 'toast-error');
            i.className = tipo === 'sucesso' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            i.style.color = tipo === 'sucesso' ? '#34d399' : '#f87171';
            document.getElementById('toast-texto').innerText = msg;
            setTimeout(() => t.classList.remove('show'), 4000);
        }

        function mudarAba(e, id) {
            if (e) {
                e.preventDefault();
            }

            document.querySelectorAll('.tab-content').forEach((aba) => aba.classList.remove('active'));
            document.querySelectorAll('.tab-link').forEach((link) => link.classList.remove('active'));

            const alvo = document.getElementById(id);
            if (alvo) {
                alvo.classList.add('active');
            }

            const linkAlvo = document.querySelector(`.tab-link[data-tab="${id}"]`);
            if (linkAlvo) {
                linkAlvo.classList.add('active');
            }

            document.getElementById('titulo-topo').innerText = titulosAba[id] || 'Dashboard';
            localStorage.setItem('abaAtiva', id);

            if (window.innerWidth <= 980 && e) {
                toggleMenu();
            }
        }

        async function buscarStatsNuvem() {
            try {
                const res = await fetch('/api_bot_global_stats');
                const d = await res.json();
                document.getElementById('display-grupos').innerText = new Intl.NumberFormat('pt-BR').format(d.total_grupos || 0);
                document.getElementById('display-alcance').innerText = new Intl.NumberFormat('pt-BR').format(d.total_alcance || 0);
                document.getElementById('display-bots').innerText = d.bots ? Object.keys(d.bots).length : 0;
            } catch (e) {
                document.getElementById('display-grupos').innerText = '0';
                document.getElementById('display-alcance').innerText = '0';
                document.getElementById('display-bots').innerText = '0';
            }
        }

        window.onload = () => {
            const abaSalva = localStorage.getItem('abaAtiva') || 'aba-dashboard';
            mudarAba(null, abaSalva);
            calcularCheckout();
            calcularCompra();
            calcularSimuladorAfiliado();
            buscarStatsNuvem();
            <?php if(isset($erro) && !empty($erro)): ?>
                mostrarNotificacao(<?php echo json_encode($erro); ?>, 'erro');
            <?php endif; ?>
            <?php if(isset($sucesso) && !empty($sucesso)): ?>
                mostrarNotificacao(<?php echo json_encode($sucesso); ?>, 'sucesso');
            <?php endif; ?>
        };

        function copiarLinkAfiliado() {
            const campo = document.getElementById('link-indicacao');
            campo.select();
            document.execCommand('copy');
            mostrarNotificacao('Link de afiliado copiado!');
        }

        function calcularSimuladorAfiliado() {
            const input = document.getElementById('simulador-deposito-indicado');
            const saidaSaldo = document.getElementById('sim-afiliado-saldo');
            const saidaEnvios = document.getElementById('sim-afiliado-envios');

            if (!input || !saidaSaldo || !saidaEnvios) {
                return;
            }

            const deposito = parseFloat(input.value) || 0;
            const bonusSaldo = deposito * 0.25;
            const bonusEnvios = Math.floor(bonusSaldo / 0.02);

            saidaSaldo.innerText = 'R$ ' + bonusSaldo.toFixed(2).replace('.', ',');
            saidaEnvios.innerText = bonusEnvios.toLocaleString('pt-BR') + ' envios';
        }

        function previewImagem(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('upload-texto').style.display = 'none';
                    const preview = document.getElementById('preview-img');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    document.getElementById('btn-remover-img').style.display = 'block';
                    document.getElementById('box-upload').style.borderColor = 'rgba(34,197,94,0.45)';
                    fotoBase64 = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removerImagem() {
            document.getElementById('foto-campanha').value = '';
            document.getElementById('preview-img').style.display = 'none';
            document.getElementById('preview-img').src = '';
            document.getElementById('upload-texto').style.display = 'block';
            document.getElementById('btn-remover-img').style.display = 'none';
            document.getElementById('box-upload').style.borderColor = 'rgba(56, 189, 248, 0.5)';
            fotoBase64 = '';
        }

        function calcularCheckout() {
            let v = parseFloat(document.getElementById('valor-compra').value) || 0;
            document.getElementById('resumo-valor').innerText = 'R$ ' + v.toFixed(2).replace('.', ',');
            document.getElementById('resumo-total').innerText = 'R$ ' + (v + 1).toFixed(2).replace('.', ',');
        }

        function calcularCompra() {
            let q = parseInt(document.getElementById('qtd-comprar').value) || 0;
            let custo = q * 0.02;
            let bonusMultiplicador = Math.floor(custo / 10);
            let bonus = bonusMultiplicador * 500;
            let totalReceber = q + bonus;

            document.getElementById('custo-compra').innerText = 'R$ ' + custo.toFixed(2).replace('.', ',');

            if (bonus > 0) {
                document.getElementById('display-bonus').style.display = 'flex';
                document.getElementById('valor-bonus').innerText = '+' + bonus + ' GRÁTIS';
                document.getElementById('total-receber').innerText = totalReceber + ' envios';
                document.getElementById('total-receber').style.color = '#22c55e';
            } else {
                document.getElementById('display-bonus').style.display = 'none';
                document.getElementById('total-receber').innerText = q + ' envios';
                document.getElementById('total-receber').style.color = '#60a5fa';
            }
        }

        async function comprarCreditosSaldo() {
            let q = parseInt(document.getElementById('qtd-comprar').value) || 0;
            if (q < 100) {
                return alert('Mínimo 100 envios.');
            }

            let custo = q * 0.02;
            let bonus = Math.floor(custo / 10) * 500;

            let msgConfirm = `Confirmar compra de ${q} mensagens por R$ ${custo.toFixed(2).replace('.', ',')}?`;
            if (bonus > 0) {
                msgConfirm = `Você vai comprar ${q} mensagens por R$ ${custo.toFixed(2).replace('.', ',')} e GANHAR +${bonus} GRÁTIS!\n\nTotal a receber: ${q + bonus} envios.\nConfirmar?`;
            }

            if (!confirm(msgConfirm)) {
                return;
            }

            try {
                const res = await fetch('/comprar_creditos', { method: 'POST', body: JSON.stringify({ quantidade: q }) });
                const d = await res.json();
                if (d.status === 'sucesso') {
                    mostrarNotificacao(d.mensagem);
                    setTimeout(() => location.reload(), 2500);
                } else {
                    mostrarNotificacao(d.mensagem, 'erro');
                }
            } catch (e) {
                mostrarNotificacao('Erro de conexão', 'erro');
            }
        }

        function dispararSucessoDopamina() {
            document.getElementById('dopamina-confirmacao').style.display = 'flex';
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(740, ctx.currentTime);
                osc.frequency.linearRampToValueAtTime(980, ctx.currentTime + 0.12);
                gain.gain.setValueAtTime(0.06, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.18);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.2);
            } catch (e) {
                // ignore áudio em navegadores bloqueados
            }
            setTimeout(() => location.reload(), 1600);
        }

        async function verificarPix(id) {
            try {
                const res = await fetch(`/verificar_status_pix?id=${id}`);
                const d = await res.json();
                if (d.status === 'pago') {
                    clearInterval(loopPix);
                    dispararSucessoDopamina();
                }
            } catch (e) {
                // sem ação
            }
        }

        async function gerarPagamentoPix() {
            const v = parseFloat(document.getElementById('valor-compra').value);
            if (v < 5) {
                return alert('Depósito mínimo: R$ 5,00.');
            }

            const btn = document.getElementById('btn-gerar-pix');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Conectando ao gateway...';
            try {
                const res = await fetch('/gerar_pix', { method: 'POST', body: JSON.stringify({ valor: v }) });
                const d = await res.json();
                if (d.status === 'sucesso') {
                    document.getElementById('img-qrcode').src = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(d.copia_cola)}&margin=10`;
                    document.getElementById('input-copiacola').value = d.copia_cola;
                    document.getElementById('area-pagamento').style.display = 'block';
                    btn.style.display = 'none';
                    if (loopPix) {
                        clearInterval(loopPix);
                    }
                    loopPix = setInterval(() => verificarPix(d.fatura_id), 3000);
                } else {
                    alert(d.mensagem);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fab fa-pix"></i> Gerar PIX agora';
                }
            } catch (e) {
                alert('Erro na conexão com o servidor.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fab fa-pix"></i> Gerar PIX agora';
            }
        }

        function copiarPix() {
            const campo = document.getElementById('input-copiacola');
            campo.select();
            document.execCommand('copy');
            mostrarNotificacao('Código copiado!');
        }

        async function iniciarDisparoNuvem() {
            const q = parseInt(document.getElementById('qtd-disparos').value);
            const t = document.getElementById('texto-nuvem').value;
            const turbo = document.getElementById('check-turbo').checked;

            if (!q || !t) {
                return alert('Preencha a quantidade e a mensagem.');
            }

            const btn = document.getElementById('btn-disparar-nuvem');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Enviando...';

            try {
                const res = await fetch('/lancar_campanha_nuvem', {
                    method: 'POST',
                    body: JSON.stringify({ qtd: q, texto: t, imagem: fotoBase64, turbo: turbo })
                });
                const d = await res.json();
                if (d.status === 'sucesso') {
                    mostrarNotificacao('Campanha lançada!');
                    mudarAba(null, 'aba-historico');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarNotificacao(d.mensagem, 'erro');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-paper-plane"></i> Lançar campanha';
                }
            } catch (e) {
                mostrarNotificacao('Erro ao conectar.', 'erro');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Lançar campanha';
            }
        }
    </script>
</body>
</html>
