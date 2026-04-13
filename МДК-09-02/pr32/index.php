<?php
include 'config.php';

// Получаем все услуги из БД
$result = $conn->query("SELECT * FROM services");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сервисный центр - Заявка на услугу</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>Сервисный центр</h1>
            <p>Оставьте заявку — мы решим вашу проблему</p>
        </div>
    </div>

    <div class="nav-menu">
        <div class="container">
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="login.php">Вход для админа</a></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <h2>Наши услуги</h2>
            <div class="services-grid">
                <?php while ($service = $result->fetch_assoc()): ?>
                <div class="service-card">
                    <h3><?= htmlspecialchars($service['title']) ?></h3>
                    <p><?= htmlspecialchars($service['description']) ?></p>
                    <div class="price"><?= number_format($service['price'], 0, '', ' ') ?> ₽</div>
                    <button class="btn order-btn" 
                            data-id="<?= $service['id'] ?>"
                            data-title="<?= htmlspecialchars($service['title']) ?>">
                         Заказать услугу
                    </button>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- Модальное окно для заявки -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Оформление заявки</h3>
            <form action="submit_request.php" method="POST">
                <input type="hidden" name="services_id" id="service_id">
                <div class="form-group">
                    <label>Услуга:</label>
                    <input type="text" id="service_title" readonly>
                </div>
                <div class="form-group">
                    <label>Ваше ФИО:</label>
                    <input type="text" name="fio" required>
                </div>
                <div class="form-group">
                    <label>Телефон:</label>
                    <input type="tel" name="phone" required>
                </div>
                <button type="submit" class="btn btn-success">Отправить заявку</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>© 2026 Сервисный центр. Все права защищены.</p>
        </div>
    </div>

    <script>
        // Модальное окно
        var modal = document.getElementById('modal');
        var btns = document.getElementsByClassName('order-btn');
        var span = document.getElementsByClassName('close')[0];

        for (var i = 0; i < btns.length; i++) {
            btns[i].onclick = function() {
                var id = this.getAttribute('data-id');
                var title = this.getAttribute('data-title');
                document.getElementById('service_id').value = id;
                document.getElementById('service_title').value = title;
                modal.style.display = 'block';
            }
        }

        span.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>