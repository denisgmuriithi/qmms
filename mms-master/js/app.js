$(document).ready(function () {
    "use strict";


// Script for global page functionality
//when submit btn is clicked check to see if lead is new
    $("#btnSubmit").on("click", function () {
        addLead();
        addPotential();
    });

    //setting date picker
 //$(".datepicker").val(new Date());

    //activate tabs

    $("#myTab").on("click", function (event) {
        $("#myTab .active").removeClass("active");
        $(event.target).addClass("active");
    });

    //setting predicted sales data
 function setPredictedCloseDate(){
    let seconds, selected, period, date, pDate;
    period = $("#period").val();
     selected = $("#cycles option:selected").val();
    //console.log(selected, period);

    if(selected === "MONTHS"){
        seconds = period * 4 * 604800;
    }else if(selected === "WEEKS"){
        seconds = period * 604800;
    }else if(selected === "DAYS"){
        seconds = period * 86400;
    }

    date = new Date(new Date().getTime() + (seconds * 1000 ));

    //console.log(date, seconds);
    $("#predictedCloseDate").val(date);
 }

 $("#period").on("change", function(){
     setPredictedCloseDate();
 });

 $("#cycles").on("change", function(){
    setPredictedCloseDate();
 });
//script for Leads


    function addLead() {
        let lead = {};
        lead.leadName = $("#leadName").val();
        lead.date = $("#datetime").val();
        lead.phone = $("#leadPhone").val();
        lead.contact = $("#leadContact").val();
        lead.balance = $("#drBalance").val();
        lead.email = $("#leadEmail").val();
        lead.address = $("#leadPhysicalAdd").val();

        //console.log("lead", lead);
        let url = "add.php?action=addLead";
        $.ajax({
            url: url,
            method: "POST",
            data: lead,
            success: function (data) {
                //console.log(data);
            }
        });
    }

    $("#leads").on("change", function () {
        let id = $(this).val(), url;
        url = "read.php?id=" + id;

        //console.log(url, id);

        $.get({
            url: url,
            success: function (data) {
                data = JSON.parse(data);
                //console.log(data);
                populateLeadData(data);
            }
        });

    });

    function populateLeadData(data) {
        $("#datetime").val(data.date);
        $("#leadName").val(data.name);
        $("#leadPhone").val(data.phone);
        $("#leadContact").val(data.contact_person);
        $("#drBalance").val(data.invoice);
        $("#leadEmail").val(data.email);
        $("#leadPhysicalAdd").val(data.address);
        getPotential(data.opportunity_id);
    }

    // script for potential
    function addPotential() {
        let potential = {};
        potential.opportunity = $("#opportunity").val();
        potential.description = $("#description").val();
        potential.amount = $("#potAmount").val();
        potential.margin = $("#projectedMargin").val();
        potential.interestLevel = $("#interestLevels").val();
        potential.agent = $("#agents").val();
        potential.protocol = $("#protocols").val();
        potential.period = $("#period").val();
        potential.cycles = $("#cycles").val();
        potential.predictedClose = $("#predictedClose").val();
        potential.infoSources = $("#infoSources").val();
        potential.industry = $("#industry").val();

        let url = "add.php?action=addPotential";
        $.ajax({
            url: url,
            method: "POST",
            data: potential,
            success: function (data) {
                //console.log(data, "add potential called");
            }
        })
    }

    function getPotential(id) {
        //console.log("potential id = ", id);
        $.get({
            url: "read.php?potId=" + id,
            success: function (data) {
                //console.log(data);
                setPotential(data);
            }
        });
    }

    function setPotential(data) {
        $("#opportunity").val(data.name);
        $("#description").val(data.description);
        $("#potAmount").val(data.potential_amount);
        $("#projectedMargin").val(data.projected_margin);
        $("#interestLevels").val(data.interest_level);
        $("#agents").val(data.sales_agent);
        $("#protocols").val(data.engagement_protocol);
        $("#period").val(data.predicted_sales_period);
        $("#cycles").val(data.cycles);
        $("#predictedClose").val(data.predicted_close_date);
        $("#infoSources").val(data.information_source);
        $("#industry").val(data.industry_selector);

    }

    // script for partners

    function addPartner() {
        let partner = {}, url;
        partner.partnerName = $("#partnerName").val();
        partner.partnerCategory = $("#partnerCategory").val();
        partner.partnerRole = $("#partnerRole").val();
        partner.opportunityId = $("#opportunityId").val();

        url = "read.php?action=addPartner";
        //console.log(partner);

        $.ajax({
            url: url,
            method: "POST",
            data: partner,
            success: function (data) {
                //console.log(data);
                displayPartners(data);
            }
        });

    }

    function setPartners() {
        let url = "read.php?action=setPartner";
        $.ajax({
            url: url,
            method: "POST",
            data: {"opportunityId": $("#opportunityId").val()},
            success: function (data) {
                //console.log(data);
                displayPartners(data);
            }
        })
    }

    setPartners();

    function getPartner(id) {
        $.get({
            url: "read.php?partnerId=" + id,
            success: function (data) {
                //console.log(data);
                data = JSON.parse(data);
                displayPartners(data);
            }
        });
    }


    $("#btnPartner").on("click", function () {
        addPartner();
    });

    $("button .delete").click(function () {
        //event.preventDefault();
       //console.log( "clicked");
       //$(this).data("value");
    });

    function displayPartners(data) {
        data = JSON.parse(data);
        let pentries = $("#pentries"), row, count = 1;
        pentries.empty();
        //console.log(data);
        for (let i = 0; i < data.length; i++) {
            row = `<tr id='partnerData'><td>${count++}</td><td>${data[i].name}</td><td>${data[i].category}</td><td>${data[i].role}</td>
<td><a href="delete.php?partId=${data[i].id}" class='btn btn-info delete' role="button" id='delete' data-value="${data[i].id}"><i class='material-icons'>delete</i> </a> </td></tr>`;
            $(row).appendTo(pentries);
        }
        clearForm();
    }

    function clearForm() {
        $("#partnerName").val("");
        $("#partnerCategory").val("");
        $("#partnerRole").val("");
    }

    // script for competitors
    function addCompetitors() {
        let competitors = {};
        competitors.name = $("#competitorName").val();
        competitors.threat = $("#competitorThreat").val();
        competitors.strength = $("#competitorStrength").val();
        competitors.weakness = $("#competitorWeakness").val();
        competitors.won = $("#won").val();
        competitors.opportunityId = $("#opportunityId").val();


        let url = "read.php?action=addCompetitor";
        //console.log(competitors);
        $.ajax({
            url: url,
            method: "POST",
            data: competitors,
            success: function (data) {
                //console.log(data);
                data = JSON.parse(data);
                setCompetitors(data);
            }
        });
    }

    function getCompetitors(id) {
        $.get({
            url: "read.php?competitorId=" + id,
            success: function (data) {
                //console.log(data);
                displayCompetitors(data);
            }
        });
    }

    function setCompetitors() {
        let url = "read.php?action=setCompetitor";
        $.ajax({
            url: url,
            method: "POST",
            data: {"opportunityId": $("#opportunityId").val()},
            success: function (data) {
                //console.log(data);
                displayCompetitors(data);
            }
        });
    }

    setCompetitors();

    $("#addCompetitor").on("click", function () {
        addCompetitors();
    });

    function  displayCompetitors(data) {
        data = JSON.parse(data);
        $("#centries").empty();
        let i, status, row, count=1;
        for (i = 0; i < data.length; i++) {
            //TODO set competitors
            if (data[i].won === "1"){
                status = "Yes";
            }else{
                status = "No";
            }
            row =`<tr id='${data[i].id}'><td>${count++}</td><td>${data[i].name}</td><td>${data[i].threat_level}</td><td>${data[i].strength}</td>
<td>${data[i].weakness}</td><td>${status}</td><td><a href="delete.php?delComId=${data[i].id}" class='btn btn-link delCom' id='delete' role="button"><i class='material-icons'>delete</i> </a> </td></tr>`
            $(row).appendTo($("#centries"));
        }
        clearCompetitorForm();
    }

function clearCompetitorForm(){
    $("#competitorName").val("");
    $("#competitorThreat").val("");
        $("#competitorStrength").val("");
        $("#competitorWeakness").val("");
        $("#won").val("");
}
//script for task operations
    function addTask() {
        let task = {};
        task.name = $("#taskName").val();
        task.party = $("#taskParty").val();
        task.date = $("#taskDate").val();
        task.remarks = $("#taskRemarks").val();
        task.outCome = $("#taskOutcome").val();
        task.opportunityId = $("#opportunityId").val();

        let url = "read.php?action=addProgress";
        //console.log(task);
        $.ajax({
            url: url,
            method: "POST",
            data: task,
            success: function (data) {
                //console.log(data);
                displayProgress(data);
            }
        });
    }

    function displayProgress(data) {
        data = JSON.parse(data);
        $("#tentries").empty();
        let i, status, row, count=1;
        for (i = 0; i < data.length; i++) {
            //TODO set competitors
            if (data[i].won === "1"){
                status = "Yes";
            }else{
                status = "No";
            }
            row =`<tr><td>${count++}</td><td>${data[i].task}</td><td>${data[i].party}</td><td>${data[i].date}</td><td>${data[i].remarks}</td>
            <td>${data[i].outcome}</td><td><a href="delete.php?progId=${data[i].id}" class='btn btn-link ' id='delete' role="button"><i class='material-icons'>delete</i> </a> </td></tr>`;
            $(row).appendTo($("#tentries"));

        }
        clearProgressForm();
    }

    function getProgress(id) {
        $.get({
            url: "read.php?progressId=" + id,
            success: function (data) {
                //console.log(data);
                setProgress(data);
            }
        });
    }

    function setProgress() {
          let url = "read.php?action=setProgress";
        $.ajax({
            url: url,
            method: "POST",
            data: {"opportunityId": $("#opportunityId").val()},
            success: function (data) {
                //console.log(data);
                displayProgress(data);
            }
        });
    }

    setProgress();

    $("#addTask").on("click", function () {
        addTask();
    });


function clearProgressForm(){
    $("#taskName").val("");
    $("#taskParty").val("");
    $("#taskDate").val("");
    $("#taskRemarks").val("");
    $("#taskOutcome").val("");
}
});


