<?php 
    include '../../assets/php/database.php';
    include '../assets/php/authentication.php';
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
    $pages = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') ); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Accounts | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.11.3/dataTables.bootstrap4.min.css" integrity="sha512-+RecGjm1x5bWxA/jwm9sqcn5EV0tNej3Xxq5HtIOLM9YM9VgI2LbhEDn099Xhxg6HuvrmsXR0J6JQxL7tLHFHw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.7/responsive.bootstrap4.min.css" integrity="sha512-+TJckkeGxlxMsXzzgiOzPP98YRd+4BiK4B6n/8T4ls+LHSVtwLNvidIXKHL0OkzwBz8iG5YNwcKO6U2mWgoHDQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/1.7.0/buttons.bootstrap4.min.css" integrity="sha512-0LpZpPhy5gC20rXCT9HfsYz0gF+wRD62I/MCY+d1tDgK7xKpvd0hQLMBqyXS9BYdzyis/BdIW2iMIBK8e+0o+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css" integrity="sha512-z13ghwce5srTmilJxE0+xd80zU6gJKJricLCq084xXduZULD41qpjRE9QpWmbRyJq6kZ2yAaWyyPAgdxwxFEAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css"> 
    <?php } ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css" integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Main CSS File -->
    <link rel="stylesheet" href="/admin/assets/css/admin_style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed <?php if($acc['acc_darkmode'] == 1){echo 'dark-mode';} ?>" id="bodytag">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/assets/img/uploads/<?php echo $pages['page_website_icon']?>" alt="AdminLTELogo" height="100" width="100">
        </div>

        <!-- Navbar -->
        <?php include '../header.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6 row">
                            <h1 class="m-0 mr-3">All Accounts</h1>
                            <a href="/admin/accounts/create_account.php" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Create Account</a>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Accounts</li>
                                <li class="breadcrumb-item active">All Accounts</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <form id="update_account">
                    <div class="container-fluid">
                        <div class="col-12">
                            <table id="tblDataTable" class="table table-hover">
                                <div class="card">
                                    <div class="card-header border-0 py-2 bg-warning">
                                        <h3 class="card-title">Notes</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <li>You cannot change your own role and status.</li>
                                        <li>Deletion of your own account can only be performed in your profile.</li>
                                        <li>Changing Super Admin's role and status is prohibited.</li>
                                        <li>Changing Pensioner's role is prohibited.</li>
                                        <li>You can set Pensioner's account inactive and active, but once the pensioner is set as deceased you will not be able to set it as active again.</li>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class="row col-md-6 px-0">
                                        <?php if ( $acc['acc_role'] != 'Staff' ) { ?>
                                            <div class="input-group col-md-8">
                                                <select id="update_account_select" name="update_account_select" class="form-control selectpicker" title="Bulk Action..." data-style="form-control" data-live-search="true">
                                                    <option class="text-muted" disabled>Change Role To:</option>
                                                    <option value="Admin">Admin</option>
                                                    <option value="Staff">Staff</option>
                                                    <option data-divider="true"></option>
                                                    <option class="text-muted" disabled>Change Status To:</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                    <option data-divider="true"></option>
                                                    <option value="Delete" class="text-red">Delete</option>
                                                </select>
                                                <span class="input-group-append">
                                                    <button id="update_account_submit" name="update_account_submit" type="submit" class="btn btn-default">Apply</button>
                                                </span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="input-group col-md-6">
                                        <select class="form-control" name="select_role" required>
                                            <option value="All" <?php if (!isset($_SESSION['select_role']) ) { echo 'selected="selected"'; } ?> 
                                                >All Roles</option>
                                            <option value="Super Admin"
                                                <?php if ( isset($_SESSION['select_role']) ) { 
                                                        if ( $_SESSION['select_role'] == 'Super Admin' ){echo 'selected="selected"';}} ?>
                                                >Super Admin</option>
                                            <option value="Admin"
                                                <?php if ( isset($_SESSION['select_role']) ) { 
                                                        if ( $_SESSION['select_role'] == 'Admin' ){echo 'selected="selected"';}} ?>
                                                >Admin</option>
                                            <option value="Staff"
                                                <?php if ( isset($_SESSION['select_role']) ) { 
                                                        if ( $_SESSION['select_role'] == 'Staff' ){echo 'selected="selected"';}} ?>
                                                >Staff</option>
                                            <option value="Pensioner"
                                                <?php if ( isset($_SESSION['select_role']) ) { 
                                                        if ( $_SESSION['select_role'] == 'Pensioner' ){echo 'selected="selected"';}} ?>
                                                >Pensioner</option>
                                        </select>
                                        <select class="form-control" name="select_status" required>
                                            <option value="All" <?php if (!isset($_SESSION['select_status']) ) { echo 'selected="selected"'; } ?> 
                                                >All Status</option>
                                            <option value="Active"
                                                <?php if ( isset($_SESSION['select_status']) ) { 
                                                    if ( $_SESSION['select_status'] == 'Active' ){echo 'selected="selected"';}} ?>
                                                >Active</option>
                                            <option value="Inactive"
                                                <?php if ( isset($_SESSION['select_status']) ) { 
                                                    if ( $_SESSION['select_status'] == 'Inactive' ){echo 'selected="selected"';}} ?>
                                                >Inactive</option>
                                        </select>
                                        <span class="input-group-append">
                                            <button id="view_role_status" type="submit" class="btn btn-default" name="view_role_status"><i class="fas fa-filter"></i> Filter</button>
                                        </span>
                                        <span class="input-group-append">
                                            <button id="reset_role_status" type="submit" class="btn btn-danger" name="reset_role_status"><i class="fas fa-eraser"></i> Clear</button>
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <thead>
                                    <tr>
                                        <?php if ( $acc['acc_role'] != 'Staff' ) { ?>
                                        <th>
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="thCheckbox">
                                                <label for="thCheckbox"></label>
                                            </div>
                                        </th>
                                        <?php } ?>
                                        <th>No.</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Contact No.</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if ( isset( $_SESSION['query'] ) ) {
                                            $query = mySQLi_query($con, $_SESSION['query']) or die(mySQLi_error($con));
                                        }else {
                                            $query = mySQLi_query($con, 'SELECT * from tbl_accounts order by acc_id DESC') or die(mySQLi_error($con));
                                        }
                                            
                                        $count = 1;
                                        while($acc2=mySQLi_fetch_assoc($query)){
                                    ?>
                                        <tr>
                                            <?php if ( $acc['acc_role'] != 'Staff' ) { ?>
                                            <td id="trCheckbox">
                                                <div class="icheck-primary">
                                                    <input name="acc_id[]" class="check_box" id="tdCheckbox<?php echo $count;?>" value="<?php echo $acc2['acc_id']; ?>" type="checkbox" onmouseover="this.style.cursor='pointer'">
                                                    <label for="tdCheckbox<?php echo $count;?>"></label>
                                                </div>
                                            </td>
                                            <?php } ?>
                                            <td class="view_acc_data" data-toggle="modal" data-id="<?php echo $acc2['acc_id']; ?>" data-target="#account_details_modal">
                                                <?php echo $count; ?></td>
                                            <td class="view_acc_data" data-toggle="modal" data-id="<?php echo $acc2['acc_id']; ?>" data-target="#account_details_modal">
                                                <?php echo $acc2['acc_username'] ?></td>
                                            <td class="view_acc_data" data-toggle="modal" data-id="<?php echo $acc2['acc_id']; ?>" data-target="#account_details_modal">
                                                <?php echo $acc2['acc_lastname'] . ', ' . $acc2['acc_firstname'] . ' ' . $acc2['acc_middlename']; ?></td>
                                            <td class="view_acc_data" data-toggle="modal" data-id="<?php echo $acc2['acc_id']; ?>" data-target="#account_details_modal">
                                                <?php echo $acc2['acc_contactno'] ?></td>
                                            <td class="view_acc_data" data-toggle="modal" data-id="<?php echo $acc2['acc_id']; ?>" data-target="#account_details_modal">
                                                <?php echo $acc2['acc_email'] ?></td>
                                            <td class="view_acc_data" data-toggle="modal" data-id="<?php echo $acc2['acc_id']; ?>" data-target="#account_details_modal">
                                                <?php echo ucfirst($acc2['acc_role']) ?></td>
                                            <td class="view_acc_data text-bold text-<?php if($acc2["acc_status"] == 'Active'){echo 'success';}else{echo 'danger';} ?>" 
                                                data-toggle="modal" data-id="<?php echo $acc2['acc_id']; ?>" data-target="#account_details_modal">
                                                <?php echo ucfirst($acc2["acc_status"]) ?></td>
                                        </tr>
                                    <?php $count++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-->
                    </div><!-- /.container-fluid -->
                </form>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <div class="modal fade" id="account_details_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="account_details">
                
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/js/bootstrap-select.min.js" integrity="sha512-CJXg3iK9v7yyWvjk2npXkQjNQ4C1UES1rQaNB7d7ZgEVX2a8/2BmtDmtTclW4ial1wQ41cU34XPxOw+6xJBmTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script><!-- InputMask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.11.3/dataTables.bootstrap4.min.js" integrity="sha512-9o2JT4zBJghTU0EEIgPvzzHOulNvo0jq2spTfo6mMmZ6S3jK+gljrfo0mKDAxoMnrkZa6ml2ZgByBQ5ga8noDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive/2.2.7/dataTables.responsive.min.js" integrity="sha512-4ecidd7I1XWwmLVzfLUN0sA0t2It86ti4qwPAzXW7B0/yIScpiOj7uyvFgu/ieGTEFjO5Ho98RZIqt75+ZZhdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.7/responsive.bootstrap4.min.js" integrity="sha512-OiHNq9acGP68tNJIr1ctDsYv7c2kuEVo2XmB78fh4I+3Wi0gFtZl4lOi9XIGn1f1SHGcXGhn/3VHVXm7CYBFNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/1.7.0/js/dataTables.buttons.min.js" integrity="sha512-EzaqIDcdBg8g037o9E12U69oY/mfHffJJzUtB6dgd67AB4IXkMi1/7WY6og4fKSVXtqqt35S/R5ClqNHjSIH4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/1.7.0/buttons.bootstrap4.min.js" integrity="sha512-D4MloW0hy9XtYnqtvwfg2T2WZRn0dB8Ir0KcPrDX7S/gVE05JotZQHirzd9vMSIT8ViKyntOOZl1muHii0spUA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js" integrity="sha512-uVSVjE7zYsGz4ag0HEzfugJ78oHCI1KhdkivjQro8ABL/PRiEO4ROwvrolYAcZnky0Fl/baWKYilQfWvESliRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js" integrity="sha512-HLbtvcctT6uyv5bExN/qekjQvFIl46bwjEq6PBvFogNfZ0YGVE+N3w6L+hGaJsGPWnMcAQ2qK8Itt43mGzGy8Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.min.js" integrity="sha512-VIF8OqBWob/wmCvrcQs27IrQWwgr3g+iA4QQ4hH/YeuYBIoAUluiwr/NX5WQAQgUaVx39hs6l05cEOIGEB+dmA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/1.7.0/js/buttons.html5.min.js" integrity="sha512-ehHOosb2HF/KK/7kZSGFaOijR+smIS5PvSPBG0He69iTEQe30Q+g0NLJYQUmySpqGrol1frtzE1Re2a9AebxiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/1.7.0/js/buttons.print.min.js" integrity="sha512-kYpyIzqFmlPX1c3EhpL4+8AajeawkvGies2wVJcpMZJ/7zupZ/KcHa8QsDng8rtFUn2yPk/0MZolkz3pTqhsPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/1.7.0/js/buttons.colVis.min.js" integrity="sha512-ll1/he+7pNOn7mpHZxOpCdV6HB+BNYs9rcDeHZSTV33/JHJIET2HCSjbCXREbl0LteZVQpg+zgpAlIABGXL/ow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <?php }else{ ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
    <script>
        /* ---------------------------------------------- /*
        * Table Functions
        /* ---------------------------------------------- */
            // Div Width
        var divWidth = "<'row'<'col-sm-12 col-md-8'l><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        // Adding Datatable Functions to Tables
        $('#tblDataTable').DataTable({
            "dom": divWidth,
            "responsive": true, "lengthChange": false, "autoWidth": false, "bSort": true,
            "lengthMenu": [
                [ 10, 25, 50, 100, -1 ],
                [ '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]
            ],
            "buttons": [
                { extend: 'copy', className: 'btn btn-default bg-transparent', text: '<i class="fas fa-copy"></i> Copy' },
                { extend: 'excel', className: 'btn btn-default bg-transparent', text: '<i class="fas fa-file-excel"></i> Export Excel' },
                { extend: 'pdf', className: 'btn btn-default bg-transparent', text: '<i class="fas fa-file-pdf"></i> Export PDF' },
                { extend: 'print', className: 'btn btn-default bg-transparent', text: '<i class="fas fa-print"></i> Print' },
                // { extend: 'colvis', className: 'btn btn-default bg-transparent', text: '<i class="fas fa-columns"></i> Column Visibility' },
                { extend: 'pageLength', className: 'btn btn-default bg-transparent' },
            ]
        }).buttons().container().appendTo('#tblDataTable_wrapper .col-md-8:eq(0)');
        // Update account
        btnUpdate = 0;
        $("#update_account_submit").click(function(){
            btnUpdate = '1';
        });
        $("#view_role_status").click(function(){
            btnUpdate = '2';
        });
        $("#reset_role_status").click(function(){
            btnUpdate = '3';
        });
        $("body").on('submit', '#update_account', function(event){
            event.preventDefault();
            var formData = new FormData(this);
            if(btnUpdate == '1'){
                if($("input[name='acc_id[]']").is(":checked")){
                    var update_account_select = $('#update_account_select').children("option:selected").val();
                    var title = toast_title = btn = '';
                    if(update_account_select == 'Admin'){title='Do you really want to make the selected account/s as admin?';toast_title='Selected account/s was successfully set as admin';btn='Set account/s as Admin'}
                    else if(update_account_select == 'Staff'){title='Do you really want to make the selected account/s as staff?';toast_title='Selected account/s was successfully set as staff';btn='Set account/s as Staff'}
                    else if(update_account_select == 'Active'){title='Do you really want to make the selected account/s as active?';toast_title='Selected account/s was successfully set as active';btn='Set account/s as Active'}
                    else if(update_account_select == 'Inactive'){title='Do you really want to make the selected account/s as inactive?';toast_title='Selected account/s was successfully set as inactive';btn='Set account/s as Inactive'}
                    else if(update_account_select == 'Delete'){title='Do you really want to delete the selected account/s?';toast_title='Successfully deleted selected account/s';btn='Delete account/s'}
                    formData.append('update_account_submit', 'true');
                    Swal.fire({
                        title: title,
                        // text: "You won't be able to revert this!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: btn
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "php/accounts_crud.php",
                                method: "POST",
                                processData: false,
                                contentType: false,
                                cache: false,
                                data: formData,
                                success:function(response){
                                    if(response == 1){
                                        Swal.fire({
                                            icon: 'success',
                                            title: toast_title,
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true
                                        })
                                        $("#update_account_select").val('default').selectpicker("refresh");
                                        $('#tblDataTable').load(location.href + " #tblDataTable");
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
                        }
                    })
                }else{
                    Swal.fire({
                        title: 'Oopss...',
                        text: "Please select at least 1 row",
                        icon: 'error',
                    })
                }
            }else if(btnUpdate == '2'){
                formData.append('view_role_status', 'true');
                $.ajax({
                    url: "php/accounts_crud.php",
                    method: "POST",
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    success:function(response){
                        $('#tblDataTable').load(location.href + " #tblDataTable");
                    }
                });
            }else if(btnUpdate == '3'){
                formData.append('reset_role_status', 'true');
                $.ajax({
                    url: "php/accounts_crud.php",
                    method: "POST",
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    success:function(response){
                        $('#tblDataTable').load(location.href + " #tblDataTable");
                    }
                });
            }
                
        })
    </script>
</body>
</html>