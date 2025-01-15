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

$stmt = $db->prepare("SELECT * FROM `oblacik_users` WHERE `$search` = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$result = $result->fetch_all(MYSQLI_ASSOC);

if ($result->num_rows == 0){
    header('Location: index.php?page=log');
}

foreach ($result as $row) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['user'] = $row['name'];
        $_SESSION['id'] = $row['ID'];
        $_SESSION['admin'] = $row['privilege'];
        $_SESSION['error_code'] = "Login successful";
        header('Location: index.php');
        exit();
    }
}

$_SESSION['error_code'] = "Invalid username or password";
header('Location: index.php?page=log');
?>
