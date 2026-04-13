<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Courier.php';
require_once __DIR__ . '/../models/Employee.php';
require_once __DIR__ . '/../helpers/Validator.php';

class AdminController {
    private $pdo;
    private $order;
    private $client;
    private $courier;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->order = new Order($pdo);
        $this->client = new Client($pdo);
        $this->courier = new Courier($pdo);
        
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            header('Location: /delivery/public/index.php?route=auth/login');
            exit;
        }
    }
    
 public function dashboard() {
    $orders = $this->order->getAll();
    $clients = $this->client->getAll();
    $couriers = $this->courier->getAll();
    
    // Подсчёт статусов заказов
    $newOrders = 0;
    $inTransit = 0;
    $delivered = 0;
    foreach($orders as $order) {
        if($order['status'] == 'новый') $newOrders++;
        elseif($order['status'] == 'в пути') $inTransit++;
        elseif($order['status'] == 'доставлен') $delivered++;
    }
    
    $title = 'Панель администратора';
    
    ob_start();
    ?>
    
    <div class="row mb-4 fade-in">
        <div class="col-md-3">
            <div class="card stat-card bg-primary-gradient text-white">
                <div class="card-body">
                    <h5><i class="fas fa-box"></i> Всего заказов</h5>
                    <h3><?= count($orders) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-success-gradient text-white">
                <div class="card-body">
                    <h5><i class="fas fa-users"></i> Клиентов</h5>
                    <h3><?= count($clients) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-info-gradient text-white">
                <div class="card-body">
                    <h5><i class="fas fa-motorcycle"></i> Курьеров</h5>
                    <h3><?= count($couriers) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="card-body text-white">
                    <h5><i class="fas fa-chart-line"></i> Доставлено</h5>
                    <h3><?= $delivered ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4 fade-in">
        <div class="card-header">
            <h5><i class="fas fa-chart-line"></i> Меню управления</h5>
        </div>
        <div class="card-body">
            <a href="/delivery/public/index.php?route=admin/clients" class="btn btn-outline-primary m-1">
                <i class="fas fa-users"></i> Клиенты
            </a>
            <a href="/delivery/public/index.php?route=admin/couriers" class="btn btn-outline-success m-1">
                <i class="fas fa-motorcycle"></i> Курьеры
            </a>
            <a href="/delivery/public/index.php?route=admin/employees" class="btn btn-outline-warning m-1">
                <i class="fas fa-user-cog"></i> Сотрудники
            </a>
            <a href="/delivery/public/index.php?route=export/orders" class="btn btn-outline-info m-1">
                <i class="fas fa-file-excel"></i> Экспорт заказов
            </a>
            <a href="/delivery/public/index.php?route=export/couriers" class="btn btn-outline-info m-1">
                <i class="fas fa-file-excel"></i> Экспорт курьеров
            </a>
        </div>
    </div>
    
    <div class="card fade-in">
        <div class="card-header">
            <h5><i class="fas fa-truck"></i> Список заказов</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th><th>Клиент</th><th>Откуда</th><th>Куда</th><th>Вес</th><th>Стоимость</th><th>Статус</th><th>Курьер</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order): 
                        $statusBadge = '';
                        switch($order['status']) {
                            case 'доставлен': $statusBadge = 'badge-success'; break;
                            case 'в пути': $statusBadge = 'badge-warning'; break;
                            default: $statusBadge = 'badge-secondary';
                        }
                    ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $order['client_name'] ?></td>
                        <td><?= mb_substr($order['from_address'], 0, 30) ?>...</td>
                        <td><?= mb_substr($order['to_address'], 0, 30) ?>...</td>
                        <td><?= $order['weight'] ?> кг</td>
                        <td><?= $order['cost'] ?> руб</td>
                        <td><span class="badge-status <?= $statusBadge ?>"><?= $order['status'] ?></span></td>
                        <td><?= $order['courier_name'] ?? 'не назначен' ?></td>
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
    
