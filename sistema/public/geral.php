<?php
    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }

    $id_usuario = $_SESSION['id_usuario'];
    $mensagem = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome_usuario = $_POST['nome_usuario'] ?? "";
        $email_usuario = $_POST['email_usuario'] ?? "";
        $telefone_usuario = $_POST['telefone_usuario'] ?? "";
        $cep_usuario = $_POST['cep_usuario'] ?? "";

        if (!str_ends_with($email_usuario, '@tlb.com')) {
            $mensagem = "Por favor, use um email empresarial @tlb.com!";
        } else {
            $url = "https://viacep.com.br/ws/{$cep_usuario}/json/";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            
            if (isset($data['erro'])) {
                $mensagem = "CEP não encontrado! Verifique o CEP digitado.";
            } else {
                $sql = "UPDATE usuario SET nome_usuario = ?, email_usuario = ?, telefone_usuario = ?, cep_usuario = ? WHERE id_usuario = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $nome_usuario, $email_usuario, $telefone_usuario, $cep_usuario, $id_usuario);
                
                if ($stmt->execute()) {
                    $mensagem = "Dados atualizados com sucesso!";
                    $_SESSION['nome_usuario'] = $nome_usuario;
                } else {
                    $mensagem = "Erro ao atualizar dados: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }

    $sql = "SELECT nome_usuario, email_usuario, funcao_usuario, telefone_usuario, cep_usuario FROM usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $dados_usuario = $result->fetch_assoc();
        $nome_usuario = $dados_usuario['nome_usuario'];
        $email_usuario = $dados_usuario['email_usuario'];
        $funcao_usuario = $dados_usuario['funcao_usuario'];
        $telefone_usuario = $dados_usuario['telefone_usuario'];
        $cep_usuario = $dados_usuario['cep_usuario'];
    }
    $stmt->close();
?>
<?php include "header.php"; ?>
    <main>
        <div class="paginaGeral">
            <h1>
                <i class="bi bi-gear-fill"></i> Configurações Gerais
            </h1>

            <?php if ($mensagem): ?>
                <div class="mensagem-alerta <?php echo strpos($mensagem, 'sucesso') !== false ? 'success' : 'error'; ?>">
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>

            <div class="blocoIdioma">
                <h2>Meus Dados</h2>
                <form method="POST" id="formEditarDados">
                    <div style="display: grid; gap: 15px; margin-top: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nome de Usuário</label>
                            <input type="text" name="nome_usuario" value="<?php echo htmlspecialchars($nome_usuario); ?>" 
                                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
                            <input type="email" name="email_usuario" value="<?php echo htmlspecialchars($email_usuario); ?>" 
                                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Telefone</label>
                            <input type="text" name="telefone_usuario" id="telefone" value="<?php echo htmlspecialchars($telefone_usuario); ?>" 
                                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">CEP</label>
                            <input type="text" name="cep_usuario" id="cep" value="<?php echo htmlspecialchars($cep_usuario); ?>" 
                                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" required>
                            <small style="color: #666; font-size: 12px;">Digite apenas números</small>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Função</label>
                            <input type="text" value="<?php echo htmlspecialchars($funcao_usuario); ?>" 
                                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f5f5f5;" readonly disabled>
                        </div>
                    </div>
                    
                    <button type="submit" class="btnAlterações" style="margin-top: 20px;">
                        <i class="bi bi-check-lg"></i> Salvar Alterações
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length <= 11) {
                if (value.length <= 2) {
                    value = value.replace(/^(\d{0,2})/, '($1');
                } else if (value.length <= 6) {
                    value = value.replace(/^(\d{2})(\d{0,4})/, '($1) $2');
                } else if (value.length <= 10) {
                    value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                } else {
                    value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                }
            } else {
                value = value.slice(0, 11);
                value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            }
            
            e.target.value = value;
        });

        document.getElementById('cep').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) {
                value = value.slice(0, 8);
            }
            e.target.value = value;
        });

        document.getElementById('formEditarDados').addEventListener('submit', function(e) {
            const telefone = document.getElementById('telefone').value.replace(/\D/g, '');
            const cep = document.getElementById('cep').value;
            const email = document.querySelector('input[name="email_usuario"]').value;
            
            if (!email.endsWith('@tlb.com')) {
                alert('Por favor, use um email empresarial @tlb.com!');
                e.preventDefault();
                return false;
            }
            
            if (telefone.length < 10 || telefone.length > 11) {
                alert('Telefone deve ter 10 ou 11 dígitos!');
                e.preventDefault();
                return false;
            }
            
            if (cep.length !== 8) {
                alert('CEP deve ter 8 dígitos!');
                e.preventDefault();
                return false;
            }
        });
    </script>

</body>
</html>