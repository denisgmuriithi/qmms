<?php
session_start();
if (isset($_SESSION['user']) && $_GET['id']){
    require_once "../config/database.php";
    $db = new Database();
    $pdo= $db->getConnection();

    $statement = $pdo->prepare("DELETE FROM `agents` WHERE `id`=?");
    if ($statement->execute(array($_GET['id']))){
        header("Location: index.php");
        exit();
    }
}
