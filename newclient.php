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
<title>Qet | Add Client</title>

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
					<h3 class="title1">Add Client</h3>
                    <main class="container">
<section id="reg-page" class="card p-5 mt-5">
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
            <input type="text" name="firstName" id="firstName" class="form-control col-md-6" placeholder="Enter First Name"> <br>
            
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