<?php
require 'libs/Smarty.class.php';  // framework
require 'dbconnect.php';  // db_connection
session_start();

$smarty = new \Smarty\Smarty;

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    $_SESSION['upld-code'] = 3;
    exit();
}

$upload_ID = $_GET['id'];  // might need to change this to POST
$user_ID = $_SESSION['id'];

// Check if the user has already favourited the upload
$stmt = $db->prepare("SELECT * FROM `oblacik_favourites` WHERE `upload_ID` = ? AND `user_ID` = ?");
$stmt->bind_param("ii", $upload_ID, $user_ID);
$stmt->execute();
$result = $stmt->get_result();
$favourites = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// if the user has already favourited the upload, remove it from favourites otherwise add it
if (count($favourites) > 0) {
    $stmt = $db->prepare("DELETE FROM `oblacik_favourites` WHERE `upload_ID` = ? AND `user_ID` = ?");
} else {
    $stmt = $db->prepare("INSERT INTO `oblacik_favourites` (`upload_ID`, `user_ID`) VALUES (?, ?)");
}

$stmt->bind_param("ii", $upload_ID, $user_ID);
$stmt->execute();
$stmt->close();

header('Location: index.php'); //change this to redirect to the same page
?>
