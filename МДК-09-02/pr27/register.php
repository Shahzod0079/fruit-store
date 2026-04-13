<?php
require_once "includes/connection.php";
include "includes/header.php";
include "includes/reg.php";

if (!empty($message)) {
    echo "<div class='error'><span onclick='ignore()'>x</span>" . $message . "</div>";
    echo "<script>
    function ignore () { document.querySelector('.error').style.display = 'none'; }
    </script>";
}
?>
<div class="container">
    <div id="login">
        <h1>Регистрация</h1>
        <form action="register.php" id="registerform" method="post" name="registerform">
            <label for="user_login">Полное имя
                <input id="full_name" name="full_name" size="32" type="text" value="">
            </label>
            <label for="user_pass">E-mail
                <input id="email" name="email" size="32" type="email" value="">
            </label>
            <label for="user_pass">Имя пользователя
                <input id="username" name="username" size="20" type="text" value="">
            </label>
            <label for="user_pass">Пароль
                <input id="password" name="password" size="32" type="password" value="">
            </label>
            <input id="register" name="register" type="submit" value="Зарегистрироваться">
            <p>Уже зарегистрированы? <a href="login.php">Введите имя пользователя</a></p>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>