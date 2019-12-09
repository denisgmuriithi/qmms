<?php
require_once "../config/database.php";
if (!isset($_GET['id'])) {
    header("Location : index.php");
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

$state = $pdo->prepare("SELECT * FROM `opportunities` WHERE `id`=?");
if ($state->execute(array($_GET['id']))) {
    $row = $state->fetch();
    //echo var_dump($row);
}

$stm = $pdo->prepare("SELECT * FROM `leads` WHERE `id`=?");
if ($stm->execute(array($row['leadId']))) {
    $lead = $stm->fetch();
}


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
    <a class="navbar-brand" href="#">QET-Marketing Management System</a>
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
    <!-- page content goes here -->

    <!-- page header section -->
    <section class="card mt-2">
        <div class="card-body">
            <div class="card-title"><strong>Opportunity Details : <?php echo $row['name'] ?></strong>
                <button class="btn btn-success float-right btn-submit" type="button" name="save" id="btnSubmit">
                    <i class="material-icons">chevron_right</i>SUBMIT
                </button>
            </div>
        </div>
    </section>

    <!-- navigation tabs -->
    <section class="card mt-1">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="lead-tab" href="#lead" data-toggle="tab" role="tab"
                       aria-controls="lead" aria-selected="true">LEAD DETAILS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="potential-tab" href="#potential" data-toggle="tab" role="tab"
                       aria-controls="potential" aria-selected="false">POTENTIAL</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="partners-tab" href="#partners" data-toggle="tab" role="tab"
                       aria-controls="partners" aria-selected="false">PARTNERS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="competitors-tab" href="#competitors" data-toggle="tab" role="tab"
                       aria-controls="competitors" aria-selected="false">COMPETITORS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="progress-tab" href="#progress" data-toggle="tab" role="tab"
                       aria-controls="progress" aria-selected="false">PROGRESS</a>
                </li>
            </ul>
        </div>
    </section>

    <!-- tab contents -->
    <section class="card">
        <div class="card-body tab-content">
            <!-- lead details -->
            <div role="tabpanel" class="tab-pane fade active show" id="lead" aria-expanded="true"
                 aria-labelledby="lead-tab">
                <form class="form-horizontal" method="post" id="f0">
                    <div class="row">
                        <div class="col-md-8 col-8">
                            <div class="form-group">
                                <label class="col-md-12">Select Existing Lead or Customer </label>
                                <div class="col-md-12">
                                    <select class="form-control select2" name="lead" id="leads">
                                        <option value='<?php echo $lead["id"] ?>'
                                                selected><?php echo $lead['name'] ?></option>
                                        <?php
                                        $stm = $pdo->prepare("SELECT * FROM `leads`");
                                        $stm->execute();
                                        while ($opt = $stm->fetch()) {
                                            echo "<option value='{$opt['id']}'>{$opt['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-4">
                            <div class="form-group">
                                <label class="col-md-12">Date <span
                                            style="padding-top:0px;color:red;">*</span></label>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input id="datetime" type="text" class="validate form-control datepicker"
                                               name="datetime" placeholder="dd/mm/YYYY"
                                               value="<?php echo $lead['date'] ?>"
                                               required>
                                        <span class="input-group-addon"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Lead Name <span style="padding-top:0px;color:red;">*</span></label>
                        <div class="col-md-12">
                            <input type="text" id="leadName" class="form-control" name="name"
                                   value="<?php echo $lead['name'] ?>"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Contact Name <span
                                    style="padding-top:0px;color:red;">*</span></label>
                        <div class="col-md-12">
                            <input type="text" id="leadContact" class="form-control" name="contactName"
                                   value="<?php echo $lead['contact_person'] ?>"
                            >
                        </div>
                    </div>
                    <input type="text" style="display: none" id="leadType" name="leadType">
                    <div class="row">
                        <div class="col-md-8 col-8">for
                            <div class="form-group">
                                <label class="col-md-12">Phone No.<span
                                            style="padding-top:0px;color:red;">**</span></label>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-text">+254</span>
                                        <input type="text" id="leadPhone" class="form-control" name="phone"
                                               value="<?php echo $lead['phone'] ?>"
                                               placeholder="722 000 000">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-4">
                            <div class="form-group">
                                <label class="col-md-12">Total Invoiced to Date</label>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-text">KSh.</span>
                                        <input type="number" id="drBalance" class="form-control"
                                               placeholder="0.00" name="invoice" value="<?php echo $lead['invoice'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">e-Mail Address</label>
                        <div class="col-md-12">
                            <input type="email" id="leadEmail" class="form-control" name="email"
                                   value="<?php echo $lead['email'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Physical Address</label>
                        <div class="col-md-12">
                                <textarea class="form-control" id="leadPhysicalAdd" rows="3"
                                          name="physicalAdd"><?php echo $lead['address'] ?></textarea>
                        </div>
                    </div>
                </form>

            </div>
            <!-- POTENTIAL-->
            <div role="tabpanel" aria-labelledby="potential-tab" class="tab-pane fade in show" id="potential"
                 aria-expanded="false">
                <form class="form-horizontal" id="f1">
                    <div class="form-group">
                        <label class="col-md-12">Name of Opportunity <span
                                    style="padding-top:0px;color:red;">*</span></label>
                        <div class="col-md-12">
                            <input type="text" name="opportunity" id="opportunity" class="form-control"
                                   value="<?php echo $row['name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Description of Opportunity <span
                                    style="padding-top:0px;color:red;">*</span></label>
                        <div class="col-md-12">
                                        <textarea class="form-control" rows="3"
                                                  name="description"
                                                  id="description"><?php echo $row['description'] ?></textarea>
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
                                               class="form-control" value="<?php echo $row['potential_amount'] ?>">
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
                                               class="form-control" value="<?php echo $row['projected_margin'] ?>">
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
                                        <option value="<?php echo $row['interest_level'] ?>"
                                                selected><?php echo $row['interest_level'] ?></option>
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

                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM `agents`");
                                        $statement->execute();
                                        if ($statement->rowCount() > 0) {
                                            $agents = $statement->fetchAll();
                                            foreach ($agents as $agent) {
                                                if ($row['sales_agent'] == $agent['id']) {
                                                    echo "<option value='{$agent['id']}' selected>{$agent['name']}</option>";
                                                } else {
                                                    echo "<option value='{$agent['id']}'>{$agent['name']}</option>";
                                                }
                                            }
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
                                        <option value="<?php echo $row['engagement_protocol']?>"><?php echo $row['engagement_protocol']?></option>
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
                                           value="<?php echo $row['predicted_sales_period']?>">
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
                                               value="<?php echo $row['predicted_close_date']?>" readonly
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
                                        <option value="<?php echo $row['information_source']?>" selected><?php echo $row['information_source']?></option>
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
                                           value="<?php echo $row['industry_selector']?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- partners -->
            <div role="tabpanel" aria-labelledby="partners-tab" class="tab-pane fade in show" id="partners"
                 aria-expanded="false">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Role</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody id="pentries">
                        </tbody >
                        <tbody>
                        <tr>
                            <td id="nextP">1</td>
                            <td class="txt-oflo">
                                <input type="number" value="<?php echo $row['id']?>" hidden id="opportunityId">
                                <div class="form-group"><input type="text" class="form-control" id="partnerName">
                                </div>
                            </td>
                            <td class="txt-oflo">
                                <div class="form-group">
                                    <select class="form-control select2" style="min-width: 150px"
                                            id="partnerCategory">
                                        <option value="" disabled selected>Select One</option>
                                        <option value="Sub-Contractor">Sub-Contractor</option>
                                        <option value="Supplier">Supplier</option>
                                        <option value="Referee">Referee</option>
                                        <option value="Associate">Associate</option>
                                        <option value="Agent">Sales Agent</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </td>
                            <td class="txt-oflo">
                                <div class="form-group"><input type="text" class="form-control" id="partnerRole">
                                </div>
                            </td>
                            <td class="txt-oflo">
                                <button type="button" class="btn btn-success btn-add" id="btnPartner"><i
                                            class="material-icons">add</i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- COMPETITORS -->
            <div role="tabpanel" aria-labelledby="competitors-tab" class="tab-pane fade in show" id="competitors"
                 aria-expanded="false">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Threat Level</th>
                            <th>Strength</th>
                            <th>Weakness</th>
                            <th>Won?</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody id="centries">
                        </tbody>
                        <tbody>
                        <tr>
                            <td id="nextC">1</td>
                            <td class="txt-oflo">
                                <div class="form-group"><input type="text" class="form-control" id="competitorName">
                                </div>
                            </td>
                            <td class="txt-oflo">
                                <div class="form-group">
                                    <select class="form-control select2" style="min-width: 150px"
                                            id="competitorThreat">
                                        <option value="" disabled selected>Select One</option>
                                        <option value="LOW">LOW</option>
                                        <option value="MEDIUM">MEDIUM</option>
                                        <option value="HIGH">HIGH</option>
                                    </select>
                                </div>
                            </td>
                            <td class="txt-oflo">
                                <div class="form-group"><input type="text" class="form-control"
                                                               id="competitorStrength"></div>
                            </td>
                            <td class="txt-oflo">
                                <div class="form-group"><input type="text" class="form-control"
                                                               id="competitorWeakness"></div>
                            </td>
                            <td class="txt-oflo">
                                <div class="form-group">
                                    <select class="form-control select2" style="min-width: 150px"
                                            id="won">
                                        <option value="" disabled selected>Select One</option>
                                        <option value="yes">YES</option>
                                        <option value="no">NO</option>
                                    </select>
                                </div>
                            </td>
                            <td class="txt-oflo">
                                <button type="button" class="btn btn-success bt-addc" id="addCompetitor"><i
                                            class="material-icons">add</i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- PROGRESS -->
            <div role="tabpanel" aria-labelledby="progress-tab" class="tab-pane fade in show" id="progress"
                 aria-expanded="false">
                <div class="panel-body">
                    <label class="col-md-4">OVERALL STATUS: <span
                                style="padding-top:0px;color:red;">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control select2" id="overallStatus">
                            <option value="OPEN" selected>OPEN</option>
                            <option value="WON">WON</option>
                            <option value="CANCELLED">CANCELLED</option>
                            <option value="LOST">LOST</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Task</th>
                            <th>Party</th>
                            <th>Date</th>
                            <th>Remarks</th>
                            <th>Outcome</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody id="tentries">
                        </tbody>
                        <tbody>
                        <tr>
                            <td id="nextT">1</td>

                            <td class="txt-oflo">
                                <div class="form-group">
                                    <!--select class="form-control select2" style="min-width: 150px" id="taskName">
                                      <option value="" disabled selected>Select One</option>
                                    </select-->
                                    <div class="form-group"><input type="text" class="form-control" id="taskName">
                                    </div>
                                </div>
                            </td>
                            <td class="txt-oflo">
                                <!--select class="form-control select2" style="min-width: 150px" id="taskParty">
                                  <option value="" disabled selected>Select One</option>
                                </select-->
                                <div class="form-group"><input type="text" class="form-control" id="taskParty">
                                </div>
                            </td>
                            <td class="txt-oflo">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input id="taskDate" type="text" class="validate form-control datepicker"
                                               placeholder="dd/mm/YYYY" required>
                                        <span class="input-group-addon"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </td>
                            <td class="txt-oflo">
                                <div class="form-group"><input type="text" class="form-control" id="taskRemarks">
                                </div>
                            </td>
                            <td class="txt-oflo">
                            <div class="form-group">
                                <select type="text" class="form-control" id="taskOutcome">
                                    <option value="" disabled selected>Select One</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>
                            </td>
                            <td class="txt-oflo">
                                <button type="button" class="btn btn-success btn-add" id="addTask"><i
                                            class="material-icons">add</i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>
<script src="../js/app.js"></script>
</body>
</html>