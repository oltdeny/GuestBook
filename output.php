<?php
include_once "config.php";
if(isset($_GET['page'])){
    $page = $_GET['page']-1;
}
else{
    $page = 0;
}
$start = abs($page*$paginate_param);
$mysqli = new mysqli($config['host'], $config['username'], $config['passwd'], $config['dbname']);
$mysqli->query("SET NAMES 'utf8'");
$result = $mysqli->query("SELECT * FROM `Records` ORDER BY `rec_id` DESC LIMIT $start, $paginate_param");
echo "<table>";
echo "<tr>";
echo "<td>"."№ Записи"."</td>"."<td>"."Имя пользователя"."</td>"."<td>"."Текст записи"."</td>"."<td>"."ID записи"."</td>"."<td>"."ID пользователя"."</td>";
echo "</tr>";
while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>".++$start."</td>"."<td>".$row['user_name']."</td>"."<td>".$row['text']."</td>"."<td>".$row['rec_id']."</td>"."<td>".$row['user_id']."</td>";
    echo "</tr>";
}
echo "</table>";
$result = $mysqli->query("SELECT COUNT(*) FROM `Records`");
$arr = mysqli_fetch_array($result);
$count = $arr['COUNT(*)'];
$pageCount = ceil($count/$paginate_param);
echo "Страницы: ";
for($i = 1; $i <= $pageCount; $i++){
    if($i-1 == $page) {
        echo $i." ";
    }
    else{
        echo '<a class = "links" href="'.$_SERVER['PHP_SELF'].'?page='.$i.'">'.$i." "."</a>";
    }
}