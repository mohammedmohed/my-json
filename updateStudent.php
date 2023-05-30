<?php
include("connToDataBase.php");
header("Content-Type:application/json");
$db = new MyDataBase();
$check = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $age = $_POST["age"];
    $phone = $_POST["phone"];
    $gender = $_POST["gender"];

    if (!preg_match("/^[a-z]/i", $name)) {
        $check = false;
    }
    if (!preg_match("/^[0-9]+$/", $age)) {
        $check = false;
    } elseif (strlen($age) > 3 || $age < 0 || $age > 120) {
        $check = false;
    }
    if (!preg_match("/^[0-9]+$/", $phone)) {
        $check = false;
    }

    if ($check) {
        if ($gender == "male" || $gender == "female") {
            $db->updateStudents($id, $name, $age, $phone, $gender);
        } else {
            $check = false;
        }
    }
}

?>