<?php
include("connToDataBase.php");
header("Content-Type:application/json");
$db = new MyDataBase();
$db->getAllStudents();
?>