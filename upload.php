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

$ADD_TO_DB = false;

$target_dir = "files/";
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

// Check if all chunks are uploaded
if ($chunk != $chunks - 1) {
    echo json_encode(array('status' => "$chunk of $chunks"));
    exit();
}

$fp = fopen($target_file, 'w');
for ($i = 0; $i < $chunks; $i++) {
    $chunkFile = $target_file . '.part' . $i;
    $chunk = file_get_contents($chunkFile);
    fwrite($fp, $chunk);
    unlink($chunkFile);
}
fclose($fp);

$fileType = mime_content_type($target_file);


// Determine the table based on the file type
switch ($fileType) {
    case 'image/jpeg':
    case 'image/jpg':
    case 'image/png':
    case 'image/gif':
    case 'image/bmp':
    case 'image/webp':
        $table = 'oblacik_photos';
        break;
    case 'application/pdf':
    case 'application/msword':
        $table = 'oblacik_books';
        break;
    case 'video/mp4':
    case 'video/avi':
    case 'video/mpeg':
    case 'video/x-msvideo':
        $table = 'oblacik_movies';
        break;
    default:
        $table = 'oblacik_others';
        break;
}

$title = $_POST['title'];
$desc = $_POST['description'];

$response = array(
    'title' => $title,
    'description' => $desc,
    'fileType' => $fileType
);

echo json_encode($response);

// Insert into the uploads table
$stmt = $db->prepare("INSERT INTO `oblacik_uploads` (`user_ID`) VALUES (?)");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$upload_id = $stmt->insert_id;
$stmt->close();

// Insert into the specific table based on file type
$stmt = $db->prepare("INSERT INTO `$table` (`upload_ID`, `name`, `description`, `source_address`) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $upload_id, $title, $desc, $target_file);
$stmt->execute();
$stmt->close();
?>
