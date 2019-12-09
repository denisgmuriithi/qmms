<?php
require_once "../config/database.php";
$db = new Database();
$pdo = $db->getConnection();

if(isset($_GET['historyId']) && !empty($_GET['historyId'])) {
    $id = $_GET['historyId'];
    $statement = $pdo->prepare("DELETE FROM `history` WHERE `id`=?");
    if($statement->execute(array($id))){
        header("Location: index.php");
    }else {
        echo json_encode(array("message"=>"failed to delete"));
    }
}