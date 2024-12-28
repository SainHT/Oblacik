<?php
    require 'libs/Smarty.class.php';  //framework
    require 'dbconnect.php';  //db_connection
    session_start();

    $smarty = new \Smarty\Smarty;
    
    //TODO: upload larger files
    //* https://www.w3schools.com/php/php_file_upload.asp
    $target_dir = "files/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;

    $fileType = $_FILES['file']['type'];
    $table = '';

    // changes the table based on the file type
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

    if(file_exists($target_file)) {
        $_SESSION['upld-code'] = 2;
        $uploadOk = 1;
    }

    if ($_SESSION['upld-code'] == 0) {  
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $_SESSION['upld-code'] = 0;
        } else {
            $_SESSION['upld-code'] = 1;
        }
    }


    $title = $_POST['title'];
    $desc = $_POST['description'];
    $categories = $_POST['categories'];
    $categories = explode(',', $categories);
    $categories = implode(',', $categories);
    if ($_SESSION['upld-code'] != 0) {
        $_SESSION['upld-data'] = $_POST;
    }

    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
        exit();
    }

    if ($_SESSION['upld-code'] != 0) {
        header('Location: index.php?page=upld');
        exit();
    }

    echo $_SESSION['upld-code'] . "<br>";
    echo $target_file . "<br>";
    
    //TODO: parametrized queries
    $sql = "INSERT INTO `oblacik_uploads` (`user_ID`) VALUES ('".$_SESSION['id']."')";
    $result = $db->query($sql);

    $sql = "SELECT `upload_ID` FROM `oblacik_uploads` WHERE `user_ID` = '".$_SESSION['id']."' ORDER BY `upload_ID` DESC LIMIT 1";
    $result = $db->query($sql);
    foreach ($result as $row) {
        $upload_id = $row['upload_ID'];
    }

    //TODO: functioning categories
    $sql = "INSERT INTO `$table` (`upload_ID`, `name`, `description`, `category_ID`, `source_address`) VALUES ('$upload_id', '$title', '$desc', '$categories', '$target_file')";
    $result = $db->query($sql);

    header('Location: index.php?page=upld');
?>