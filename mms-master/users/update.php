<?php
require_once "../config/database.php";


$db = new Database();
$pdo = $db->getConnection();

if (isset($_GET['id'])) {
    $statement = $pdo->prepare("SELECT * FROM `users` WHERE `id`=?");
    $statement->execute(array($_GET['id']));
    $user = $statement->fetch();
} else {
    header("Location: index.php");
    exit;
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
<section id="reg-page" class="form-page">
<h1 class="display-4 text-center capitalize">Edit User</h1>
    <form action="" method="post" role="form">
        <?php
        //executes only if submit is clicked
            if(isset($_POST["register"])){
                //declare input data
                $username = sanitize($_POST["username"]);//sanitize the user input
                $name = sanitize($_POST['name']);
                $email = sanitize($_POST['email']);
                $role = sanitize($_POST['role']);

                //simple validation checks
                if(empty($username)){
                    echo "<div class='alert alert-info'>please enter username</div>";
                }elseif(empty($name)){
                    echo "<div class='alert alert-info'>please enter Name</div>";
                }elseif(empty($email)){
                    echo "<div class='alert alert-info'>Please enter email</div>";
                }elseif(empty($role)){
                    echo "<div class='alert alert-info'>Please select role</div>";
                }elseif(empty($password)){
                    echo "<div class='alert alert-info'>Please enter password</div>";
                }

                //perform action on input 
                if(!empty($username) &&
                    !empty($name) &&
                    !empty($role) &&
                    !empty($email)){
                        $id = $_GET['id'];
                        $statement = $pdo->prepare("UPDATE `users` SET `username`=?,`name`=?,`email`=?,`role`=? WHERE `id`=?");
                        $qry = $statement->execute(array($username, $name, $email, $role, $id));

                        if ($qry) {
                            header("Location: index.php");
                            exit;
                        } else {
                            echo "<div class=\"alert alert-warning\"><strong>Warning!</strong> failed to update user.</div>";
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
            <label for="username" id="username">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username" value="<?php echo $user['username'];?>">
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="<?php echo $user['name'];?>">
        </div>
        <div class="form-group">
            <label for="email" id="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" value="<?php echo $user['email'];?>">
        </div>
        <div class="form-group">
            <label for="role" id="role">Select Role</label>
            <select name="role" id="role" class="form-control">
            <option value="<?php echo $user['role'];?>"><?php echo $user['role'];?></option>
                <option value="admin">Admin</option>
                <option value="member">User</option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" name="register" class=" btn btn-primary" value="Sign Up">
        </div>
    </form>
</section>
</main>
<script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>