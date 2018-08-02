<?php
session_start();
if(isset($_POST['output'])){
    unset ($_SESSION['id']);
    unset ($_SESSION['admin']);
    header("Location: index.php");
    exit();
}
include_once "config.php";
include_once "html.php";
$mysqli = new mysqli($config['host'], $config['username'], $config['passwd'], $config['dbname']);
$mysqli->query("SET NAMES 'utf8'");
if(isset($_POST['input'])){
    echo "<form action='authorization.php' method='post' class=\"reg_form\">".
        "<label for=\"nickname\">Логин</label><input type=\"text\" id=\"nickname\" name=\"nickname\" placeholder=\"Имя пользователя\"><br>".
        "<label for=\"password\">Пароль</label><input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Пароль\"><br>".
        "<input type='submit' class='buttons' name='log' value='Вход'>".
        "</form>";
}
elseif(isset($_POST['registration'])){
    echo "<form action='registration.php' method='post' class=\"reg_form\">".
        "<label for=\"nickname\">Логин</label><input type=\"text\" id=\"nickname\" name=\"nickname\" placeholder=\"Имя пользователя\"><br>".
        "<label for=\"password\">Пароль</label><input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Пароль\"><br>".
        "<label for=\"password2\">Пароль</label><input type=\"password\" id=\"password2\" name=\"password2\" placeholder=\"Пароль повторно\"><br>".
        "<input type='submit' class='buttons' name='reg' value='Регистрация'>".
        "</form>";
}
elseif (isset($_POST['anon_entry'])){
    echo "<form action='addRecord.php' method='post' class=\"reg_form\">".
        "<label for=\"record\">Оставить запись:</label><textarea id=\"record\" class='matrix' name=\"record\" placeholder=\"Ваше сообщение:\"></textarea><br>".
        "<input type='text' name='name' placeholder='Как вас зовут?'>".
        "<input type='submit' class='buttons' name='send_anon' value='Отправить'>".
        "</form>";
}
elseif($_SESSION['id']){
    $id = $_SESSION['id'];
    $success = $mysqli->query("SELECT * FROM `Users` WHERE id = '$id'");
    $arr = mysqli_fetch_array($success);
    echo "Вы вошли в личный кабинет под именем ".$arr['nickname']."\n".
        "Что вы хотите сделать?".
        "<form action='addRecord.php' method='post' class=\"reg_form\">".
        "<label for=\"record\">Оставить запись:</label><textarea id=\"record\" class='matrix' name=\"record\" placeholder=\"Ваше сообщение:\"></textarea><br>".
        "<input type='submit' class='buttons' name='send' value='Отправить'>".
        "</form>";
    echo "<form action='office.php' method='post' class=\"reg_form\">".
        "<input type='submit' class='buttons' name='output' value='Выход'>".
        "</form>";
}
else {
    echo "Вы не авторизованы. Выполните вход, или зарегистрируйтесь, чтобы оставить запись от своего имени. Или же оставьте анонимную запись.";
    echo "<form action='' method=\"post\" class=\"reg_form\">".
        "<input type=\"submit\" class=\"buttons\" name=\"input\" value=\"Авторизация\">".
        "<input type=\"submit\" class=\"buttons\" name=\"registration\" value=\"Регистрация\">".
        "<input type=\"submit\" class=\"buttons\" name=\"anon_entry\" title=\"Оставить запись анонимно\" value=\"Анонимная запись\">".
        "</form>";
}