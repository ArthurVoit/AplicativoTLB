<?php
include "../db.php";
session_start();
   
$register_msg = "";
   
if (isset($data['erro'])) {
    echo json_encode(['success' => false, 'message' => 'CEP não encontrado']);
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])){
    
    $novo_usuario = $_POST['novo_usuario'] ?? "";
    $novo_email = $_POST['novo_email'] ?? "";
    $nova_senha = $_POST['nova_senha'] ?? "";
    $confirmar_senha = $_POST['confirmar_senha'] ?? "";
    $novo_cep = $_POST['CEP'] ?? "";
    $telefone = $_POST['telefone'] ?? "";
    
    // Verificar se é email empresarial @tlb.com
    if (!str_ends_with($novo_email, '@tlb.com')) {
        $register_msg = "Por favor, use um email empresarial @tlb.com!";
    }
    elseif(strlen($nova_senha) < 5){
        $register_msg = "A senha deve ter pelo menos 5 caracteres!";
    }
    elseif(!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $nova_senha)){
        $register_msg = "A senha deve conter pelo menos um caractere especial!";
    }
    elseif($nova_senha !== $confirmar_senha){
        $register_msg = "As senhas não coincidem!";
    }
    elseif($novo_usuario && $nova_senha && $novo_email && $novo_cep && $telefone){
        
        $url = "https://viacep.com.br/ws/{$novo_cep}/json/";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        if(isset($data['erro'])) {
            $register_msg = "CEP não encontrado!";
        } else {
            $novo_logradouro  =  $data['logradouro'] ?? ''; 
            $novo_complemento =  $data['complemento'] ?? ''; 
            $novo_bairro      =  $data['bairro'] ?? ''; 
            $novo_cidade      =  $data['localidade'] ?? ''; 
            $novo_estado      =  $data['uf'] ?? '';
            
            $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $nova_func = 'normal';
            
            $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario, funcao_usuario, cep_usuario, logradouro_usuario, complemento_usuario, bairro_usuario, cidade_usuario, estado_usuario, telefone_usuario) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssssss", $novo_usuario, $novo_email, $hash, $nova_func, $novo_cep, $novo_logradouro, $novo_complemento, $novo_bairro, $novo_cidade, $novo_estado, $telefone);
            
            if($stmt->execute()) {
                $_SESSION['cadastro_sucesso'] = true;
                header("Location: login.php");
                exit;
            } else {
                if($stmt->errno == 1062) {
                    $register_msg = "Este email já está cadastrado!";
                } else {
                    $register_msg = "Erro ao cadastrar novo usuário: " . $stmt->error;
                }
            };
            $stmt->close();
        }
    } else {
        $register_msg = "Preencha todos os campos.";
    };
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../script/scriptCadastro.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
</head>

<body class="bodyTelaCadastro">
    <section class="cadastro">
        <div class="formCadastro">
            <a href="login.php"><i class="bi bi-arrow-left-circle"></i></a>
            <form method="post" id="formcadastro">
                <?php if($register_msg): ?> 
                    <div class="inputContainer">
                        <p class="<?php echo strpos($register_msg, 'sucesso') !== false ? 'success-msg' : 'error-msg'; ?>"> 
                            <?= $register_msg ?> 
                        </p> 
                    </div>
                <?php endif; ?>
                
                <div class="inputContainer">
                    <input type="text" id="novo_usuario" name="novo_usuario" required placeholder="usuário" value="<?php echo htmlspecialchars($novo_usuario ?? ''); ?>">
                    <i class="bi bi-person-fill"></i>
                </div>
                
                <div class="inputContainer">
                    <input type="email" id="novo_email" name="novo_email" required placeholder="email @tlb.com" value="<?php echo htmlspecialchars($novo_email ?? ''); ?>">
                    <i class="bi bi-at"></i>
                </div>
                
                <div class="inputContainer">
                    <input type="tel" id="telefone" name="telefone" required placeholder="telefone (11) 99999-9999" value="<?php echo htmlspecialchars($telefone ?? ''); ?>">
                    <i class="bi bi-telephone-fill"></i>
                </div>
                
                <div class="inputContainer">
                    <input type="password" id="nova_senha" name="nova_senha" required placeholder="senha">
                    <i class="bi bi-lock-fill"></i>
                </div>
                
                <div class="inputContainer">
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required placeholder="confirmar senha">
                    <i class="bi bi-lock-fill"></i>
                </div>
                
                <div class="inputContainer">
                    <input type="text" id="CEP" name="CEP" required placeholder="CEP (apenas números)" value="<?php echo htmlspecialchars($novo_cep ?? ''); ?>">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                
                <button class="buttonRoxoCadastro" type="submit" name="register" value="1">Cadastrar-se</button>
            </form>
            <p class="pCadastro">Ao clicar você estará de acordo com as políticas da empresa</p>
            <a href="politicas.php">Ver políticas</a>
        </div>
    </section>
</body>
</html>