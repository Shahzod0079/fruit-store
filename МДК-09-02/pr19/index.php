<?php
//Подключение
require_once "login.php";
$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database)
or die (mysqli_connect_error());
mysqli_set_charset($db_server, "utf8");

//Обработка добавления для таблицы Students
if (isset($_POST['add_student'])) {
    $group     = $_POST['group'];
    $disc_id   = (int)$_POST['discipline_id'];
    $grade     = $_POST['grade'] === '' ? 'NULL' : (int)$_POST['grade'];
    $control   = $_POST['control'];

    $query = "INSERT INTO Students (GroupName, DisciplineID, Grade, ControlType)
              VALUES ('$group', $disc_id, $grade, '$control')";
    mysqli_query($db_server, $query) or die("Ошибка добавления студента: " . mysqli_error($db_server));
}

//Обработка добавления для таблицы Disciplines
if (isset($_POST['add_discipline'])) {
    $title = $_POST['title'];
    $hours = (int)$_POST['hours'];

    $query = "INSERT INTO Disciplines (Title, Hours) VALUES ('$title', $hours)";
    mysqli_query($db_server, $query) or die("Ошибка добавления дисциплины: " . mysqli_error($db_server));
}

//Обработка удаления  из таблицы Students
if (isset($_POST['delete_student'])) {
    $id = (int)$_POST['student_id'];
    $query = "DELETE FROM Students WHERE StudentID = $id";
    mysqli_query($db_server, $query) or die("Ошибка удаления студента: " . mysqli_error($db_server));
}

//Обработка удаления  из таблицы Disciplines
if (isset($_POST['delete_discipline'])) {
    $id = (int)$_POST['discipline_id'];
    $query = "DELETE FROM Disciplines WHERE DisciplineID = $id";
    mysqli_query($db_server, $query) or die("Ошибка удаления дисциплины: " . mysqli_error($db_server));
}

//Получение данных для вывода
$students_result = mysqli_query($db_server, "SELECT * FROM Students ORDER BY StudentID");
$disciplines_result = mysqli_query($db_server, "SELECT * FROM Disciplines ORDER BY DisciplineID");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Университет: студенты и дисциплины</title>

</head>
<body>
    <h1>Управление учебным процессом</h1>
    <div class="container">
        <div class="left">
            <h2>Студенты и оценки</h2>
            <form method="post">
                <div class="form-group"><label>Группа:</label> <input type="text" name="group" required></div>
                <div class="form-group"><label>ID дисциплины:</label> <input type="number" name="discipline_id" required></div>
                <div class="form-group"><label>Оценка:</label> <input type="number" name="grade" placeholder="необяз."></div>
                <div class="form-group"><label>Контроль:</label> <input type="text" name="control" required></div>
                <button type="submit" name="add_student" class="btn">Добавить студента</button>
            </form>

            <hr>

            <h3>Существующие записи</h3>
            <?php if (mysqli_num_rows($students_result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($students_result)): ?>
                    <div class="record">
                        <span class="record-content">
                            <strong>ID <?= $row['StudentID'] ?></strong> |
                            Группа <?= htmlspecialchars($row['GroupName']) ?> |
                            Дисц. <?= $row['DisciplineID'] ?> |
                            Оценка: <?= $row['Grade'] ?? '—' ?> |
                            <?= htmlspecialchars($row['ControlType']) ?>
                        </span>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="student_id" value="<?= $row['StudentID'] ?>">
                            <button type="submit" name="delete_student" class="btn btn-delete">Удалить</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Пока нет студентов.</p>
            <?php endif; ?>
        </div>
            <!--Дисциплины -->
        <div class="right">
            <h2>Дисциплины</h2>
            <form method="post">
                <div class="form-group"><label>Название:</label> <input type="text" name="title" required></div>
                <div class="form-group"><label>Часов:</label> <input type="number" name="hours" required></div>
                <button type="submit" name="add_discipline" class="btn">Добавить дисциплину</button>
            </form>

            <hr>
            <h3>Существующие дисциплины</h3>
            <?php if (mysqli_num_rows($disciplines_result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($disciplines_result)): ?>
                    <div class="record">
                        <span class="record-content">
                            <strong>ID <?= $row['DisciplineID'] ?></strong> |
                            <?= htmlspecialchars($row['Title']) ?> |
                            <?= $row['Hours'] ?> ч.
                        </span>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="discipline_id" value="<?= $row['DisciplineID'] ?>">
                            <button type="submit" name="delete_discipline" class="btn btn-delete">Удалить</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Пока нет дисциплин.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php
//Закрытие
    mysqli_close($db_server);
    ?>
</body>
</html>