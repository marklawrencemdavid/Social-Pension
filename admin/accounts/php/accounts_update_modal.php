<?php
    if(isset($_POST['acc_id'])){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        include '../../../assets/php/database.php';
        $cur_user = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') ); 
        $acc = mysqli_fetch_array(mysqli_query($con, " SELECT * FROM tbl_accounts WHERE acc_id = '".$_POST['acc_id']."' "));
        $output = '
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">';if ($acc['acc_role'] == 'Pensioner') {$output.='Pensioner';}$output.=' Account Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row justify-content-md-center">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-md-4 order-1 order-md-1">
                                        <img src=';if ($acc['acc_role'] != 'Pensioner') { $output .= '"/assets/img/account_picture/'.$acc['acc_picture'].'"'; }
                                            else { $output .= '"/assets/img/applicant_picture/'.$acc['acc_picture'].'"'; }
                                $output .= ' class="rounded mx-auto d-block" alt="1x1 picture" 
                                            style="height: 100%; width: 100%; background: #777777;">
                                        <br>
                                    </div>
                                    <div class="col-md-8 order-2 order-md-2">
                                        <table class="table no-border mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="py-2">Name:</td>
                                                    <th class="py-2">'.$acc['acc_lastname']. ', ' .$acc['acc_firstname']. ' ' .$acc['acc_middlename'].'</th>
                                                </tr>
                                                <tr>
                                                    <td class="py-2">Email:</td>
                                                    <th class="py-2">'.$acc['acc_email'].'</th>
                                                </tr>
                                                <tr>
                                                    <td class="py-2">Contact Number:</td>
                                                    <th class="py-2">'.$acc['acc_contactno'].'</th>
                                                </tr>
                                                <tr>
                                                    <td class="py-2">Username:</td>
                                                    <th class="py-2">'.$acc['acc_username'].'</th>
                                                </tr>
                                                <tr>
                                                    <td class="py-2">Role:</td>
                                                    <th class="py-2">'.$acc['acc_role'].'</th>
                                                </tr>
                                                <tr>
                                                    <td class="py-2">Status:</td>
                                                    <th class="py-2 text-';
                                                    if($acc["acc_status"] == 'Active'){$output .= 'success"';}else{$output .= 'danger"';}
                                                        $output .='>'.$acc['acc_status'].'</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>';
        echo $output;
    }
?>