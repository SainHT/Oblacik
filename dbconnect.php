<?php
require 'libs/Smarty.class.php';
$smarty = new \Smarty\Smarty;

$smarty -> configLoad('db.conf');
$db_host = $smarty -> getConfigVars('host');
$db_name = $smarty -> getConfigVars('name');
$db_user = $smarty -> getConfigVars('user');
$db_pass = $smarty -> getConfigVars('pass');

$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$db) {
    die('Could not connect: ' . mysqli_connect_error());
}
?>