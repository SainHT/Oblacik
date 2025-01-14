<?php
require 'libs/Smarty.class.php';  //framework
require 'dbconnect.php';  //db_connection

$smarty = new \Smarty\Smarty;

session_start();
$username = $_POST['username'];
$password = $_POST['password'];

if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
    $search = "email";
} else {
    $search = "name";
}

$sql = "SELECT * FROM `oblacik_users` WHERE `$search` = '$username'";
$result = $db->query($sql);

if ($result->num_rows == 0){
    header('Location: index.php?page=log');
}

foreach ($result as $row) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['user'] = $row['name'];
        $_SESSION['id'] = $row['ID'];
        $_SESSION['admin'] = $row['privilege'];
        header('Location: index.php');
    } else {
        header('Location: index.php?page=log');
    }
}

?>
