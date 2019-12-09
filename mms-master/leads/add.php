<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit;
} else {
    $user = $_SESSION["user"];
    //var_dump($_SESSION["user"]);
}
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
    <h2 class="display-4 page-header">Save leads</h2>
    <p>Fill all the fields then click submit to save leads </p>

<section class="card p-5">
<form action="" method="post" role="form">
        <?php
        if (isset($_POST["submit"])) {
            $leads = sanitize($_POST["lead"]);
            $date = sanitize($_POST["date"]);
            $contact = sanitize($_POST["contactName"]);
            $email = sanitize($_POST["email"]);
            $phone = sanitize($_POST["phone"]);
            $invoice = sanitize($_POST["invoice"]);
            $address = sanitize($_POST["address"]);

            if (empty($leads)) {
                echo "<div class='alert alert-warning'>Please enter leads name</div>";
            } elseif (empty($date)) {
                echo "<div class='alert alert-warning'>Please enter date </div>";
            } elseif (empty($contact)) {
                echo "<div class='alert alert-warning'>Please enter contact</div>";
            } elseif (empty($phone)) {
                echo "<div class='alert alert-warning'>Please enter phone Number</div>";
            } elseif (empty($email)) {
                echo "<div class='alert alert-warning'>Please enter Email</div>";
            }elseif (empty($address)) {
                echo "<div class='alert alert-warning'>Please enter Address</div>";
            }

            if (!empty($leads) && !empty($date) || !empty($contact) || !empty($phone) || !empty($email) || !empty($address)) {
                $statement = $pdo->prepare("SELECT * FROM `leads` WHERE `email`=? OR `phone`=? ");
                $statement->execute(array($email, $phone));
                $result = $statement->rowCount();

                if ($result > 0) {
                    echo "<div class='alert alert-warning'>leads may already exist in the records</div>";
                } else {

                    // TODO : create a select for opportunity
                    $statement = $pdo->prepare("INSERT INTO `leads`(`name`, `contact_person`, `phone`, `email`, `address`, `invoice`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    if ($statement->execute(array($leads, $contact, $phone, $email, $address, $invoice, $date))) {
                        echo "<div class='alert alert-success'>leads saved successfully</div>";
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-warning'>Failed to save leads</div>";
                    }

                }
            }
        }

        function sanitize($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;

        }

        ?>
        <div class="form-group">
            <label for="name">Lead Name</label>
            <input type="text" name="lead" class="form-control" id="name" placeholder="leads Name">
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" id="date" placeholder="09/09/19">
        </div>
        <div class="form-group">
            <label for="contactName">Contact Name</label>
            <input type="text" name="contactName" id="contactName" class="form-control" placeholder="Contact Name">
        </div>
        <div class="form-group">
            <label for="contact">Phone Number</label>
            <input type="tel" name="phone" id="contact" class="form-control" placeholder="Phone Number">
        </div>
        <div class="form-group">
            <label for="invoice">Invoice</label>
            <input type="number" name="invoice" id="invoice" class="form-control" placeholder="Ksh 0.00">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="address">Physical Address</label>
            <input type="text" name="address" id="address" class="form-control" placeholder="Physical Address">
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="Submit" class="btn btn-primary form-control">
        </div>
    </form>

</section>
    
</main>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>