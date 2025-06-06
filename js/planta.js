document.addEventListener('DOMContentLoaded', () => {
    const botoesTamanho = document.querySelectorAll('.opcao');
    const quantidaden = document.querySelector('.quantidade');
    const botaoDiminuir = document.querySelector('.diminuir');
    const botaoAumentar = document.querySelector('.aumentar');

    botoesTamanho.forEach(botao => {
        botao.addEventListener('click', () => {
            botoesTamanho.forEach(btn => btn.classList.remove('selecionado'));
            botao.classList.add('selecionado');
        });
    });

    botaoDiminuir.addEventListener('click', () => {
        let quantidade = parseInt(quantidaden.textContent);
        if (quantidade > 0) {
            quantidade--;
            quantidaden.textContent = quantidade;
        }
    });

    botaoAumentar.addEventListener('click', () => {
        let quantidade = parseInt(quantidaden.textContent);
        quantidade++;
        quantidaden.textContent = quantidade;
    });
});