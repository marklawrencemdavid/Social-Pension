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
    <title>Purchase Booklet | <?php echo $pages['page_website_title'];?></title>

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
                            <h1 class="m-0 mr-3">Purchase Booklet</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Pensioners</li>
                                <li class="breadcrumb-item active">Purchase Booklet</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <p>Note: Items that have been rejected will be automatically deleted after a day. <a id="del_all" href="#" class="text-danger">Delete all rejected items.</a></p>
                    <form id="pen_app_form">
                        <table id="tblDataTable" class="table table-hover">
                            <div class="d-flex justify-content-center">
                                <div class="col-md-12 px-0">
                                    <div class="input-group col-md-4">
                                        <?php if(isset($_SESSION['error'])){echo $_SESSION['error'];} ?>
                                        <select id="select_app_rej" class="form-control selectpicker" title="Bulk Action..." data-style="form-control" name="update_purchase_bulk" required>
                                            <?php if ( $acc['acc_role'] != 'Staff' ) { ?>
                                                <option value="Approved">Approve</option>
                                                <option value="Rejected">Reject</option>
                                                <option value="Pending">Pending</option>
                                            <?php } else { ?>
                                                <option value="Approved">Approve</option>
                                                <option value="Rejected">Reject</option>
                                            <?php } ?>
                                        </select>
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-default" id="update_purchase_bulk_submit" name="update_purchase_bulk_submit">Apply</button>
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
                                    <th>Status</th>
                                    <th>Commodities</th>
                                    <th>Quantity</th>
                                    <th>Amount of Purchase</th>
                                    <th>Name of Establishment</th>
                                    <th>Date of Purchase</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $count = 1;
                                    $query=mySQLi_query($con, "SELECT * from tbl_purchases order by pur_status DESC, pur_id") or die(mySQLi_error($con));
                                    while($pur=mySQLi_fetch_assoc($query)){
                                ?>
                                    <tr>
                                        <td id="trCheckbox">
                                            <div class="icheck-primary">
                                                <input name="pur_id[]" class="check_box" id="tdCheckbox<?php echo $count;?>" value="<?php echo $pur['pur_id']; ?>" type="checkbox" onmouseover="this.style.cursor='pointer'">
                                                <label for="tdCheckbox<?php echo $count;?>"></label>
                                            </div>
                                        </td>
                                        <td class="view_pur_data" data-id="<?php echo $pur['pur_id']; ?>"><?php echo $count; ?></td>
                                        <td class="view_pur_data" data-id="<?php echo $pur['pur_id']; ?>">
                                            <?php if($pur['pur_status'] == 'Pending'){echo '<span class="badge badge-warning">'.$pur['pur_status'].'</span>';}
                                            elseif($pur['pur_status'] == 'Approved'){echo '<span class="badge badge-success">'.$pur['pur_status'].'</span>';}
                                            elseif($pur['pur_status'] == 'Rejected'){echo '<span class="badge badge-danger" id="rejected">'.$pur['pur_status'].'</span>';} ?></td>
                                        <td class="view_pur_data" data-id="<?php echo $pur['pur_id']; ?>"><?php echo $pur['pur_commodity']; ?></td>
                                        <td class="view_pur_data" data-id="<?php echo $pur['pur_id']; ?>"><?php echo $pur['pur_quantity']; ?></td>
                                        <td class="view_pur_data" data-id="<?php echo $pur['pur_id']; ?>"><?php echo $pur['pur_amount']; ?></td>
                                        <td class="view_pur_data" data-id="<?php echo $pur['pur_id']; ?>"><?php echo $pur['pur_establishment']; ?></td>
                                        <td class="view_pur_data" data-id="<?php echo $pur['pur_id']; ?>"><?php echo date('M d, Y', strtotime($pur['pur_date'])); ?></td>
                                    </tr>
                                <?php $count++; } ?>
                            </tbody>
                        </table>
                    </form>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <div class="modal fade" id="purchase_details_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="purchase_details">
                
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
        // Update Purchase
        $("body").on('submit', '#pen_app_form', function(event){
            event.preventDefault();
            if($("input[name='pur_id[]']").is(":checked")){
                var select_app_rej = $('#select_app_rej').children("option:selected").val();
                var title = toast_title = btn = '';
                if(select_app_rej == 'Approved'){title='Do you really want to approve the selected item/s?';toast_title='Successfully approved selected item/s';btn='Approve'}
                else if(select_app_rej == 'Rejected'){title='Do you really want to reject the selected item/s?';toast_title='Successfully rejected selected item/s';btn='Reject'}
                else if(select_app_rej == 'Pending'){title='Do you really want to set the selected item/s as pending?';toast_title='Successfully set the selected item/s as pending';btn='Move to pending'}
                Swal.fire({
                    title: title,
                    // text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    // confirmButtonColor: '#3085d6',
                    // cancelButtonColor: '#d33',
                    confirmButtonText: btn
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData(this);
                        formData.append('update_purchase_bulk_submit', 'true');
                        $.ajax({
                            url: "php/purchase_crud.php",
                            method: "POST",
                            processData: false,
                            contentType: false,
                            cache: false,
                            data: formData,
                            success:function(response){
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                })
                                Toast.fire({
                                    icon: 'success',
                                    title: toast_title
                                })
                                $('#pen_app_form')[0].reset();
                                $("#select_app_rej").val('default').selectpicker("refresh");
                                $('#tblDataTable').load(location.href + " #tblDataTable");
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
        // Update Purchase Solo
        $("body").on('submit', '#pen_app_form_solo', function(event){
            event.preventDefault();
            var formData = new FormData(this);
            if(btnUpdate == '1'){title='Do you really want to approve this item?';toast_title='Successfully approved selected item/s';btn='Approve';formData.append('update_purchase_a', $("#update_purchase_a").val());}
            else if(btnUpdate == '2'){title='Do you really want to reject this item?';toast_title='Successfully rejected selected item/s';btn='Reject';formData.append('update_purchase_r', $("#update_purchase_r").val());}
            else if(btnUpdate == '3'){title='Do you really want to set this item as pending?';toast_title='Successfully set the selected item/s as pending';btn='Move to pending';formData.append('update_purchase_p', $("#update_purchase_p").val());}
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
                        url: "php/purchase_crud.php",
                        method: "POST",
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        success:function(response){
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: toast_title
                            })
                            $('#purchase_details_modal').modal('hide');
                            $('#tblDataTable').load(location.href + " #tblDataTable");
                        }
                    });
                }
            })
        })
        // Delete All Rejected
        $("body").on('click', '#del_all', function(event){
            event.preventDefault();
            if($("span[id=rejected]").length > 0){
                Swal.fire({
                    title: 'Do you really want to delete all rejected items?',
                    text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete applicant/s'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "php/purchase_crud.php?d=1",
                            method: "GET",
                            processData: false,
                            contentType: false,
                            cache: false,
                            data: {d:'1'},
                            success:function(response){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully deleted all rejected items',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                })
                                $('#tblDataTable').load(location.href + " #tblDataTable");
                            }
                        });
                    }
                })
            }else{
                Swal.fire({
                    title: 'Oopss...',
                    text: "No data to be deleted",
                    icon: 'error',
                })
            }
        })
    </script>
</body>
</html>