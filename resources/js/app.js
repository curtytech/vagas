import './bootstrap';

(function () {
    const stored = localStorage.getItem('theme'); // 'dark' | 'light' | null
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (stored === 'dark' || (!stored && prefersDark)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();

document.getElementById('themeToggle').addEventListener('click', () => {
    const root = document.documentElement;
    const isDark = root.classList.toggle('dark');
    console.log(isDark)
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
    document.getElementById('themeToggleIconLight').classList.toggle('hidden', isDark);
    document.getElementById('themeToggleIconDark').classList.toggle('hidden', !isDark);
    console.log(localStorage.getItem('theme'))

});

module.exports = {
    darkMode: 'class', // recomendado para toggle manual
    // ou: darkMode: 'media', // detecta a preferência do sistema automaticamente
    content: ['./src/**/*.{js,jsx,ts,tsx,html}'],
    theme: { /* ... */ },
    plugins: [],
}