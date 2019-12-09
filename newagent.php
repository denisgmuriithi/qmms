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
<title>Qet | New Agent</title>

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
					<h3 class="title1">New Agent</h3>
                   
                    <main class="container ">
    <section class="card p-5 mt-5">
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