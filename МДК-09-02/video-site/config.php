<?php
// config.php - Исправленная версия
session_start();

define('USERS_FILE', 'users.json');
define('VISITORS_FILE', 'visitors.json');

// Функция для загрузки пользователей (исправлено)
function loadUsers() {
    if (!file_exists(USERS_FILE)) {
        file_put_contents(USERS_FILE, json_encode([]));
        return [];
    }
    $content = file_get_contents(USERS_FILE);
    $users = json_decode($content, true);
    
    // Преобразуем старый формат в новый если нужно
    if ($users && isset($users[0]['username'])) {
        $newFormat = [];
        foreach ($users as $user) {
            $newFormat[$user['username']] = [
                'password' => $user['password'],
                'created_at' => $user['created_at'] ?? date('Y-m-d H:i:s')
            ];
        }
        $users = $newFormat;
        saveUsers($users);
    }
    
    return $users ?: [];
}

// Функция для сохранения пользователей (исправлено)
function saveUsers($users) {
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Функция для загрузки посетителей
function loadVisitors() {
    if (!file_exists(VISITORS_FILE)) {
        file_put_contents(VISITORS_FILE, json_encode([]));
    }
    return json_decode(file_get_contents(VISITORS_FILE), true) ?: [];
}

// Функция для сохранения посетителей
function saveVisitors($visitors) {
    file_put_contents(VISITORS_FILE, json_encode($visitors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Добавление посетителя
function addVisitor($username) {
    $visitors = loadVisitors();
    $visitors[] = [
        'username' => $username,
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR']
    ];
    saveVisitors($visitors);
}
?>