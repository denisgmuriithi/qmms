<?php
require_once "../config/database.php";
    $db = new Database();
    $pdo = $db->getConnection();


if(isset($_GET['id'])){
    $opportunityId = $_GET['id'];
    $statement = $pdo->prepare("DELETE FROM `opportunities` WHERE `id`=?");
    if($statement->execute(array($opportunityId))){
        header("Location: index.php");
    }else {
        echo json_encode(array("message"=>"failed to delete"));
    }
}elseif(isset($_GET['partId'])){
    $id = $_GET['partId'];
    $statement = $pdo->prepare("DELETE FROM `partners` WHERE `id`=?");
    if($statement->execute(array($id))){
        header("Location: index.php");
    }else {
        echo json_encode(array("message"=>"failed to delete"));
    }
}elseif(isset($_GET['delComId'])){
    $id = $_GET['delComId'];
    $statement = $pdo->prepare("DELETE FROM `competitors` WHERE `id`=?");
    if($statement->execute(array($id))){
        header("Location: index.php");
    }else {
        echo json_encode(array("message"=>"failed to delete"));
    }
}elseif(isset($_GET['progId'])){
    $id = $_GET['progId'];
    $statement = $pdo->prepare("DELETE FROM `progress` WHERE `id`=?");
    if($statement->execute(array($id))){
        header("Location: index.php");
    }else {
        echo json_encode(array("message"=>"failed to delete"));
    }
}else{
    header("Location: index.php");
}


   
