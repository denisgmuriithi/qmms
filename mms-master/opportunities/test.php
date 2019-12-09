<?php
require_once "../config/database.php";
$db = new Database();
$pdo = $db->getConnection();

if (!isset($_GET['action'])){
    echo json_encode(array("message"=>"wrong directory"));
    exit();
}else{
    echo json_encode(array("action"=>$_GET['action']));
}
$name = $_POST['partnerName'];
$category = $_POST['partnerCategory'];
$role = $_POST['partnerRole'];
$opportunityId = $_POST['opportunityId'];

if (!empty($name) && !empty($category) && !empty($role) && !empty($opportunityId)){
    $stm = $pdo->prepare("INSERT INTO `partners`(`name`, `category`, `role`, `opportunity_id`) VALUES (?, ?, ?, ?)");
    if ($stm->execute(array($name, $category, $role, $opportunityId))){
       // echo json_encode(array("message"=>"Record added successfully"));
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../font/roboto/roboto.css">
    <link rel="stylesheet" type="text/css" href="../font/material/material-icons.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</head>
<body>
<ul>
<script>
    for(let i = 0; i < 10 ; i++){
        $(`<li><button>button ${i}</button></li>`).appendTo($("<ul>"));
    }
</script>
</ul>
</body>
</html>

