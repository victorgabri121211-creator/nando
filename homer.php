                        </div>
                    <?php else: ?>
                        <div style="display: grid; gap: 20px;">
                        <?php foreach($campanhas as $c): 
                            $perc = ($c['meta_envios'] > 0) ? ($c['envios_realizados'] / $c['meta_envios']) * 100 : 0; 
                            $statusCor = $c['status'] == 'concluida' ? 'var(--accent-green)' : ($c['status'] == 'rodando' ? 'var(--blue-light)' : 'var(--text-dim)');
                        ?>
                        <div class="form-card" style="padding: 25px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                <h4 style="margin: 0; font-size: 16px; color: #fff;">Campanha #<?php echo $c['id']; ?></h4>
                                <span style="background: rgba(0,0,0,0.3); color: <?php echo $statusCor; ?>; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid rgba(255,255,255,0.05); box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);">
                                    <?php echo strtoupper($c['status']); ?>
                                </span>
                            </div>
                            <div class="progress-container"><div class="progress-bar" style="width: <?php echo $perc; ?>%; background: <?php echo $statusCor; ?>; box-shadow: 0 0 10px <?php echo $statusCor; ?>;"></div></div>
                            <div style="display: flex; justify-content: space-between; font-size: 13px; color: var(--text-dim); margin-top: 10px;">
                                <span>Progresso: <strong style="color: #fff; font-size: 14px;"><?php echo $c['envios_realizados']; ?> / <?php echo $c['meta_envios']; ?></strong></span>
                                <span><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y H:i', strtotime($c['criado_em'])); ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="aba-loja" class="tab-content">
                    <div class="main-grid">
                        
                        <div class="form-card">
                            <div style="text-align: center; margin-bottom: 25px;">
                                <i class="fas fa-shopping-cart" style="font-size: 48px; color: var(--blue-light); margin-bottom: 15px; filter: drop-shadow(0 0 15px rgba(56,189,248,0.4));"></i>
                                <h3 style="margin: 0; color: #fff; font-size: 22px;">Loja de Envios</h3>
                                <p style="color: var(--text-dim); font-size: 13px; margin-top: 5px;">Compre créditos com o seu saldo da carteira</p>
                            </div>
                            
                            <div class="promo-box">
                                <h4 style="margin: 0 0 5px 0; color: var(--accent-orange); font-size: 16px;"><i class="fas fa-fire"></i> PROMOÇÃO ATIVA</h4>
                                <p style="color: #fff; font-size: 13px; margin: 0; font-weight: 500;">A cada <strong>R$ 10,00</strong> convertidos numa compra, você ganha <strong style="color: var(--accent-green);">+500 disparos GRÁTIS</strong> na mesma hora!</p>
                            </div>
                            
                            <label class="form-label" style="text-align: center;">Quantidade de Mensagens</label>
                            <input type="number" id="qtd-comprar" class="input-dark" style="font-size: 24px; text-align: center; font-weight: 800;" value="1000" oninput="calcularCompra()">
                            
                            <div style="background: rgba(0,0,0,0.4); padding: 15px; border-radius: 10px; margin-top: 20px; border: 1px solid var(--border-color); box-shadow: inset 0 2px 5px rgba(0,0,0,0.5);">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                                    <span style="color: var(--text-dim);">Preço por disparo:</span>
                                    <span style="color: #fff; font-weight: 600;">R$ 0,02</span>
                                </div>
                                <div id="display-bonus" style="display: none; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                                    <span style="color: var(--text-dim);">Bônus Promocional:</span>
                                    <span id="valor-bonus" style="color: var(--accent-green); font-weight: 700; text-shadow: 0 0 5px rgba(16,185,129,0.5);">+500 GRÁTIS</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; border-top: 1px dashed var(--border-color); padding-top: 10px; font-size: 14px;">
                                    <span style="color: var(--text-dim);">Total de Envios a Receber:</span>
                                    <span id="total-receber" style="color: var(--blue-light); font-weight: 700;">1000 envios</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 10px; margin-top: 10px; font-size: 16px;">
                                    <span style="font-weight: 600; color: var(--text-dim);">Custo Final a Debitar:</span>
                                    <span id="custo-compra" style="color: var(--accent-red); font-weight: 800; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">R$ 20,00</span>
                                </div>
                            </div>
                            
                            <button class="btn-primary" onclick="comprarCreditosSaldo()" style="width: 100%; margin-top: 25px; height: 55px; font-size: 15px;"><i class="fas fa-exchange-alt"></i> CONVERTER EM ENVIOS</button>
                        </div>

                        <div class="form-card">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <i class="fas fa-wallet" style="font-size: 48px; color: var(--accent-green); margin-bottom: 15px; filter: drop-shadow(0 0 15px rgba(16,185,129,0.4));"></i>
                                <h3 style="margin: 0; color: #fff; font-size: 22px;">Injetar Saldo</h3>
                                <p style="color: var(--text-dim); font-size: 13px; margin-top: 5px;">Depósito Mínimo: <strong>R$ 5,00</strong></p>
                            </div>
                            
                            <label class="form-label" style="text-align: center;">Valor Desejado (R$)</label>
                            <input type="number" id="valor-compra" class="input-dark" style="font-size: 24px; text-align: center; font-weight: 800;" value="20" oninput="calcularCheckout()">
                            
                            <div style="background: rgba(0,0,0,0.4); padding: 15px; border-radius: 10px; margin-top: 20px; border: 1px solid var(--border-color); box-shadow: inset 0 2px 5px rgba(0,0,0,0.5);">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                                    <span style="color: var(--text-dim);">Valor depositado:</span>
                                    <span id="resumo-valor" style="color: #fff; font-weight: 600;">R$ 20,00</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                                    <span style="color: var(--text-dim);">Taxa do Gateway:</span>
                                    <span style="color: #fff; font-weight: 600;">R$ 1,00</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 10px; font-size: 16px;">
                                    <span style="font-weight: 600; color: var(--text-dim);">Total a pagar:</span>
                                    <span id="resumo-total" style="color: var(--accent-green); font-weight: 800; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">R$ 21,00</span>
                                </div>
                            </div>
                            
                            <button class="btn-primary" id="btn-gerar-pix" onclick="gerarPagamentoPix()" style="width: 100%; margin-top: 25px; height: 55px; font-size: 15px; background: linear-gradient(135deg, #10b981, #059669); border-color: transparent; box-shadow: 0 8px 20px rgba(16,185,129,0.3);"><i class="fab fa-pix"></i> GERAR PIX AGORA</button>
                            
                            <div id="area-pagamento" style="display: none; margin-top: 30px; text-align: center; animation: fadeIn 0.5s;">
                                <p style="font-size: 14px; color: var(--text-dim); margin-bottom: 15px;">Escaneie o QR Code abaixo ou copie o código</p>
                                <div style="background: #fff; padding: 15px; border-radius: 16px; display: inline-block; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.6);">
                                    <img src="" id="img-qrcode" style="width: 180px; height: 180px; display: block;">
                                </div>
                                <input type="text" id="input-copiacola" readonly class="input-dark" style="font-size: 12px; text-align: center; color: var(--text-dim); margin-bottom: 15px;">
                                <button class="btn-primary" onclick="copiarPix()" style="width: 100%; background: var(--bg-input); border-color: var(--border-color); box-shadow: none;"><i class="fas fa-copy"></i> COPIAR CÓDIGO PIX</button>
                                <p style="color: var(--accent-orange); font-size: 13px; margin-top: 20px; font-weight: 700;"><i class="fas fa-circle-notch fa-spin"></i> Aguardando confirmação do pagamento...</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <footer style="text-align: center; padding: 25px; color: var(--text-dim); font-size: 13px; border-top: 1px solid var(--border-color); background: rgba(15,23,42,0.5); z-index: 5;">Nuvem Cloud &bull; Advanced Cloud Infrastructure &bull; 2026</footer>
        </main>
    </div>

    <script>
        let fotoBase64 = ""; let loopPix;

        function toggleMenu() { document.getElementById('sidebar').classList.toggle('open'); }
        
        function mostrarNotificacao(msg, tipo = 'sucesso') {
            const t = document.getElementById('toast-notificacao'); const i = document.getElementById('toast-icone');
            t.className = 'toast-global show ' + (tipo === 'sucesso' ? 'toast-success' : 'toast-error');
            i.className = tipo === 'sucesso' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            i.style.color = tipo === 'sucesso' ? 'var(--accent-green)' : 'var(--accent-red)';
            document.getElementById('toast-texto').innerText = msg;
            setTimeout(() => t.classList.remove('show'), 4000);
        }
        
        function mudarAba(e, id) {
            if(e) e.preventDefault();
            document.querySelectorAll('.tab-content').forEach(a => a.classList.remove('active'));
            document.querySelectorAll('.tab-link').forEach(l => l.classList.remove('active'));
            document.getElementById(id).classList.add('active');
            if(e) { e.currentTarget.classList.add('active'); document.getElementById('titulo-topo').innerText = e.currentTarget.innerText; }
            localStorage.setItem('abaAtiva', id);
            if(window.innerWidth <= 992 && e) toggleMenu();
        }

        async function buscarStatsNuvem() {
            try {
                const res = await fetch('/api_bot_global_stats');
                const d = await res.json();
                document.getElementById('display-grupos').innerText = new Intl.NumberFormat('pt-BR').format(d.total_grupos || 0);
                document.getElementById('display-alcance').innerText = new Intl.NumberFormat('pt-BR').format(d.total_alcance || 0);
                document.getElementById('display-bots').innerText = d.bots ? Object.keys(d.bots).length : 0;
            } catch(e) {
                document.getElementById('display-grupos').innerText = "0";
                document.getElementById('display-alcance').innerText = "0";
                document.getElementById('display-bots').innerText = "0";
            }
        }

        window.onload = () => { 
            mudarAba(null, localStorage.getItem('abaAtiva') || 'aba-dashboard'); 
            calcularCheckout(); 
            calcularCompra(); 
            buscarStatsNuvem(); 
        };

        function copiarLinkAfiliado() { document.getElementById('link-indicacao').select(); document.execCommand('copy'); mostrarNotificacao("Link de Afiliado copiado!"); }

        function previewImagem(input) { 
            if (input.files && input.files[0]) { 
                const reader = new FileReader(); 
                reader.onload = (e) => { 
                    document.getElementById('upload-texto').style.display = 'none'; 
                    const preview = document.getElementById('preview-img'); 
                    preview.src = e.target.result; preview.style.display = 'block'; 
                    document.getElementById('btn-remover-img').style.display = 'block'; 
                    document.getElementById('box-upload').style.borderColor = 'transparent';
                    fotoBase64 = e.target.result; 
                }; reader.readAsDataURL(input.files[0]); 
            } 
        }

        function removerImagem() { 
            document.getElementById('foto-campanha').value = ""; document.getElementById('preview-img').style.display = 'none'; document.getElementById('preview-img').src = ""; 
            document.getElementById('upload-texto').style.display = 'block'; document.getElementById('btn-remover-img').style.display = 'none'; 
            document.getElementById('box-upload').style.borderColor = 'rgba(56, 189, 248, 0.4)'; fotoBase64 = ""; 
        }

        function calcularCheckout() { 
            let v = parseFloat(document.getElementById('valor-compra').value) || 0; 
            document.getElementById('resumo-valor').innerText = "R$ " + v.toFixed(2).replace('.', ',');
            document.getElementById('resumo-total').innerText = "R$ " + (v + 1).toFixed(2).replace('.', ','); 
        }
        
        // 🟢 CÁLCULO E FEEDBACK DA PROMOÇÃO EM TEMPO REAL
        function calcularCompra() { 
            let q = parseInt(document.getElementById('qtd-comprar').value) || 0; 
            let custo = q * 0.02; 
            
            // Lógica de Bônus: +500 a cada R$ 10,00 gastos
            let bonusMultiplicador = Math.floor(custo / 10);
            let bonus = bonusMultiplicador * 500;
            let totalReceber = q + bonus;
            
            document.getElementById('custo-compra').innerText = "R$ " + custo.toFixed(2).replace('.', ','); 
            
            if(bonus > 0) {
                document.getElementById('display-bonus').style.display = 'flex';
                document.getElementById('valor-bonus').innerText = "+" + bonus + " GRÁTIS";
                document.getElementById('total-receber').innerText = totalReceber + " envios";
                document.getElementById('total-receber').style.color = "var(--accent-green)";
            } else {
                document.getElementById('display-bonus').style.display = 'none';
                document.getElementById('total-receber').innerText = q + " envios";
                document.getElementById('total-receber').style.color = "var(--blue-light)";
            }
        }

        async function comprarCreditosSaldo() { 
            let q = parseInt(document.getElementById('qtd-comprar').value) || 0; 
            if(q < 100) return alert("Mínimo 100 envios."); 
            
            let custo = q * 0.02;
            let bonus = Math.floor(custo / 10) * 500;
            
            let msgConfirm = `Confirmar compra de ${q} mensagens por R$ ${custo.toFixed(2).replace('.',',')}?`;
            if (bonus > 0) { msgConfirm = `Você vai comprar ${q} mensagens por R$ ${custo.toFixed(2).replace('.',',')} e GANHAR +${bonus} GRÁTIS!\n\nTotal a receber: ${q + bonus} envios.\nConfirmar?`; }
            
            if(!confirm(msgConfirm)) return; 
            
            try { 
                const res = await fetch('/comprar_creditos', { method: 'POST', body: JSON.stringify({ quantidade: q }) }); 
                const d = await res.json(); 
                if(d.status === 'sucesso') { mostrarNotificacao(d.mensagem); setTimeout(() => location.reload(), 2500); } else { mostrarNotificacao(d.mensagem, "erro"); } 
            } catch(e) { mostrarNotificacao("Erro de conexão", "erro"); } 
        }

        function dispararSucessoDopamina() { document.getElementById('audio-sucesso').play(); document.getElementById('dopamina-confirmacao').style.display = 'flex'; }

        async function verificarPix(id) { 
            try { 
                const res = await fetch(`/verificar_status_pix?id=${id}`); 
                const d = await res.json(); 
                if(d.status === 'pago') { 
                    clearInterval(loopPix); 
                    dispararSucessoDopamina(); 
                } 
            } catch(e) {} 
        }

        async function gerarPagamentoPix() { 
            const v = parseFloat(document.getElementById('valor-compra').value); 
            if(v < 5) return alert("Depósito Mínimo: R$ 5,00."); 
            
            const btn = document.getElementById('btn-gerar-pix'); btn.disabled = true; btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> CONECTANDO AO BANCO...'; 
            try { 
                const res = await fetch('/gerar_pix', { method: 'POST', body: JSON.stringify({ valor: v }) }); 
                const d = await res.json(); 
                if(d.status === 'sucesso') { 
                    document.getElementById('img-qrcode').src = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(d.copia_cola)}&margin=10`; 
                    document.getElementById('input-copiacola').value = d.copia_cola; document.getElementById('area-pagamento').style.display = 'block'; btn.style.display = 'none';
                    if(loopPix) clearInterval(loopPix); loopPix = setInterval(() => verificarPix(d.fatura_id), 3000); 
                } else { alert(d.mensagem); btn.disabled = false; btn.innerHTML = '<i class="fab fa-pix"></i> GERAR PIX AGORA'; } 
            } catch(e) { alert("Erro na conexão com o servidor."); btn.disabled = false; btn.innerHTML = '<i class="fab fa-pix"></i> GERAR PIX AGORA'; } 
        }

        function copiarPix() { document.getElementById('input-copiacola').select(); document.execCommand('copy'); mostrarNotificacao("Código Copiado!"); }

        async function iniciarDisparoNuvem() { 
            const q = parseInt(document.getElementById('qtd-disparos').value); 
            const t = document.getElementById('texto-nuvem').value; 
            const turbo = document.getElementById('check-turbo').checked; 
            if(!q || !t) return alert("Preencha a quantidade e a mensagem."); 
            const btn = document.getElementById('btn-disparar-nuvem'); btn.disabled = true; btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> ENVIANDO...'; 
            try { 
                const res = await fetch('/lancar_campanha_nuvem', { method: 'POST', body: JSON.stringify({ qtd: q, texto: t, imagem: fotoBase64, turbo: turbo }) }); 
                const d = await res.json(); 
                if(d.status === 'sucesso') { mostrarNotificacao("Campanha lançada!"); mudarAba(null, 'aba-historico'); setTimeout(() => location.reload(), 1500); } 
                else { mostrarNotificacao(d.mensagem, "erro"); btn.disabled = false; btn.innerHTML = '<i class="fas fa-paper-plane"></i> LANÇAR CAMPANHA'; } 
            } catch(e) { mostrarNotificacao("Erro ao conectar.", "erro"); btn.disabled = false; btn.innerHTML = '<i class="fas fa-paper-plane"></i> LANÇAR CAMPANHA'; } 
        }
    </script>
</body>
</html>