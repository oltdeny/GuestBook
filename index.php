<?php
    session_start();
    include_once "html.php";
    if($_SESSION['admin']){
        echo "<a href='AdminOffice.php' class='links'>Кабинет админа</a>";
        include_once "output.php";
    }
    elseif($_SESSION['id']){
        echo "<a href='office.php' class='links'>Личный кабинет</a>";
        include_once "output.php";
    }
    else{
        echo "<a href='office.php' class='links'>Возможные действия</a>";
        include_once "output.php";
    }