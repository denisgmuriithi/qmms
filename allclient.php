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
    <main class="container">
        <!-- leads table -->
        <div class="row">
            <form action="index.php" class="form-inline col-md-6" role="form" method="get">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="Search">
                    <button type="submit" name="submit-search" class="btn btn-default form-control">
                        <i class="material-icons">search</i></button>
                </div>
            </form>
            <a href="newclient.php" class="col-md-6">
                <button class="btn btn-success pull-right">Add client</button>
            </a>
        </div>
        <table class="table my-5">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Operations</th>
            </tr>
            </thead>
            <tbody id="tcontent">
            <?php
            $statement = $pdo->prepare("SELECT * FROM `clients`");
            if ($statement->execute()) {
                $results = $statement->fetchAll();
            } else {
                echo "<div class='alert alert-info'><i class='material-icons'>face</i> No Records Yet</div>";
            }
            //if search is set display results
            if (isset($_GET['submit-search'])) {

                $search = sanitize($_GET['search']);

                if (empty($search)) {
                    echo "<div class=\"alert alert-warning\"><strong>Warning!</strong> please enter a search term.</div>";
                } elseif (!empty($search)) {
                    $search_term = "%" . $search . "%";
                    $stm = $pdo->prepare("SELECT * FROM `clients` WHERE (`name` LIKE ? OR `email` LIKE ? OR `address` LIKE ?)");
                    $stm->execute(array($search_term, $search_term, $search_term, $search_term));
                    $results = $stm->fetchAll();

                    if ($stm->rowCount() == 0) {
                        echo "<div class=\"alert alert-warning\"><strong>Warning!</strong> No results found for " . $search . ".</div>";
                    } else {
                        fetchRecords($results);
                    }
                }
            } else {
                fetchRecords($results);
            }

            ?>
            </tbody>
        </table>
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