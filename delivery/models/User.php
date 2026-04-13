<?php
class User {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findByLogin($login) {
        $stmt = $this->pdo->prepare("SELECT * FROM employees WHERE login = ?");
        $stmt->execute([$login]);
        return $stmt->fetch();
    }
    
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}