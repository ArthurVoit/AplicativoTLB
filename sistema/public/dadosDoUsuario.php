<?php
    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }

    $id_usuario = $_SESSION['id_usuario'];
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['nova_foto'])) {
        $uploadDir = '../uploads/usuarios/';
        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $nomeArquivo = uniqid() . '_' . basename($_FILES['nova_foto']['name']);
        $caminhoCompleto = $uploadDir . $nomeArquivo;
        
        $tipoArquivo = strtolower(pathinfo($caminhoCompleto, PATHINFO_EXTENSION));
        $extensoesPermitidas = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array($tipoArquivo, $extensoesPermitidas)) {
            if (move_uploaded_file($_FILES['nova_foto']['tmp_name'], $caminhoCompleto)) {

                $caminhoRelativo = 'uploads/usuarios/' . $nomeArquivo;
                $sqlUpdate = "UPDATE usuario SET foto_usuario = ? WHERE id_usuario = ?";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bind_param("si", $caminhoRelativo, $id_usuario);
                
                if ($stmtUpdate->execute()) {
                    $_SESSION['mensagem'] = "Foto atualizada com sucesso!";
                    $_SESSION['foto_usuario'] = $caminhoRelativo;
                } else {
                    $_SESSION['mensagem'] = "Erro ao atualizar foto no banco de dados.";
                }
                $stmtUpdate->close();
            } else {
                $_SESSION['mensagem'] = "Erro ao fazer upload da imagem.";
            }
        } else {
            $_SESSION['mensagem'] = "Por favor, selecione uma imagem válida (JPG, JPEG, PNG ou GIF).";
        }
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    
    $sql = "SELECT nome_usuario, email_usuario, funcao_usuario, telefone_usuario, foto_usuario, cep_usuario FROM usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $dados_usuario = $result->fetch_assoc();
        $foto_usuario = $dados_usuario['foto_usuario'];
        $nome_usuario = $dados_usuario['nome_usuario'];
        $email_usuario = $dados_usuario['email_usuario'];
        $funcao_usuario = $dados_usuario['funcao_usuario'];
        $telefone_usuario = $dados_usuario['telefone_usuario'];
        $cep_usuario = $dados_usuario['cep_usuario'];
        
        if (empty($telefone_usuario)) {
            $telefone_usuario = "Não cadastrado";
        }
        
        if (empty($foto_usuario)) {
            $foto_usuario = '../img/foto-padrao.jpg';
        } else {
            if (strpos($foto_usuario, '../') === false && strpos($foto_usuario, 'uploads/usuarios/') !== false) {
                $foto_usuario = '../' . $foto_usuario;
            }
            
            if (!file_exists($foto_usuario)) {
                $foto_usuario = '../images/usuario-padrao.jpg';
            }
        }
    } else {
        $nome_usuario = "Usuário não encontrado";
        $email_usuario = "N/A";
        $funcao_usuario = "N/A";
        $telefone_usuario = "N/A";
        $foto_usuario = '../images/usuario-padrao.jpg';
    }
    
    $stmt->close();
?>

<?php include "header.php"; ?>
<br>
<main>
    <div class="dadosUsuario">
        <?php 
        if (isset($_SESSION['mensagem'])) {
            echo '<div class="mensagem-alerta ' . (strpos($_SESSION['mensagem'], 'sucesso') !== false ? 'success' : 'error') . '">';
            echo $_SESSION['mensagem'];
            echo '</div>';
            unset($_SESSION['mensagem']);
        }
        ?>
        
        <div class="foto-container" style="text-align: center; margin-bottom: 20px;">
            <form method="POST" enctype="multipart/form-data" id="fotoForm">
                <input type="file" name="nova_foto" id="nova_foto" accept="image/*" style="display: none;">
                
                <label for="nova_foto" style="cursor: pointer; display: inline-block;">
                    <img class='foto_usuario' src='<?php echo $foto_usuario; ?>' alt='Foto do usuário' title='Clique para alterar a foto' 
                         onerror="this.src='../images/usuario-padrao.jpg'">
                </label>
            </form>
            
            <div id="preview-container" style="display: none; margin-top: 10px;">
                <p>Prévia da nova foto:</p>
                <img id="preview" src="#" alt="Prévia da nova foto" style="max-width: 150px; max-height: 150px; border-radius: 50%;">
                <div style="margin-top: 10px;">
                    <button type="button" onclick="confirmarTrocaFoto()" style="background-color: #27ae60; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; margin-right: 10px;">
                        <i class="bi bi-check-lg"></i> Confirmar
                    </button>
                    <button type="button" onclick="cancelarTrocaFoto()" style="background-color: #e74c3c; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">
                        <i class="bi bi-x-lg"></i> Cancelar
                    </button>
                </div>
            </div>
        </div>
        
        <h1><?php echo htmlspecialchars($nome_usuario); ?></h1>
        <div class="flex">
            <i class="bi bi-person-fill"></i>
            <div class="textoDadosUsuario">
                <h2>Email: <?php echo htmlspecialchars($email_usuario); ?></h2>
                <h2>Função: <?php echo htmlspecialchars($funcao_usuario); ?></h2>
                <h2>Telefone: <?php echo htmlspecialchars($telefone_usuario); ?></h2>
                <h2>CEP: <?php echo htmlspecialchars($cep_usuario); ?></h2>
            </div>
        </div>
    </div>
    
    <h1 class="configuracoesDados">Configurações</h1>
    <div class="configuracoesDados">
        <a href="geral.php" class="iconDadosUsuario">
            <i class="bi bi-gear-fill"></i>
            <h2>Geral</h2>
        </a>
        <a href="seguranca.php" class="iconDadosUsuario">
            <i class="bi bi-shield-fill-check"></i>
            <h2>Segurança</h2>
        </a>
        <a href="logout.php?logout=true" class="iconDadosUsuario">
            <i class="bi bi-box-arrow-left"></i>
            <h2>Sair</h2>
        </a>
    </div>
</main>

<script>
document.getElementById('nova_foto').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('preview-container');
    const preview = document.getElementById('preview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
});

function confirmarTrocaFoto() {
    document.getElementById('fotoForm').submit();
}

function cancelarTrocaFoto() {
    document.getElementById('nova_foto').value = '';
    document.getElementById('preview-container').style.display = 'none';
}
</script>

</body>
</html>