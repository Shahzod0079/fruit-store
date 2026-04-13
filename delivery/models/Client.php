<?php
class Client {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM clients ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO clients (full_name, phone, email, address) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['full_name'], $data['phone'], $data['email'], $data['address']]);
    }
    
    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE clients SET full_name = ?, phone = ?, email = ?, address = ? WHERE id = ?");
        return $stmt->execute([$data['full_name'], $data['phone'], $data['email'], $data['address'], $id]);
    }
    
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM clients WHERE id = ?");
        return $stmt->execute([$id]);
    }
}