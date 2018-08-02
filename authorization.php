<?php
session_start();
include_once "config.php";
$mysqli = new mysqli($config['host'], $config['username'], $config['passwd'], $config['dbname']);
$mysqli->query("SET NAMES 'utf8'");
if($_POST['log']){
    $nickname = htmlspecialchars($_POST['nickname']);
    $password = htmlspecialchars($_POST['password']);
    $errors = "";
    if($password == "")
        $errors .= "Введите пароль <br />";
    if($nickname == "")
        $errors .= "Введите логин <br />";
    if($errors != ""){
        include_once "html.php";
        echo "<span style='color: red'>".$errors."</span>";
        echo "<form action='authorization.php' method='post' class=\"reg_form\">".
            "<label for=\"nickname\">Логин</label><input type=\"text\" id=\"nickname\" name=\"nickname\" value='$nickname' placeholder=\"Имя пользователя\"><br>".
            "<label for=\"password\">Пароль</label><input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Пароль\"><br>".
            "<input type='submit' class='buttons' name='log' value='Вход'>".
            "</form>";
    }
    else {
        $success = $mysqli->query("SELECT * FROM `Users` WHERE nickname = '$nickname' AND password = MD5('$password')");
        $arr = mysqli_fetch_array($success);
        include_once "html.php";
        if($arr == null){
            $errors = "<span style='color: red'>Неверный логин или пароль.</span><br />";
            echo $errors;
            echo "<form action='authorization.php' method='post' class=\"reg_form\">".
                "<label for=\"nickname\">Логин</label><input type=\"text\" id=\"nickname\" name=\"nickname\" value='$nickname' placeholder=\"Имя пользователя\"><br>".
                "<label for=\"password\">Пароль</label><input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Пароль\"><br>".
                "<input type='submit' class='buttons' name='log' value='Вход'>".
                "</form>";
        }else{
            if($arr['admin'] == 1){
                echo "Вы вошли как админ , перейдите в <a href='adminOffice.php' class='links'>Кабинет админа</a> для начала работы.";
                $_SESSION['admin'] = $arr['admin'];
            }
            else{
                echo "Вы вошли под именем ".$arr['nickname'].", перейдите в <a href='office.php' class='links'>Личный кабинет</a> для начала работы.";
                $_SESSION['id'] = $arr['id'];
            }
        }
    }
}