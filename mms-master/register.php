<?php
require_once "config/database.php";

$db = new Database();
$pdo = $db->getConnection();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>QET - Marketing Management System</title>
    <link rel="stylesheet" type="text/css" href="font/roboto/roboto.css">
    <link rel="stylesheet" type="text/css" href="font/material/material-icons.css">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
<main class="container ">
<section id="reg-page" class="form-page">
<h1 class="display-4 text-center capitalize">Add User</h1>
    <form action="" method="post" role="form">
        <?php
        //executes only if submit is clicked
            if(isset($_POST["register"])){
                //declare input data
                $username = sanitize($_POST["username"]);//sanitize the user input
                $name = sanitize($_POST['name']);
                $email = sanitize($_POST['email']);
                $role = sanitize($_POST['role']);
                $password = $_POST["password"];
                $confirmPassword = $_POST["confirmPassword"];

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
                }elseif(empty($confirmPassword)){
                    echo "<div class='alert alert-info'>Please enter password confirmation</div>";
                }elseif($confirmPassword !== $password){
                    echo "<div class='alert alert-info'>Please ensure the passwords match</div>";
                }

                //perform action on input 
                if(!empty($username) &&
                    !empty($password) &&
                    !empty($name) &&
                    !empty($role) &&
                    !empty($email) &&
                    !empty($confirmPassword) &&
                    $confirmPassword == $password){
                        //query to check if username exists
                    $statement = $pdo->prepare("SELECT * FROM `users` WHERE `username`=?");
                    $statement->execute(array($username));
                    $result = $statement->rowCount();

                    if ($result > 0) {
                        echo "<div class=\"alert alert-warning\"><strong>Warning!</strong> Username already exists.</div>";
                    } else {
                        //insert user input to database
                        $statement = $pdo->prepare("INSERT INTO `users`(`username`, `name`, `email`, `role`, `password`) VALUES (?, ?, ?, ?, ?)");
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $qry = $statement->execute(array($username, $name, $email, $role,  $password));

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
            <label for="username" id="username">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username">
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
        </div>
        <div class="form-group">
            <label for="email" id="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="role" id="role">Select Role</label>
            <select name="role" id="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="member">User</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password" id="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
        </div>
        <div class="form-group">
            <label for="confirm-password" id="confirm-password">Confirm Password</label>
            <input type="password" name="confirmPassword" class="form-control" id="confirm-password" placeholder="Enter Password Confirmation">
        </div>
        <div class="form-group">
            <input type="submit" name="register" class=" btn btn-primary" value="Sign Up">
        </div>
    </form>
</section>
</main>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>