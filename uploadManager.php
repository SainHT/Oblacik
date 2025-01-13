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

$fileName = $_POST['file'];
$thumbnailName = $_POST['thumbnail'];
$title = $_POST['title'];
$description = $_POST['description'];

//bind the chunks together of the file
$target_file = "files/" . basename($fileName);
$fp = fopen($target_file, 'w');
for ($i = 0; $i < $chunks; $i++) {
    $chunkFile = $target_file . '.part' . $i;
    $chunk = file_get_contents($chunkFile);
    fwrite($fp, $chunk);
    unlink($chunkFile);
}
fclose($fp);

//bind the chunks together of the thumbnail
$thumbnailType = mime_content_type($thumbnailName);
if (!preg_match('/^image\//', $thumbnailType)) {
    $_SESSION['upld-code'] = 4;
    exit();
}

$thumbnail_file = "assets/img/thumbnails/" . basename($thumbnailName);
$fp = fopen($thumbnail_file, 'w');
for ($i = 0; $i < $chunks; $i++) {
    $chunkFile = $thumbnail_file . '.part' . $i;
    $chunk = file_get_contents($chunkFile);
    fwrite($fp, $chunk);
    unlink($chunkFile);
}
fclose($fp);


//determine the table based on the file type
$fileType = mime_content_type($fileName);
switch ($fileType) {
    case (preg_match('/^image\//', $fileType) ? true : false):
        $table = 'oblacik_photos';
        break;
    case 'application/pdf':
    case 'application/msword':
        $table = 'oblacik_books';
        break;
    case (preg_match('/^video\//', $fileType) ? true : false):
        $table = 'oblacik_movies';
        break;
    default:
        $table = 'oblacik_others';
        break;
}

//Insert the file into uploads table
$stmt = $db->prepare("INSERT INTO `oblacik_uploads` (`user_ID`) VALUES (?)");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$upload_id = $stmt->insert_id;
$stmt->close();

// Insert the file into the database
$stmt = $db->prepare("INSERT INTO `$table` (`upload_ID`, `name`, `description`, `source_address`, `thumbnail`) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $upload_id, $title, $description, $target_file, $thumbnailName);
$stmt->execute();
$stmt->close();

$_SESSION['upld-code'] = 0;
?>
