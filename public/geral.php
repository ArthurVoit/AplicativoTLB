<?php
    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }
?>
<?php include "header.php"; ?>
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
            <br>
            <br>
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