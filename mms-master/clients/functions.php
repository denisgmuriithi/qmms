<?php
require_once "../config/database.php";

$db = new Database();
$pdo = $db->getConnection();

if (!isset($_GET['action'])){
    header("Location: index.php");
    exit();
}

if ($_GET['action'] == "updateDetails"){
    $name = $_POST['name'];
    $contactName = $_POST['contactName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $id = $_POST['detailId'];

    if (!empty($name) && !empty($contactName) && !empty($email) && !empty($phone) && !empty($address) && !empty($id)){
        $statement = $pdo->prepare("UPDATE `clients` SET `name`=?,`contact_name`=?,`phone`=?,`email`=?,`address`=? WHERE `id`=?");
        if ($statement->execute(array($name, $contactName, $phone, $email, $address, $id))){
            //echo json_encode(array("message"=>"Record added successfully"));
            $statement = $pdo->prepare("SELECT * FROM `clients` WHERE `id`=?");
            if($statement->execute(array($id))){
                $result = $statement->fetch();
                echo json_encode($result);
            }
        }else{
            echo json_encode(array("message"=>"failed to update Client Details"));
        }
    }else{
        echo json_encode(array("message"=>"Please ensure all fields are filled"));
    }
}elseif($_GET['action'] == "addHistory"){
    $solution = $_POST['solution'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $manager = $_POST['manager'];
    $status = $_POST['status'];
    $id = $_POST['detailId'];

    if(!empty($solution) && !empty($description) && !empty($amount) && !empty($manager) && !empty($status) && !empty($id)){
        $statement = $pdo->prepare("INSERT INTO `history`( `clientId`, `solution`, `description`, `amount`, `manager`, `status`) VALUES (?, ?, ?, ?, ?, ?)");
        if ($statement->execute(array($id, $solution, $description, $amount, $manager, $status))){
            //echo json_encode(array("message"=>"Record added successfully"));
            $statement = $pdo->prepare("SELECT * FROM `history` WHERE `clientId`=?");
            if($statement->execute(array($id))){
                $result = $statement->fetchAll();
                echo json_encode($result);
            }
        }else{
            echo json_encode(array("message"=>"failed to save business history"));
        }
    }else{
        echo json_encode(array("message"=>"Please ensure all fields are filled"));
    }
}elseif($_GET['action'] == "getHistory"){
    $id = $_POST['detailId'];
    if(!empty($id)){
        $statement = $pdo->prepare("SELECT * FROM `history` WHERE `clientId`=?");
            if($statement->execute(array($id))){
                $result = $statement->fetchAll();
                echo json_encode($result);
            }
    }else{
        echo json_encode(array("message"=>"reguest un successful"));
    }
}else{
    echo json_encode(array("message"=>"invalid url credentials"));
}