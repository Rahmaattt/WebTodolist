function initNavbarAdjustment() {
  const adjustNavbar = () => {
    const content = document.getElementById('navbarContent');
    const toggler = document.querySelector('.navbar-toggler');
    if (!content || !toggler) return;

    if (window.innerWidth >= 576) {
      content.classList.add('show');
      toggler.style.display = 'none';
    } else {
      content.classList.remove('show');
      toggler.style.display = '';
    }
  };

  window.addEventListener('load', adjustNavbar);
  window.addEventListener('resize', adjustNavbar);
}
    
document.addEventListener("DOMContentLoaded", function () {
  initNavbarAdjustment();
});