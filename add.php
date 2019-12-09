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
<title>Qet | Add Lead</title>

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
					<h3 class="title1">Add Lead</h3>
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
        <form>
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