public function clients() {
    $clients = $this->client->getAll();
    $title = 'Управление клиентами';
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h2><i class="fas fa-users me-2"></i>Клиенты</h2>
        <a href="/delivery/public/index.php?route=admin/clientAdd" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Добавить клиента
        </a>
    </div>
    
    <div class="search-box">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Поиск по ФИО, телефону или email...">
    </div>
    
    <div class="table-container">
        <table class="table" id="clientsTable">
            <thead>
                <tr>
                    <th>ID</th><th>ФИО</th><th>Телефон</th><th>Email</th><th>Адрес</th><th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clients as $client): ?>
                <tr class="fade-in">
                    <td><?= $client['id'] ?></td>
                    <td><i class="fas fa-user-circle me-2" style="color:#667eea"></i><?= $client['full_name'] ?></td>
                    <td><i class="fas fa-phone me-2"></i><?= $client['phone'] ?></td>
                    <td><i class="fas fa-envelope me-2"></i><?= $client['email'] ?></td>
                    <td><i class="fas fa-map-marker-alt me-2"></i><?= $client['address'] ?></td>
                    <td class="action-buttons">
                        <a href="/delivery/public/index.php?route=admin/clientEdit&id=<?= $client['id'] ?>" class="btn btn-icon btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/delivery/public/index.php?route=admin/clientDelete&id=<?= $client['id'] ?>" class="btn btn-icon btn-delete" onclick="return confirm('Удалить клиента?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#clientsTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
    </script>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}
    
public function clientAdd() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = Validator::validateClient($_POST);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /delivery/public/index.php?route=admin/clientAdd');
            return;
        }
        
        $this->client->create($_POST);
        $_SESSION['success'] = "Клиент добавлен";
        header('Location: /delivery/public/index.php?route=admin/clients');
        return;
    }
    
    $title = 'Добавить клиента';
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h2><i class="fas fa-user-plus me-2"></i>Добавить клиента</h2>
        <a href="/delivery/public/index.php?route=admin/clients" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Назад
        </a>
    </div>
    
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach($_SESSION['errors'] as $error): ?>
                <div><i class="fas fa-exclamation-circle me-2"></i><?= $error ?></div>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
    
    <div class="card form-card fade-in">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user"></i> ФИО <span class="required-field"></span></label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-phone"></i> Телефон</label>
                    <input type="text" name="phone" class="form-control" placeholder="+7 (999) 123-45-67" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-map-marker-alt"></i> Адрес</label>
                    <textarea name="address" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-save me-2"></i>Сохранить
                </button>
            </form>
        </div>
    </div>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}

public function clientEdit() {
    $id = $_GET['id'] ?? 0;
    $client = $this->client->getById($id);
    
    if (!$client) {
        header('Location: /delivery/public/index.php?route=admin/clients');
        return;
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $this->client->update($id, $_POST);
        $_SESSION['success'] = "Клиент обновлён";
        header('Location: /delivery/public/index.php?route=admin/clients');
        return;
    }
    
    $title = 'Редактировать клиента';
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h2><i class="fas fa-user-edit me-2"></i>Редактировать клиента</h2>
        <a href="/delivery/public/index.php?route=admin/clients" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Назад
        </a>
    </div>
    
    <div class="card form-card fade-in">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user"></i> ФИО</label>
                    <input type="text" name="full_name" class="form-control" value="<?= $client['full_name'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-phone"></i> Телефон</label>
                    <input type="text" name="phone" class="form-control" value="<?= $client['phone'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $client['email'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-map-marker-alt"></i> Адрес</label>
                    <textarea name="address" class="form-control" rows="3" required><?= $client['address'] ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-save me-2"></i>Сохранить
                </button>
            </form>
        </div>
    </div>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}
    public function clientDelete() {
        $id = $_GET['id'] ?? 0;
        $this->client->delete($id);
        header('Location: /delivery/public/index.php?route=admin/clients');
    }
    
