<?php
    if(isset($_POST['sms_id'])){
        include '../../../assets/php/database.php';
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
                        <label>Sender</label>
                    </div>
                    <div class="col-9">
                        <span>';
                        if(isset($sender['acc_username'])){$output .= $sender['acc_username'];}else{$output .= 'Pension Status Message';};
                        $output .= '</span>
                    </div>
                </div>
                <div class="col-12 row mb-2">
                    <div class="col-3">
                        <label>Date</label>
                    </div>
                    <div class="col-9">
                        <span>'.date("M d, Y - h:i a", strtotime($sms['sms_date'])).'</span>
                    </div>
                </div>
                <div class="col-12 row mb-2">
                    <div class="col-3">
                        <label>Receiver(Total)</label>
                    </div>
                    <div class="col-9">
                        <span>'.$sms['sms_receiver_total'].'</span>
                    </div>
                </div>
                <div class="col-12 row mb-2">
                    <div class="col-3">
                        <label>Worth</label>
                    </div>
                    <div class="col-9">
                        <span>₱ '.$sms['sms_receiver_total']*0.50.'</span>
                    </div>
                </div>
                <div class="col-12 row mb-2">
                    <div class="col-3">
                        <label>Message</label>
                    </div>
                    <div class="col-9">
                        <span>'.$sms['sms_message'].'</span>
                    </div>
                </div>
                <div class="col-12 row mb-2">
                    <div class="col-3">
                        <label>Receivers</label>
                    </div>
                    <div class="col-9">
                        <span>';
                        $explode = explode('|', $sms['sms_receiver']);
                        foreach($explode as $barangay){
                            if($barangay != ''){
                                $explode = explode(",", $barangay);
                                $output .= '<h5>Barangay '.$explode[0].'</h5>';
                                $count = 0;
                                $output .= '<table class="table">
                                                <thead>
                                                    <th class="py-0">Name</th>
                                                    <th class="py-0">Contact No.</th>
                                                </thead>
                                                <tbody>';
                                foreach($explode as $number){
                                    $count += 1;
                                    if($count != 1){
                                        $appl = mysqli_fetch_assoc(mysqli_query($con, "SELECT appl_lastname,appl_firstname,appl_middlename FROM tbl_applicants WHERE appl_contactno = '".$number."' "));
                                        $output .= '<tr>
                                                        <td class="py-0">'.$appl['appl_lastname'].', '.$appl['appl_firstname'].' '.$appl['appl_middlename'].'</td>
                                                        <td class="py-0">'.$number.'</td>
                                                    </tr>';
                                    }
                                }
                                        $output .= '</tbody>
                                            </table>';
                            }
                        }
            $output .= '</span>
                    </div>
                </div>
            </div>
        ';
        echo $output;
    }
?>