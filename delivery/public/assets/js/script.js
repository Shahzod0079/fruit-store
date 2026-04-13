function toggleTheme() {
    let body = document.body;
    body.classList.toggle('dark-theme');
    let icon = document.getElementById('themeIcon');
    if (body.classList.contains('dark-theme')) {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
        localStorage.setItem('theme', 'dark');
    } else {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
        localStorage.setItem('theme', 'light');
    }
}

if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-theme');
    document.getElementById('themeIcon').classList.remove('fa-moon');
    document.getElementById('themeIcon').classList.add('fa-sun');
}