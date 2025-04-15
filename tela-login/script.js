function validarForm(){
    var tamanho_nome = document.forms["formcadastro"].nome.value.length;
    var email = document.forms["formcadastro"].email.value;
    var senha = document.forms["formcadastro"].senha.value;
    var confirmarSenha = document.forms["formcadastro"].confirmarsenha.value;
if(tamanho_nome < 5 || tamanho_nome > 64){
    alert("O nome deve ter entre 5 e 64 caracteres.");
    return false
}
if(email.length < 5 || email.length > 128 || email.indexOf('@') == -1 || email.indexOf('.') == -1){
    alert("O email deve ser preenchido corretamente.")
    return false;
}
if(senha !== confirmarSenha){
    alert("A senha e a confirmação de senha devem ser a mesma.")
    return false;
}
}

    
