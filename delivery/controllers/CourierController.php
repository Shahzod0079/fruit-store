<?php
require_once __DIR__ . '/../models/Order.php';

class CourierController {
    private $pdo;
    private $order;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->order = new Order($pdo);
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'courier') {
            header('Location: /delivery/public/index.php?route=auth/login');
            exit;
        }
    }
    
public function dashboard() {
    $courier_id = $_SESSION['user']['id'];
    $orders = $this->order->getByCourier($courier_id);
    
    $title = 'Панель курьера';
    ob_start();
    ?>
    <div class="row mb-4 fade-in">
        <div class="col-md-6">
            <div class="card stat-card bg-primary-gradient text-white">
                <div class="card-body">
                    <h5><i class="fas fa-box"></i> Мои заказы</h5>
                    <h3><?= count($orders) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card bg-success-gradient text-white">
                <div class="card-body">
                    <h5><i class="fas fa-check-circle"></i> Доставлено</h5>
                    <h3><?= count(array_filter($orders, fn($o) => $o['status'] == 'доставлен')) ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card fade-in">
        <div class="card-header">
            <h5><i class="fas fa-truck"></i> Мои заказы</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead><tr><th>ID</th><th>Откуда</th><th>Куда</th><th>Вес</th><th>Стоимость</th><th>Статус</th><th>Действие</th></tr></thead>
                <tbody>
                    <?php foreach($orders as $order): 
                        $badge = $order['status'] == 'доставлен' ? 'badge-success' : ($order['status'] == 'в пути' ? 'badge-warning' : 'badge-secondary');
                    ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= mb_substr($order['from_address'], 0, 30) ?>...</td>
                        <td><?= mb_substr($order['to_address'], 0, 30) ?>...</td>
                        <td><?= $order['weight'] ?> кг</td>
                        <td><?= $order['cost'] ?> руб</td>
                        <td><span class="badge-status <?= $badge ?>"><?= $order['status'] ?></span></td>
                        <td>
                            <?php if($order['status'] == 'назначен'): ?>
                                <a href="/delivery/public/index.php?route=courier/updateStatus&id=<?= $order['id'] ?>&status=в пути" class="btn btn-icon btn-warning">🚚 Взять</a>
                            <?php elseif($order['status'] == 'в пути'): ?>
                                <a href="/delivery/public/index.php?route=courier/updateStatus&id=<?= $order['id'] ?>&status=доставлен" class="btn btn-icon btn-success">✅ Доставлен</a>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}
    public function updateStatus() {
        $id = $_GET['id'] ?? 0;
        $status = $_GET['status'] ?? '';
        
        if($id && $status) {
            $this->order->updateStatus($id, $status);
        }
        
        header('Location: /delivery/public/index.php?route=courier/dashboard');
    }
}