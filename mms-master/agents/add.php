<?php
require_once "../config/database.php";
session_start();
if(isset($_SESSION['user'])){
    $db = new Database();
    $pdo = $db->getConnection();
}else{
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>QET - Marketing Management System</title>
    <link rel="stylesheet" type="text/css" href="../font/roboto/roboto.css">
    <link rel="stylesheet" type="text/css" href="../font/material/material-icons.css">

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">QET-Marketing Management System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
            aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto float-right">
            <li class="nav-item active">
                <a class="nav-link" href="../home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#"></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../logout.php">Logout</a>
            </li>
        </ul>
</nav>
<main class="container ">
    <section class="card p-5 mt-5">
        <h4 class="page-header ">Agent Form</h4>

        <form method="post" role="form">
            <?php
                if (isset($_POST['submit'])){
                    $agent = $_POST['agent'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];

                    if(empty($agent)){
                        echo "<div class='alert alert-warning'>Please enter agent name</div>";
                    }elseif(empty($email)){
                        echo "<div class='alert alert-warning'>Please enter email</div>";
                    }elseif(empty($phone)){
                        echo "<div class='alert alert-warning'>Please provide phone number</div>";
                    }else{
                        if(!empty($agent) &&
                        !empty($email) &&
                        !empty($phone)){
                            $stm = $pdo->prepare("SELECT * FROM `agents` WHERE (`name` LIKE ? OR `phone` LIKE ? OR `email` LIKE ?)");
                            $stm->execute(array($agent, $phone, $email));
                            if ($stm->rowCount() > 0){
                                echo "<div class='alert alert-warning'>The agent already exists</div>";
                            }else{
                                $statement = $pdo->prepare("INSERT INTO `agents`(`name`, `email`, `phone`) VALUES (?, ?, ?)");
                                if ($statement->execute(array($agent, $email, $phone))){
                                    header("Location: index.php");
                                    exit();
                                }else{
                                    echo "<div class='alert alert-warning'>failed to save agent</div>";
                                }
                            }
                        }
                    }
                }
            ?>
            <div class="form-group">
                <label for="name">Agent Name</label>
                <input type="text" name="agent" class="form-control" id="name" placeholder="Agent Name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="contact">Phone Number</label>
                <input type="tel" name="phone" id="contact" class="form-control" placeholder="Phone Number">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary form-control">
            </div>
        </form>
    </div>

</main>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>