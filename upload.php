<?php
    require 'libs/Smarty.class.php';  //framework
    require 'dbconnect.php';  //db_connection
    session_start();

    $smarty = new \Smarty\Smarty;
    
    //TODO: file upload


    $title = $_POST['title'];
    $desc = $_POST['description'];
    $categories = $_POST['categories'];
    $categories = explode(',', $categories);
    $categories = implode(',', $categories);

    //TODO: sql query
    $sql = "INSERT INTO `files` (`title`, `description`, `categories`) VALUES ('$title', '$desc', '$categories')";

    //return with a code
    $_SESSION['code'] = 1;
    $_SESSION['data'] = $_POST;

    header('Location: index.php?page=upld');
?>