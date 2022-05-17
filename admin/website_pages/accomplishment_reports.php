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
    <title>Accomplishment Reports Page | <?php echo $pages['page_website_title'];?></title>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" integrity="sha512-pDpLmYKym2pnF0DNYDKxRnOk1wkM9fISpSOjt8kWFKQeDmBTjSnBZhTd41tXwh8+bRMoSaFsRnznZUiH9i3pxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6 row">
                            <h1>Accomplishment Reports</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Pages</li>
                                <li class="breadcrumb-item active">Accomplishment Reports</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid row">
                    <!-- Error  -->
                    <div class="col-12"><?php if(isset($_SESSION['error'])){echo $_SESSION['error']; }unset($_SESSION['error']); ?></div>
                    <div class="col-md-2">
                        <a href="#" data-toggle="modal" data-target="#create_report_modal" class="btn btn-primary btn-block mb-3">Create Report</a>
                        <form action="/admin/website_pages/php/reports_query" method="post">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <button type="submit" class="nav-link btn <?php if(!isset($_SESSION['queryReportsButton'])){echo 'text-primary';}?>" name="view_report_published"><i class="far fa-file-alt"></i> Published</button>
                                </li>
                                <li class="nav-item">
                                    <button type="submit" class="nav-link btn <?php if(isset($_SESSION['queryReportsButton']) && $_SESSION['queryReportsButton'] == 'Draft'){echo 'text-primary';}?>" name="view_report_drafts"><i class="fas fa-file-signature"></i> Drafts</button>
                                </li>
                                <li class="nav-item">
                                    <button type="submit" class="nav-link btn <?php if(isset($_SESSION['queryReportsButton']) && $_SESSION['queryReportsButton'] == 'Trashed'){echo 'text-primary';}?>" name="view_report_trash"><i class="far fa-trash-alt"></i> Trash</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="col-md-10">
                        <table id="tblReports" class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 1px;">No.</th>
                                    <th>Title</th>
                                    <th>Notes</th>
                                    <th style="width: 50%;">Content</th>
                                    <th>Date Posted</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if ( isset( $_SESSION['queryReports'] ) ) {
                                        $query = mySQLi_query($con, $_SESSION['queryReports']) or die(mySQLi_error($con));
                                    } else {
                                        $query = mySQLi_query($con, "SELECT * from tbl_reports where rep_status = 'Published' order by rep_id DESC") or die(mySQLi_error($con));
                                    }
                                    $count = 1;
                                    while($rep=mySQLi_fetch_assoc($query)){
                                ?>
                                    <tr class="view_rep_data" data-id="<?php echo $rep['rep_id']; ?>">
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $rep['rep_title']; ?></td>
                                        <td><?php echo $rep['rep_notes']; ?></td>
                                        <td>
                                            <?php 
                                                if (strlen($rep['rep_content']) <= 500) {
                                                    echo $rep['rep_content'];
                                                }else { 
                                                    $rep_content = $rep['rep_content']." ";
                                                    $rep_content = substr($rep_content,0,500);
                                                    $rep_content = substr($rep_content,0,strrpos($rep_content,' '));
                                                    $rep_content = $rep_content."...";
                                                    echo $rep_content;
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $rep['rep_datetime']; ?></td>
                                    </tr>
                                <?php $count++;} ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- ./wrapper -->

    <!-- Create Report Modal -->
    <div class="modal fade" id="create_report_modal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Create Report</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="insert_report" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="m-0">Send email notification to subscribers? </label>
                            <input type="checkbox" name="send_email" id="send_email" data-bootstrap-switch data-on-text="Yes" data-off-text="No">
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label>Report Title <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-10">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <input name="rep_title" type="text" class="form-control" required>
                                    <div class="invalid-feedback">Please enter a title.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label>Report Notes</label>
                            </div>
                            <div class="col-10">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <textarea name="rep_notes" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <label>Report Content <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-10">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <textarea id="rep_content" name="rep_content" row="7" required></textarea>
                                    <div class="invalid-feedback">Please enter the content.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="loading"></div>
                        <button id="create_report_draft" type="submit" class="btn btn-info"><i class="fas fa-file-signature"></i> Draft</button>
                        <button id="create_report_publish" type="submit" class="btn btn-success"><i class="fas fa-file-alt"></i> Publish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Report Modal -->
    <div class="modal fade" id="edit_report_modal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content card card-outline card-info" id="edit_report">
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" integrity="sha512-J+763o/bd3r9iW+gFEqTaeyi+uAphmzkE/zU8FxY6iAvD3nQKXa+ZAWkBI9QS9QkYEKddQoiy0I5GDxKf/ORBA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js" integrity="sha512-+cXPhsJzyjNGFm5zE+KPEX4Vr/1AbqCUuzAS8Cy5AfLEWm9+UI9OySleqLiSQOQ5Oa2UrzaeAOijhvV/M4apyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <?php }else{ ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
    <script>
        $("input[data-bootstrap-switch]").bootstrapSwitch()
        /* ---------------------------------------------- /*
        * Summernote
        /* ---------------------------------------------- */
        $('#rep_content').summernote({
            placeholder: 'Write something...',
            height: 300,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
        /* ---------------------------------------------- /*
        * Table Functions
        /* ---------------------------------------------- */
        // Div Width
        var divWidth = "<'row'<'col-sm-12 col-md-8'l><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        $('#tblReports').DataTable({
            "dom": divWidth,
            "responsive": true, "lengthChange": false, "autoWidth": false, "bSort": true,
            "lengthMenu": [
                [ 10, 25, 50, 100, -1 ],
                [ '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]
            ],
            "buttons": [
                { extend: 'pageLength', className: 'btn btn-default bg-transparent' }
            ]
        }).buttons().container().appendTo('#tblReports_wrapper .col-md-8:eq(0)');
        // Insert Report
        var btnInsert = '';
        $("#create_report_draft").click(function(){
            btnInsert = 1;
        });
        var send_mail = 0;
        $('#send_email').on('switchChange.bootstrapSwitch', function(event, state) {
            if(state == true) {
                send_mail = 1;
            } else {
                send_mail = 0;
            }
        });
        $("body").on('submit', '#insert_report', function(event){
            event.preventDefault();
            $('#loading').html('<i class="fas fa-spinner fa-spin"></i> Creating report, please wait.');
            var formData = new FormData(this);
            if(btnInsert == 1){formData.append('create_report_draft', 'true');}
            else{formData.append('create_report_publish', 'true');}
            if(send_mail == 1){formData.append('send_email', 'true');}
            $.ajax({
                url: "php/pages_crud",
                method: "POST",
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                success:function(response){
                    if(response == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Report added successfully.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        })
                        $('#insert_report').removeClass('was-validated');
                        $('#insert_report')[0].reset();
                        $('#create_report_modal').modal('hide');
                        $('#tblReports').load(location.href + " #tblReports")
                        $("#rep_content").summernote("reset");
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
                    $('#loading').html('');
                }
            });
        })
        // Populate Modal Report
        $("body").on('click', '.view_rep_data', function(event){
            $('#edit_report_modal').modal();
            var rep_id = $(this).attr("data-id");
            $.ajax({
                url: "/admin/website_pages/php/reports_edit_modal.php",
                method: "POST",
                data:{rep_id:rep_id},
                success:function(response){
                    $('#edit_report').html(response);
                    $('#edit_report_modal').modal('show');
                }
            });
        });
        // Update Report
        $("body").on('submit', '#update_report', function(event){
            event.preventDefault();
            var formData = new FormData(this);
            if(btnUpdate == '1'){formData.append('update_report_sp', 'true');}
            else if(btnUpdate == '2'){formData.append('update_report_sd', 'true');}
            else if(btnUpdate == '3'){formData.append('update_report_t', 'true');}
            else if(btnUpdate == '4'){formData.append('update_report_d', 'true');}

            if(btnUpdate == '4'){
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
                        $.ajax({
                            url: "php/pages_crud",
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
                                    title: 'Report deleted successfully.'
                                })
                                $('#edit_report_modal').modal('hide');
                                $('#tblReports').load(location.href + " #tblReports")
                            }
                        });
                    }
                })
            }else{
                $.ajax({
                    url: "php/pages_crud",
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
                            title: 'Report updated successfully.'
                        })
                        $('#edit_report_modal').modal('hide');
                        $('#tblReports').load(location.href + " #tblReports")
                    }
                });
            } 
        });
    </script>
</body>
</html>