<?php
require 'libs/Smarty.class.php';  // framework
require 'dbconnect.php';  // db_connection
session_start();

$smarty = new \Smarty\Smarty;

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(array('msg' => 'User not logged in'));
    exit();
}

try {
    $upload_ID = intval($_POST['id']);
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
} catch (Exception $e) {
    $_SESSION['error_code'] = 'item could not be favourited. Please try again later.';
    echo json_encode(array('upld-code' => 1, 'msg' => $e->getMessage()));
    exit();
}

exit();
?>
