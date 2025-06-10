function validarForm() {
    try {
        let nome = document.forms["formcadastro"].nome.value;
        if (nome.length < 5 || nome.length > 64) {
            throw "O nome deve ter entre 5 e 64 caracteres.";
        }

        let email = document.forms["formcadastro"].email.value;
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            throw "O email deve ser preenchido corretamente.";
        }

        let senha = document.forms["formcadastro"].senha.value;
        let confirmarSenha = document.forms["formcadastro"].confirmarsenha.value;
        if (senha.length < 6) {
            throw "A senha deve ter pelo menos 6 caracteres.";
        }
        if (senha !== confirmarSenha) {
            throw "A senha e a confirmação de senha devem ser iguais.";
        }

        alert("Cadastro realizado com sucesso!");
        document.getElementById("formcadastro").submit();
    } catch (e) {
        alert(`ERRO: ${e}`);
    }
}
