<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../script/navBar.js"></script>
    <script src="../script/lang.js"></script>
</head>
<body>
    <header>
        <div class="navbar">
        <div class="btnNavBar"><a href="notificacao.html"><img src="../assets/icons/bell.svg" alt=""></a></div>
        <h1>Dados do Usuário</h1>
        <button class="nav-button" onclick="alternarMenu()"> ≡</button>
        <div class="menu" id="menu">
            <button class="close-button" onclick="alternarMenu()">X</button>
            <a href="mapa.html">Mapa</a>
            <a href="dadosDoUsuario.html">Dados do Usuário</a>
            <a href="relatorios.html">Relatórios</a>
            <a href="consumodeEnergia.html">Consumo de Energia</a>
            <a href="monitoramentoManutencao.html">Monitoramento e Manutenção</a>
            <a href="eficienciaOperacional.html">Eficiência Operacional</a>
        </div>
        </div>
    </header>
    <main>
        <div class="paginaGeral">
            <h1 id="title">
                <i class="bi bi-gear-fill"></i> Configurações Gerais
            </h1>


            <div class="blocoIdioma">
                <h2 id="languageSection">Idioma</h2>
                <button class="btnIdioma" id="languageButton">
                <i class="bi bi-translate"></i> Mudar idioma
                </button>
            </div>
        </div>

    </main>
    <script>
        window.onload = async function () {
            let currentLang = localStorage.getItem('lang') || 'pt';

            async function loadLanguage(lang) {
            const response = await fetch('../lang.json');
            const translations = await response.json();

            document.getElementById('title').textContent = translations[lang].title;
            document.getElementById('languageSection').textContent = translations[lang].languageSection;
            document.getElementById('languageButton').innerHTML = `<i class="bi bi-translate"></i> ${translations[lang].languageButton}`;
            }

            document.getElementById('languageButton').addEventListener('click', () => {
            currentLang = currentLang === 'pt' ? 'en' : 'pt';
            localStorage.setItem('lang', currentLang);
            loadLanguage(currentLang);
            });

            loadLanguage(currentLang);
        };
    </script>



</body>
</html>