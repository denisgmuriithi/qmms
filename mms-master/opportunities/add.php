<?php
require_once "../config/database.php";
session_start();
if (!isset($_SESSION['user'])) {
    header("Location:index.php");
    exit();
}
$db = new Database();
$pdo = $db->getConnection();
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
    <a class="navbar-brand" href="#">QET - Marketing Management System</a>
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
                    <i class="material-icons">chevron_right</i>SUBMIT
                </button>
            </form>
        </div>
    </section>

</main>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>
<script src="../js/app.js"></script>
</body>
</html>