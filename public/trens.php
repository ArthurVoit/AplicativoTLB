<?php
include "../db.php";
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$mensagem = "";

if (isset($_GET['excluir'])) {
    $id_excluir = $_GET['excluir'];
    
    $stmt = $conn->prepare("DELETE FROM trem WHERE id_trem = ?");
    $stmt->bind_param("i", $id_excluir);
    
    if ($stmt->execute()) {
        $mensagem = "success|Trem excluído com sucesso!";
    } else {
        $mensagem = "error|Erro ao excluir trem: " . $stmt->error;
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_editar = $_POST['id_trem'] ?? 0;
    $modelo = $_POST['modelo_trem'] ?? "";
    $status = $_POST['status_operacional_trem'] ?? "";
    $localizacao = $_POST['localizacao_atual_trem'] ?? "";
    
    if (isset($_POST['adicionar'])) {
        if ($modelo && $status && $localizacao) {
            $stmt = $conn->prepare("INSERT INTO trem (modelo_trem, status_operacional_trem, localizacao_atual_trem) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $modelo, $status, $localizacao);
            
            if ($stmt->execute()) {
                $mensagem = "success|Trem cadastrado com sucesso!";
            } else {
                $mensagem = "error|Erro ao cadastrar trem: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensagem = "error|Preencha todos os campos obrigatórios!";
        }
    }
    
    if (isset($_POST['editar'])) {
        if ($modelo && $status && $localizacao) {
            $stmt = $conn->prepare("UPDATE trem SET modelo_trem = ?, status_operacional_trem = ?, localizacao_atual_trem = ? WHERE id_trem = ?");
            $stmt->bind_param("sssi", $modelo, $status, $localizacao, $id_editar);
            
            if ($stmt->execute()) {
                $mensagem = "success|Trem atualizado com sucesso!";
            } else {
                $mensagem = "error|Erro ao atualizar trem: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensagem = "error|Preencha todos os campos obrigatórios!";
        }
    }
}

$sql = "SELECT id_trem, modelo_trem, status_operacional_trem, localizacao_atual_trem FROM trem ORDER BY id_trem";
$result = $conn->query($sql);
?>

<?php include "header.php"; ?>

<main>
    <div id="trem3D"></div>
    
    <div class="paginaFuncionarios" style="margin-top: 40px;">
        <h1>
            <i class="bi bi-train-front"></i> Gerenciar Trens
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
                <h2>Lista de Trens</h2>
                <span class="totalFuncionarios">Total: <?php echo $result->num_rows; ?> trem(ns)</span>
            </div>

            <?php if ($result->num_rows > 0): ?>
                <div class="tabelaFuncionarios">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Modelo</th>
                                <th>Status</th>
                                <th>Localização Atual</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_trem']); ?></td>
                                <td><?php echo htmlspecialchars($row['modelo_trem']); ?></td>
                                <td>
                                    <span class="funcao-badge <?php echo $row['status_operacional_trem'] === 'Operacional' ? 'admin' : 'normal'; ?>">
                                        <?php echo htmlspecialchars($row['status_operacional_trem']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['localizacao_atual_trem']); ?></td>
                                <td class="acoes">
                                    <button class="btn-editar" title="Editar" onclick="abrirModalEditar(<?php echo $row['id_trem']; ?>, '<?php echo htmlspecialchars($row['modelo_trem']); ?>', '<?php echo htmlspecialchars($row['status_operacional_trem']); ?>', '<?php echo htmlspecialchars($row['localizacao_atual_trem']); ?>')">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <a href="trens.php?excluir=<?php echo $row['id_trem']; ?>" class="btn-excluir" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir o trem <?php echo htmlspecialchars($row['modelo_trem']); ?>?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="sem-funcionarios">
                    <i class="bi bi-train"></i>
                    <p>Nenhum trem cadastrado.</p>
                </div>
            <?php endif; ?>

            <div class="botoes-acao">
                <button class="btn-adicionar" onclick="abrirModalAdicionar()">
                    <i class="bi bi-plus-circle"></i> Adicionar Trem
                </button>
            </div>
        </div>
    </div>
</main>

<div id="modalAdicionar" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="bi bi-plus-circle"></i> Adicionar Trem</h2>
            <span class="close" onclick="fecharModal('modalAdicionar')">&times;</span>
        </div>
        <form method="post" class="modal-form">
            <div class="inputGroup">
                <label for="modelo_trem">Modelo do Trem:</label>
                <input type="text" id="modelo_trem" name="modelo_trem" required>
            </div>

            <div class="inputGroup">
                <label for="status_operacional_trem">Status Operacional:</label>
                <select id="status_operacional_trem" name="status_operacional_trem" required>
                    <option value="Operacional">Operacional</option>
                    <option value="Manutenção">Manutenção</option>
                    <option value="Fora de Serviço">Fora de Serviço</option>
                    <option value="Em Trânsito">Em Trânsito</option>
                </select>
            </div>

            <div class="inputGroup">
                <label for="localizacao_atual_trem">Localização Atual:</label>
                <input type="text" id="localizacao_atual_trem" name="localizacao_atual_trem" required>
            </div>

            <div class="modal-botoes">
                <button type="submit" name="adicionar" class="btn-salvar">
                    <i class="bi bi-plus-circle"></i> Cadastrar Trem
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
            <h2><i class="bi bi-pencil-square"></i> Editar Trem</h2>
            <span class="close" onclick="fecharModal('modalEditar')">&times;</span>
        </div>
        <form method="post" class="modal-form">
            <input type="hidden" id="editar_id_trem" name="id_trem">
            
            <div class="inputGroup">
                <label for="editar_modelo_trem">Modelo do Trem:</label>
                <input type="text" id="editar_modelo_trem" name="modelo_trem" required>
            </div>

            <div class="inputGroup">
                <label for="editar_status_operacional_trem">Status Operacional:</label>
                <select id="editar_status_operacional_trem" name="status_operacional_trem" required>
                    <option value="Operacional">Operacional</option>
                    <option value="Manutenção">Manutenção</option>
                    <option value="Fora de Serviço">Fora de Serviço</option>
                    <option value="Em Trânsito">Em Trânsito</option>
                </select>
            </div>

            <div class="inputGroup">
                <label for="editar_localizacao_atual_trem">Localização Atual:</label>
                <input type="text" id="editar_localizacao_atual_trem" name="localizacao_atual_trem" required>
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

<script type="importmap">
    {
        "imports": {
            "three": "https://cdn.jsdelivr.net/npm/three@0.177.0/build/three.module.js",
            "jsm/": "https://cdn.jsdelivr.net/npm/three@0.177.0/examples/jsm/"
        }
    }
</script>
<script type="module" src="../script/loadModel-final.js"></script>

<script>
    function abrirModalAdicionar() {
        document.getElementById('modalAdicionar').style.display = 'block';
    }

    function abrirModalEditar(id, modelo, status, localizacao) {
        document.getElementById('editar_id_trem').value = id;
        document.getElementById('editar_modelo_trem').value = modelo;
        document.getElementById('editar_status_operacional_trem').value = status;
        document.getElementById('editar_localizacao_atual_trem').value = localizacao;
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