public function couriers() {
    $couriers = $this->courier->getAll();
    $title = 'Управление курьерами';
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h2><i class="fas fa-motorcycle me-2"></i>Курьеры</h2>
        <a href="/delivery/public/index.php?route=admin/courierAdd" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Добавить курьера
        </a>
    </div>
    
    <div class="search-box">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Поиск по ФИО, транспорту или графику...">
    </div>
    
    <div class="table-container">
        <table class="table" id="couriersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Транспорт</th>
                    <th>Статус</th>
                    <th>График</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($couriers as $courier): 
                    $statusClass = '';
                    $statusText = '';
                    switch($courier['status']) {
                        case 'свободен':
                            $statusClass = 'status-free';
                            $statusText = '🟢 Свободен';
                            break;
                        case 'занят':
                            $statusClass = 'status-busy';
                            $statusText = '🟡 Занят';
                            break;
                        default:
                            $statusClass = 'status-off';
                            $statusText = '🔴 Не работает';
                    }
                ?>
                <tr class="fade-in">
                    <td><?= $courier['id'] ?></td>
                    <td><i class="fas fa-user-circle me-2" style="color:#667eea"></i><?= $courier['full_name'] ?></td>
                    <td><span class="courier-transport"><i class="fas fa-car me-1"></i><?= $courier['transport'] ?></span></td>
                    <td><span class="courier-status <?= $statusClass ?>"><?= $statusText ?></span></td>
                    <td><i class="fas fa-calendar-alt me-2"></i><?= $courier['schedule'] ?></td>
                    <td class="action-buttons">
                        <a href="/delivery/public/index.php?route=admin/courierEdit&id=<?= $courier['id'] ?>" class="btn btn-icon btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/delivery/public/index.php?route=admin/courierDelete&id=<?= $courier['id'] ?>" class="btn btn-icon btn-delete" onclick="return confirm('Удалить курьера?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#couriersTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
    </script>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}
public function courierAdd() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = Validator::validateCourier($_POST);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /delivery/public/index.php?route=admin/courierAdd');
            return;
        }
        $this->courier->create($_POST);
        $_SESSION['success'] = "Курьер добавлен";
        header('Location: /delivery/public/index.php?route=admin/couriers');
        return;
    }
    
    $title = 'Добавить курьера';
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-motorcycle me-2"></i>Добавить курьера</h2>
        <a href="/delivery/public/index.php?route=admin/couriers" class="btn btn-secondary">← Назад</a>
    </div>
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><?php foreach($_SESSION['errors'] as $error) echo "<div>$error</div>"; unset($_SESSION['errors']); ?></div>
    <?php endif; ?>
    <div class="card"><div class="card-body">
        <form method="POST">
            <div class="mb-3"><label>ФИО</label><input type="text" name="full_name" class="form-control" required></div>
            <div class="mb-3"><label>Транспорт</label><input type="text" name="transport" class="form-control" required></div>
            <div class="mb-3"><label>График</label><input type="text" name="schedule" class="form-control" required></div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div></div>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}
    
