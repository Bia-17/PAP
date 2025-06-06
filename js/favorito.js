function toggleFavorito(button) {
    const container = button.parentElement;

    const btn1 = container.querySelector('.btn1');
    const btn2 = container.querySelector('.btn2');

    if (button.classList.contains('btn1')) {
        btn1.style.display = 'none';
        btn2.style.display = 'inline-block';
    } else {
        btn2.style.display = 'none';
        btn1.style.display = 'inline-block';
    }
}