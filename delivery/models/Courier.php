<?php
class Courier {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM couriers ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM couriers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getFree() {
        $stmt = $this->pdo->query("SELECT * FROM couriers WHERE status = 'свободен'");
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO couriers (full_name, transport, status, schedule) VALUES (?, ?, 'свободен', ?)");
        return $stmt->execute([$data['full_name'], $data['transport'], $data['schedule']]);
    }
    
    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE couriers SET full_name = ?, transport = ?, status = ?, schedule = ? WHERE id = ?");
        return $stmt->execute([$data['full_name'], $data['transport'], $data['status'], $data['schedule'], $id]);
    }
    
    public function updateStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE couriers SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
    
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM couriers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}