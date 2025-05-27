const validarForm = () => {
    try {
        let tamanho_nome = document.forms["formcadastro"].nome.value.length;
        if (!/^['A-Za-zÀ-ÿ\s']$/.test(tamanho_nome)) {
            throw ("O nome deve ter entre 5 e 64 caracteres.");
        }

        let email = document.forms["formcadastro"].email.value;
        if (email.length < 5 || email.length > 128 || email.indexOf('@') == -1 || email.indexOf('.') == -1) {
            throw("O email deve ser preenchido corretamente.");
        }

        let senha = document.forms["formcadastro"].senha.value;
        let confirmarSenha = document.forms["formcadastro"].confirmarsenha.value;
        if (senha !== confirmarSenha) {
            throw("A senha e a confirmação de senha devem ser a mesma.");
        }
    } catch (e) {
        alert(`ERRO: ${e}`);
    }
}

document.querySelectorAll('.inputContainer input').forEach(input => {
    input.addEventListener('focus', function() {
        this.nextElementSibling.style.opacity = "0"; // Oculta o ícone ao clicar
    });

    input.addEventListener('blur', function() {
        if (this.value === "") {
            this.nextElementSibling.style.opacity = "1"; // Mostra o ícone se o campo estiver vazio
        }
    });
});