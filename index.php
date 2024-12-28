<?php
require 'libs/Smarty.class.php';  # framework
require 'dbconnect.php';  # db_connection
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
    2 => 'File already exists'
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
    'upld' => 'upload.tpl'
);

if (array_key_exists($page, $pages)) {
    $smarty->display($pages[$page]);
} else {
    $smarty->display('index.tpl');
}
