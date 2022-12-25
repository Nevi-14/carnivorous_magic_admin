"use strict";

$(document).ready(function(){
    $("#registerForm").on("submit", function(e){
        var form = $(this);
        
        e.preventDefault();
        $.ajax({
            url : "#",
            type : 'POST',
            data : $(this).serialize(),    // multiple data sent using ajax
            success: function (response) {

                form.find('button[type=submit]').removeAttr('disabled');
                try{
                    var obj = JSON.parse(response);

                    if (obj.error === true) {
                        swal("", obj.message, "error");
                        $("#registerError").html(obj.message).show();
                    }else{
                        window.location.href = home +"my-account";
                    }
                }catch(ev){
                    form.find('button[type=submit]').removeAttr('disabled');
                }
            }
        });
    });

});