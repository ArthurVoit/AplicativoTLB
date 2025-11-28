document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formcadastro');
    const senhaInput = document.getElementById('nova_senha');
    const confirmarSenhaInput = document.getElementById('confirmar_senha');
    const cepInput = document.getElementById('CEP');
    const emailInput = document.getElementById('novo_email');
    const telefoneInput = document.getElementById('telefone');

    cepInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 8) {
            value = value.slice(0, 8);
        }
        e.target.value = value;
    });

    telefoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length <= 11) {
            if (value.length <= 2) {
                value = value.replace(/^(\d{0,2})/, '($1');
            } else if (value.length <= 6) {
                value = value.replace(/^(\d{2})(\d{0,4})/, '($1) $2');
            } else if (value.length <= 10) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else {
                value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            }
        } else {
            value = value.slice(0, 11);
            value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        }
        
        e.target.value = value;
    });

    form.addEventListener('submit', function(e) {
        const senha = senhaInput.value;
        const confirmarSenha = confirmarSenhaInput.value;
        const email = emailInput.value;
        const telefone = telefoneInput.value.replace(/\D/g, '');
        
        if (!email.endsWith('@tlb.com')) {
            alert('Por favor, use um email empresarial @tlb.com!');
            e.preventDefault();
            return false;
        }
        
        if (telefone.length < 10 || telefone.length > 11) {
            alert('Telefone deve ter 10 ou 11 dígitos!');
            e.preventDefault();
            return false;
        }
        
        if (senha.length < 5) {
            alert('A senha deve ter pelo menos 5 caracteres!');
            e.preventDefault();
            return false;
        }
        
        if (!/[!@#$%^&*(),.?":{}|<>]/.test(senha)) {
            alert('A senha deve conter pelo menos um caractere especial!');
            e.preventDefault();
            return false;
        }
        
        if (senha !== confirmarSenha) {
            alert('As senhas não coincidem!');
            e.preventDefault();
            return false;
        }
        
        if (cepInput.value.length !== 8) {
            alert('CEP deve ter 8 dígitos!');
            e.preventDefault();
            return false;
        }
    });
});