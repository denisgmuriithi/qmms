<?php

require_once "../config/database.php";
//
//if (!isset($_GET['action'])){
//    header("Location: index.php");
//    exit();
//}
//
//if ($_GET['action'] == "opportunity"){
//
//}

$db = new Database();
$pdo = $db->getConnection();

if (!isset($_GET['action'])){
    header("Location: index.php");
    exit();
}

if ($_GET['action'] == "read"){
    $statement = $pdo->prepare("SELECT * FROM `opportunities`");
    if ($statement->execute()) {
        $results = $statement->fetchAll();
        $opportunities = array();
        foreach ($results as $result) {
            $stm = $pdo->prepare("SELECT * FROM `leads` WHERE `id`=?");
            $stm->execute(array($result['leadId']));
            $lead = $stm->fetch();
            $stmt = $pdo->prepare("SELECT * FROM `agents` WHERE `id`=?");
            $stmt->execute(array($result['sales_agent']));
            $agent = $stmt->fetch();
            $arr = array("id"=>$result['id'], "date"=>$result['predicted_close_date'], "lead"=>$lead['name'], "title"=>$result['name'], "description"=>$result['description'], "agent"=>$agent['name'], "status"=>$result['status']);
            array_push($opportunities, $arr);
        }
        echo json_encode($opportunities);
    }
}elseif ($_GET['action'] == "addPartner"){
    $name = $_POST['partnerName'];
    $category = $_POST['partnerCategory'];
    $role = $_POST['partnerRole'];
    $opportunityId = $_POST['opportunityId'];

    if (!empty($name) && !empty($category) && !empty($role) && !empty($opportunityId)){
        $stm = $pdo->prepare("INSERT INTO `partners`(`name`, `category`, `role`, `opportunity_id`) VALUES (?, ?, ?, ?)");
        if ($stm->execute(array($name, $category, $role, $opportunityId))){
            //echo json_encode(array("message"=>"Record added successfully"));
            $statement = $pdo->prepare("SELECT * FROM `partners` WHERE `opportunity_id`=?");
            if($statement->execute(array($opportunityId))){
                $result = $statement->fetchAll();
                echo json_encode($result);
            }
        }else{
            echo json_encode(array("message"=>"failed to add partner"));
        }
    }else{
        echo json_encode(array("message"=>"Please ensure all fields are filled"));
    }
}elseif($_GET['action'] == "setPartner"){
    $opportunityId = $_POST['opportunityId'];
    if (!empty($opportunityId)){
        $statement = $pdo->prepare("SELECT * FROM `partners` WHERE `opportunity_id`=?");
        if ($statement->execute(array($opportunityId))){
            $results = $statement->fetchAll();
            echo json_encode($results);
        }else{
            echo json_encode(array("message"=>"failed to get records"));
        }
    }else{
        echo json_encode(array("message"=>"error occurred"));
    }
}elseif($_GET['action'] == "addCompetitor"){
    $name = $_POST['name'];
    $threat = $_POST['threat'];
    $strength = $_POST['strength'];
    $weakness = $_POST['weakness'];
    $won = $_POST['won'];
    $opportunityId = $_POST['opportunityId'];

    if (!empty($name) && !empty($threat) && !empty($strength) && !empty($weakness) && !empty($won) && !empty($opportunityId)){
        $stm = $pdo->prepare("INSERT INTO `competitors`(`name`, `threat_level`, `strength`, `weakness`, `won`, `opportunity_id`) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stm->execute(array($name, $threat, $strength, $weakness, $won, $opportunityId))){
            //echo json_encode(array("message"=>"Record added successfully"));
            $statement = $pdo->prepare("SELECT * FROM `competitors` WHERE `opportunity_id`=?");
            if($statement->execute(array($opportunityId))){
                $result = $statement->fetchAll();
                echo json_encode($result);
            }
        }else{
            echo json_encode(array("message"=>"failed to add competitor"));
        }
    }else{
        echo json_encode(array("message"=>"Please ensure all fields are filled"));
    }
}elseif($_GET['action']=="setCompetitor"){
    $opportunityId = $_POST['opportunityId'];
    if (!empty($opportunityId)){
        $statement = $pdo->prepare("SELECT * FROM `competitors` WHERE `opportunity_id`=?");
        if ($statement->execute(array($opportunityId))){
            $results = $statement->fetchAll();
            echo json_encode($results);
        }else{
            echo json_encode(array("message"=>"failed to get records"));
        }
    }else{
        echo json_encode(array("message"=>"error occurred"));
    }
}elseif ($_GET['action'] == "setProgress") {
    $opportunityId = $_POST['opportunityId'];
    if (!empty($opportunityId)){
        $statement = $pdo->prepare("SELECT * FROM `progress` WHERE `opportunity_id`=?");
        if ($statement->execute(array($opportunityId))){
            $results = $statement->fetchAll();
            echo json_encode($results);
        }else{
            echo json_encode(array("message"=>"failed to get records"));
        }
    }else{
        echo json_encode(array("message"=>"error occurred"));
    }    
}elseif ($_GET['action'] == "addProgress"){
    $name = $_POST['name'];
    $party = $_POST['party'];
    $date = $_POST['date'];
    $remarks = $_POST['remarks'];
    $outCome = $_POST['outCome'];
    $opportunityId = $_POST['opportunityId'];

    if(!empty($name) && !empty($party) && !empty($date) && !empty($remarks) && !empty($opportunityId)){
        $statement = $pdo->prepare("INSERT INTO `progress`( `task`, `party`, `date`, `remarks`, `outcome`, `opportunity_id`) VALUES (?, ?, ?, ?, ?, ?)");
        if($statement->execute(array($name, $party, $date, $remarks, $outCome, $opportunityId))){
            $statement = $pdo->prepare("SELECT * FROM `progress` WHERE `opportunity_id`=?");
            if($statement->execute(array($opportunityId))){
                $result = $statement->fetchAll();
                echo json_encode($result);
            }
        }else {
            echo json_encode(array("message"=>"failed to save progress"));
        }
    }else {
        echo json_encode(array("message"=>"please ensure all fields are filled"));
    }
}

