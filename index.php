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
    'shelf' => 'shelf.tpl',
    'books' => 'show.tpl',
    'photos' => 'show.tpl',
    'others' => 'show.tpl',
    'movies' => 'show.tpl',
);

$smarty->assign('default_img', 'https://img.freepik.com/premium-photo/purple-background-with-purple-background-that-says-purple_517312-43531.jpg');

$file_categories = array(
    'books' => 'books',
    'movies' => 'movies',
    'photos' => 'photos',
    'others' => 'others',
);

//get favourites
$stmt = $db->prepare('SELECT * FROM `oblacik_favourites` WHERE `user_id` = ?');
$stmt->bind_param('i', $logged);
$stmt->execute();
$result = $stmt->get_result();
$favourites = $result->fetch_all(MYSQLI_ASSOC);
$favourites = array_column($favourites, 'upload_ID');
$smarty->assign('favourites', $favourites);

if (array_key_exists($page, $pages)) {
    $smarty->assign('categories', $file_categories);
    if($page == 'shelf'){
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $smarty->assign('type', $type);
    
        $stmt = $db->prepare('SELECT * FROM `oblacik_' . $type . '` ORDER BY `ID` DESC');
        $stmt->execute();
        $result = $stmt->get_result();
        $files = $result->fetch_all(MYSQLI_ASSOC);

        $file_categories[$type] = $files;
        $smarty->assign('categories', $file_categories);
    }
    elseif ($page == 'books' || $page == 'photos' || $page == 'others' || $page == 'movies') {
        $desired_ID = isset($_GET['id']) ? $_GET['id'] : null;
        if ($desired_ID == null) {
            header('Location: index.php');
        }

        $stmt = $db->prepare('SELECT * FROM `oblacik_' . $file_categories[$page] . '` WHERE `ID` = ?');
        $stmt->bind_param('i', $desired_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $files = $result->fetch_all(MYSQLI_ASSOC);
        $file_type = mime_content_type($files[0]['source_address']);
        $file_type_short = explode('/', $file_type)[0];

        if (count($files) == 0) {
            header('Location: index.php');
        }
        
        $smarty->assign('file_type', $file_type);
        $smarty->assign('file_type_short', $file_type_short);
        $smarty->assign('file', $files[0]);
    }
    
    $smarty->display($pages[$page]);
    
} else {
    foreach ($file_categories as $category) {
        $stmt = $db->prepare('SELECT * FROM `oblacik_' . $category . '` ORDER BY `ID` DESC LIMIT 13');
        $stmt->execute();
        $result = $stmt->get_result();
        $files = $result->fetch_all(MYSQLI_ASSOC);
        $file_categories[$category] = $files;
    }

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
