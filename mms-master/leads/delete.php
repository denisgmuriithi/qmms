<?php
require_once "../config/database.php";

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../logout.php");
    exit;
}

$database = new Database();
$pdo = $database->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM `leads` WHERE `id`=?";
    if ($pdo->prepare($sql)->execute(array($id))) {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}