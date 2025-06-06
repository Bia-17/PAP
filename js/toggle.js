const barralado=document.querySelector(".barralado");
const barraladoToggler=document.querySelector(".barralado-toggler");

barraladoToggler.addEventListener("click", () => {
    barralado.classList.toggle("collapsed");
});

  document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('menuToggle');
    const sidebar = document.querySelector('.barralado');

    toggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
    });
  });