public function courierEdit() {
    $id = $_GET['id'] ?? 0;
    $courier = $this->courier->getById($id);
    if (!$courier) { header('Location: /delivery/public/index.php?route=admin/couriers'); return; }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $this->courier->update($id, $_POST);
        $_SESSION['success'] = "Курьер обновлён";
        header('Location: /delivery/public/index.php?route=admin/couriers');
        return;
    }
    
    $title = 'Редактировать курьера';
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user-edit me-2"></i>Редактировать курьера</h2>
        <a href="/delivery/public/index.php?route=admin/couriers" class="btn btn-secondary">← Назад</a>
    </div>
    <div class="card"><div class="card-body">
        <form method="POST">
            <div class="mb-3"><label>ФИО</label><input type="text" name="full_name" class="form-control" value="<?= $courier['full_name'] ?>" required></div>
            <div class="mb-3"><label>Транспорт</label><input type="text" name="transport" class="form-control" value="<?= $courier['transport'] ?>" required></div>
            <div class="mb-3"><label>Статус</label>
                <select name="status" class="form-select">
                    <option value="свободен" <?= $courier['status'] == 'свободен' ? 'selected' : '' ?>>Свободен</option>
                    <option value="занят" <?= $courier['status'] == 'занят' ? 'selected' : '' ?>>Занят</option>
                    <option value="не работает" <?= $courier['status'] == 'не работает' ? 'selected' : '' ?>>Не работает</option>
                </select>
            </div>
            <div class="mb-3"><label>График</label><input type="text" name="schedule" class="form-control" value="<?= $courier['schedule'] ?>" required></div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div></div>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}
    public function courierDelete() {
        $id = $_GET['id'] ?? 0;
        $this->courier->delete($id);
        header('Location: /delivery/public/index.php?route=admin/couriers');
    }
    public function employees() {
    $employeeModel = new Employee($this->pdo);
    $employees = $employeeModel->getAll();
    $title = 'Управление сотрудниками';
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h2><i class="fas fa-user-cog me-2"></i>Сотрудники</h2>
        <a href="/delivery/public/index.php?route=admin/employeeAdd" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Добавить сотрудника
        </a>
    </div>
    
    <div class="search-box">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Поиск по ФИО, логину или должности...">
    </div>
    
    <div class="table-container">
        <table class="table" id="employeesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Должность</th>
                    <th>Логин</th>
                    <th>Роль</th>
                    <th>Курьер ID</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($employees as $emp): 
                    $roleClass = '';
                    $roleIcon = '';
                    switch($emp['role']) {
                        case 'admin':
                            $roleClass = 'role-admin';
                            $roleIcon = '👑';
                            break;
                        case 'dispatcher':
                            $roleClass = 'role-dispatcher';
                            $roleIcon = '📞';
                            break;
                        case 'courier':
                            $roleClass = 'role-courier';
                            $roleIcon = '🚚';
                            break;
                    }
                ?>
                <tr class="fade-in employee-row">
                    <td><?= $emp['id'] ?></td>
                    <td><i class="fas fa-user-circle me-2" style="color:#667eea"></i><?= $emp['full_name'] ?></td>
                    <td><i class="fas fa-briefcase me-2"></i><?= $emp['position'] ?></td>
                    <td><i class="fas fa-key me-2"></i><?= $emp['login'] ?></td>
                    <td><span class="role-badge <?= $roleClass ?>"><?= $roleIcon ?> <?= $emp['role'] ?></span></td>
                    <td><?= $emp['courier_id'] ?? '-' ?></td>
                    <td class="action-buttons">
                        <a href="/delivery/public/index.php?route=admin/employeeEdit&id=<?= $emp['id'] ?>" class="btn btn-icon btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/delivery/public/index.php?route=admin/employeeReset&id=<?= $emp['id'] ?>" class="btn btn-icon btn-reset" onclick="return confirm('Сбросить пароль на 123456?')">
                            <i class="fas fa-key"></i>
                        </a>
                        <a href="/delivery/public/index.php?route=admin/employeeDelete&id=<?= $emp['id'] ?>" class="btn btn-icon btn-delete" onclick="return confirm('Удалить сотрудника?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#employeesTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
    </script>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}

