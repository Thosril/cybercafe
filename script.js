const mobileMenu = document.getElementById('mobile-menu');
const navList = document.getElementById('nav-list');

mobileMenu.addEventListener('click', () => {
    navList.classList.toggle('active'); // Ajoute ou retire la classe active
});
