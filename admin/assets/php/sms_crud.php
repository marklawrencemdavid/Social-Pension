<?php
    $response = '0';
    // Send SMS
    if($_GET['id'] == 1){
        if(isset($_POST['barangay'])){
            if(trim($_POST['message']) != ''){
                if (session_status() == PHP_SESSION_NONE) {session_start();}
                include_once '../../../assets/php/database.php';
                $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_sms_shortcode FROM `tbl_pages` WHERE page_id = 1 "));
                $message = preg_replace( "/(\r|\n)(\r|\n)/", "\\n", trim($_POST['message']));
                $shortcode = $pages['page_sms_shortcode'];
                $clientCorrelator = "264823";
                $count = 1; $receiver = '';
                foreach ($_POST['barangay'] as $barangay){
                    $query = mysqli_query($con, "SELECT appl_accesstoken,appl_contactno FROM tbl_applicants WHERE appl_barangay = '".$barangay."' AND appl_status = 'Active'");
                    $numrows = mysqli_num_rows($query);
                    $lastbarangay = end($_POST['barangay']);
                    if($numrows > 0){
                        while($data = mysqli_fetch_assoc($query)){
                            $access_token = $data['appl_accesstoken'];
                            $address = $data['appl_contactno'];
                            
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
                                if(end($_POST['barangay']) == $lastbarangay && $count == $numrows){
                                    $noti_action = 'SMS Send';
                                    //Activity Log
                                    mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$count."', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                                    //tbl_sms
                                    mysqli_query($con, "INSERT INTO tbl_sms (sms_sender_id, sms_message, sms_receiver, sms_receiver_total, sms_date) VALUES ('".$_SESSION['acc_id']."', '".$message."', '".$receiver."', '".$count."', '".date('Y-m-d H:i:s')."')");
                                    $response = "1";
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
            }else{
                $response = "Please provide a message.";
            }
        }else{
            $response = "Please select a barangay.";
        }
    }
    //Update SMS config
    else if($_GET['id'] == 2){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        date_default_timezone_set('Asia/Manila');
        include '../../../assets/php/database.php';
        $page_sms_shortcode = $_POST['page_sms_shortcode'];
        $page_sms_shortcode = trim($page_sms_shortcode);
        $page_sms_shortcode = mysqli_real_escape_string($con, $page_sms_shortcode);
        
        $page_sms_appid = $_POST['page_sms_appid'];
        $page_sms_appid = trim($page_sms_appid);
        $page_sms_appid = mysqli_real_escape_string($con, $page_sms_appid);

        $page_sms_appsecret = $_POST['page_sms_appsecret'];
        $page_sms_appsecret = trim($page_sms_appsecret);
        $page_sms_appsecret = mysqli_real_escape_string($con, $page_sms_appsecret);

        if($page_sms_shortcode != ''){
            if($page_sms_appid != ''){
                if($page_sms_appsecret != ''){
                    if(mysqli_query($con, "UPDATE tbl_pages 
                                SET page_sms_shortcode = '$page_sms_shortcode', page_sms_appid = '$page_sms_appid', page_sms_appsecret = '$page_sms_appsecret'
                                WHERE page_id = 1")){
                        $noti_action = 'Page Settings';
                        //Activity Log
                        mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '1', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                        //Insert to tbl_notifications
                        mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '1', '".date('Y-m-d H:i:s')."')");
                        $response = 1;
                    }else{
                        $response = mysqli_error($con);
                    }
                }else{
                    $response = 'Invalid App Secret.';
                }
            }else{
                $response = 'Invalid App ID.';
            }
        }else{
            $response = 'Invalid Short Code.';
        }
    }
    echo $response;
?>