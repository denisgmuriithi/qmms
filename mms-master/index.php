<?php
require_once "config/database.php";

//establish a database connection
$db = new Database();
$pdo = $db->getConnection();
// password_hash("1234",PASSWORD_DEFAULT);
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

<main class="container">
<section id="login-page" class="form-page">
<h1 class="display-4 text-center capitalize">Sign In</h1>
    <form action="" method="post" role="form">
        <?php
        //execute on submit
            if(isset($_POST["login"])){
                //get user input
                $username = sanitize($_POST["username"]);
                $password = $_POST["password"];
                

                if(empty($username)){
                    echo "<div class='alert alert-danger'>Please enter username</div>";
                }elseif(empty($password)){
                    echo "<div class='alert alert-danger'>Please enter a password</div>";
                }

                //verify user credentials
                if(!empty($username) && !empty($password)){
                    $statement = $pdo->prepare("SELECT * FROM `users` WHERE `username`=?");
                    $statement->execute(array($username));
                    $qry = $statement->rowCount();
                    $user = $statement->fetch();

                    if ($qry == 0) {
                        echo "
                        <div class='alert alert-warning alert-dismissable fade in' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='close'>
                                <span aria-hidden='true'>
                                    &times;
                                </span>
                            </button>
                            <strong>Warning!</strong> Incorrect details/user doesnt exist.
                        </div>
                        ";
                    } else {
                        echo "<strong>Warning!</strong>".password_verify($password, $user['password']);
                        if (password_verify($password, $user['password'])) {
                            session_start();
                            $_SESSION['user'] = $user;
                            //echo "user successfuly logged in";
                            header("Location: home.php");
                            //exit;
                        } else {
                            echo "
                            <div class='alert alert-warning alert-dismissable fade in' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='close'>
                                    <span aria-hidden='true'>
                                        &times;
                                    </span>
                                </button>
                                <strong>Warning!</strong> Incorrect details.
                            </div>
                            ";
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
            <label for="password" id="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
        </div>
        <div class="form-group">
            <input type="submit" name="login" class="form-control btn btn-primary" value="Login">
        </div>
    </form>
</section>
</main>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>