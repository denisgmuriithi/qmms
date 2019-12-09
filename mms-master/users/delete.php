<?php
session_start();

require_once "../config/database.php";

if(!isset($_SESSION['user']) && !isset($_GET['id'])){
    header("Location: index.php");
    exit();
}else{
    $db = new Database();
    $pdo = $db->getConnection();
    $id = $_GET['id'];
    $stm = $pdo->prepare("DELETE FROM `users` WHERE `id`=?");
    if($stm->execute(array($id))){
        header("Location: index.php");
        exit();
    }
}
?>