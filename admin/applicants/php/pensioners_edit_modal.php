<?php
    if(isset($_POST['appl_id'])){
        if (session_status() == PHP_SESSION_NONE){session_start();}
        include '../../../assets/php/database.php';
        $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
        $appl = mysqli_fetch_array(  mysqli_query($con, " SELECT * FROM tbl_applicants WHERE appl_id = '".$_POST['appl_id']."' ") );
        $output = '
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"> Pending Applicant Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row justify-content-md-center">
                            <div class="col-md-12">
                                <form class="needs-validation" enctype="multipart/form-data" action="" method="post">
                                    <div class="form-row">
                                        <div class="col-md-4 order-1 order-md-1">
                                            <div class="appl_image_container">
                                                <img src="/assets/img/applicant_picture/'.$appl['appl_picture'].'" class="rounded mx-auto d-block" alt="1x1 picture">
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-md-8 order-2 order-md-2">
                                            <table class="table no-border h-100">
                                                <tbody>
                                                    <tr>
                                                        <td class="py-1" scope="row">Name:</td>
                                                        <th class="py-1">'.$appl['appl_lastname']. ', ' .$appl['appl_firstname']. ' ' .$appl['appl_middlename'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1" scope="row">Address:</td>
                                                        <th class="py-1">'.$appl['appl_houseno']. ' ' .$appl['appl_barangay']. ', ' .$appl['appl_municipality']. ', ' .$appl['appl_province'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1" scope="row">Contact Number:</td>
                                                        <th class="py-1">0'.$appl['appl_contactno'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1" scope="row">Email:</td>
                                                        <th class="py-1">'.$appl['appl_email'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1" scope="row">Birthday:</td>
                                                        <th class="py-1">'.$appl['appl_birthdate'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1" scope="row">Place of birth:</td>
                                                        <th class="py-1">'.$appl['appl_placeofbirth'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1" scope="row">Gender:</td>
                                                        <th class="py-1">'.$appl['appl_gender'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1" scope="row">Civil Status:</td>
                                                        <th class="py-1">'.$appl['appl_civilstatus'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1" scope="row">Previous Occupation:</td>
                                                        <th class="py-1">'.$appl['appl_prevoccupation'].'</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-1" scope="row">Current pensioner at:</td>
                                                        <th class="py-1">'.$appl['appl_pensioner'].'</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br><label>Applicant ID or Birth certificate</label>';
                                    if($appl['appl_proof'] != '' ){
                                    $output .= '<div class="row">
                                        <div class="col sidebar" style="max-height:500px;overflow-y:auto;">
                                            <center><img src="/assets/img/applicant_proof/'.$appl['appl_proof'].'" class="img-fluid"></center>
                                        </div>';
                                    }else{
                                        $output .= '<p>None</p>';
                                    }
                                    $output .= '</div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>';
        echo $output;
    }
?>
<style>
    .appl_image_container{
        position: relative;
        width: 100%;
    }
    .appl_image_container:after {
        content: "";
        display: block;
        padding-bottom: 100%;
    }
    .appl_image_container img {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
</style>