<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } 

require_once "config/database.php";


$db = new Database();
$pdo = $db->getConnection();
?>
<!DOCTYPE HTML>
<html>
<head>
<title>QMMS | Qet Systems </title>

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
<!-- chart -->
<script src="js/Chart.js"></script>
<!-- //chart -->
<!--Calender-->
<link rel="stylesheet" href="css/clndr.css" type="text/css" />
<script src="js/underscore-min.js" type="text/javascript"></script>
<script src= "js/moment-2.2.1.js" type="text/javascript"></script>
<script src="js/clndr.js" type="text/javascript"></script>
<script src="js/site.js" type="text/javascript"></script>
<!--End Calender-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
<div class="main-content">
		
		 <?php include_once('includes/sidebar.php');?>
		
	<?php include_once('includes/header.php');?>
		<!-- main content start-->
		<main class="container">
        <!-- leads table -->
        <!-- <h2 class="display-4 page-header">Manage Leads</h2>
        <h2 class ="title">All Leads</h2>
        <p>You can edit Leads by clicking the edit icon.</p>
        <p>Add opportunities using the Add opportunity button, Search for leads using the search bar</p>
        <div class="row">
            <form action="index.php" class="form-inline col-md-6" role="form" method="get">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="Search">
                    <button type="submit" name="submit-search" class="btn btn-default form-control">
                        <i class="material-icons">search</i></button>
                    <?php
                    if (isset($_GET['submit-search'])) {
                        echo "<a href='index.php'><button class='btn btn-info form-control'>" . $_GET['search'] . " &times; </button></a>";
                    }
                    ?>
                </div>
            </form>
            <a href="add.php" class="col-md-6">
                <button class="btn btn-success pull-right">Add lead</button>
            </a>
        </div> -->
        

        <main class="container">
    <div class="row bg-title">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <h4 class="page-title">SALE OPPORTUNITIES</h4>
            <p></p>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-12">
            <ol class="breadcrumb">
                <li><a href="#sales">Sales</a></li>
                <li><a class="active">Opportunities</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control select2" name="lead" id="leads">
                                    <option value="" disabled selected>Select lead</option>
                                    <?php
                                    $stm = $pdo->prepare("SELECT * FROM `leads`");
                                    $stm->execute();
                                    while ($row = $stm->fetch()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="input-daterange input-group" id="date-range">
                                <span class="input-group-addon bg-primary b-0 text-white">From: </span>
                                <input type="text" class="form-control" name="start" id="start"/>
                                <span class="input-group-addon bg-primary b-0 text-white">to: </span>
                                <input type="text" class="form-control" name="end" id="end"/>
                                <span class="input-group-btn">
                                      <button type="button" class="btn btn-info btn-search">
                                        <i class="material-icons">search</i>
                                      </button>
                                    </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a href="newopportunity.php">
                                <button class="btn btn-success waves-effect waves-light pull-right bt-create"
                                        type="button"><span class="btn-label"><i class="material-icons"></i></span>Add New
                                    Opportunity
                                </button>
                            </a>
                            <p></p>
                        </div>
                    </div>

                </h3>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>START DATE</th>
                            <th>LEAD</th>
                            <th>TITLE</th>
                            <th>DESCRIPTION</th>
                            <th>SALES AGENT</th>
                            <th>STATUS</th>
                            <th>OPTIONS</th>
                        </tr>
                        </thead>
                        <tbody id="tcontent">
                        </tbody>
                    </table> <!--a href="#">Check all the sales</a--> </div>
            </div>
        </div>
    </div>
</main>
    
		<!--footer-->
		
        <!--//footer-->
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
<?php
function fetchRecords($records)
{
    $counter = 1;
    foreach ($records as $record) {
        echo "
        <tr>
        <td scope='col'>{$counter}</td>
        <td scope='col'> {$record['name']}</td>
        <td scope='col'>{$record['email']}</td>
        <td scope='col'>{$record['phone']}</td>
        <td scope='col'>
        <a href=\"update.php?id={$record['id']}\" class='btn-primary btn btn-link'>
                        <i class=\"fas fas-delete\"></i>View
                    </a>&nbsp;
                    
</td>
</tr>
        ";
        $counter++;
    }
}

function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}