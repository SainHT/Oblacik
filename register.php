<?php
require 'libs/Smarty.class.php';  //framework
require 'dbconnect.php';  //db_connection

$smarty = new \Smarty\Smarty;

session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$r_password = $_POST['r_password'];
$password = password_hash($password, PASSWORD_DEFAULT);

$email = $_POST['email'];

if (password_verify($r_password, $password)) {

    $email_check_sql = "SELECT * FROM `oblacik_users` WHERE `email` = '$email'";
    $email_check_result = $db->query($email_check_sql);
    if ($email_check_result->num_rows > 0) {
        $_SESSION['reg-code'] = 2;
        header('Location: index.php?page=reg');
        exit();
    }

    $sql = "INSERT INTO `oblacik_users` (`name`, `password`, `email`) VALUES ('$username', '$password', '$email')";
    $result = $db->query($sql);
    if ($result) {
        $_SESSION['reg-code'] = 0;
    } else {
        $_SESSION['reg-code'] = 1;
    }
} else {
    $_SESSION['reg-code'] = 3;
}

if ($_SESSION['reg-code'] == 0) {
    $sql = "SELECT * FROM `oblacik_users` WHERE `email` = '$email'";
    $result = $db->query($sql);
    foreach ($result as $row) {
        $_SESSION['user'] = $row['name'];
        $_SESSION['id'] = $row['id'];
    }
    header('Location: index.php?page=log');
    exit();
}
else {
    header('Location: index.php?page=reg');
    exit();
}
?>

//Stormblessed -> KnightsRadiant