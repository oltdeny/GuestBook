<?php
include_once "html.php";
echo "</br>"."Вы вошли в кабинет Админа"."</br>".
    "Что вы хотите сделать?"."</br>";
echo "<form action='office.php' method='post' class=\"reg_form\">".
    "<input type='submit' class='buttons' name='output' value='Выход'>".
    "</form>";
?>
<div id="append">

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="http://test1.learning.dev1.msoft.su/GuestBook/scripts/script.js"></script>
<?php
include_once "outputForAdmin.php";
?>

