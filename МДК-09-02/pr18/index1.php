<?php
// подключение
require_once "login.php";
$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database)
or die (mysqli_connect_error());
mysqli_set_charset($db_server, "utf8");


if (isset($_POST["add"]) &&
    isset($_POST["author"]) &&
    isset($_POST["title"]) &&
    isset($_POST["category"]) &&
    isset($_POST["year"]) &&
    isset($_POST["isbn"]))
{
    $author = $_POST["author"];
    $title = $_POST["title"];
    $category = $_POST["category"];
    $year = $_POST["year"];
    $isbn = $_POST["isbn"];

    $query = "INSERT INTO classics VALUES" .
    "('$author', '$title', '$category', '$year', '$isbn')";
    
    $result = mysqli_query($db_server, $query)
    or die ("Ошибка в запросе: ". mysqli_error($db_server));
}

// вывод информации из БД
$query = "SELECT * FROM classics";
$result = mysqli_query($db_server, $query);
if (!$result) die ("Сбой при доступе к базе данных: " . mysqli_error($db_server));

// вывод данных из БД
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<p>" . $row['author'] . "</p>";
        echo "<p>" . $row['title'] . "</p>";
        echo "<p>" . $row['category'] . "</p>";
        echo "<p>" . $row['year'] . "</p>";
        echo "<p>" . $row['isbn'] . "</p>";
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='delete' value='yes'>";
        echo "<input type='hidden' name='isbn' value='" . $row['isbn'] . "'>";
        echo "<input type='submit' value='DELETE_RECORD'>";
        echo "</form>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
    <input type="text" name="author" placeholder="Автор">
    <input type="text" name="title" placeholder="Название">
    <input type="text" name="category" placeholder="Категория">
    <input type="text" name="year" placeholder="Год издания">
    <input type="text" name="isbn" placeholder="isbn">
    <input type="submit" name="add" value="add">
   </form>
</body>
</html>
<?php mysqli_close($db_server); ?>