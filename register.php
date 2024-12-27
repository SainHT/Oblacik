<?php
require 'libs/Smarty.class.php';  //framework
require 'dbconnect.php';  //db_connection

$smarty = new \Smarty\Smarty;

session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$r_password = $_POST['r_password'];
$password = password_hash($password, PASSWORD_BCRYPT);
$r_password = password_hash($r_password, PASSWORD_BCRYPT);
$email = $_POST['email'];

if ($password == $r_password) {
    $sql = "INSERT INTO `users` (`username`, `password`, `email`) VALUES ('$username', '$password', '$email')";
    $result = $conn->query($sql);
    if ($result) {
        $smarty->assign('message', 'Registration successful');
    } else {
        $smarty->assign('message', 'Registration failed');
    }
} else {
    $smarty->assign('message', 'Passwords do not match');
}

header('Location: index.php?page=log');
?>