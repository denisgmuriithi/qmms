<?php
require_once "../config/database.php";
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
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
                            <a href="add.php">
                                <button class="btn btn-success waves-effect waves-light pull-right bt-create"
                                        type="button"><span class="btn-label"><i class="material-icons">add</i></span>NEW
                                    OPPORTUNITY
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
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        // $('.input-daterange input').each(function () {
        //     $(this).datepicker('clearDates');
        // });

        $.get({
            url:"read.php?action=read",
            success:function (data) {
                console.log(data);
                data = JSON.parse(data);
                populateData(data);
            }
        });

        function populateData(data) {
            let i, status;
            for ( i = 0; i < data.length; i++) {
                if (data[i].status === "1"){
                    status = "active";
                }else{
                    status = "deactivated";
                }
                let row = `<tr><td>${data[i].date}</td><td>${data[i].lead}</td><td>${data[i].title}</td>
<td>${data[i].description}</td><td>${data[i].agent}</td><td>${status}</td>
<td><a href="update.php?id=${data[i].id}" class='text-primary'>
                        <i class='material-icons'>edit</i>
                    </a>&nbsp;
                    <a href="delete.php?id=${data[i].id}" class='text-danger'>
                        <i class='material-icons'>delete</i>
                    </a></td></tr>`;
                $(row).appendTo($("#tcontent"));
            }
        }
    });
</script>

</body>
</html>