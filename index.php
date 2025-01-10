<?php
require 'libs/Smarty.class.php';  // framework
require 'dbconnect.php';  // db_connection
session_start();

$smarty = new \Smarty\Smarty;

$smarty->debugging = false;
$smarty->caching = false;

//logging
$logged = isset($_SESSION['id']) ? $_SESSION['id'] : NULL;
if ($logged == NULL) {
    $smarty->assign('logged', false);
} 
else {
    $smarty->assign('logged', true);
    $smarty->assign('user', $_SESSION['user']);
    $smarty->assign('admin', $_SESSION['admin'] == 1 ? true : false);
}

//register
$reg_code = isset($_SESSION['reg-code']) ? $_SESSION['reg-code'] : NULL;
$reg_msg = array(
    0 => 'Registration successful',
    1 => 'Registration failed',
    2 => 'Email already in use',
    3 => 'Passwords do not match'
);

if(array_key_exists($reg_code, $reg_msg)) {
    $smarty->assign('reg_message', $reg_msg[$reg_code]);
} 
else {
    $smarty->assign('reg_message', '');
}

//upload
$code = isset($_SESSION['upld-code']) ? $_SESSION['upld-code'] : NULL;
$code_msg = array(
    0 => 'File upload successfully',
    1 => 'File uploaded failed',
    2 => 'File already exists',
    3 => 'User not logged in',
);

if(array_key_exists($code, $code_msg)) {
    $smarty->assign('message', $code_msg[$code]);
    if ($code == 0) {
        $smarty->assign('data', $_SESSION["upld-data"]);
    }
    $_SESSION['upld-code'] = NULL;
} 
else {
    $smarty->assign('message', '');
}

//page
$page = isset($_GET['page']) ? $_GET['page'] : 'index';
$pages = array(
    'reg' => 'register.tpl',
    'log' => 'login.tpl',
    'upld' => 'upload.tpl',
    'book' => 'book_filetype.tpl',
    'movie' => 'movie_filetype.tpl',
);

if (array_key_exists($page, $pages)) {
    $smarty->display($pages[$page]);
} else {
    //books
    $stmt = $db->prepare('SELECT * FROM `oblacik_books` ORDER BY `book_ID` DESC LIMIT 13');
    $stmt->execute();
    $result = $stmt->get_result();
    $books = $result->fetch_all(MYSQLI_ASSOC);
    $smarty->assign('books', $books);

    //movies
    $stmt = $db->prepare('SELECT * FROM `oblacik_movies` ORDER BY `movie_ID` DESC LIMIT 13');
    $stmt->execute();
    $result = $stmt->get_result();
    $movies = $result->fetch_all(MYSQLI_ASSOC);
    $smarty->assign('movies', $movies);

    //photos
    $stmt = $db->prepare('SELECT * FROM `oblacik_photos` ORDER BY `photo_ID` DESC LIMIT 13');
    $stmt->execute();
    $result = $stmt->get_result();
    $photos = $result->fetch_all(MYSQLI_ASSOC);
    $smarty->assign('photos', $photos);

    //other
    $stmt = $db->prepare('SELECT * FROM `oblacik_others` ORDER BY `other_ID` DESC LIMIT 13');
    $stmt->execute();
    $result = $stmt->get_result();
    $other = $result->fetch_all(MYSQLI_ASSOC);
    $smarty->assign('other', $other);

    $smarty->display('index.tpl');
}

//admin panel
$smarty->configLoad('db.conf', 'AdminPanel');
$admin_conf = $smarty->getConfigVars('admin');
$getter = $smarty->getConfigVars('getter');

$admin = isset($_GET[$admin_conf]) ? $_GET[$admin_conf] : '';
if ($admin == $getter && $_SESSION['admin'] == 1 && $logged != NULL) {
    header('Location: admin.php');
}