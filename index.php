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

//error codes
$error_code = isset($_SESSION['error_code']) ? $_SESSION['error_code'] : NULL;
if ($error_code != NULL) {
    $smarty->assign('urgency', strpos($error_code, 'success') !== false);
    $smarty->assign('error_msg', $error_code);
    $_SESSION['error_code'] = NULL;
} 

//page
$page = isset($_GET['page']) ? $_GET['page'] : 'index';
$pages = array(
    'reg' => 'register.tpl',
    'log' => 'login.tpl',
    'upld' => 'upload.tpl',
    'books' => 'book_filetype.tpl',
    'photos' => 'book_filetype.tpl',
    'others' => 'book_filetype.tpl',
    'movies' => 'movie_filetype.tpl',
);

if (array_key_exists($page, $pages)) {
    $smarty->display($pages[$page]);
} else {
    $file_categories = array(
        'books' => 'books',
        'movies' => 'movies',
        'photos' => 'photos',
        'others' => 'others',
    );

    foreach ($file_categories as $category) {
        $stmt = $db->prepare('SELECT * FROM `oblacik_' . $category . '` ORDER BY `ID` DESC LIMIT 13');
        $stmt->execute();
        $result = $stmt->get_result();
        $files = $result->fetch_all(MYSQLI_ASSOC);
        $file_categories[$category] = $files;
    }


    $smarty->assign('default_img', 'https://img.freepik.com/premium-photo/purple-background-with-purple-background-that-says-purple_517312-43531.jpg');
    $smarty->assign('categories', $file_categories);

    $smarty->display('index.tpl');
}

//admin panel
// $smarty->configLoad('db.conf', 'AdminPanel');
// $admin_conf = $smarty->getConfigVars('admin');
// $getter = $smarty->getConfigVars('getter');

// $admin = isset($_GET[$admin_conf]) ? $_GET[$admin_conf] : '';
// if ($admin == $getter && $_SESSION['admin'] == 1 && $logged != NULL) {
//     header('Location: admin.php');
// }

?>
