<?php
require 'libs/Smarty.class.php';  //framework
require 'dbconnect.php';  //db_connection

$smarty = new \Smarty\Smarty;

session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: index.php');
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$start = ($page) * $limit;

$sql = "SELECT * FROM `oblacik_users` LIMIT $start, $limit";
$result = $db->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(*) as count FROM `oblacik_users`";
$result = $db->query($sql);
$num_users = $result->fetch_row()[0];
$pages = ceil($num_users / $limit);

$smarty->assign('users', $users);  //all users
$smarty->assign('pages', $pages);  //total number of pages
$smarty->assign('page', $page);    //current page

$smarty->display('admin-panel.tpl');
?>