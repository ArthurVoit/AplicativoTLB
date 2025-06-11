function alternarNotificacoes(topicoEl) {
  const notificacoes = topicoEl.nextElementSibling;
  const seta = topicoEl.querySelector('.seta');

  const ativo = notificacoes.style.display === 'block';

  notificacoes.style.display = ativo ? 'none' : 'block';
  seta.classList.toggle('ativa');
}
