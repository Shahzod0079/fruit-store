<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Courier.php';


if (isset($_SESSION['success'])) {
    echo "<div style='color:green; padding:10px; background:#e0ffe0; margin-bottom:10px'>✅ " . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}

class ExportController {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            header('Location: /delivery/public/index.php?route=auth/login');
            exit;
        }
    }
    
    public function orders() {
        $orderModel = new Order($this->pdo);
        $orders = $orderModel->getAll();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="orders_' . date('Y-m-d') . '.xls"');
        
        echo '<html>';
        echo '<meta charset="utf-8">';
        echo '<table border="1">';
        echo '<tr>
                <th>ID</th>
                <th>Клиент</th>
                <th>Откуда</th>
                <th>Куда</th>
                <th>Вес (кг)</th>
                <th>Стоимость (руб)</th>
                <th>Статус</th>
                <th>Курьер</th>
                <th>Дата</th>
              </tr>';
        
        foreach($orders as $order) {
            echo '<tr>';
            echo '<td>' . $order['id'] . '</td>';
            echo '<td>' . $order['client_name'] . '</td>';
            echo '<td>' . $order['from_address'] . '</td>';
            echo '<td>' . $order['to_address'] . '</td>';
            echo '<td>' . $order['weight'] . '</td>';
            echo '<td>' . $order['cost'] . '</td>';
            echo '<td>' . $order['status'] . '</td>';
            echo '<td>' . $order['courier_name'] . '</td>';
            echo '<td>' . $order['order_date'] . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        echo '</html>';
    }
    
    public function couriers() {
        $courierModel = new Courier($this->pdo);
        $couriers = $courierModel->getAll();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="couriers_' . date('Y-m-d') . '.xls"');
        
        echo '<html>';
        echo '<meta charset="utf-8">';
        echo '<table border="1">';
        echo '<tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Транспорт</th>
                <th>Статус</th>
                <th>График</th>
              </tr>';
        
        foreach($couriers as $courier) {
            echo '<tr>';
            echo '<td>' . $courier['id'] . '</td>';
            echo '<td>' . $courier['full_name'] . '</td>';
            echo '<td>' . $courier['transport'] . '</td>';
            echo '<td>' . $courier['status'] . '</td>';
            echo '<td>' . $courier['schedule'] . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        echo '</html>';
    }
}