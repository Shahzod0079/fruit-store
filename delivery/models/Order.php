<?php
class Order {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAll() {
        $stmt = $this->pdo->query("SELECT o.*, c.full_name as client_name, cr.full_name as courier_name 
                                   FROM orders o 
                                   LEFT JOIN clients c ON o.client_id = c.id 
                                   LEFT JOIN couriers cr ON o.courier_id = cr.id 
                                   ORDER BY o.id DESC");
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO orders (client_id, from_address, to_address, weight, cost, status) 
                                     VALUES (?, ?, ?, ?, ?, 'новый')");
        return $stmt->execute([$data['client_id'], $data['from_address'], $data['to_address'], $data['weight'], $data['cost']]);
    }
    
    public function updateStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
    
    public function assignCourier($order_id, $courier_id) {
        $stmt = $this->pdo->prepare("UPDATE orders SET courier_id = ?, status = 'назначен' WHERE id = ?");
        return $stmt->execute([$courier_id, $order_id]);
    }
    
    public function getByCourier($courier_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE courier_id = ? ORDER BY id DESC");
        $stmt->execute([$courier_id]);
        return $stmt->fetchAll();
    }
}