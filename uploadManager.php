<?php
require 'libs/Smarty.class.php';  //framework
require 'dbconnect.php';  //db_connection
session_start();

$smarty = new \Smarty\Smarty;

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(array('msg' => 'User not logged in'));
    exit();
}

$fileName = $_POST['file'];
$thumbnailName = $_POST['thumbnail'];
$title = $_POST['title'];
$description = $_POST['description'];

//bind the chunks together of the file
$chunks = $_POST['file_chunks'];
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
$thumbnail_file = "assets/img/thumbnails/" . basename($thumbnailName);

$chunks = $_POST['thumbnail_chunks'];
$fp = fopen($thumbnail_file, 'w');
for ($i = 0; $i < $chunks; $i++) {
    $chunkFile = $thumbnail_file . '.part' . $i;
    $chunk = file_get_contents($chunkFile);
    fwrite($fp, $chunk);
    unlink($chunkFile);
}
fclose($fp);

//thumbnail has to be an image
if (!getimagesize($thumbnail_file)) {
    $_SESSION['error_code'] = 'Thumbnail is not an image';
    echo json_encode(array('msg' => 'Thumbnail is not an image'));
    unlink($thumbnail_file);
    exit();
}


//determine the table based on the file type
$fileType = mime_content_type($target_file);
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

// Rename the thumbnail file to include the upload ID
$thumbnail_extension = pathinfo($thumbnail_file, PATHINFO_EXTENSION);
$new_thumbnail_file = "assets/img/thumbnails/" . $upload_id . '-thumbnail.' . $thumbnail_extension;
rename($thumbnail_file, $new_thumbnail_file);
$thumbnailName = $new_thumbnail_file;
$thumbnailName = basename($new_thumbnail_file);

// Insert the file into the database
$stmt = $db->prepare("INSERT INTO `$table` (`upload_ID`, `name`, `description`, `source_address`, `thumbnail`) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $upload_id, $title, $description, $target_file, $thumbnailName);
$stmt->execute();
$stmt->close();

$_SESSION['error_code'] = 'File uploaded successfully';
?>
