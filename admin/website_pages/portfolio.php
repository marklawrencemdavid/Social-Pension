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
    <title>Portfolio Page | <?php echo $pages['page_website_title'];?></title>

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
                            <h1>Portfolio</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Pages</li>
                                <li class="breadcrumb-item active">Portfolio</li>
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
                        <a href="#" data-toggle="modal" data-target="#create_portfolio_modal" class="btn btn-primary btn-block mb-3">New Activity</a>
                        <form action="php/portfolio_query" method="post">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <button type="submit" class="nav-link btn <?php if(!isset($_SESSION['queryPortfoliosButton'])){echo 'text-primary';}?>" name="view_portfolio_published"><i class="far fa-file-alt"></i> Published</button>
                                </li>
                                <li class="nav-item">
                                    <button type="submit" class="nav-link btn <?php if(isset($_SESSION['queryPortfoliosButton']) && $_SESSION['queryPortfoliosButton'] == 'Draft'){echo 'text-primary';}?>" name="view_portfolio_drafts"><i class="fas fa-file-signature"></i> Drafts</button>
                                </li>
                                <li class="nav-item">
                                    <button type="submit" class="nav-link btn <?php if(isset($_SESSION['queryPortfoliosButton']) && $_SESSION['queryPortfoliosButton'] == 'Trashed'){echo 'text-primary';}?>" name="view_portfolio_trash"><i class="far fa-trash-alt"></i> Trash</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="col-md-10">
                        <table id="tblPortfolios" class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 1px;">No.</th>
                                    <th>Title</th>
                                    <th>Text</th>
                                    <th width="110px">Date Posted</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if ( isset( $_SESSION['queryPortfolios'] ) ) {
                                        $query = mySQLi_query($con, $_SESSION['queryPortfolios']) or die(mySQLi_error($con));
                                    } else {
                                        $query = mySQLi_query($con, "SELECT * from tbl_portfolios where port_status = 'Published' order by port_id DESC") or die(mySQLi_error($con));
                                    }
                                    $count = 1;
                                    while($port=mySQLi_fetch_assoc($query)){
                                ?>
                                    <tr class="view_port_data" data-id="<?php echo $port['port_id']; ?>">
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $port['port_title']; ?></td>
                                        <td>
                                            <?php 
                                                if(strlen($port['port_notes']) < 290){
                                                    echo $port['port_notes'];
                                                }else{
                                                    $port_notes = $port['port_notes']." ";
                                                    $port_notes = substr($port_notes,0,290);
                                                    $port_notes = substr($port_notes,0,strrpos($port_notes,' '));
                                                    $port_notes = $port_notes."...";
                                                    echo $port_notes;
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $port['port_date']; ?></td>
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

    <!-- New Activity Modal -->
    <div class="modal fade" id="create_portfolio_modal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>New Activity</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="insert_portfolio" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label class="m-0">Send email notification to subscribers? </label>
                            <input type="checkbox" name="send_email" id="send_email" data-bootstrap-switch data-on-text="Yes" data-off-text="No">
                        </div>
                        <div class="form-group">
                            <label>Title <span class="text-danger">*</span></label>
                            <input name="port_title" id="title" type="text" class="form-control" required>
                            <div class="invalid-feedback">Please fill the title field</div>
                        </div>
                        <div class="form-group">
                            <label>Short text <span class="text-danger">*</span></label>
                            <textarea name="port_notes" id="text" class="form-control" rows="5" required></textarea>
                            <div class="invalid-feedback">Please fill the title field</div>
                        </div>
                        <div class="form-group">
                            <input name="port_image[]" id="file-input" accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff, .svg" type="file" multiple hidden required>
                            <label for="file-input" class="btn btn-default">Select Images <span class="text-danger">*</span></label>
                            <label id="file-clear" class="btn btn-danger">Clear</label>
                            <div class="invalid-feedback">Please select some images.</div>
                            <span id="error_file"></span>
                        </div>
                        <div id="preview" class="form-group row"></div>
                        <div id="uploaded_images_preview"></div>
                        <div class="row col m-0 p-0 justify-content-end">
                            <div id="loading"></div>
                            <button id="port_save_p" type="submit" class="btn btn-success mr-1">Save & Publish</button>
                            <button id="port_save_d" type="submit" class="btn btn-primary">Save & Draft</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Protfolio Modal -->
    <div class="modal fade" id="edit_portfolio_modal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content card card-outline card-info" id="edit_portfolio">
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
        $('#tblPortfolios').DataTable({
            "dom": divWidth,
            "responsive": true, "lengthChange": false, "autoWidth": false, "bSort": true,
            "lengthMenu": [
                [ 10, 25, 50, 100, -1 ],
                [ '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]
            ],
            "buttons": [
                { extend: 'pageLength', className: 'btn btn-default bg-transparent' }
            ]
        }).buttons().container().appendTo('#tblPortfolios_wrapper .col-md-8:eq(0)');
        $("input[data-bootstrap-switch]").bootstrapSwitch()
        // File
        $('#file-input').on("change", function(){
            var $preview = $('#preview').empty();
            if (this.files) $.each(this.files, readAndPreview);

            function readAndPreview(i, file) {
                if (!/\.(png|jpg|jpeg|bmp|tiff|gif)$/i.test(file.name)){
                    $("#error_file").html("Selected an unsupported file. The system is only accepting png,jpg,jpeg,bmp,tiff, and gif file.");
                } else {
                    var reader = new FileReader();

                    if((file.name).length < 21){
                        var filename = file.name
                    }else{
                        var filename = (file.name).substring(0, 21) + '...'
                    }

                    $(reader).on("load", function() {
                        $preview.append("<div class='col-2'>"+"<img src='"+this.result+"' style='width:100%'/>"+"<p class='text-center'>"+filename+"</p>"+"</div>");
                    });

                    reader.readAsDataURL(file);
                }
            }
        });
        $('#file-clear').on("click", function(){
            $('#file-input').val('');
            $("#preview").html("");
        });
        // Insert portfolio activity
        var btnInsert = '';
        $("#port_save_p").click(function(){
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
        $("body").on('submit', '#insert_portfolio', function(event){
            event.preventDefault();
            $('#loading').html('<i class="fas fa-spinner fa-spin"></i> Creating activity, please wait.');
            var formData = new FormData(this);
            if(btnInsert == 1){formData.append('port_save_p', 'true');}
            else{formData.append('port_save_d', 'true');}
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
                            title: 'Activity added successfully.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        })
                        $('#response').html(response);
                        $('#insert_portfolio').removeClass('was-validated');
                        $('#insert_portfolio')[0].reset();
                        $('#create_portfolio_modal').modal('hide');
                        $('#tblPortfolios').load(location.href + " #tblPortfolios")
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
        // Populate Modal Portfolio
        $("body").on('click', '.view_port_data', function(event){
            $('#edit_portfolio_modal').modal();
            var port_id = $(this).attr("data-id");
            $.ajax({
                url: "/admin/website_pages/php/portfolio_edit_modal.php",
                method: "POST",
                data:{port_id:port_id},
                success:function(response){
                    $('#edit_portfolio').html(response);
                    $('#edit_portfolio_modal').modal('show');
                }
            });
        });
        // Update Activity
        $("body").on('submit', '#update_portfolio', function(event){
            event.preventDefault();
            var formData = new FormData(this);
            if(btnUpdate == '1'){formData.append('port_update_p', 'true');}
            else if(btnUpdate == '2'){formData.append('port_update_d', 'true');}
            else if(btnUpdate == '3'){formData.append('port_update_de', 'true');}
            else if(btnUpdate == '4'){formData.append('port_update_t', 'true');}

            if(btnUpdate == '3'){
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
                                    title: 'Activity deleted successfully.'
                                })
                                $('#response').html(response)
                                $('#edit_portfolio_modal').modal('hide');
                                $('#tblPortfolios').load(location.href + " #tblPortfolios")
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
                            title: 'Activity updated successfully.'
                        })
                        $('#response').html(response)
                        $('#edit_portfolio_modal').modal('hide');
                        $('#tblPortfolios').load(location.href + " #tblPortfolios")
                    }
                });
            } 
        });
    </script>
</body>
</html>
