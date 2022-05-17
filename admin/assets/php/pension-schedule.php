<?php 
    if (session_status() == PHP_SESSION_NONE) {session_start();}
    include_once '../../../assets/php/database.php';
    $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_sms_shortcode,page_pension_message,page_pension_value,page_pension_date,page_barangay,page_pension_status FROM `tbl_pages` WHERE page_id = 1 "));
    $date = $pages['page_pension_date'];
    
    if($date != '' && (date('Y-m-d', strtotime($date)) == date('Y-m-d'))){
        // Max the execution time
        ini_set('max_execution_time', 600);

        // Get the values needed
        $shortcode = $pages['page_sms_shortcode'];
        $message = preg_replace( "/(\r|\n)(\r|\n)/", "\\n", trim($pages['page_pension_message']));
        $barangays = explode(',', $pages['page_barangay']);
        $clientCorrelator = "264823";
        $pension_value = $pages['pension_value'];
        $count = 1; $receiver = '';

        // Send message to all pensioners of every barangay
        foreach ($barangays as $barangay){
            $query = mysqli_query($con, "SELECT appl_id,appl_accesstoken,appl_contactno,appl_pension_recieved FROM tbl_applicants WHERE appl_barangay = '".$barangay."' AND appl_status = 'Active'");
            $numrows = mysqli_num_rows($query);
            $lastbarangay = end($barangays);
            if($numrows > 0){
                while($data = mysqli_fetch_assoc($query)){
                    $id = $data['appl_id'];
                    $access_token = $data['appl_accesstoken'];
                    $address = $data['appl_contactno'];
                    $pension_recieved = $data['appl_pension_recieved'] + $pension_value;
                    
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/".$shortcode."/requests?access_token=".$access_token ,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "{\"outboundSMSMessageRequest\": { \"clientCorrelator\": \"".$clientCorrelator."\", \"senderAddress\": \"".$shortcode."\", \"outboundSMSTextMessage\": {\"message\": \"".$message."\"}, \"address\": \"".$address."\" } }",
                        CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
                    ));
                    curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                        $response = "cURL Error #:" . $err;
                    } else {
                        if($count == 1){
                            $receiver .= $barangay.','.$address;
                            if($numrows == 1){
                                $receiver .= '|';
                            }
                        }else if($count < $numrows){
                            $receiver .= ','.$address;
                        }else{
                            $receiver .= ','.$address.'|';
                        }
                        //Pensioner
                        mysqli_query($con, "UPDATE tbl_applicants SET appl_pension_recieved = '$pension_recieved' WHERE appl_id = '$id'");
                        if(end($barangays) == $lastbarangay && $count == $numrows){
                            $noti_action = 'SMS Send';
                            //Activity Log
                            mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$count."', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                            //tbl_sms
                            mysqli_query($con, "INSERT INTO tbl_sms (sms_sender_id, sms_message, sms_receiver, sms_receiver_total, sms_date) VALUES ('".$_SESSION['acc_id']."', '".$message."', '".$receiver."', '".$count."', '".date('Y-m-d H:i:s')."')");
                            $response = "Success";
                        }
                        $count += 1;
                    }
                }
            }else{
                if($response == 0){
                    $response = "No active pensioner found.";
                }
            }
        }
        
        // Clear the schedule and Update Status
        $page_pension_status = $pages['page_pension_status'].'Done';
        mysqli_query($con, "UPDATE tbl_pages SET page_pension_value='', page_pension_date='', page_pension_message='', page_pension_status='".$page_pension_status."' WHERE page_id=1");
    }else{
        $response = 'No schedule today.';
    }
    echo $response;
?>