<?php
if (isset($_FILES['video'])) {
    $uploadDir = 'recordings/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $filename = $uploadDir . $_FILES['video']['name'];
    move_uploaded_file($_FILES['video']['tmp_name'], $filename);
    echo "Видео сохранено: " . $filename;
}
?>