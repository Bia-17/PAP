const loginTab = document.getElementById('entrar-tab');
const registerTab = document.getElementById('registro-tab');
const container = document.querySelector('.container');
const loginForm = document.getElementById('entrar-form');
const registerForm = document.getElementById('registro-form');

loginTab.addEventListener('click', () => {
    loginTab.classList.add('ativa');
    registerTab.classList.remove('ativa');
    loginForm.classList.add('ativa');
    registerForm.classList.remove('ativa');

    container.style.maxHeight = '600px';
});

registerTab.addEventListener('click', () => {
    registerTab.classList.add('ativa');
    loginTab.classList.remove('ativa');
    registerForm.classList.add('ativa');
    loginForm.classList.remove('ativa');

    container.style.maxHeight = '900px'; 
});

async function handleLogin(){
    account.create0Auth2Session(
        'google',
        'http://localhost:5500/',
        'http://localhost:5500/fail'
    )
}