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
    <section class="card mt-2">
        <div class="card-body">
            <div class="card-title">
                <h1 class="display-4 text-center">Opportunity Form</h1>
            </div>

            <form class="form-horizontal " id="f1" method="post">
                <?php
                if (isset($_POST['save'])) {
                    $leadId = $_POST['leadId'];
                    $opportunity = $_POST['opportunity'];
                    $description = $_POST['description'];
                    $potAmount = $_POST['potAmount'];
                    $projectedMargin = $_POST['projectedMargin'];
                    $interestLevel = $_POST['interestLevel'];
                    $agent = $_POST['agent'];
                    $protocol = $_POST['protocol'];
                    $period = $_POST['period'];
                    $cycle = $_POST['cycle'];
                    $predictedClose = $_POST['predictedClose'];
                    $infoSource = $_POST['infoSource'];
                    $industry = $_POST['industry'];

                    if (!empty($leadId) &&
                        !empty($opportunity) &&
                        !empty($description) &&
                        !empty($potAmount) &&
                        !empty($projectedMargin) &&
                        !empty($interestLevel) &&
                        !empty($agent) &&
                        !empty($protocol) &&
                        !empty($period) &&
                        !empty($cycle) &&
                        !empty($predictedClose) &&
                        !empty($infoSource) &&
                        !empty($industry)) {
                        $stm = $pdo->prepare("SELECT * FROM `opportunities` WHERE `name`=? AND `leadId`=?");
                        $stm->execute(array($opportunity, $leadId));
                        if ($stm->rowCount() > 0) {
                            echo "<div class='alert alert-info'>The opportunity already exists</div>";
                        } else {
                            $stm = $pdo->prepare("INSERT INTO `opportunities`( `name`, `description`, `potential_amount`, `projected_margin`, `interest_level`, `sales_agent`, `engagement_protocol`, `predicted_sales_period`, `predicted_close_date`, `information_source`, `industry_selector`, `leadId`) VALUES (?, ?, ?, ?, ?, ?, ? , ?, ?, ?, ?, ?)");
                            $qry = $stm->execute(array($opportunity, $description, $potAmount, $projectedMargin, $interestLevel, $agent, $protocol, $period, $predictedClose, $infoSource, $industry, $leadId));
                            if ($qry){
                                header("Location: index.php");
                            }
                        }
                    } else {
                        echo "<div class='alert alert-warning'>Please  ensure all fields are filled</div>";
                    }
                }
                ?>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="leads">SELECT LEAD</label>
                        <select class="form-control select2" name="leadId" id="leads">
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
                <div class="form-group">
                    <label class="col-md-12">Name of Opportunity <span
                                style="padding-top:0px;color:red;">*</span></label>
                    <div class="col-md-12">
                        <input type="text" name="opportunity" id="opportunity" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12">Description of Opportunity <span
                                style="padding-top:0px;color:red;">*</span></label>
                    <div class="col-md-12">
                                                <textarea class="form-control" rows="3"
                                                          name="description" id="description"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label class="col-md-12">Potential Amount </label>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">KSh.</span>
                                    <input type="number" name="potAmount" id="potAmount"
                                           class="form-control" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-3">
                        <div class="form-group">
                            <label class="col-md-12">Projected Margin</label>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input type="number" name="projectedMargin" id="projectedMargin"
                                           class="form-control" value="">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-3">
                        <div class="form-group">
                            <label class="col-md-12">Level of Interest<span
                                        style="padding-top:0px;color:red;">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control select2" name="interestLevel"
                                        id="interestLevels">
                                    <option value="" disabled selected>Select One</option>
                                    <option value="LOW">LOW</option>
                                    <option value="MEDIUM">MEDIUM</option>
                                    <option value="HIGH">HIGH</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label class="col-md-12">Sales Agent <span
                                        style="padding-top:0px;color:red;">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control select2" name="agent" id="agents">
                                    <option value="" disabled selected>Select Agent</option>
                                    <?php
                                    $stm = $pdo->prepare("SELECT * FROM `agents`");
                                    $stm->execute();
                                    while ($row = $stm->fetch()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label class="col-md-12">Engagement Protocol <span
                                        style="padding-top:0px;color:red;">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control select2" name="protocol" id="protocols">
                                    <option value="walk in">Walk In</option>
                                    <option value="Call">Call</option>
                                    <option value="liason">liason</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-3 col-3">
                        <div class="form-group">
                            <label class="col-md-12">Predicted Sales Period </label>
                            <div class="col-md-12 col-12">
                                <input type="number" class="form-control" name="period" id="period"
                                       value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-3">
                        <div class="form-group">
                            <label class="col-md-12"><span style="font-size: 1px">#</span></label>
                            <div class="col-md-12">
                                <select class="form-control select2" name="cycle" id="cycles">
                                    <option value="DAYS" selected>DAYS</option>
                                    <option value="WEEKS">WEEKS</option>
                                    <option value="MONTHS">MONTHS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label class="col-md-12">Predicted Close Date</label>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <input id="predictedClose" type="text" class="validate form-control datepicker"
                                           name="predictedClose" placeholder="dd/mm/YYYY"
                                    >
                                    <span class="input-group-addon"><i class="icon-calender"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label class="col-md-12">Information Source </label>
                            <div class="col-md-12">
                                <select class="form-control select2" name="infoSource" id="infoSources">
                                    <option value="" disabled selected>Select One</option>
                                    <option value="Referral">Personal Referral</option>
                                    <option value="Agent">Sales Agent</option>
                                    <option value="Website">Website</option>
                                    <option value="Newspaper">Newspaper</option>
                                    <option value="Advertisement">Outdoor Advertisement</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label class="col-md-12">Industry Sector</label>
                            <div class="col-md-12">
                                <input type="text" name="industry" id="industry" class="form-control"
                                       value="">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-submit" type="button" name="save" id="btnSubmit">
                    <i class="material-icons"></i>SUBMIT
                </button>
            </form>
        </div>
    </section>

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