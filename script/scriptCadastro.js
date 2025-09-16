const validarForm = () => {
    try {
        let nome_usuario = document.forms["formcadastro"].nome_usuario.value;
        if (nome_usuario.length < 5 || nome_usuario.length > 64) {
            throw "O nome deve ter entre 5 e 64 caracteres.";
        }

        let email_usuario = document.forms["formcadastro"].email_usuario.value;
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email_usuario)) {
            throw "O email deve ser preenchido corretamente.";
        }

        let senha_usuario = document.forms["formcadastro"].senha_usuario.value;
        let confirmar_senha = document.forms["formcadastro"].confirmar_senha.value;
        if (senha_usuario.length < 6) {
            throw "A senha deve ter pelo menos 6 caracteres.";
        }
        if (senha_usuario !== confirmar_senha) {
            throw "A senha e a confirmação de senha devem ser iguais.";
        }

        alert("Cadastro realizado com sucesso!");
        document.getElementById("formcadastro").submit();
    } catch (e) {
        alert(`ERRO: ${e}`);
    }
}
