<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{

if(isset($_POST['submit']))
  {
    $sername=$_POST['sername'];
    $cost=$_POST['cost'];
   

     
    $query=mysqli_query($con, "insert into  tblservices(ServiceName,Cost) value('$sername','$cost')");
    if ($query) {
    	echo "<script>alert('Service has been added.');</script>"; 
    		echo "<script>window.location.href = 'add-services.php'</script>";   
    $msg="";
  }
  else
    {
    echo "<script>alert('Something Went Wrong. Please try again.');</script>";  	
    }

  
}
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>Qet | New User</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
 <!-- js-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!--left-fixed -navigation-->
		 <?php include_once('includes/sidebar.php');?>
		<!--left-fixed -navigation-->
		<!-- header-starts -->
	 <?php include_once('includes/header.php');?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<h3 class="title1">New User</h3>
                   
                    <main class="container ">
<section id="reg-page" class="form-page">
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


		 
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.js"> </script>
</body>
</html>
<?php } ?>