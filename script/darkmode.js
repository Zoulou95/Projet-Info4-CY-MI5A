document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('darkModeToggle');

    if (localStorage.getItem('dark-mode') === 'true') {
        document.body.classList.add('dark-mode');
        toggleButton.textContent = '☀️ Mode Clair';
    }

    toggleButton.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
        const isDarkMode = document.body.classList.contains('dark-mode');

     
        toggleButton.textContent = isDarkMode ? '☀️ Mode Clair' : '🌙 Mode Sombre';

    
        localStorage.setItem('dark-mode', isDarkMode);
    });
});