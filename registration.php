<?php
session_start();
include_once "config.php";
$mysqli = new mysqli($config['host'], $config['username'], $config['passwd'], $config['dbname']);
$mysqli->query("SET NAMES 'utf8'");
if($_POST['reg']){
    $nickname = htmlspecialchars($_POST['nickname']);
    $password = htmlspecialchars($_POST['password']);
    $password2 = htmlspecialchars($_POST['password2']);
    $errors = "";
    if($password == "")
        $errors .= "Введите пароль <br />";
    if($nickname == "")
        $errors .= "Введите логин <br />";
    if($password != $password2)
        $errors .= "Пароли не совпадают <br />";
    if($errors != ""){
        include_once "html.php";
        echo "<span style='color: red'>".$errors."</span>";
        echo "<form action='registration.php' method='post' class=\"reg_form\">".
            "<label for=\"nickname\">Логин</label><input type=\"text\" id=\"nickname\" name=\"nickname\" value='$nickname' placeholder=\"Имя пользователя\"><br>".
            "<label for=\"password\">Пароль</label><input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Пароль\"><br>".
            "<label for=\"password2\">Пароль</label><input type=\"password\" id=\"password2\" name=\"password2\" placeholder=\"Пароль повторно\"><br>".
            "<input type='submit' class='buttons' name='reg' value='Регистрация'>".
            "</form>";
    }
    else {
        $success = $mysqli->query("INSERT INTO `Users` (`nickname`, `password`) VALUES ('$nickname', md5($password))");
        include_once "html.php";
        if(!$success){
            $errors = "Пользователь с таким ником уже существует. <br />";
            echo "<span style='color: red'>".$errors."</span>";
            echo "<form action='registration.php' method='post' class=\"reg_form\">".
                "<label for=\"nickname\">Логин</label><input type=\"text\" id=\"nickname\" name=\"nickname\" value='$nickname' placeholder=\"Имя пользователя\"><br>".
                "<label for=\"password\">Пароль</label><input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Пароль\"><br>".
                "<label for=\"password2\">Пароль</label><input type=\"password\" id=\"password2\" name=\"password2\" placeholder=\"Пароль повторно\"><br>".
                "<input type='submit' class='buttons' name='reg' value='Регистрация'>".
                "</form>";
        }else{
            $success = $mysqli->query("SELECT * FROM `Users` WHERE nickname = '$nickname' AND password = MD5('$password')");
            $arr = mysqli_fetch_array($success);
            $_SESSION['id'] = $arr['id'];
            echo "Поздравляю! Вы зарегистрированы! Войдите в <a href='office.php' class='links'>Личный кабинет</a>, чтобы начать работу.";
        }
    }
}