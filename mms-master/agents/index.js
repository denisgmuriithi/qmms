$(document).ready(function(){
    $.get({
           url: "read.php",
           success: function (data) {
               data = JSON.parse(data);
               console.log(data);
               populateAgentData(data);
           }
       });

    function populateAgentData(data){
     let count = 0, status;
     for(let i = 0; i < data.length; i++){
       count +=1;
       if(data[i].status === 1) {
         status = "active";
       }else{
         status = "Deactivated";
       }
       let row = "<tr><td>"+count+"</td><td>"+data[i].name+"</td><td>"+data[i].email+"</td><td>"+data[i].phone+"</td><td>"+status+"</td><td><button class='btn btn-primary btn-sm' data-value = "+data[i].id+" id='edit'>edit</button> <button class='btn btn-danger btn-sm'data-value = "+data[i].id+" id='delete'>delete</button></td></tr>";
       $(row).appendTo($("#tcontent"));
     }
    }

    $("#submit").on("click", function(event){
     event.preventDefault();
       console.log("clicked");
       submitAgentData();
    });

    function submitAgentData(){
     if ($("#name").val().length <= 0) {
       $("#name").focus();
       $("<p class='alert alert-info'>please provide a name</p>").appendTo($(".modal-body"));
     }else if ($("#email").val().length <= 0) {
       $("#email").focus();
       $("<p class='alert alert-info'>please provide an email</p>").appendTo($(".modal-body"));
     }else if ($("#contact").val().length <= 0) {
       $("#contact").focus();
       $("<p class='alert alert-info'>please provide contact</p>").appendTo($(".modal-body"));
     }else{
       data = {
         name : $("#name").val(),
         email: $("#email").val(),
         contact: $("#contact").val()
       };

       console.log(data);
       postAgent(data);
     }
    }

    function postAgent(data){
      $.post({
        url: "add.php?action=add",
        method: "POST",
        data: data,
        success: function(data){
          //data = JSON.parse(data);
          console.log(data);
           location.reload()
        }
      });
    }

    //AGENT UPDATE

    $("#edit").on("click", function(){
        console.log("clicked");
        alert($("#edit").attr('data-value'));
    });

    $('.btn btn-danger #delete').click(function() {
        alert($(this).attr('data-value'));
    });
   
 });