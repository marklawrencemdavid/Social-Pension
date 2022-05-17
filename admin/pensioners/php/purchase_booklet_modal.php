<?php
    if(isset($_POST['pur_id'])){
        if (session_status() == PHP_SESSION_NONE) { session_start(); }
        include '../../../assets/php/database.php';

        $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT acc_role from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
        $pur = mysqli_fetch_array(mysqli_query($con, " SELECT * FROM tbl_purchases WHERE pur_id = '".$_POST['pur_id']."' "));
        $acc_appl_id = mysqli_fetch_array(mysqli_query($con, " SELECT acc_appl_id FROM tbl_accounts WHERE acc_id = '".$pur['acc_id']."' "));
        $appl = mysqli_fetch_array(mysqli_query($con, " SELECT * FROM tbl_applicants WHERE appl_id = '".$acc_appl_id['acc_appl_id']."' "));
        $output = '<div class="modal-header">
                        <h5 class="modal-title">Purchase Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-3"><label>Pensioner Name</label><label class="float-right">:</label></div>
                            <div class="col-9"><h5>'.$appl['appl_lastname'].', '.$appl['appl_firstname'].' '.$appl['appl_middlename'].'</h5></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3"><label>Pensioner Address</label><label class="float-right">:</label></div>
                            <div class="col-9">'.$appl['appl_houseno'].', '.$appl['appl_barangay'].', '.$appl['appl_municipality'].', '.$appl['appl_province'].'</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3"><label>Commodity</label><label class="float-right">:</label></div>
                            <div class="col-9">'.$pur['pur_commodity'].'</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3"><label>Quantity</label><label class="float-right">:</label></div>
                            <div class="col-9">'.$pur['pur_quantity'].'</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3"><label>Amount</label><label class="float-right">:</label></div>
                            <div class="col-9">Php '.$pur['pur_amount'].'</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3"><label>Name of Establishment</label><label class="float-right">:</label></div>
                            <div class="col-9">'.$pur['pur_establishment'].'</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-3"><label>Proof of purchase</label><label class="float-right">:</label></div>
                            <div class="col-9"><div class="col-12"><img src="../../../assets/img/pensioner_proof/'.$pur['pur_proof'].'" style="width:100%"></div></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form id="pen_app_form_solo">';
        if($appl['appl_status'] == 'Active'){
            if ($acc['acc_role'] == 'Super Admin' || $acc['acc_role'] == 'Admin') {
                if($pur['pur_status'] == 'Approved'){
                    $output .= '<button id="update_purchase_r" name="update_purchase_r" value="'.$pur['pur_id'].'" type="submit" class="btn btn-danger">Reject</button>
                        <button id="update_purchase_p" name="update_purchase_p" value="'.$pur['pur_id'].'" type="submit" class="btn btn-warning">Pending</button>';
                }elseif($pur['pur_status'] == 'Rejected'){
                    $output .= '<button id="update_purchase_a" name="update_purchase_a" value="'.$pur['pur_id'].'" type="submit" class="btn btn-success">Approve</button>
                        <button id="update_purchase_p" name="update_purchase_p" value="'.$pur['pur_id'].'" type="submit" class="btn btn-warning">Pending</button>';
                }elseif($pur['pur_status'] == 'Pending'){
                    $output .= '<button id="update_purchase_a" name="update_purchase_a" value="'.$pur['pur_id'].'" type="submit" class="btn btn-success">Approve</button>
                        <button id="update_purchase_r" name="update_purchase_r" value="'.$pur['pur_id'].'" type="submit" class="btn btn-danger">Reject</button>';
                }
            }elseif($acc['acc_role'] == 'Staff' && $pur['pur_status'] == 'Pending'){
                    $output .= '<button id="update_purchase_a" name="update_purchase_a" value="'.$pur['pur_id'].'" type="submit" class="btn btn-success">Approve</button>
                                <button id="update_purchase_r" name="update_purchase_r" value="'.$pur['pur_id'].'" type="submit" class="btn btn-danger">Reject</button>';
            }
        }
                $output .= '<button data-dismiss="modal" type="button" class="btn btn-default ml-1">Close</button>
                </form></div>';
        echo $output;
    }
?>
<script>
    btnUpdate = 0;
    $("#update_purchase_a").click(function(){
        btnUpdate = '1';
    });
    $("#update_purchase_r").click(function(){
        btnUpdate = '2';
    });
    $("#update_purchase_p").click(function(){
        btnUpdate = '3';
    });
</script>