<?php
require 'libs/Smarty.class.php';  //framework
require 'dbconnect.php';  //db_connection

$smarty = new \Smarty\Smarty;

session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $user = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $admin = isset($_POST['privilege']) ? 1 : 0;

    //whem changing password as well
    if($password != '') {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE `oblacik_users` SET `name` = ?, `password` = ?, `email` = ?, `privilege` = ? WHERE `user_ID` = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('sssii', $user, $password, $email, $admin, $id);
        $stmt->execute();
        header('Location: admin.php');
    }
    
    //if password is not changed
    $sql = "UPDATE `oblacik_users` SET `name` = ?, `email` = ?, `privilege` = ? WHERE `user_ID` = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ssii', $user, $email, $admin, $id);
    $stmt->execute();

    header('Location: admin.php');
}
?>