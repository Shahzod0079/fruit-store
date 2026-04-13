<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Courier.php';
require_once __DIR__ . '/../helpers/Validator.php';

class DispatcherController {
    private $pdo;
    private $order;
    private $client;
    private $courier;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->order = new Order($pdo);
        $this->client = new Client($pdo);
        $this->courier = new Courier($pdo);
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'dispatcher') {
            header('Location: /delivery/public/index.php?route=auth/login');
            exit;
        }
    }
    
public function dashboard() {
    $orders = $this->order->getAll();
    $clients = $this->client->getAll();
    $freeCouriers = $this->courier->getFree();
    
    $title = 'Панель диспетчера';
    ob_start();
    ?>
    <div class="row mb-4 fade-in">
        <div class="col-md-4">
            <div class="card stat-card bg-primary-gradient text-white">
                <div class="card-body">
                    <h5><i class="fas fa-box"></i> Всего заказов</h5>
                    <h3><?= count($orders) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-success-gradient text-white">
                <div class="card-body">
                    <h5><i class="fas fa-users"></i> Клиентов</h5>
                    <h3><?= count($clients) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-info-gradient text-white">
                <div class="card-body">
                    <h5><i class="fas fa-motorcycle"></i> Свободных курьеров</h5>
                    <h3><?= count($freeCouriers) ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4 fade-in">
        <div class="card-header">
            <h5><i class="fas fa-plus"></i> Создать заказ</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="/delivery/public/index.php?route=dispatcher/createOrder" class="row g-3">
                <div class="col-md-4">
                    <select name="client_id" class="form-select" required>
                        <option value="">Выберите клиента</option>
                        <?php foreach($clients as $client): ?>
                            <option value="<?= $client['id'] ?>"><?= $client['full_name'] ?> (<?= $client['phone'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4"><input type="text" name="from_address" class="form-control" placeholder="Откуда" required></div>
                <div class="col-md-4"><input type="text" name="to_address" class="form-control" placeholder="Куда" required></div>
                <div class="col-md-3"><input type="number" step="0.1" name="weight" class="form-control" placeholder="Вес (кг)" required></div>
                <div class="col-md-3"><input type="number" step="0.01" name="cost" class="form-control" placeholder="Стоимость" required></div>
                <div class="col-md-3"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Создать</button></div>
            </form>
        </div>
    </div>
    
    <div class="card mb-4 fade-in">
        <div class="card-header">
            <h5><i class="fas fa-user-check"></i> Назначить курьера</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="/delivery/public/index.php?route=dispatcher/assignCourier" class="row g-3">
                <div class="col-md-5">
                    <select name="order_id" class="form-select" required>
                        <option value="">Выберите заказ</option>
                        <?php foreach($orders as $order): ?>
                            <?php if($order['status'] == 'новый' || $order['status'] == 'назначен'): ?>
                                <option value="<?= $order['id'] ?>">Заказ #<?= $order['id'] ?> - <?= $order['client_name'] ?> (<?= $order['status'] ?>)</option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="courier_id" class="form-select" required>
                        <option value="">Выберите курьера</option>
                        <?php foreach($freeCouriers as $courier): ?>
                            <option value="<?= $courier['id'] ?>"><?= $courier['full_name'] ?> (<?= $courier['transport'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2"><button type="submit" class="btn btn-success w-100"><i class="fas fa-check"></i> Назначить</button></div>
            </form>
        </div>
    </div>
    
    <div class="card fade-in">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Список заказов</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead><tr><th>ID</th><th>Клиент</th><th>Откуда</th><th>Куда</th><th>Вес</th><th>Стоимость</th><th>Статус</th><th>Курьер</th></tr></thead>
                <tbody>
                    <?php foreach($orders as $order): 
                        $badge = $order['status'] == 'доставлен' ? 'badge-success' : ($order['status'] == 'в пути' ? 'badge-warning' : 'badge-secondary');
                    ?>
                    <tr><td><?= $order['id'] ?></td><td><?= $order['client_name'] ?></td><td><?= mb_substr($order['from_address'], 0, 30) ?>...</td><td><?= mb_substr($order['to_address'], 0, 30) ?>...</td><td><?= $order['weight'] ?> кг</td><td><?= $order['cost'] ?> руб</td><td><span class="badge-status <?= $badge ?>"><?= $order['status'] ?></span></td><td><?= $order['courier_name'] ?? 'не назначен' ?></td></tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}
    public function createOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = Validator::validateOrder($_POST);
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: /delivery/public/index.php?route=dispatcher/dashboard');
                return;
            }
            
            $this->order->create($_POST);
            $_SESSION['success'] = "Заказ успешно создан";
        }
        header('Location: /delivery/public/index.php?route=dispatcher/dashboard');
    }
    
    public function assignCourier() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->order->assignCourier($_POST['order_id'], $_POST['courier_id']);
            $this->courier->updateStatus($_POST['courier_id'], 'занят');
        }
        header('Location: /delivery/public/index.php?route=dispatcher/dashboard');
    }
}