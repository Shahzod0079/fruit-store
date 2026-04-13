<?php
if(isset($_POST["register"])){
    if(!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password']))
    {
        $full_name = htmlspecialchars($_POST['full_name']);
        $email = htmlspecialchars($_POST['email']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $query = "SELECT * FROM usertbl WHERE username='".$username."'";
        $query_s = mysqli_query($db, $query);
        $numrows = mysqli_num_rows($query_s);
        
        if($numrows == 0) {

            $sql = "INSERT INTO usertbl (full_name, email, username, password) VALUES ('$full_name','$email','$username', '$password')";
            $result = mysqli_query($db, $sql);
            
            if($result){
                $message = "Аккаунт успешно создан";
            } else {
                $message = "Не удалось создать аккаунт!";
            }
        } else {
            $message = "Это имя пользователя уже существует! Пожалуйста, попробуйте другое!";
        }
    } else {
        $message = "Заполни все поля!";
    }
}
?>