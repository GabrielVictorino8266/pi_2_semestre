const hamburger = document.getElementById("hamburger");
const navbar = document.getElementById("navbar");

// Adicionar evento de clique para abrir/fechar o menu
hamburger.addEventListener("click", () => {
    navbar.classList.toggle("open");
});

document.querySelector('.dropdown-btn').addEventListener('click', function() {
    const dropdownContent = document.querySelector('.dropdown-content');
    dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
  });