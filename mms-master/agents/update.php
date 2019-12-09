<?php
require_once "../config/database.php";
session_start();
if (!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}
$db = new Database();
$pdo = $db->getConnection();

if (isset($_GET['id'])){
    $stm = $pdo->prepare("SELECT * FROM `agents` WHERE `id`=?");
    if ($stm->execute(array($_GET['id']))){
        $agent = $stm->fetch();
        //echo var_dump($agent);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>QET - Marketing Management System</title>
    <link rel="stylesheet" type="text/css" href="../font/roboto/roboto.css">
    <link rel="stylesheet" type="text/css" href="../font/material/material-icons.css">

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

  </head>
  <body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">QET-Marketing Management System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
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
  <section class="card p-5 mt-5">
  <form  method="post" role="form">
      <?php
      if (isset($_POST['submit'])){
        $name = $_POST['agent'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        if (empty($name)){
            echo "<div class='alert alert-warning'>Please enter name</div>";
        }elseif (empty($email)){
            echo "<div class='alert alert-warning'>Please provide email</div>";
        }elseif (empty($phone)){
            echo "<div class='alert alert-warning'>Please provide phone</div>";
        }

        if (!empty($name) &&
        !empty($email) &&
        !empty($phone)){
            $stm = $pdo->prepare("UPDATE `agents` SET `name`=?,`email`=?,`phone`=? WHERE `id`=?");
            if ($stm->execute(array($name, $email, $phone, $_GET['id']))){
                header("Location:index.php");
                exit();
            }else{
                echo "<div class='alert alert-warning'>Failed to update</div>";
            }
        }
      }
      ?>
        <div class="form-group">
                <label for="name">Agent Name</label>
                <input type="text" name="agent" class="form-control" id="name" value="<?php echo $agent['name']?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo $agent['email']?>">
            </div>
            <div class="form-group">
                <label for="contact">Phone Number</label>
                <input type="tel" name="phone" id="contact" class="form-control" value="<?php echo $agent['phone']?>">
            </div>
            <div class="form-group">
               <input type="submit" name="submit" value="Submit" class="btn btn-primary form-control">
            </div>
        </form>
  </section>
  
  </main>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="index.js"></script>
</body>
</html>
