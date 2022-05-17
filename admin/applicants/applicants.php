<?php 
    include '../../assets/php/database.php';
    include '../assets/php/authentication.php';
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
    $pages = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') ); 
    $curPageName = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Applicants | <?php echo $pages['page_website_title'];?></title>

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
                        <div class="col-sm-6">
                            <h1 class="m-0 mr-3">Pending Applicants</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Pensioners</li>
                                <li class="breadcrumb-item active">Applicants</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content" id="pen_app_div">
                <form id="pen_app_form">
                    <div class="container-fluid">
                        <!-- Success/Error -->
                        <?php if (isset( $_SESSION['succeserror'])) {  echo $_SESSION['succeserror']; } unset($_SESSION['succeserror']); ?>
                        <table id="tblDataTable" class="table table-hover">
                            <div class="d-flex justify-content-center">
                                <div class="col-md-12 px-0">
                                    <div class="input-group col-md-4">
                                        <select id="select_app_rej" class="form-control selectpicker" title="Bulk Action..." data-style="form-control" name="pensioner_status" required>
                                            <option value="Active">Approve</option>
                                            <option value="Rejected" class="text-red">Reject</option>
                                        </select>
                                        <span class="input-group-append">
                                            <!-- add '.example2' for jquery confirm -->
                                            <button type="submit" class="btn btn-default" name="update_pensioner_status">Apply</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <thead>
                                <tr>
                                    <th>
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="thCheckbox">
                                            <label for="thCheckbox"></label>
                                        </div>
                                    </th>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Contact No.</th>
                                    <th>Birthday</th>
                                    <th>Birth Place</th>
                                    <th>Gender</th>
                                    <th>Civil Status</th>
                                    <th>Previous Occupation</th>
                                    <th>Pensioner</th>
                                </tr>
                            </thead>
                            <tbody id="pen_app_table">
                                <?php
                                    $count = 1;
                                    $query=mySQLi_query($con, "SELECT * from tbl_applicants where appl_status = 'Applicant' order by appl_id DESC") or die(mySQLi_error($con));
                                    while($appl=mySQLi_fetch_assoc($query)){
                                ?>
                                    <tr>
                                        <td id="trCheckbox">
                                            <div class="icheck-primary">
                                                <input name="appl_id[]" class="check_box" id="tdCheckbox<?php echo $count;?>" value="<?php echo $appl['appl_id']; ?>" type="checkbox" onmouseover="this.style.cursor='pointer'">
                                                <label for="tdCheckbox<?php echo $count;?>"></label>
                                            </div>
                                        </td>
                                        <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                            <?php echo $count; ?></td>
                                        <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                            <?php echo $appl['appl_lastname'] . ', ' . $appl['appl_firstname'] . ' ' . $appl['appl_middlename']; ?></td>
                                        <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                            <?php echo $appl['appl_houseno'] . ' ' . $appl['appl_barangay'] . ', ' . $appl['appl_municipality'] . ', ' . $appl['appl_province']; ?></td>
                                        <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                            0<?php echo $appl['appl_contactno']; ?></td>
                                        <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                            <?php echo $appl['appl_birthdate']; ?></td>
                                        <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                            <?php echo $appl['appl_placeofbirth']; ?></td>
                                        <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                            <?php echo $appl['appl_gender']; ?></td>
                                        <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                            <?php echo $appl['appl_civilstatus']; ?></td>
                                        <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                            <?php echo $appl['appl_prevoccupation']; ?></td>
                                        <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                            <?php echo $appl['appl_pensioner']; ?></td>
                                    </tr>
                                <?php $count++; } ?>
                            </tbody>
                        </table>
                    </div><!-- /.container-fluid -->
                </form>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <div class="modal fade" id="applicant_details_modal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" id="applicant_details">
                
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
                    // { extend: 'colvis', className: 'btn btn-default', text: '<i class="fas fa-columns"></i> Column Visibility' },
                    { extend: 'pageLength', className: 'btn btn-default bg-transparent' },
                ]
            }).buttons().container().appendTo('#tblDataTable_wrapper .col-md-8:eq(0)');
        // Update pensioner
        $("body").on('submit', '#pen_app_form', function(event){
            event.preventDefault();
            if($("input[name='appl_id[]']").is(":checked")){
                var select_app_rej = $('#select_app_rej').children("option:selected").val();
                var title = toast_title = btn = html ='';
                if(select_app_rej == 'Active'){
                    title='Do you really want to approve the selected applicants?';toast_title='Successfully approved selected applicants';btn='Approve applicant/s';
                    html = '<span>Send a notification to applicant</span><br>'+ 
                            '<div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="inlineRadioOptions" id="sms" value="sms" checked><label class="form-check-label" for="sms">SMS(recommended)</label></div>' +
                            '<div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="inlineRadioOptions" id="email" value="email"><label class="form-check-label" for="email">Email</label></div>';
                }
                else if(select_app_rej == 'Rejected'){
                    title='Do you really want to reject the selected applicants?';toast_title='Successfully rejected selected applicants';btn='Reject applicant/s';
                    html = '<span>Send a notification to applicant</span><br>'+ 
                            '<div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="inlineRadioOptions" id="email" value="email" checked><label class="form-check-label" for="email">Email(recommended)</label></div>' +
                            '<div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="inlineRadioOptions" id="sms" value="sms"><label class="form-check-label" for="sms">SMS</label></div>';
                }
                Swal.fire({
                    title: title,
                    html: html,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: btn,
                    preConfirm: () => {
                        var sms = Swal.getPopup().querySelector('#sms').checked
                        var email = Swal.getPopup().querySelector('#email').checked
                        return {sms:sms, email:email}
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData(this);
                        if(result.value.sms == true){formData.append('update_pensioner_notify', 'sms');}
                        else if(result.value.email == true){formData.append('update_pensioner_notify', 'email');}
                        formData.append('update_pensioner_status', 'true');
                        $.ajax({
                            url: "php/pensioners_crud.php",
                            method: "POST",
                            processData: false,
                            contentType: false,
                            cache: false,
                            data: formData,
                            success:function(response){
                                if(response == ''){
                                    Swal.fire({
                                        icon: 'success',
                                        title: toast_title,
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    })
                                    $("#select_app_rej").val('default').selectpicker("refresh");
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
        })
    </script>
</body>
</html>