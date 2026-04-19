<?php
$fatMesInput = isset($fatMes) ? (float)$fatMes : 0.0;
$fatTotalInput = isset($fatTotal) ? (float)$fatTotal : 0.0;
$lucroTaxasInput = isset($lucroTaxas) ? (float)$lucroTaxas : 0.0;

$faturasGerais = isset($faturasGerais) && is_array($faturasGerais) ? $faturasGerais : [];
$listaUsuarios = isset($listaUsuarios) && is_array($listaUsuarios) ? $listaUsuarios : [];
$totalUsuarios = isset($totalUsuarios) ? (int)$totalUsuarios : count($listaUsuarios);
$listaCampanhas = isset($listaCampanhas) && is_array($listaCampanhas) ? $listaCampanhas : [];
$listaBots = isset($listaBots) && is_array($listaBots) ? $listaBots : [];

function taxaFatura(array $f): float {
    if (isset($f['taxa']) && is_numeric($f['taxa'])) return (float)$f['taxa'];
    if (isset($f['taxa_gateway']) && is_numeric($f['taxa_gateway'])) return (float)$f['taxa_gateway'];
    if (isset($f['taxa_cobrada']) && is_numeric($f['taxa_cobrada'])) return (float)$f['taxa_cobrada'];
    return 1.0;
}

$agora = new DateTimeImmutable('now');
$inicioDia = $agora->setTime(0, 0, 0);
$inicioSemana = $inicioDia->modify('monday this week');
$inicioMes = $inicioDia->modify('first day of this month');

$faturamentoDia = 0.0;
$faturamentoSemana = 0.0;
$faturamentoMesCalc = 0.0;
$faturamentoTotalCalc = 0.0;

$taxasDia = 0.0;
$taxasSemana = 0.0;
$taxasMes = 0.0;
$taxasTotalCalc = 0.0;

$qtdFaturasPagas = 0;
$faturamentoPorMes = array_fill(1, 12, 0.0);

foreach ($faturasGerais as $f) {
    if (strtolower((string)($f['status'] ?? '')) !== 'pago') continue;
    if (empty($f['criado_em'])) continue;

    try {
        $data = new DateTimeImmutable((string)$f['criado_em']);
    } catch (Throwable $e) {
        continue;
    }

    $bruto = (float)($f['total_pago'] ?? 0);
    $taxa = taxaFatura($f);

    $qtdFaturasPagas++;
    $faturamentoTotalCalc += $bruto;
    $taxasTotalCalc += $taxa;

    if ((int)$data->format('Y') === (int)$agora->format('Y')) {
        $faturamentoPorMes[(int)$data->format('n')] += $bruto;
    }

    if ($data >= $inicioDia) {
        $faturamentoDia += $bruto;
        $taxasDia += $taxa;
    }
    if ($data >= $inicioSemana) {
        $faturamentoSemana += $bruto;
        $taxasSemana += $taxa;
    }
    if ($data >= $inicioMes) {
        $faturamentoMesCalc += $bruto;
        $taxasMes += $taxa;
    }
}

$faturamentoMesExibir = $fatMesInput > 0 ? $fatMesInput : $faturamentoMesCalc;
$faturamentoTotalExibir = $fatTotalInput > 0 ? $fatTotalInput : $faturamentoTotalCalc;
$lucroTaxasExibir = $lucroTaxasInput > 0 ? $lucroTaxasInput : $taxasTotalCalc;

$lucroDia = max($faturamentoDia - $taxasDia, 0);
$lucroSemana = max($faturamentoSemana - $taxasSemana, 0);
$lucroMes = max($faturamentoMesExibir - $taxasMes, 0);
$ticketMedio = $qtdFaturasPagas > 0 ? $faturamentoTotalExibir / $qtdFaturasPagas : 0;

