<?php
$goods = [
    [
        'id' => 1,
        'name' => 'Смартфон iPhone 15',
        'price' => 99990,
        'category' => 'Смартфоны',
        'description' => 'Современный смартфон с мощным процессором и большим экраном'
    ],
    [
        'id' => 2,
        'name' => 'Ноутбук MacBook Air',
        'price' => 89990,
        'category' => 'Ноутбуки',
        'description' => 'Легкий и мощный ноутбук для работы и развлечений'
    ],
    [
        'id' => 3,
        'name' => 'Беспроводные наушники AirPods',
        'price' => 29990,
        'category' => 'Аудиотехника',
        'description' => 'Беспроводные наушники с шумоподавлением'
    ]
];

function showGoods($goods) {
    foreach ($goods as $item) {
        include 'goods.php';
    }
}

showGoods($goods);
?>
