<?php
require 'libs/Smarty.class.php';  //framework
require 'dbconnect.php';  //db_connection
session_start();

$smarty = new \Smarty\Smarty;

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    $_SESSION['upld-code'] = 3;
    exit();
}

$target_dir = $_POST['dir'];
$fileName = $_POST['filename'];
$chunks = $_POST['chunks'];
$chunk = $_POST['chunkIndex'];

$target_file = $target_dir . basename($fileName);

// Check if file already exists
// if (file_exists($target_file)) {
//     $_SESSION['upld-code'] = 2;
//     $_SESSION['upld-data'] = $_POST;
//     header('Location: index.php?page=upld');
//     exit();
// }

// Save the chunk
$chunkFile = $target_file . '.part' . $chunk;
if (!move_uploaded_file($_FILES['file']['tmp_name'], $chunkFile)) {
    echo json_encode(array('status' => 'Error uploading chunk'));
    exit();
}


echo json_encode(array('status' => "$chunk of $chunks"));
?>
