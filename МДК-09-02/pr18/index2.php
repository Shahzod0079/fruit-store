<?php
// подключение
require_once "login1.php";
$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database)
or die (mysqli_connect_error());
mysqli_set_charset($db_server, "utf8");

// Добавление дисциплины
if (isset($_POST["add"])) {
    $title = $_POST["title"];
    $hours = $_POST["hours"];
    
    $query = "INSERT INTO Disciplines (Title, Hours) VALUES ('$title', $hours)";
    mysqli_query($db_server, $query) or die (mysqli_error($db_server));
    echo "Дисциплина добавлена!";
}

// Вывод всех дисциплин
$result = mysqli_query($db_server, "SELECT * FROM Disciplines");
?>

<form method="post">
    <input type="text" name="title" placeholder="Название дисциплины" required>
    <input type="number" name="hours" placeholder="Количество часов" required>
    <input type="submit" name="add" value="Добавить">
</form>

<h3>Список дисциплин:</h3>
<?php while($row = mysqli_fetch_assoc($result)): ?>
    <p><?= $row["DisciplineID"] ?> <?= $row["Title"] ?> <?= $row["Hours"] ?> ч.</p>
<?php endwhile; ?>

<?php mysqli_close($db_server); ?>