<?php
    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }

    echo "<!-- DEBUG: Função do usuário: " . ($_SESSION['funcao_usuario'] ?? 'não definida') . " -->";
    include "header.php";
?>

<section class="mapaAlterado">
    <br>
    <img src="../assets/img/mapaSA.png" alt="Mapa">

    <div class="tooltip-container btn-s1">
        <button class="btn-mapa">S1</button>
        <span class="tooltip-text" id="sensor-s1">
            Carregando...
        </span>
    </div>
    <div class="tooltip-container btn-s1">
        <button class="btn-mapa">S1</button>
        <span class="tooltip-text" id="sensor-s2">
            Carregando...
        </span>
    </div>
    <div class="tooltip-container btn-s2">
        <button class="btn-mapa">S2</button>
        <span class="tooltip-text" id="sensor2-s2">
            Carregando...
        </span>
    </div>
    <div class="tooltip-container btn-s3">
        <button class="btn-mapa">S3</button>
        <span class="tooltip-text" id="sensor-s3">
            Carregando...
        </span>
    </div>

</section>

<script>
        let allMessages = [];

        function fetchMessages() {
            fetch('get_messages.php?t=' + new Date().getTime())
                .then(r => r.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }
                    if (data.length > 0) {
                        data.forEach(m => {
                            const key = m.time + m.msg;
                            if (!allMessages.includes(key)) {
                                allMessages.push(key);
                                const div = document.createElement('div');
                                div.className = 'msg';
                                div.textContent = `[${m.time}] ${m.topic}: ${m.msg}`;
                                document.getElementById('messages').appendChild(div);
                            }
                        });
                    }
                })
                .catch(e => console.error(e));
        }

        // Polling a cada 1 segundo
        setInterval(fetchMessages, 1000);
        fetchMessages();
    </script>


</body>
</html>