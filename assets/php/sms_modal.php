<?php
    if(isset($_POST['sms_id'])){
        include 'database.php';
        $result = mysqli_query($con, " SELECT * FROM tbl_sms WHERE sms_id = '".$_POST['sms_id']."' ");
        $sms = mysqli_fetch_array($result);
        $sender = mysqli_fetch_assoc(mysqli_query($con, "SELECT acc_username FROM tbl_accounts WHERE acc_id = '".$sms['sms_sender_id']."' "));
        $output = '
            <div class="modal-header">
                <div>
                    <h4 class="modal-title"><i class="fas fa-envelope"></i> Message Information</h4>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 row mb-2">
                    <div class="col-3">
                        <b>Date</b>
                    </div>
                    <div class="col-9">
                        <span>'.date("M d, Y - h:i a", strtotime($sms['sms_date'])).'</span>
                    </div>
                </div>
                <div class="col-12 row mb-2">
                    <div class="col-3">
                        <b>Message</b>
                    </div>
                    <div class="col-9">
                        <span>'.$sms['sms_message'].'</span>
                    </div>
                </div>
            </div>
        ';
        echo $output;
    }
?>