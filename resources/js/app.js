import './bootstrap';

// Inicializa tema com base no localStorage ou preferência do sistema
(function initTheme() {
    const saved = localStorage.getItem('theme');
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = saved ? saved === 'dark' : prefersDark;

    document.documentElement.classList.toggle('dark', isDark);
    document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
})();

// Toggle ao clicar no botão
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('theme-toggle');
    if (!toggle) return;

    // Ajusta ícones conforme estado atual
    const isDark = document.documentElement.classList.contains('dark');
    const sun = toggle.querySelector('[data-icon="sun"]');
    const moon = toggle.querySelector('[data-icon="moon"]');
    if (sun && moon) {
        sun.classList.toggle('hidden', isDark);
        moon.classList.toggle('hidden', !isDark);
    }

    toggle.addEventListener('click', () => {
        const isDarkNow = document.documentElement.classList.contains('dark');
        const next = isDarkNow ? 'light' : 'dark';
        document.documentElement.classList.toggle('dark', next === 'dark');
        document.documentElement.style.colorScheme = next === 'dark' ? 'dark' : 'light';
        localStorage.setItem('theme', next);

        if (sun && moon) {
            sun.classList.toggle('hidden', next === 'dark');
            moon.classList.toggle('hidden', next === 'light');
        }
    });
});