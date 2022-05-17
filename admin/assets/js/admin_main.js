$(function() { 'use strict'
    /* ---------------------------------------------- /*
    * Validate Forms
    /* ---------------------------------------------- */
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
});
$(function() {
    /* ---------------------------------------------- /*
    * Register Form Availability
    /* ---------------------------------------------- */
        $('#page_form_avail_time_from, #page_form_avail_time_to, #page_form_avail_day_from, #page_form_avail_day_to').change(function(){
            var page_form_avail_time_to = $('#page_form_avail_time_to').val().slice(0, 5);
            var page_form_avail_time_from = $('#page_form_avail_time_from').val().slice(0, 5);
            // Only days are same
            if ( page_form_avail_time_to != page_form_avail_time_from && $('#page_form_avail_day_to').val() == $('#page_form_avail_day_from').val() ) {
                $('#messagehr').html(''); 
                $('#messagedy').html('Days should not be the same.');
                $(':button[type="submit"]').prop('disabled', true);
            }
            // Only time is same
            else if ( page_form_avail_time_to == page_form_avail_time_from && $('#page_form_avail_day_to').val() != $('#page_form_avail_day_from').val() ) {
                $('#messagehr').html('Time should not be the same.'); 
                $('#messagedy').html('');
                $(':button[type="submit"]').prop('disabled', true);
            }
            // Both are same
            else if ( page_form_avail_time_to == page_form_avail_time_from && $('#page_form_avail_day_to').val() == $('#page_form_avail_day_from').val() ) {
                $('#messagehr').html('Time should not be the same.'); 
                $('#messagedy').html('Days should not be the same.');
                $(':button[type="submit"]').prop('disabled', true);
            }
            // Both are not same
            else if ( page_form_avail_time_to != page_form_avail_time_from && $('#page_form_avail_day_to').val() != $('#page_form_avail_day_from').val() ) {
                $('#messagehr').html(''); 
                $('#messagedy').html('');
                $(':button[type="submit"]').prop('disabled', false);
            }
        });
    /* ---------------------------------------------- /*
    * Settings Time Availability
    /* ---------------------------------------------- */
        $('#page_avail_time_to, #page_avail_time_from').change(function(){
            var page_avail_time_to = $('#page_avail_time_to').val().slice(0, 5);
            var page_avail_time_from = $('#page_avail_time_from').val().slice(0, 5);
            // Time are same
            if ( page_avail_time_to == page_avail_time_from ) {
                $('#messagehr').html('Time should not be the same.'); 
                $(':button[type="submit"]').prop('disabled', true);
            }
            // Time are not same
            else if ( page_avail_time_to != page_avail_time_from ) {
                $('#messagehr').html(''); 
                $(':button[type="submit"]').prop('disabled', false);
            }
        });
    /* ---------------------------------------------- /*
    * Populate Modal Pensioner
    /* ---------------------------------------------- */
        $("body").on('click', '.view_data', function(event){
            $('#applicant_details_modal').modal();
            var appl_id = $(this).attr("data-id");
            $.ajax({
                url: "/admin/applicants/php/pensioners_edit_modal.php",
                method: "POST",
                data:{appl_id:appl_id},
                success:function(data){
                    $('#applicant_details').html(data);
                    $('#applicant_details_modal').modal('show');
                }
            });
        });
    /* ---------------------------------------------- /*
    * Populate Modal Purchase Booklet
    /* ---------------------------------------------- */
        $("body").on('click', '.view_pur_data', function(){
            $('#purchase_details_modal').modal();
            var pur_id = $(this).attr("data-id");
            $.ajax({
                url: "/admin/pensioners/php/purchase_booklet_modal.php",
                method: "POST",
                // processData: false,
                // contentType: false,
                // cache: false,
                data:{pur_id:pur_id},
                success:function(data){
                    $('#purchase_details').html(data);
                    $('#purchase_details_modal').modal('show');
                }
            });
        });
    /* ---------------------------------------------- /*
    * Populate Modal Accounts
    /* ---------------------------------------------- */
        $("body").on('click', '.view_acc_data', function(event){
            $('#account_details_modal').modal();
            var acc_id = $(this).attr("data-id");
            $.ajax({
                url: "/admin/accounts/php/accounts_update_modal.php",
                method: "POST",
                data:{acc_id:acc_id},
                success:function(data){
                    $('#account_details').html(data);
                    $('#account_details_modal').modal('show');
                }
            });
        });
    /* ---------------------------------------------- /*
    * To Do
    /* ---------------------------------------------- */
        // Insert
        $("body").on('submit', '#insert_todo', function(event){
            event.preventDefault();
            $.ajax({
                url: "assets/php/todo_crud.php?insert=true",
                method: "POST",
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData(this),
                success:function(response){
                    $('#todo_create').modal('hide');
                    $('#insert_todo')[0].reset();
                    $('.todo-list').load(location.href + " .todo-list")
                }
            });
        })
        // Update Modal Populate
        $("body").on('click', '.todo_edit', function(event){
            $('#todo_update').modal();
            var todo_id = $(this).attr("id");
            $.ajax({
                url: "/admin/assets/php/todo_update_modal.php?",
                method: "POST",
                data:{todo_id:todo_id},
                success:function(data){
                    $('#todo_update_content').html(data);
                    $('#todo_update').modal('show');
                }
            });
        });
        // Update
        $("body").on('submit', '#todo_update_form', function(event){
            event.preventDefault();
            $.ajax({
                url: "/admin/assets/php/todo_crud.php?update=true",
                method: "POST",
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData(this),
                success:function(response){
                    $('#todo_update').modal('hide');
                    $('#response').html(response);
                    $('#todo_update_form')[0].reset();
                    $('.todo-list').load(location.href + " .todo-list")
                }
            });
        })
        // Delete
        $("body").on('click', '.todo_delete', function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var todo_id = $(".todo_delete").attr("id");
                    $.ajax({
                        url: "/admin/assets/php/todo_crud.php",
                        method: "POST",
                        data:{todo_delete:'true',todo_id:todo_id},
                        success:function(response){
                            $('.todo-list').load(location.href + " .todo-list")
                        }
                    });
                }
            })
        });
    /* ---------------------------------------------- /*
    * Table Account Check All Checkbox
    /* ---------------------------------------------- */
        $("#thCheckbox").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    /* ---------------------------------------------- /*
    * Show/Hide Password
    /* ---------------------------------------------- */
        $("#passwordShowHide").on('click', function(event) {
            event.preventDefault();
            if($('#appl_password').attr("type") == "text"){
                $('#appl_password').attr('type', 'password');
                $('#passwordShowHideIcon').addClass( "fa-eye-slash" );
                $('#passwordShowHideIcon').removeClass( "fa-eye" );
            }else if($('#appl_password').attr("type") == "password"){
                $('#appl_password').attr('type', 'text');
                $('#passwordShowHideIcon').removeClass( "fa-eye-slash" );
                $('#passwordShowHideIcon').addClass( "fa-eye" );
            }
        });
        $("#updatePasswordShowHide").on('click', function() {
            if($(this).is(":checked")) {
                // checkbox is checked -> do something
                $('#old_password').attr('type', 'text');
                $('#new_password').attr('type', 'text');
                $('#re_password').attr('type', 'text');
            } else {
                // checkbox is not checked -> do something different
                $('#old_password').attr('type', 'password');
                $('#new_password').attr('type', 'password');
                $('#re_password').attr('type', 'password');
            }
        });
});
// Initialize glightbox
const glightbox = GLightbox({
    selector: '.glightbox'
});
// Application form >> Pensioner group >> 'Other' checkbox 
function enableDisableOther(isChecked, inputID){
    document.getElementById(inputID).disabled = !isChecked
    document.getElementById(inputID).focus();
}
// Number Only Input
function onlyNumberInput(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
// Generate Password
function generate_password(){
    var password =  Array(24).fill('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$*_')
	.map(x => x[Math.floor(crypto.getRandomValues(new Uint32Array(1))[0] / (0xffffffff + 1) * x.length)]).join('');

    document.getElementById('appl_password').value = password;   
}
// Backup Upload
function backup_upload(input){
    if(input.files){
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload=(e)=>{
            document.getElementById("appl_picturelabel").innerHTML = document.getElementById('appl_picture').files[0].name;
        }
    }
}
// Display Picture
function readUrl(input){
    if(input.files){
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload=(e)=>{
            document.getElementById("displaypicture").src = e.target.result;
        }
    }
    document.getElementById("appl_picturelabel").innerHTML = document.getElementById('appl_picture').files[0].name;
}
// Remove Picture
function removeImg(){
    document.getElementById("displaypicture").src="/assets/img/account_picture/profile.svg"; 
    document.getElementById("appl_picture").value="";
    document.getElementById("appl_picturelabel").innerHTML = 'Choose file...';
} 
// Display Picture Pages Website Icon
function pageWebsiteIcon(input){
    if(input.files){
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload= function(e){
            document.getElementById("page_website_icon_preview").src = e.target.result;
        }
    }
    document.getElementById("page_website_icon_label").value = document.getElementById('page_website_icon_image').files[0].name;
}
// Remove Picture Pages Website Icon
function pageWebsiteIconRemove(){
    document.getElementById("page_website_icon_preview").src="/assets/img/uploads/no_image.png";
    document.getElementById("page_website_icon_label").value = "";
}
// Display Picture Pages About Image
function pageAboutImage(input){
    if(input.files){
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload= function(e){
            document.getElementById("page_about_image_preview").src = e.target.result;
        }
    }
    document.getElementById("page_about_image_label").value = document.getElementById('page_about_image').files[0].name;
}
// Remove Picture Pages About IMage
function pageAboutImageRemove(){
    document.getElementById("page_about_image_preview").src="/assets/img/uploads/no_image.png"; 
    document.getElementById("page_about_image_label").value = "";
}
// Display Picture Pages Header Background
function pageHeaderBackImage(input){
    if(input.files){
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload= function(e){
            document.getElementById("page_header_back_image_preview").src = e.target.result;
        }
    }
    document.getElementById("page_header_back_image_label").value = document.getElementById('page_header_back_image').files[0].name;
}
// Remove Picture Pages Header Background
function pageHeaderBackImageRemove(){
    document.getElementById("page_header_back_image_preview").src="/assets/img/uploads/no_image.png"; 
    document.getElementById("page_header_back_image_label").value = "";
}
var delay = 0;
function notification() {
    // All Notifications
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText > 0) {
                document.getElementById("noti_number").innerHTML = this.responseText;
                document.getElementById("noti_number_sidebar").innerHTML = this.responseText;
                if ( this.responseText == 1 ) {
                    document.getElementById("noti_number2").innerHTML = this.responseText  + ' New Notification';
                } else if ( this.responseText > 1 ) {
                    document.getElementById("noti_number2").innerHTML = this.responseText  + ' New Notifications';
                }
                if(location.pathname == "/admin/notifications"){
                    document.getElementById("noti_new_detected").innerHTML = '<i class="fas fa-sync"></i> ' + this.responseText + ' new notification. Click here to refresh page.';
                    if (this.responseText > 0) {
                        document.getElementById('noti_new_div').style.display = 'block';
                    }
                }
            } else {
                document.getElementById("noti_number").innerHTML = '';
                document.getElementById("noti_number_sidebar").innerHTML = '';
                document.getElementById("noti_number2").innerHTML = 'No New Notification';
            }
        }
    };
    xhttp.open("GET", "/admin/assets/php/notification_crud.php?id=1", true);
    xhttp.send();
    delay = 5000;
    setTimeout(notification, delay);
};notification();
var openNotifDropDown = false;
function readNotif(){
    if (openNotifDropDown == false){
        // All Notification Dropdown
        var xhttp2 = new XMLHttpRequest();
        xhttp2.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("noti_dropdown").innerHTML = this.responseText;
                document.getElementById("noti_number").innerHTML = '';
                document.getElementById("noti_number_sidebar").innerHTML = '';
            }
        };
        xhttp2.open("GET", "/admin/assets/php/notification_crud.php?id=2", true);
        xhttp2.send();
        openNotifDropDown = true;
    }else{
        openNotifDropDown = false;
    }
}
// To Do Check
function todo_check(id){
    $.ajax({
        type: "POST",
        url: "/admin/assets/php/todo_crud.php",
        data: {id:id}
    });
}