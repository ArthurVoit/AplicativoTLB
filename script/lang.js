window.onload = async function alterarLinguagem() {
    let currentLang = localStorage.getItem('lang') || 'pt';

    async function loadLanguage(lang) {
    const response = await fetch('lang.json');
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