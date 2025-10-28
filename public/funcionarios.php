<?php
include '../db.php';
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['funcao_usuario'] !== 'administrador') {
    echo "Acesso negado. Você não tem permissão para acessar esta página.
    <br>
    <a href='mapa.php'>Retornar ao aplicativo</a>
    ";
    exit;
}

$mensagem = "";

if (isset($_GET['excluir'])) {
    $id_excluir = $_GET['excluir'];

    if ($id_excluir == $_SESSION['id_usuario']) {
        $mensagem = "error|Você não pode excluir sua própria conta!";
    } else {
        $stmt = $conn->prepare("DELETE FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_excluir);
        
        if ($stmt->execute()) {
            $mensagem = "success|Usuário excluído com sucesso!";
        } else {
            $mensagem = "error|Erro ao excluir usuário: " . $stmt->error;
        }
        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_editar = $_POST['id_usuario'] ?? 0;
    $nome = $_POST['nome_usuario'] ?? "";
    $email = $_POST['email_usuario'] ?? "";
    $telefone = $_POST['telefone_usuario'] ?? "";
    $funcao = $_POST['funcao_usuario'] ?? "normal";
    
    if (isset($_POST['adicionar'])) {
        $senha = $_POST['senha_usuario'] ?? "";
        
        if ($nome && $email && $senha) {
            $stmt_verifica = $conn->prepare("SELECT id_usuario FROM usuario WHERE email_usuario = ?");
            $stmt_verifica->bind_param("s", $email);
            $stmt_verifica->execute();
            $result_verifica = $stmt_verifica->get_result();
            
            if ($result_verifica->num_rows > 0) {
                $mensagem = "error|Este email já está cadastrado!";
            } else {
                $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario, telefone_usuario, funcao_usuario) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nome, $email, $senha, $telefone, $funcao);
                
                if ($stmt->execute()) {
                    $mensagem = "success|Funcionário cadastrado com sucesso!";
                } else {
                    $mensagem = "error|Erro ao cadastrar funcionário: " . $stmt->error;
                }
                $stmt->close();
            }
            $stmt_verifica->close();
        } else {
            $mensagem = "error|Preencha todos os campos obrigatórios!";
        }
    }
    
    if (isset($_POST['editar'])) {
        $nova_senha = $_POST['nova_senha'] ?? "";
        
        if ($nome && $email) {
            if ($nova_senha) {
                $stmt = $conn->prepare("UPDATE usuario SET nome_usuario = ?, email_usuario = ?, telefone_usuario = ?, funcao_usuario = ?, senha_usuario = ? WHERE id_usuario = ?");
                $stmt->bind_param("sssssi", $nome, $email, $telefone, $funcao, $nova_senha, $id_editar);
            } else {
                $stmt = $conn->prepare("UPDATE usuario SET nome_usuario = ?, email_usuario = ?, telefone_usuario = ?, funcao_usuario = ? WHERE id_usuario = ?");
                $stmt->bind_param("ssssi", $nome, $email, $telefone, $funcao, $id_editar);
            }
            
            if ($stmt->execute()) {
                $mensagem = "success|Usuário atualizado com sucesso!";
            } else {
                $mensagem = "error|Erro ao atualizar usuário: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensagem = "error|Preencha todos os campos obrigatórios!";
        }
    }
}

$sql = "SELECT id_usuario, nome_usuario, email_usuario, telefone_usuario, funcao_usuario FROM usuario ORDER BY nome_usuario";
$result = $conn->query($sql);
?>

<?php include "header.php"; ?>
    
    <main>
        <div class="paginaFuncionarios">
            <h1>
                <i class="bi bi-people-fill"></i> Gerenciar Funcionários
            </h1>

            <?php 
            if ($mensagem): 
                list($tipo, $texto) = explode('|', $mensagem, 2);
            ?>
                <div class="mensagem-alerta <?php echo $tipo; ?>">
                    <?php echo $texto; ?>
                </div>
            <?php endif; ?>

            <div class="blocoFuncionarios">
                <div class="cabecalhoFuncionarios">
                    <h2>Lista de Funcionários</h2>
                    <span class="totalFuncionarios">Total: <?php echo $result->num_rows; ?> funcionário(s)</span>
                </div>

                <?php if ($result->num_rows > 0): ?>
                    <div class="tabelaFuncionarios">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Função</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nome_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($row['telefone_usuario'] ?? 'Não informado'); ?></td>
                                    <td>
                                        <span class="funcao-badge <?php echo $row['funcao_usuario'] === 'administrador' ? 'admin' : 'normal'; ?>">
                                            <?php echo htmlspecialchars($row['funcao_usuario']); ?>
                                        </span>
                                    </td>
                                    <td class="acoes">
                                        <button class="btn-editar" title="Editar" onclick="abrirModalEditar(<?php echo $row['id_usuario']; ?>, '<?php echo htmlspecialchars($row['nome_usuario']); ?>', '<?php echo htmlspecialchars($row['email_usuario']); ?>', '<?php echo htmlspecialchars($row['telefone_usuario'] ?? ''); ?>', '<?php echo htmlspecialchars($row['funcao_usuario']); ?>')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <?php if ($row['id_usuario'] != $_SESSION['id_usuario']): ?>
                                            <a href="funcionarios.php?excluir=<?php echo $row['id_usuario']; ?>" class="btn-excluir" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir o usuário <?php echo htmlspecialchars($row['nome_usuario']); ?>?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="btn-excluir disabled" title="Não é possível excluir sua própria conta">
                                                <i class="bi bi-trash"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="sem-funcionarios">
                        <i class="bi bi-people"></i>
                        <p>Nenhum funcionário cadastrado.</p>
                    </div>
                <?php endif; ?>

                <div class="botoes-acao">
                    <button class="btn-adicionar" onclick="abrirModalAdicionar()">
                        <i class="bi bi-person-plus"></i> Adicionar Funcionário
                    </button>
                </div>
            </div>
        </div>
    </main>

    <div id="modalAdicionar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="bi bi-person-plus"></i> Adicionar Funcionário</h2>
                <span class="close" onclick="fecharModal('modalAdicionar')">&times;</span>
            </div>
            <form method="post" class="modal-form">
                <div class="inputGroup">
                    <label for="nome_usuario">Nome:</label>
                    <input type="text" id="nome_usuario" name="nome_usuario" required>
                </div>

                <div class="inputGroup">
                    <label for="email_usuario">Email:</label>
                    <input type="email" id="email_usuario" name="email_usuario" required>
                </div>

                <div class="inputGroup">
                    <label for="senha_usuario">Senha:</label>
                    <input type="password" id="senha_usuario" name="senha_usuario" required>
                </div>

                <div class="inputGroup">
                    <label for="telefone_usuario">Telefone:</label>
                    <input type="text" id="telefone_usuario" name="telefone_usuario">
                </div>

                <div class="inputGroup">
                    <label for="funcao_usuario">Função:</label>
                    <select id="funcao_usuario" name="funcao_usuario" required>
                        <option value="normal">Usuário Normal</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>

                <div class="modal-botoes">
                    <button type="submit" name="adicionar" class="btn-salvar">
                        <i class="bi bi-person-plus"></i> Cadastrar
                    </button>
                    <button type="button" class="btn-cancelar" onclick="fecharModal('modalAdicionar')">
                        <i class="bi bi-x-lg"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="bi bi-pencil-square"></i> Editar Funcionário</h2>
                <span class="close" onclick="fecharModal('modalEditar')">&times;</span>
            </div>
            <form method="post" class="modal-form">
                <input type="hidden" id="editar_id_usuario" name="id_usuario">
                
                <div class="inputGroup">
                    <label for="editar_nome_usuario">Nome:</label>
                    <input type="text" id="editar_nome_usuario" name="nome_usuario" required>
                </div>

                <div class="inputGroup">
                    <label for="editar_email_usuario">Email:</label>
                    <input type="email" id="editar_email_usuario" name="email_usuario" required>
                </div>

                <div class="inputGroup">
                    <label for="editar_telefone_usuario">Telefone:</label>
                    <input type="text" id="editar_telefone_usuario" name="telefone_usuario">
                </div>

                <div class="inputGroup">
                    <label for="editar_funcao_usuario">Função:</label>
                    <select id="editar_funcao_usuario" name="funcao_usuario" required>
                        <option value="normal">Usuário Normal</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>

                <div class="inputGroup">
                    <label for="editar_nova_senha">Nova Senha (deixe em branco para manter a atual):</label>
                    <input type="password" id="editar_nova_senha" name="nova_senha" placeholder="Digite uma nova senha">
                </div>

                <div class="modal-botoes">
                    <button type="submit" name="editar" class="btn-salvar">
                        <i class="bi bi-check-lg"></i> Salvar Alterações
                    </button>
                    <button type="button" class="btn-cancelar" onclick="fecharModal('modalEditar')">
                        <i class="bi bi-x-lg"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Funções para os modais
        function abrirModalAdicionar() {
            document.getElementById('modalAdicionar').style.display = 'block';
        }

        function abrirModalEditar(id, nome, email, telefone, funcao) {
            document.getElementById('editar_id_usuario').value = id;
            document.getElementById('editar_nome_usuario').value = nome;
            document.getElementById('editar_email_usuario').value = email;
            document.getElementById('editar_telefone_usuario').value = telefone;
            document.getElementById('editar_funcao_usuario').value = funcao;
            document.getElementById('modalEditar').style.display = 'block';
        }

        function fecharModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        window.onclick = function(event) {
            const modals = document.getElementsByClassName('modal');
            for (let modal of modals) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>