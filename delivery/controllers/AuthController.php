<?php
require_once __DIR__ . '/../models/User.php';


if (isset($_SESSION['success'])) {
    echo "<div style='color:green; padding:10px; background:#e0ffe0; margin-bottom:10px'>✅ " . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}

class AuthController {
    private $pdo;
    private $user;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->user = new User($pdo);
    }
    
    public function login() {
        require_once __DIR__ . '/../views/auth/login.php';
    }
    
public function authenticate() {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $user = $this->user->findByLogin($login);
    
    if (!$user) {
        $_SESSION['error'] = "Пользователь не найден: $login";
        header('Location: /delivery/public/index.php?route=auth/login');
        return;
    }
    
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Неверный пароль";
        header('Location: /delivery/public/index.php?route=auth/login');
        return;
    }
    
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['full_name'],
        'role' => $user['role']
    ];
    
    if ($user['role'] == 'admin') {
        header('Location: /delivery/public/index.php?route=admin/dashboard');
    } elseif ($user['role'] == 'dispatcher') {
        header('Location: /delivery/public/index.php?route=dispatcher/dashboard');
    } elseif ($user['role'] == 'courier') {
        header('Location: /delivery/public/index.php?route=courier/dashboard');
    } else {
        header('Location: /delivery/public/index.php?route=auth/login');
    }
} 
    public function logout() {
        session_destroy();
        header('Location: /delivery/public/index.php?route=auth/login');
    }
}