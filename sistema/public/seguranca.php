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
        $senha_atual = $_POST['senha_atual'] ?? "";
        $nova_senha = $_POST['nova_senha'] ?? "";
        $confirmar_senha = $_POST['confirmar_senha'] ?? "";

        $sql = "SELECT senha_usuario FROM usuario WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $dados_usuario = $result->fetch_assoc();
            $senha_hash = $dados_usuario['senha_usuario'];
            
            if (password_verify($senha_atual, $senha_hash)) {
                if (strlen($nova_senha) < 5) {
                    $mensagem = "A senha deve ter pelo menos 5 caracteres!";
                } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $nova_senha)) {
                    $mensagem = "A senha deve conter pelo menos um caractere especial!";
                } elseif ($nova_senha !== $confirmar_senha) {
                    $mensagem = "As senhas não coincidem!";
                } else {
                    $novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                    $sql_update = "UPDATE usuario SET senha_usuario = ? WHERE id_usuario = ?";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bind_param("si", $novo_hash, $id_usuario);
                    
                    if ($stmt_update->execute()) {
                        $mensagem = "Senha alterada com sucesso!";
                        $_SESSION['senha_usuario'] = $novo_hash;
                    } else {
                        $mensagem = "Erro ao alterar senha: " . $stmt_update->error;
                    }
                    $stmt_update->close();
                }
            } else {
                $mensagem = "Senha atual incorreta!";
            }
        }
        $stmt->close();
    }
?>
<?php include "header.php"; ?>
    <main>
        <div class="paginaSeguranca">
            <h1>
                <i class="bi bi-shield-lock-fill"></i> Configurações de Segurança
            </h1>

            <?php if ($mensagem): ?>
                <div class="mensagem-alerta <?php echo strpos($mensagem, 'sucesso') !== false ? 'success' : 'error'; ?>">
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>

            <div class="blocoSenha">
                <h2>Alterar Senha</h2>
                <form method="POST" id="formAlterarSenha">
                    <div style="display: grid; gap: 15px; margin-top: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Senha Atual</label>
                            <input type="password" name="senha_atual" required 
                                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" 
                                   placeholder="Digite sua senha atual">
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nova Senha</label>
                            <input type="password" name="nova_senha" id="nova_senha" required 
                                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" 
                                   placeholder="Digite a nova senha">
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Confirmar Nova Senha</label>
                            <input type="password" name="confirmar_senha" id="confirmar_senha" required 
                                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" 
                                   placeholder="Confirme a nova senha">
                        </div>
                    </div>
                    
                    <button type="submit" class="btnSenha" style="margin-top: 20px;">
                        <i class="bi bi-key-fill"></i> Alterar Senha
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('formAlterarSenha').addEventListener('submit', function(e) {
            const novaSenha = document.getElementById('nova_senha').value;
            const confirmarSenha = document.getElementById('confirmar_senha').value;
            
            if (novaSenha.length < 5) {
                alert('A senha deve ter pelo menos 5 caracteres!');
                e.preventDefault();
                return false;
            }
            
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(novaSenha)) {
                alert('A senha deve conter pelo menos um caractere especial!');
                e.preventDefault();
                return false;
            }
            
            if (novaSenha !== confirmarSenha) {
                alert('As senhas não coincidem!');
                e.preventDefault();
                return false;
            }
        });
    </script>

</body>
</html>