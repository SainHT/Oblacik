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

// Check if the user is already logged in
if (isset($_SESSION['user'])) {
    $_SESSION['error_code'] = "You are already logged in";
    header('Location: index.php?page=reg');
    exit();
}

// Check if the user has entered all the required fields correctly
if (strlen($password) < 8 || strlen($r_password) < 8) {
    $_SESSION['error_code'] = "Password must be at least 8 characters long";
    header('Location: index.php?page=reg');
    exit();
}

if (strlen($username) < 4) {
    $_SESSION['error_code'] = "Username must be at least 4 characters long";
    header('Location: index.php?page=reg');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error_code'] = "Invalid email address";
    header('Location: index.php?page=reg');
    exit();
}

// Check if the passwords match
if (password_verify($r_password, $password)) {
    $email_check_sql = "SELECT * FROM `oblacik_users` WHERE `email` = ?";
    $stmt = $db->prepare($email_check_sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $email_check_result = $stmt->get_result();

    if ($email_check_result->num_rows > 0) {
        $_SESSION['error_code'] = "Email already in use";
        header('Location: index.php?page=reg');
        exit();
    }

    $sql = "INSERT INTO `oblacik_users` (`name`, `password`, `email`) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('sss', $username, $password, $email);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['error_code'] = "Registration successful";
    } else {
        $_SESSION['error_code'] = "Registration failed. Please try again later.";
    }
    
} else {
    $_SESSION['error_code'] = "Passwords do not match";
}


//automatically log in the user after registration if successful
if ($_SESSION['error_code'] == "Registration successful") {
    $sql = "SELECT * FROM `oblacik_users` WHERE `email` = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach ($result as $row) {
        $_SESSION['user'] = $row['name'];
        $_SESSION['id'] = $row['id'];
    }
    header('Location: index.php?page=log');
    exit();
} else {
    header('Location: index.php?page=reg');
    exit();
}
