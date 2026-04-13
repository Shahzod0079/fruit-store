<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Служба доставки - <?= $title ?? 'Панель управления' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/delivery/public/assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-truck me-2"></i>Служба доставки
            </a>
            <div class="navbar-nav ms-auto">
                <button onclick="toggleTheme()" class="btn btn-sm btn-outline-light me-2">
                    <i id="themeIcon" class="fas fa-moon"></i>
                </button>
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="nav-link text-white"><?= $_SESSION['user']['name'] ?></span>
                    <a class="nav-link text-white" href="/delivery/public/index.php?route=auth/logout">Выйти</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php foreach($_SESSION['errors'] as $error): ?>
                    <div><?= $error ?></div>
                <?php endforeach; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <?= $content ?>
    </div>

    <footer>
        <p>&copy; 2026 Служба доставки. Все права защищены.</p>
    </footer>

    <!-- <script src="/delivery/public/assets/js/script.js"></script> -->
    <script>
function toggleTheme() {
    document.body.classList.toggle('dark-theme');
    let icon = document.getElementById('themeIcon');
    if (document.body.classList.contains('dark-theme')) {
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
    let icon = document.getElementById('themeIcon');
    if(icon) {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
    }
}
</script>
</body>
</html>