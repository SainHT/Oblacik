<?php
require 'libs/Smarty.class.php';  //framework
require 'dbconnect.php';  //db_connection

$smarty = new \Smarty\Smarty;

session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: index.php');
}

//error codes
$error_code = isset($_SESSION['error_code']) ? $_SESSION['error_code'] : NULL;
if ($error_code != NULL) {
    $smarty->assign('urgency', strpos($error_code, 'success') !== false);
    $smarty->assign('error_msg', $error_code);
    $_SESSION['error_code'] = NULL;
} 

$page = isset($_GET['page']) ? $_GET['page'] : 'users';
$pages = array(
    'users'  => 'oblacik_users',
    'books'  => 'oblacik_books',
    'movies' => 'oblacik_movies',
    'photos' => 'oblacik_photos',
    'others' => 'oblacik_others',
);

$show = isset($pages[$page]) ? $pages[$page] : 'oblacik_users';
$_SESSION['show'] = $show;

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 0;
$start = ($page) * $limit;

$stmt = $db->prepare("SELECT * FROM `$show` LIMIT ?, ?");
$stmt->bind_param("ii", $start, $limit);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$_SESSION['update-keys'] = $users[0];

$num_users = count($users);
$pages = ceil($num_users / $limit);

$smarty->assign('users', $users);  //all users
$smarty->assign('pages', $pages);  //total number of pages
$smarty->assign('page', $page);    //current page

//files
$file_categories = array(
    'books' => 'books',
    'movies' => 'movies',
    'photos' => 'photos',
    'others' => 'others',
);

$smarty->assign('categories', $file_categories);

$smarty->display('admin-panel.tpl');
?>