public function employeeAdd() {
    $couriers = $this->courier->getAll();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $employeeModel = new Employee($this->pdo);
            $employeeModel->create($_POST);
            $_SESSION['success'] = "Сотрудник добавлен";
            header('Location: /delivery/public/index.php?route=admin/employees');
            return;
        } catch (Exception $e) {
            $_SESSION['errors'] = [$e->getMessage()];
        }
    }
    
    $title = 'Добавить сотрудника';
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user-plus me-2"></i>Добавить сотрудника</h2>
        <a href="/delivery/public/index.php?route=admin/employees" class="btn btn-secondary">← Назад</a>
    </div>
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><?php foreach($_SESSION['errors'] as $error) echo "<div>$error</div>"; unset($_SESSION['errors']); ?></div>
    <?php endif; ?>
    <div class="card"><div class="card-body">
        <form method="POST">
            <div class="mb-3"><label>ФИО</label><input type="text" name="full_name" class="form-control" required></div>
            <div class="mb-3"><label>Должность</label><input type="text" name="position" class="form-control" required></div>
            <div class="mb-3"><label>Логин</label><input type="text" name="login" class="form-control" required></div>
            <div class="mb-3"><label>Роль</label>
                <select name="role" id="role" class="form-select" onchange="toggleCourier()" required>
                    <option value="admin">Админ</option><option value="dispatcher">Диспетчер</option><option value="courier">Курьер</option>
                </select>
            </div>
            <div id="courier_select" style="display:none" class="mb-3">
                <label>Курьер</label><select name="courier_id" class="form-select"><option value="">Выберите</option>
                <?php foreach($couriers as $c): ?><option value="<?= $c['id'] ?>"><?= $c['full_name'] ?></option><?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить (пароль 123456)</button>
        </form>
    </div></div>
    <script>function toggleCourier(){var e=document.getElementById('role').value;document.getElementById('courier_select').style.display=e=='courier'?'block':'none';}</script>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}
public function employeeEdit() {
    $id = $_GET['id'] ?? 0;
    $employeeModel = new Employee($this->pdo);
    $employee = $employeeModel->getById($id);
    $couriers = $this->courier->getAll();
    if (!$employee) { header('Location: /delivery/public/index.php?route=admin/employees'); return; }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $employeeModel->update($id, $_POST);
            $_SESSION['success'] = "Сотрудник обновлён";
            header('Location: /delivery/public/index.php?route=admin/employees');
            return;
        } catch (Exception $e) {
            $_SESSION['errors'] = [$e->getMessage()];
        }
    }
    
    $title = 'Редактировать сотрудника';
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user-edit me-2"></i>Редактировать сотрудника</h2>
        <a href="/delivery/public/index.php?route=admin/employees" class="btn btn-secondary">← Назад</a>
    </div>
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger"><?php foreach($_SESSION['errors'] as $error) echo "<div>$error</div>"; unset($_SESSION['errors']); ?></div>
    <?php endif; ?>
    <div class="card"><div class="card-body">
        <form method="POST">
            <div class="mb-3"><label>ФИО</label><input type="text" name="full_name" class="form-control" value="<?= $employee['full_name'] ?>" required></div>
            <div class="mb-3"><label>Должность</label><input type="text" name="position" class="form-control" value="<?= $employee['position'] ?>" required></div>
            <div class="mb-3"><label>Логин</label><input type="text" name="login" class="form-control" value="<?= $employee['login'] ?>" required></div>
            <div class="mb-3"><label>Роль</label>
                <select name="role" id="role" class="form-select" onchange="toggleCourier()" required>
                    <option value="admin" <?= $employee['role'] == 'admin' ? 'selected' : '' ?>>Админ</option>
                    <option value="dispatcher" <?= $employee['role'] == 'dispatcher' ? 'selected' : '' ?>>Диспетчер</option>
                    <option value="courier" <?= $employee['role'] == 'courier' ? 'selected' : '' ?>>Курьер</option>
                </select>
            </div>
            <div id="courier_select" style="display:<?= $employee['role'] == 'courier' ? 'block' : 'none' ?>" class="mb-3">
                <label>Курьер</label><select name="courier_id" class="form-select">
                    <option value="">Выберите</option>
                    <?php foreach($couriers as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $employee['courier_id'] ? 'selected' : '' ?>><?= $c['full_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div></div>
    <script>function toggleCourier(){var e=document.getElementById('role').value;document.getElementById('courier_select').style.display=e=='courier'?'block':'none';}</script>
    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../views/layouts/main.php';
}
    public function employeeDelete() {
        $id = $_GET['id'] ?? 0;
        $employeeModel = new Employee($this->pdo);
        $employeeModel->delete($id);
        header('Location: /delivery/public/index.php?route=admin/employees');
    }
}