
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('menu-toggle');
    const nav = document.getElementById('main-nav');

    if (!toggleBtn || !nav) {
        return;
    }

    toggleBtn.addEventListener('click', () => {
        const isHidden = nav.classList.contains('hidden');
        nav.classList.toggle('hidden');
        toggleBtn.setAttribute('aria-expanded', String(isHidden));
    });
});