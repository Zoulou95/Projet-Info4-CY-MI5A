// darkMode.js : display dark mode using only cookies

document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('darkModeToggle');

    // Determines whether dark mode is active, by reading the DOM
    const isDarkMode = document.body.classList.contains('dark-mode');

    // If enabled is true, set button text to light mode. If false, set it to dark mode
    toggleButton.textContent = isDarkMode ? '☀️ Mode Clair' : '🌙 Mode Sombre';
    // true = Mode Clair
    // false = Mode Sombre

    toggleButton.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
        const enabled = document.body.classList.contains('dark-mode');

        toggleButton.textContent = enabled ? '☀️ Mode Clair' : '🌙 Mode Sombre';


        // Update cookie
        document.cookie = "dark-mode=" + enabled + "; path=/; max-age=31536000";
    });
});