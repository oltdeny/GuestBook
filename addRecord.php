<?php
session_start();
include_once "config.php";
$mysqli = new mysqli($config['host'], $config['username'], $config['passwd'], $config['dbname']);
$mysqli->query("SET NAMES 'utf8'");
if($_POST['send']){
    $record = htmlspecialchars($_POST['record']);
    $errors = "";
    if($record == ""){
        $errors .= "<span style='color: red'>Введите сообщение, прежде чем отправить.</span><br />";
    }
    if($errors != ""){
        include_once "office.php";
        echo $errors;
    }
    else{
        $id = $_SESSION['id'];
        $success = $mysqli->query("SELECT `nickname` FROM `Users` WHERE id = '$id'");
        $arr = mysqli_fetch_array($success);
        $nickname = $arr['nickname'];
        $success = $mysqli->query("INSERT INTO `Records` (`text`, `user_name`, `user_id`) VALUES ('$record', '$nickname', '$id')");
        include_once "office.php";
        if(!$success){
            echo "Ошибка при добавлении записи.";
        }else{
            echo "Поздравляю! Вы добавили запись!";
        }
    }
}
if($_POST['send_anon']){
    $record = htmlspecialchars($_POST['record']);
    $nickname = htmlspecialchars($_POST['name']);
    $errors = "";
    if($record == ""){
        $errors .= "<span style='color: red'>Введите сообщение, прежде чем отправить.</span><br />";
    }
    if($errors != ""){
        include_once "office.php";
        echo $errors;
    }
    else{
        $nickname .= "(аноним)";
        $success = $mysqli->query("INSERT INTO `Records` (`text`, `user_name`) VALUES ('$record', '$nickname')");
        include_once "office.php";
        if(!$success){
            echo "Ошибка при добавлении записи.";
        }else{
            echo "Поздравляю! Вы добавили запись!";
        }
    }
}
