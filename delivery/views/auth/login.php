<?php 
$title = 'Авторизация';
ob_start();
?>
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-lg border-0">
            <div class="card-header text-center bg-primary text-white py-4">
                <i class="fas fa-truck fa-3x mb-2"></i>
                <h3 class="mb-0">Служба доставки</h3>
                <small>Вход в систему</small>
            </div>
            <div class="card-body p-4">
                <form action="/delivery/public/index.php?route=auth/authenticate" method="POST">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user me-2"></i>Логин</label>
                        <input type="text" name="login" class="form-control form-control-lg" placeholder="Логин" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-lock me-2"></i>Пароль</label>
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Пароль" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Войти
                    </button>
                </form>
                <hr class="my-4">
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>