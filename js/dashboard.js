// Selecionando o botão e a navbar
const hamburgerButton = document.getElementById('hamburgerButton');
const navbarMenu = document.getElementById('navbarNav');

// Detecta se o menu foi aberto ou fechado e ajusta a visibilidade do botão
navbarMenu.addEventListener('show.bs.collapse', () => {
    hamburgerButton.style.display = 'none'; // Esconde o botão quando o menu é aberto
});

navbarMenu.addEventListener('hidden.bs.collapse', () => {
    hamburgerButton.style.display = 'block'; // Mostra o botão quando o menu é fechado
});

// Fecha o menu ao clicar fora dele e exibe o botão hambúrguer
document.addEventListener('click', (event) => {
    if (!navbarMenu.contains(event.target) && !hamburgerButton.contains(event.target)) {
        const navbarCollapse = new bootstrap.Collapse(navbarMenu, { toggle: false });
        navbarCollapse.hide(); // Fecha o menu ao clicar fora
        hamburgerButton.style.display = 'block'; // Exibe o botão hambúrguer
    }
});

