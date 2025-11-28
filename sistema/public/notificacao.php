<?php
    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }

    $id_usuario = $_SESSION['id_usuario'];
    $mensagem = "";

    if (isset($_POST['limpar_todas'])) {
        $sql_delete_all = "DELETE FROM alerta WHERE fk_usuario = ?";
        $stmt_delete_all = $conn->prepare($sql_delete_all);
        $stmt_delete_all->bind_param("i", $id_usuario);
        
        if ($stmt_delete_all->execute()) {
            $mensagem = "Todas as notificações foram removidas!";
            $notificacoes = [];
        } else {
            $mensagem = "Erro ao limpar notificações!";
        }
        $stmt_delete_all->close();
    }

    $sql = "SELECT a.id_alerta, a.tipo_alerta, a.mensagem_alerta, a.prioridade_alerta, a.data_hora 
            FROM alerta a 
            WHERE a.fk_usuario = ? 
            ORDER BY a.data_hora DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $notificacoes = [];
    while ($row = $result->fetch_assoc()) {
        $notificacoes[] = $row;
    }
    $stmt->close();
?>
<?php include "header.php"; ?>
    <main>
        <div class="paginaNotificacoes">
            <h1>
                <i class="bi bi-bell-fill"></i> Notificações
            </h1>

            <?php if ($mensagem): ?>
                <div class="mensagem-alerta success">
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($notificacoes)): ?>
                <div class="notificacoes-actions" style="margin-bottom: 20px; text-align: right;">
                    <form method="POST" id="formLimparTodas">
                        <input type="hidden" name="limpar_todas" value="1">
                        <button type="submit" class="btn-limpar-todas">
                            <i class="bi bi-trash"></i> Limpar Todas
                        </button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if (empty($notificacoes)): ?>
                <div class="sem-notificacoes">
                    <i class="bi bi-bell-slash"></i>
                    <p>Nenhuma notificação no momento</p>
                </div>
            <?php else: ?>
                <div class="lista-notificacoes">
                    <?php foreach ($notificacoes as $notificacao): ?>
                        <div class="notificacao-item <?php echo $notificacao['prioridade_alerta']; ?>" 
                             data-id="<?php echo $notificacao['id_alerta']; ?>">
                            <div class="notificacao-icon">
                                <?php 
                                $icon = '';
                                switch($notificacao['tipo_alerta']) {
                                    case 'Manutenção':
                                        $icon = 'bi-tools';
                                        break;
                                    case 'Atraso':
                                        $icon = 'bi-clock';
                                        break;
                                    case 'Segurança':
                                        $icon = 'bi-shield-exclamation';
                                        break;
                                    case 'Combustível':
                                        $icon = 'bi-fuel-pump';
                                        break;
                                    default:
                                        $icon = 'bi-info-circle';
                                }
                                ?>
                                <i class="bi <?php echo $icon; ?>"></i>
                            </div>
                            <div class="notificacao-content">
                                <div class="notificacao-header">
                                    <span class="notificacao-tipo"><?php echo htmlspecialchars($notificacao['tipo_alerta']); ?></span>
                                    <span class="notificacao-prioridade <?php echo $notificacao['prioridade_alerta']; ?>">
                                        <?php echo htmlspecialchars($notificacao['prioridade_alerta']); ?>
                                    </span>
                                </div>
                                <p class="notificacao-mensagem"><?php echo htmlspecialchars($notificacao['mensagem_alerta']); ?></p>
                                <span class="notificacao-tempo">
                                    <?php 
                                    $data = new DateTime($notificacao['data_hora']);
                                    echo $data->format('d/m/Y H:i');
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
        document.getElementById('formLimparTodas').addEventListener('submit', function(e) {
            if (!confirm('Tem certeza que deseja limpar todas as notificações?')) {
                e.preventDefault();
            }
        });
    </script>

</body>
</html>