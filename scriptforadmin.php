<?php
include_once "config.php";
$mysqli = new mysqli($config['host'], $config['username'], $config['passwd'], $config['dbname']);
$mysqli->query("SET NAMES 'utf8'");
if($_POST['changeRecord']){
    $text = $_POST['text'];
    $rec_id = $_POST['rec_id'];
    $query = "UPDATE `Records` SET `text`= '$text' WHERE `rec_id` = $rec_id";
    $success = $mysqli->query($query);
}
if($_POST['rec_id']){
    $rec_id = $_POST['rec_id'];
    if(is_int($rec_id)){
        $query = "DELETE FROM `Records` WHERE rec_id = $rec_id";
        $success = $mysqli->query($query);
        echo "delete";
    }
    elseif (is_string($rec_id)){
        $rec_id = (int)$rec_id;
        $query = "SELECT `text` FROM `Records` WHERE rec_id = $rec_id";
        $success = $mysqli->query($query);
        $result = mysqli_fetch_array($success);
        $result = json_encode($result);
        echo $result;
    }
}
