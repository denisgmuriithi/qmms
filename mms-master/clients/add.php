<?php
require_once "../config/database.php";

$db = new Database();
$pdo = $db->getConnection();

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
<main class="container">
<section id="reg-page" class="card p-5 mt-5">
<h1 class="display-4 text-center capitalize">Add Client</h1>
    <form action="" method="post" role="form">
        <?php
        //executes only if submit is clicked
            if(isset($_POST["addClient"])){
                //declare input data
                $name = sanitize($_POST["name"]);//sanitize the user input
                $firstName = sanitize($_POST['firstName']);
                $lastName = sanitize($_POST['lastName']);
                $email = sanitize($_POST['email']);
                $phone = sanitize($_POST['phone']);
                $address = $_POST["address"];
            

                //simple validation checks
                if(empty($name)){
                    echo "<div class='alert alert-info'>please enter Name</div>";
                }elseif(empty($lastName)){
                    echo "<div class='alert alert-info'>Please enter Last Name</div>";
                }elseif(empty($email)){
                    echo "<div class='alert alert-info'>Please enter email</div>";
                }elseif(empty($phone)){
                    echo "<div class='alert alert-info'>Please select Phone Number</div>";
                }elseif(empty($address)){
                    echo "<div class='alert alert-info'>Please enter address</div>";
                }elseif(empty($firstName)){
                    echo "<div class='alert alert-info'>Please enter First Name</div>";
                }

                //perform action on input 
                if(!empty($name) &&
                    !empty($firstName) &&
                    !empty($lastName) &&
                    !empty($address) &&
                    !empty($phone) &&
                    !empty($email) ){
                        //query to check if username exists
                    $statement = $pdo->prepare("SELECT * FROM `users` WHERE `name`=?");
                    $statement->execute(array($name));
                    $result = $statement->rowCount();

                    if ($result > 0) {
                        echo "<div class=\"alert alert-warning\"><strong>Warning!</strong> Username already exists.</div>";
                    } else {
                        //insert user input to database
                        $contactName = $firstName." ".$lastName;
                        $statement = $pdo->prepare("INSERT INTO `clients`( `name`, `contact_name`, `phone`, `email`, `address`) VALUES (?, ?, ?, ?, ?)");
                    
                        $qry = $statement->execute(array($name, $contactName, $phone, $email,  $address));

                        if ($qry) {
                            header("Location: index.php");
                            exit;
                        } else {
                            echo "<div class=\"alert alert-warning\"><strong>Warning!</strong> failed to save user.</div>";
                        }
                    }

                }
                
            }

            function sanitize($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>
        <div class="form-group">
            <label for="name" id="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
        </div>
        <div class="form-group">
            <label for="contactName">Contact Name</label>
            <div class="row">
            <input type="text" name="firstName" id="firstName" class="form-control col-md-6" placeholder="Enter First Name"> 
            <input type="text" name="lastName" id="lastName" class="form-control col-md-6" placeholder="Enter Last Name">
            </div>
            
        </div>
        <div class="form-group">
            <label for="phone" >Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone">
        </div>
        <div class="form-group">
            <label for="email" id="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
        </div>
        <div class="form-group">
           <label for="address">Address</label>
           <input type="text" name="address" class="form-control" placeholder="Enter Address"> 
        </div>
        <div class="form-group">
            <input type="submit" name="addClient" class=" btn btn-primary" value="Save">
        </div>
    </form>
</section>
</main>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>