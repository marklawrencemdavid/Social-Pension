(function () {
    'use strict'
  
    feather.replace({ 'aria-hidden': 'true' })
})()
$(function() {
    // Display preview image
    $('#file-input').on("change", function(){
        var $preview = $('#preview').empty();
        if (this.files) $.each(this.files, readAndPreview);

        function readAndPreview(i, file) {
            // Check file extensions that is allowed
            if (!/\.(png|jpg|jpeg|bmp|tiff|gif)$/i.test(file.name)){
                $("#error_file").html("<i class='bi bi-exclamation-triangle'></i> Selected an unsupported file. The system is only accepting png,jpg,jpeg,bmp,tiff, and gif file.");
                $('#file-input').val('');
            } else {
                var reader = new FileReader();

                if((file.name).length < 21){
                    var filename = file.name
                }else{
                    var filename = (file.name).substring(0, 21) + '...'
                }

                $(reader).on("load", function() {
                    $preview.append("<div class='col-12'>"+"<img src='"+this.result+"' style='width:100%'/>"+"<p class='text-center'>"+filename+"</p>"+"</div>");
                    $("#error_file").html("");
                });

                reader.readAsDataURL(file);
            }
        }
    });
    // Clear input file and image preview
    $("body").on('click', '#file-clear', function(){
        // $('#file-clear').on("click", function(){
        $('#file-input').val('');
        $("#preview").html("");
    });
    // Reset modal add_purchase on close
    $('.close').on("click", function(){
        $("#addModal").modal('hide');
        $('.needs-validation')[0].reset();
        $("#error_file").html("");
        $("#preview").html("");
    });
    // Reset update password tab on username tab click
    $('#home-tab').on("click", function(){
        $(".update_password").removeClass('was-validated');
        $('.needs-validation')[2].reset();
        $('.errorsucces').html('');
    });
    // Reset update username tab on password tab click
    $('#profile-tab').on("click", function(){
        $(".update_username").removeClass('was-validated');
        $('.needs-validation')[1].reset();
        $('.errorsucces').html('');
    });
    // Reset modal update username/password on close
    $('.close1').on("click", function(){
        $("#update").modal('hide');
        $(".update_username").removeClass('was-validated');
        $(".update_password").removeClass('was-validated');
        $('.needs-validation')[1].reset();
        $('.needs-validation')[2].reset();
        $('.errorsucces').html('');
        $("#home-tab").addClass('active');
        $("#home").addClass('show active');
        $("#profile-tab").removeClass('active');
        $("#profile").removeClass('show active');
    });
    // Show all password on update_password tab
    $('#showpass').click(function(){
        if('password' == $('#input_pass').attr('type')){
            $('#input_pass').prop('type', 'text');
            $('#input_pass1').prop('type', 'text');
            $('#input_pass2').prop('type', 'text');
        }else{
            $('#input_pass').prop('type', 'password');
            $('#input_pass1').prop('type', 'password');
            $('#input_pass2').prop('type', 'password');
        }
    });
    //Update username
    $(".update_username").submit(function(e){
        e.preventDefault();
        if($('.new_username').val() != '' && $('.cur_password').val() != ''){
            var cur_password = $.trim($(".cur_password").val());
            var new_username = $.trim($('.new_username').val());
            if(cur_password != '' && new_username != ''){
                $.ajax({
                    url: "/assets/php/profile_crud.php",
                    method: "POST",
                    data:{
                        new_username:new_username,
                        cur_password:cur_password
                    },
                    success:function(data){
                        $('.errorsucces').html(data);
                        $(".update_username").removeClass('was-validated');
                        $(".update_username")[0].reset();
                    }
                });
            }else{
                $('.errorsucces').html('<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-circle-fill h5"></i> Spaces are not allowed.</div>');
            }
        }
    });
    // Update password
    $(".update_password").submit(function(e){
        e.preventDefault();
        // Check if null
        if($('.new_password').val() != '' && $('.re_new_password').val() != '' && $('.curr_password').val() != ''){
            // Check if less than 7 characters
            if($('.new_password').val().length > 7 && $('.new_password').val().length > 7 && $('.new_password').val().length > 7){
                var new_password = $.trim($(".new_password").val());
                var re_new_password = $.trim($('.re_new_password').val());
                var curr_password = $.trim($('.curr_password').val());
                // Check if spaces
                if(new_password != '' && re_new_password != '' && curr_password != ''){
                    var pattern = /^(?=.*\d)(?=.*[a-z]).{8,}$/;
                    // Check for pattern(REGEX)
                    if(new_password.match(pattern) && re_new_password.match(pattern) && curr_password.match(pattern)){
                        if(new_password != re_new_password){
                            $('.errorsucces').html('<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-circle-fill h5"></i> New passwords do not match.</div>');
                        }else{
                            $.ajax({
                                url: "/assets/php/profile_crud.php",
                                method: "POST",
                                data:{
                                    new_password:new_password,
                                    re_new_password:re_new_password,
                                    cur_password:curr_password
                                },
                                success:function(data){
                                    $('.errorsucces').html(data);
                                    $(".update_password").removeClass('was-validated');
                                    $(".update_password")[0].reset();
                                }
                            });
                        }
                    }
                }else{
                    $('.errorsucces').html('<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-circle-fill h5"></i> Spaces are not allowed.</div>');
                }
            }
        }
    });
    // Insert Purchase
    $("body").on('submit', '#insert_purchase_form', function(event){
        event.preventDefault();
        $.ajax({
            url: "assets/php/purchase_crud.php?id=1",
            method: "POST",
            processData: false,
            contentType: false, 
            // cache: false,
            data: new FormData(this),
            success:function(response){
                if(response == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Purchase added successfully',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    })
                    $("#addModal").modal('hide');
                    $('.needs-validation')[0].reset();
                    $("#error_file").html("");
                    $("#preview").html("");
                    $('#tbl_purchase_dashboard').load(location.href + " #tbl_purchase_dashboard");
                    $('#tbl_purchase').load(location.href + " #tbl_purchase");
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: response,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    })
                }
            }
        });
    });
    // Populate Update Modal
    $("body").on('click', '#view_purchase', function(event){
        $('#updateModal').modal();
        var pur_id = $(this).attr("data-id");
        $.ajax({
            url: "/assets/php/purchase_update_modal.php",
            method: "POST",
            data:{pur_id:pur_id},
            success:function(data){
                $('#updateModalBody').html(data);
                $('#updateModal').modal('show');
            }
        });
    });
    // Update Purchase
    $("body").on('submit', '#update_purchase_form', function(event){
        event.preventDefault();
        var formData = new FormData(this);
        if(btnUpdate == '1'){formData.append('pur_update', 'true');}
        else if(btnUpdate == '2'){formData.append('pur_delete', 'true');}
        formData.append('pur_id', pur_id)
        $.ajax({
            url: "assets/php/purchase_crud.php?id=2",
            method: "POST",
            processData: false,
            contentType: false, 
            // cache: false,
            data: formData,
            success:function(response){
                if(response == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Purchase updated successfully',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    })
                    $("#updateModal").modal('hide');
                    $('.needs-validation')[0].reset();
                    $("#error_file").html("");
                    $("#preview").html("");
                    $('#tbl_purchase_dashboard').load(location.href + " #tbl_purchase_dashboard");
                    $('#tbl_purchase').load(location.href + " #tbl_purchase");
                }else if(response == 2){
                    Swal.fire({
                        icon: 'success',
                        title: 'Purchase deleted successfully',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    })
                    $("#updateModal").modal('hide');
                    $('.needs-validation')[0].reset();
                    $("#error_file").html("");
                    $("#preview").html("");
                    $('#tbl_purchase_dashboard').load(location.href + " #tbl_purchase_dashboard");
                    $('#tbl_purchase').load(location.href + " #tbl_purchase");
                }else{ 
                    Swal.fire({
                        icon: 'error',
                        title: response,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    })
                }
            }
        });
    });
    $("body").on('click', '#dashboard_button', function(){
        $("#dashboard_button").addClass('active');
        $("#purchases_button").removeClass('active');
        $("#sms_button").removeClass("active");
        $("#profile_button").removeClass("active");

        $("#dashboard_main").removeClass('visually-hidden');
        $("#purchase_main").addClass('visually-hidden');
        $("#sms_main").addClass("visually-hidden");
        $("#profile_main").addClass("visually-hidden");
    });
    $("body").on('click', '#purchases_button', function(){
        $("#dashboard_button").removeClass('active');
        $("#purchases_button").addClass('active');
        $("#sms_button").removeClass("active");
        $("#profile_button").removeClass("active");

        $("#dashboard_main").addClass('visually-hidden');
        $("#purchase_main").removeClass('visually-hidden');
        $("#sms_main").addClass("visually-hidden");
        $("#profile_main").addClass("visually-hidden");
    });
    $("body").on('click', '#sms_button', function(){
        $("#dashboard_button").removeClass('active');
        $("#purchases_button").removeClass("active");
        $("#sms_button").addClass("active");
        $("#profile_button").removeClass("active");

        $("#dashboard_main").addClass('visually-hidden');
        $("#purchase_main").addClass("visually-hidden");
        $("#sms_main").removeClass("visually-hidden");
        $("#profile_main").addClass("visually-hidden");
    });
    $("body").on('click', '#profile_button', function(){
        $("#dashboard_button").removeClass('active');
        $("#purchases_button").removeClass("active");
        $("#sms_button").removeClass("active");
        $("#profile_button").addClass("active");

        $("#dashboard_main").addClass('visually-hidden');
        $("#purchase_main").addClass("visually-hidden");
        $("#sms_main").addClass("visually-hidden");
        $("#profile_main").removeClass("visually-hidden");
    });
    $("body").on('click', '#view_sms', function(event){
        $('#smsViewModal').modal();
        var sms_id = $(this).attr("data-id");
        $.ajax({
            url: "/assets/php/sms_modal.php",
            method: "POST",
            data:{sms_id:sms_id},
            success:function(data){
                $('#sms_info').html(data);
                $('#smsViewModal').modal('show');
            }
        });
    })
});
$("#dashboard_button").addClass('active');
$("#purchases_button").removeClass('active');
$("#sms_button").removeClass("active");
$("#profile_button").removeClass("active");

$("#dashboard_main").removeClass('visually-hidden');
$("#purchase_main").addClass('visually-hidden');
$("#sms_main").addClass("visually-hidden");
$("#profile_main").addClass("visually-hidden");