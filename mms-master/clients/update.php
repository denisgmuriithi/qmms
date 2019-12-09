<?php
 require_once  "../config/database.php";

 if (isset($_GET['id'])){
     $id = $_GET['id'];
     $db = new Database();
     $pdo = $db->getConnection();

     $state = $pdo->prepare("SELECT * FROM `clients` WHERE `id`=?");
     if ($state->execute(array($id))) {
         $row = $state->fetch();
         //echo var_dump($row);
     }
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
<main class="container card mt-5 p-5">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
               aria-selected="true">Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
               aria-selected="false">History</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h4 class="display-4 text-center">Client Details</h4>
            <div class="row">
                <div class="col-md-6 ">
                    <div><strong> Name </strong></div>
                    <input type="text" class="form-control-plaintext m-2" id="name" value="<?php echo $row['name'];?>" >
                </div>
                <div class="col-md-6 ">
                    <div><strong>Contact Name </strong></div>
                    <input type="text" class="form-control-plaintext m-2" id="contactName" value="<?php echo $row['contact_name'];?>">
                </div>
                <div class="col-md-6 ">
                    <div><strong> Phone Number </strong></div>
                    <input type="text" class="form-control-plaintext m-2" id="phone" value="<?php echo $row['phone'];?>">
                </div>
                <div class="col-md-6 ">
                    <div><strong> Email </strong></div>
                    <input type="text" class="form-control-plaintext m-2" id="email" value="<?php echo $row['email'];?>">
                </div>
                <div class="col-md-6 ">
                    <div><strong> Physical Address </strong></div>
                    <input type="text" class="form-control-plaintext m-2" id="address" value="<?php echo $row['address'];?>">
                    <input type="hidden" id="detailId" value="<?php echo $row['id'];?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-offset-4 p-5">
                    <button class="btn btn-info m-5" id="update">Update Details</button>
                    <button class="btn btn-success m-5 " id="save" >Save Changes</button>
                </div>

            </div>
        </div>


        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <h2 class="display-4 text-center">Business History</h2>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>solution</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Account Manager</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody id="hentries">
                    </tbody>
                    <tbody>
                    <tr>
                        <td id="nextP">1 <input type="hidden" id="detailId" value="<?php echo $row['id'];?>"></td>
                        <td class="txt-oflo">
                            <input type="number" value="" hidden id="opportunityId">
                            <div class="form-group"><input type="text" class="form-control" id="solution">
                            </div>
                        </td>
                        <td class="txt-oflo">
                            <div class="form-group">
                                <input type="text" class="form-control" id="description">
                            </div>
                        </td>
                        <td class="txt-oflo">
                            <div class="form-group"><input type="text" class="form-control" id="amount">
                            </div>
                        </td>
                        <td class="txt-oflo">
                            <div class="form-group"><input type="text" class="form-control" id="manager">
                            </div>
                        </td>
                        <td class="txt-oflo">
                            <div class="form-group"><select type="text" class="form-control" id="status">
                            <option value="satisfied">Satisfied</option>
                            <option value="unsatisfied">UnSatisfied</option>
                            </select>
                            </div>
                        </td>
                        
                        <td class="txt-oflo">
                            <button type="button" class="btn btn-success btn-add" id="history"><i
                                        class="material-icons">add</i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        "use strict";

        // tabs functionality
        $('#myTab a').on('click', function (e) {
            e.preventDefault()
            $("#myTab .active").removeClass("active");
            $(e.target).addClass("active");
            $(this).tab('show');
        });

        //edit client details
        $("#save").hide();
        $("#update").on("click", function () {
           $(".col-md-6 input[type='text']").removeClass("form-control-plaintext").addClass("form-control");
           $("#save").show();
           $("#update").hide();
        });

        $.ajax({
            url: "functions.php?action=getHistory",
            method: "POST",
            data: {"detailId": $("#detailId").val()},
            success: function (data) {
                console.log(data);
                displayhistory(data);
            }
        });

        $("#save").on("click", function(){
            let details = {};
            details.name = $("#name").val();
            details.contactName = $("#contactName").val();
            details.email = $("#email").val();
            details.address = $("#address").val();
            details.phone = $("#phone").val();
            details.detailId = $("#detailId").val();

           // console.log(details);
            
            $.ajax({
                url: "functions.php?action=updateDetails",
                method: "POST",
                data: details,
                success:function (data) {
                   // data = JSON.parse(data);
                        console.log(data);
                        updateDetails(data);
                }
            });

            $("#save").hide();
            $(".col-md-6 input[type='text']").removeClass("form-control").addClass("form-control-plaintext");
        });

        function updateDetails(data) {
            data = JSON.parse(data);
            $("#name").val(data.name);
            $("#contactName").val(data.contact_name);
            $("#email").val(data.email);
            $("#address").val(data.address);
            $("#phone").val(data.phone);
            $("#detailId").val(data.id);
            $("#update").show();
        }

        $("#history").on("click", function(){
            let history = {};
            history.solution = $("#solution").val();
            history.description = $("#description").val();
            history.amount = $("#amount").val();
            history.manager = $("#manager").val();
            history.status = $("#status").val();
            history.detailId = $("#detailId").val();

            $.ajax({
                url: "functions.php?action=addHistory",
                method: "POST",
                data: history,
                success:function (data) {
                   // data = JSON.parse(data);
                        console.log(data);
                        displayhistory(data);
                }
            });
        });

        function displayhistory(data) {
        data = JSON.parse(data);
        $("#hentries").empty();
        let i, status, row, count=1;
        for (i = 0; i < data.length; i++) {
            row =`<tr><td>${count++}</td><td>${data[i].solution}</td><td>${data[i].description}</td><td>${data[i].amount}</td><td>${data[i].manager}</td>
            <td>${data[i].status}</td><td><a href="delete.php?historyId=${data[i].id}" class='btn btn-link ' id='delete' role="button"><i class='material-icons'>delete</i> </a> </td></tr>`;
            $(row).appendTo($("#hentries"));

        }
        clearHistoryForm();
        }

        function clearHistoryForm(){
            $("#solution").val("");
            $("#description").val("");
            $("#amount").val("");
            $("#manager").val("");
            $("#status").val("");
        }

    });
</script>
</body>
</html>