<?php
require 'libs/Smarty.class.php';  //framework
require 'dbconnect.php';  //db_connection

$smarty = new \Smarty\Smarty;

session_start();
$show = $_SESSION['show'];
$keys = array_keys($_SESSION['update-keys']);
$user = $_SESSION['update-keys'];

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try{
        foreach ($keys as $key) {
            //hash password
            if ($key == 'password' && $user[$key] != '') {
                $user[$key] = password_hash($user[$key], PASSWORD_DEFAULT);
                continue;
            } 
            else if ($key == 'privilege') {
                $user[$key] = isset($_POST[$key]) ? 1 : 0;
                continue;
            }
    
            $user[$key] = isset($_POST[$key]) ? $_POST[$key] : $user[$key];
        }
    
        $sql = "UPDATE `$show` SET ";
        $params = [];
        foreach ($keys as $key) {
            if ($key != 'ID') {
                $sql .= "`$key` = ?, ";
                $params[] = $user[$key];
            }
        }
        $sql = rtrim($sql, ', ') . " WHERE `ID` = ?";
        $params[] = $_POST['ID'];
        
        $stmt = $db->prepare($sql);
        $types = str_repeat('s', count($params) - 1) . 'i';
        if ($show == 'oblacik_users') {
            $types = str_repeat('s', count($params) - 3) . 'isi'; // privilege is second to last and between them is string
        }
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();
        $_SESSION['error_code'] = 'item updated successfully';
    }
    catch (Exception $e) {
        $_SESSION['error_code'] = 'item could not be updated. Please try again later.';
        header('Location: admin.php?page=' . substr($show, 8));
        exit();
    }
}
else {
    $_SESSION['error_code'] = 'item could not be updated. Please try again later.';
}
header('Location: admin.php?page=' . substr($show, 8));
exit();
?>
