<?php
class Employee {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Проверка, существует ли логин
    public function loginExists($login, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM employees WHERE login = ?";
        $params = [$login];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM employees ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM employees WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        // Проверяем уникальность логина
        if ($this->loginExists($data['login'])) {
            throw new Exception("Логин '{$data['login']}' уже существует");
        }
        
        $stmt = $this->pdo->prepare("INSERT INTO employees (full_name, position, login, password, role, courier_id) VALUES (?, ?, ?, ?, ?, ?)");
        $hash = password_hash('123456', PASSWORD_DEFAULT);
        $courier_id = ($data['role'] == 'courier') ? $data['courier_id'] : null;
        return $stmt->execute([$data['full_name'], $data['position'], $data['login'], $hash, $data['role'], $courier_id]);
    }
    
    public function update($id, $data) {
        // Проверяем уникальность логина (исключая текущего)
        if ($this->loginExists($data['login'], $id)) {
            throw new Exception("Логин '{$data['login']}' уже существует");
        }
        
        $stmt = $this->pdo->prepare("UPDATE employees SET full_name = ?, position = ?, login = ?, role = ?, courier_id = ? WHERE id = ?");
        $courier_id = ($data['role'] == 'courier') ? $data['courier_id'] : null;
        return $stmt->execute([$data['full_name'], $data['position'], $data['login'], $data['role'], $courier_id, $id]);
    }
    
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM employees WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    public function resetPassword($id) {
        $stmt = $this->pdo->prepare("UPDATE employees SET password = ? WHERE id = ?");
        $hash = password_hash('123456', PASSWORD_DEFAULT);
        return $stmt->execute([$hash, $id]);
    }
}