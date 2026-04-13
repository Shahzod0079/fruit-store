<?php
session_start(); 

require_once "includes/connection.php";
require_once "includes/auth.php";


if(!empty($message)){
    echo "<div class='error'><span onclick='ignore()'>x</span>".$message."</div>
    <script>
    function ignore () {document.querySelector('.error').style.display = 'none'; }
    </script>";
}
include "includes/header.php";
?>

<div class="container">
    <div id="login">
        <h1>Вход</h1>
        
        <?php if (!empty($message)): ?>
            <div class='error'><span onclick='ignore()'>x</span><?php echo $message; ?></div>
            <script>
            function ignore() { document.querySelector('.error').style.display = 'none'; }
            </script>
        <?php endif; ?>
        
        <form action="login.php" id="loginform" method="post" name="loginform">
            <label for="user_login">Имя пользователя 
                <input id="username" name="username" size="20" type="text" value="">
            </label>
            <label for="user_pass">Пароль 
                <input id="password" name="password" size="20" type="password" value="">
            </label>
            <input name="login" type="submit" value="Log In">
            <p>Еще не зарегистрированы? <a href="register.php">Регистрация</a>!</p>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>