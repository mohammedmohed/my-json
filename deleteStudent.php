<?php
include("connToDataBase.php");
header("Content-Type:application/json");
$db = new MyDataBase();
if(isset($_GET['id'])){
    $db->deleteStudentById($_GET['id']);
}

?>