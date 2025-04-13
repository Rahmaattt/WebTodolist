export function initTema() {
    const themeButton = document.getElementById('Tema');
    let isDarkMode = localStorage.getItem('theme') === 'dark';
      function setTheme() {
        if (isDarkMode) {
          document.body.classList.add('bg-dark', 'text-white');
          themeButton.textContent = "Light Mode";
        } else {
          document.body.classList.remove('bg-dark', 'text-white');
          themeButton.textContent = "Dark Mode";  
        }
      }
      themeButton.addEventListener('click', function() {
        isDarkMode = !isDarkMode;
        localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        setTheme();
      });
      setTheme();
    }