$dadosGrafico = [];
for ($m = 1; $m <= 12; $m++) {
    $dadosGrafico[] = round($faturamentoPorMes[$m], 2);
}
if (!empty($stringDadosGrafico)) {
    $dadosGrafico = array_map('floatval', explode(',', (string)$stringDadosGrafico));
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Modo Deus | Nuvem Cloud</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --bg:#050506;--panel:#0d1117cc;--line:#33415566;--txt:#f8fafc;--muted:#94a3b8;
            --blue:#38bdf8;--blue2:#2563eb;--green:#10b981;--red:#ef4444;--orange:#f59e0b;--purple:#8b5cf6;
        }
        html,body{height:100%;font-family:'Inter',sans-serif;background:var(--bg);color:var(--txt);overflow:hidden}
        body::before,body::after{content:"";position:fixed;z-index:0;pointer-events:none;border-radius:999px;filter:blur(90px)}
        body::before{width:320px;height:320px;left:-80px;top:-100px;background:#1d4ed855}
        body::after{width:300px;height:300px;right:-80px;bottom:-90px;background:#38bdf833}
        .layout{display:flex;height:100%;position:relative;z-index:1}
        .sidebar{width:260px;background:var(--panel);backdrop-filter:blur(16px);border-right:1px solid var(--line);display:flex;flex-direction:column}
        .sb-head{padding:18px;border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center}
        .brand{display:flex;align-items:center;gap:10px;font-weight:800}
        .brand img{width:34px;height:34px;object-fit:contain}
        .sb-menu{padding:12px 0;overflow:auto;flex:1}
        .tab-link{display:flex;align-items:center;gap:10px;padding:12px 16px;color:#cbd5e1;text-decoration:none;font-weight:600;font-size:13px;border-right:3px solid transparent}
        .tab-link i{
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(148, 163, 184, 0.12);
            color: #cbd5e1;
            transition: background .2s ease, color .2s ease, box-shadow .2s ease;
        }
        .tab-link:hover,.tab-link.active{background:#1d4ed833;color:var(--blue);border-right-color:var(--blue)}
        .tab-link:hover i,
        .tab-link.active i{
            background: rgba(56, 189, 248, 0.18);
            color: var(--blue);
            box-shadow: 0 0 0 1px rgba(56, 189, 248, 0.28) inset;
        }
        .sb-foot{padding:14px;border-top:1px solid var(--line)}
        .btn-back{display:flex;justify-content:center;gap:8px;border:1px solid var(--line);border-radius:10px;padding:11px;color:#fff;text-decoration:none;font-size:13px;font-weight:600}
        .main{flex:1;display:flex;flex-direction:column;min-width:0}
        .top{display:flex;justify-content:space-between;align-items:center;padding:14px 18px;background:var(--panel);border-bottom:1px solid var(--line)}
        .menu-toggle{display:none;background:none;border:none;color:#fff;font-size:20px}
        .content{flex:1;overflow:auto;padding:20px}
        .head{margin-bottom:16px}
        .head h2{font-size:24px;font-weight:800}
        .head p{margin-top:6px;color:var(--muted);font-size:14px}
        .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-bottom:16px}
        .card{background:var(--panel);border:1px solid var(--line);border-radius:12px;padding:16px;position:relative}
        .card::before{content:"";position:absolute;left:0;top:0;width:4px;height:100%;background:var(--blue)}
        .card.g::before{background:var(--green)} .card.o::before{background:var(--orange)} .card.p::before{background:var(--purple)}
        .k{font-size:11px;text-transform:uppercase;letter-spacing:.6px;color:var(--muted);font-weight:700}
        .v{margin-top:7px;font-size:24px;font-weight:800}
        .panel{background:var(--panel);border:1px solid var(--line);border-radius:12px;padding:16px;margin-bottom:16px}
        .panel h3{display:flex;justify-content:space-between;align-items:center;font-size:16px;border-bottom:1px solid var(--line);padding-bottom:10px;margin-bottom:12px}
        .split{display:grid;grid-template-columns:1.2fr .8fr;gap:12px}
        .mini{background:#0f172a88;border:1px solid var(--line);border-radius:10px;padding:10px;margin-bottom:10px}
        .mini .l{font-size:12px;color:var(--muted)} .mini .n{font-size:18px;font-weight:700;margin-top:4px}
        .table-wrap{overflow:auto;border:1px solid var(--line);border-radius:10px}
        table{width:100%;border-collapse:collapse;min-width:820px}
        th,td{padding:11px;border-bottom:1px solid var(--line);font-size:13px;text-align:left;white-space:nowrap}
        th{font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);background:#02061788}
        tr:last-child td{border-bottom:none}
        .badge{display:inline-flex;gap:5px;padding:4px 9px;border-radius:999px;font-size:11px;font-weight:700}
        .ok{background:#10b98122;color:#34d399;border:1px solid #10b98155}
        .wait{background:#f59e0b22;color:#fbbf24;border:1px solid #f59e0b55}
        .btn{display:inline-flex;align-items:center;gap:7px;padding:8px 12px;border-radius:8px;border:1px solid var(--line);background:#0f172a;color:#fff;font-size:12px;font-weight:600;cursor:pointer}
        .btn.main{background:linear-gradient(135deg,var(--blue2),#1e40af);border:none}
        .btn.refresh{
            background: rgba(15, 23, 42, 0.45);
            border: 1px solid var(--line);
            color: #e2e8f0;
            box-shadow: none;
            padding: 8px 12px;
            border-radius: 8px;
        }
        .btn.refresh i{
            opacity: 0.85;
            font-size: 12px;
        }
        .btn.refresh:hover{
            background: rgba(30, 41, 59, 0.6);
            border-color: rgba(148, 163, 184, 0.55);
            transform: none;
        }
        .btn.green{background:#10b98122;border-color:#10b98166;color:#86efac}
        .tab-content{display:none;animation:fade .25s ease}
        .tab-content.active{display:block}
        @keyframes fade{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
        @media (max-width:1080px){.split{grid-template-columns:1fr}}
        @media (max-width:992px){
            .sidebar{position:fixed;left:-280px;top:0;height:100%;z-index:10;transition:left .25s}
            .sidebar.open{left:0}
            .menu-toggle{display:block}
            .content{padding:14px}
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar" id="admin-sidebar">
        <div class="sb-head">
            <div class="brand"><img src="/assets/logo-cloud.png" alt="logo"><span>Modo Deus</span></div>
            <button class="menu-toggle" onclick="toggleAdminMenu()"><i class="fas fa-times"></i></button>
        </div>
        <div class="sb-menu">
            <a href="#" class="tab-link active" onclick="mudarAbaAdmin(event,'aba-geral')"><i class="fas fa-globe"></i> Visão Geral</a>
            <a href="#" class="tab-link" onclick="mudarAbaAdmin(event,'aba-financeiro')"><i class="fas fa-chart-line"></i> Financeiro (PIX)</a>
            <a href="#" class="tab-link" onclick="mudarAbaAdmin(event,'aba-usuarios')"><i class="fas fa-users"></i> Gestão de Clientes</a>
            <a href="#" class="tab-link" onclick="mudarAbaAdmin(event,'aba-campanhas')"><i class="fas fa-bullhorn"></i> Campanhas</a>
            <a href="#" class="tab-link" onclick="mudarAbaAdmin(event,'aba-whatsapp')"><i class="fas fa-server"></i> Nós (WhatsApp)</a>
        </div>
        <div class="sb-foot"><a href="/" class="btn-back"><i class="fas fa-sign-out-alt"></i> Voltar à Plataforma</a></div>
    </aside>

    <section class="main">
        <header class="top">
            <div style="display:flex;align-items:center;gap:12px">
                <button class="menu-toggle" onclick="toggleAdminMenu()"><i class="fas fa-bars"></i></button>
                <strong id="titulo-topo">Visão Geral</strong>
            </div>
            <button class="btn refresh" onclick="atualizarEstatisticasGlobais()"><i class="fas fa-sync-alt"></i> Atualizar Dados</button>
        </header>

        <main class="content">
            <div id="aba-geral" class="tab-content active">
                <div class="head"><h2>Radar Global</h2><p>Acompanhe o comportamento geral da infraestrutura e dos bots.</p></div>
                <div class="cards">
                    <div class="card o"><div class="k">Total de Disparos Processados</div><div class="v" id="global-envios"><i class="fas fa-circle-notch fa-spin"></i></div></div>
                    <div class="card g"><div class="k">Total de Grupos</div><div class="v" id="global-grupos"><i class="fas fa-circle-notch fa-spin"></i></div></div>
                    <div class="card p"><div class="k">Alcance Total (Pessoas)</div><div class="v" id="global-alcance"><i class="fas fa-circle-notch fa-spin"></i></div></div>
                </div>
                <div class="panel">
                    <h3><span><i class="fas fa-shield-halved" style="color:var(--blue)"></i> Status do Sistema Anti-Ban</span></h3>
                    <p style="line-height:1.7;color:var(--muted);font-size:14px">Motor probabilístico em 56%, com cooldown entre 5 e 10 minutos e atrasos humanizados para reduzir bloqueios e manter estabilidade da operação.</p>
                </div>
            </div>

            <div id="aba-financeiro" class="tab-content">
                <div class="head"><h2>Financeiro Inteligente</h2><p>Visual moderno e objetivo de lucro/faturamento com leitura rápida.</p></div>
                <div class="cards">
                    <div class="card g"><div class="k">Lucro do dia</div><div class="v">R$ <?php echo number_format($lucroDia, 2, ',', '.'); ?></div></div>
                    <div class="card g"><div class="k">Lucro da semana</div><div class="v">R$ <?php echo number_format($lucroSemana, 2, ',', '.'); ?></div></div>
                    <div class="card g"><div class="k">Lucro do mês</div><div class="v">R$ <?php echo number_format($lucroMes, 2, ',', '.'); ?></div></div>
                    <div class="card"><div class="k">Faturamento total</div><div class="v">R$ <?php echo number_format($faturamentoTotalExibir, 2, ',', '.'); ?></div></div>
                    <div class="card p"><div class="k">Lucro das taxas</div><div class="v">R$ <?php echo number_format($lucroTaxasExibir, 2, ',', '.'); ?></div></div>
                    <div class="card o"><div class="k">Ticket médio</div><div class="v">R$ <?php echo number_format($ticketMedio, 2, ',', '.'); ?></div></div>
                </div>

                <div class="panel split">
                    <div>
                        <h3><span><i class="fas fa-chart-area" style="color:var(--blue)"></i> Receita Anual (<?php echo date('Y'); ?>)</span></h3>
                        <div style="height:250px"><canvas id="graficoReceita"></canvas></div>
                    </div>
                    <div>
                        <h3><span><i class="fas fa-wave-square" style="color:var(--purple)"></i> Resumo de Performance</span></h3>
                        <div class="mini"><div class="l">Faturamento do dia</div><div class="n">R$ <?php echo number_format($faturamentoDia, 2, ',', '.'); ?></div></div>
                        <div class="mini"><div class="l">Faturamento da semana</div><div class="n">R$ <?php echo number_format($faturamentoSemana, 2, ',', '.'); ?></div></div>
                        <div class="mini"><div class="l">Faturamento do mês</div><div class="n">R$ <?php echo number_format($faturamentoMesExibir, 2, ',', '.'); ?></div></div>
                        <div class="mini"><div class="l">Faturas pagas</div><div class="n"><?php echo number_format($qtdFaturasPagas, 0, ',', '.'); ?></div></div>
                    </div>
                </div>

                <div class="panel">
                    <h3><span><i class="fas fa-file-invoice-dollar" style="color:var(--green)"></i> Histórico Geral de Faturas</span></h3>
                    <div class="table-wrap">
                        <table>
                            <thead><tr><th>Data</th><th>Cliente</th><th>TXID</th><th>Bruto</th><th>Taxa</th><th>Líquido</th><th>Status / Ação</th></tr></thead>
                            <tbody>
                            <?php if (empty($faturasGerais)): ?>
                                <tr><td colspan="7" style="text-align:center">Nenhum registro encontrado.</td></tr>
                            <?php else: foreach ($faturasGerais as $f):
                                $bruto = (float)($f['total_pago'] ?? 0);
                                $taxa = taxaFatura($f);
                                $liq = max($bruto - $taxa, 0);
                            ?>
                                <tr>
                                    <td><?php echo isset($f['criado_em']) ? date('d/m/Y H:i', strtotime($f['criado_em'])) : '-'; ?></td>
                                    <td style="font-weight:700;color:#fff"><?php echo htmlspecialchars($f['usuario'] ?? '-'); ?></td>
                                    <td style="font-family:monospace;color:var(--muted)"><?php echo htmlspecialchars((string)($f['txid'] ?? '-')); ?></td>
                                    <td style="color:#86efac;font-weight:700">R$ <?php echo number_format($bruto,2,',','.'); ?></td>
                                    <td>R$ <?php echo number_format($taxa,2,',','.'); ?></td>
                                    <td style="font-weight:700">R$ <?php echo number_format($liq,2,',','.'); ?></td>
                                    <td>
                                        <?php if (($f['status'] ?? '') === 'pago'): ?>
                                            <span class="badge ok"><i class="fas fa-check"></i> LIQUIDADO</span>
                                        <?php else: ?>
                                            <div style="display:flex;gap:8px;align-items:center">
                                                <span class="badge wait"><i class="fas fa-clock"></i> PENDENTE</span>
                                                <button onclick="aprovarFaturaManual(<?php echo (int)($f['id'] ?? 0); ?>)" class="btn green"><i class="fas fa-check-double"></i> Aprovar</button>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="aba-usuarios" class="tab-content">
                <div class="head"><h2>Gestão de Clientes</h2><p>Total de registros: <?php echo $totalUsuarios; ?>.</p></div>
                <div class="panel"><h3><span><i class="fas fa-users-cog" style="color:var(--blue)"></i> Base de Dados</span></h3><p style="color:var(--muted);font-size:14px">Módulo de clientes mantido. Utilize seus endpoints atuais para operações completas de edição/exclusão.</p></div>
            </div>

            <div id="aba-campanhas" class="tab-content">
                <div class="head"><h2>Campanhas Ativas</h2></div>
                <div class="panel"><h3><span><i class="fas fa-bullhorn" style="color:var(--orange)"></i> Operação de Campanhas</span></h3><p style="color:var(--muted);font-size:14px">Estrutura pronta para listagem e controle com os dados de <code>$listaCampanhas</code>.</p></div>
            </div>

            <div id="aba-whatsapp" class="tab-content">
                <div class="head"><h2>Nós do WhatsApp</h2></div>
                <div class="panel"><h3><span><i class="fas fa-network-wired" style="color:var(--blue)"></i> Frota de Conexões</span></h3><p style="color:var(--muted);font-size:14px">Estrutura pronta para pareamento e gestão dos bots com os endpoints já existentes.</p></div>
            </div>
        </main>
    </section>
</div>

<script>
function toggleAdminMenu(){document.getElementById('admin-sidebar').classList.toggle('open')}
function mudarAbaAdmin(e,id){e.preventDefault();document.querySelectorAll('.tab-content').forEach(a=>a.classList.remove('active'));document.querySelectorAll('.tab-link').forEach(l=>l.classList.remove('active'));document.getElementById(id).classList.add('active');e.currentTarget.classList.add('active');document.getElementById('titulo-topo').innerText=e.currentTarget.innerText;if(window.innerWidth<=992){document.getElementById('admin-sidebar').classList.remove('open')}}

async function atualizarEstatisticasGlobais(){
    try{
        const res=await fetch('/api_bot_global_stats');const d=await res.json();
        document.getElementById('global-envios').innerText=new Intl.NumberFormat('pt-BR').format(d.fake_envios||0);
        document.getElementById('global-grupos').innerText=new Intl.NumberFormat('pt-BR').format(d.total_grupos||0);
        document.getElementById('global-alcance').innerText=new Intl.NumberFormat('pt-BR').format(d.total_alcance||0);
    }catch(e){document.getElementById('global-envios').innerText='-'}
}

async function aprovarFaturaManual(id){if(!confirm('Aprovar fatura e injetar saldo?'))return;try{await fetch('/aprovar_fatura_manual',{method:'POST',body:JSON.stringify({id_fatura:id})});location.reload()}catch(e){}}

document.addEventListener('DOMContentLoaded',()=>{
    atualizarEstatisticasGlobais();
    const canvas=document.getElementById('graficoReceita');if(!canvas)return;
    const ctx=canvas.getContext('2d');
    const g=ctx.createLinearGradient(0,0,0,280);g.addColorStop(0,'rgba(56,189,248,0.35)');g.addColorStop(1,'rgba(56,189,248,0)');
    new Chart(ctx,{type:'line',data:{labels:['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],datasets:[{label:'Faturamento R$',data:<?php echo json_encode(array_values($dadosGrafico)); ?>,borderColor:'#38bdf8',backgroundColor:g,borderWidth:3,pointBackgroundColor:'#8b5cf6',pointBorderColor:'#fff',fill:true,tension:.35}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{display:false},ticks:{color:'#94a3b8'}},y:{grid:{color:'rgba(51,65,85,0.4)'},ticks:{color:'#94a3b8',callback:v=>'R$ '+v}}}}});
});
</script>
</body>
</html>
