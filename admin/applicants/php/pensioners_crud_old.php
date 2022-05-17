<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        date_default_timezone_set('Asia/Manila');
        include '../../../assets/php/database.php';
        // Bulk Move
        if (isset($_POST['update_pensioner_status']) && ($_POST['pensioner_status'] != '' && $_POST['pensioner_status'] != 'Delete')) {
            $appl_status = $_POST['pensioner_status'];
            $noti_data_id = '';
            $count = 0;
            foreach($_POST['appl_id'] as $appl_id){
                if($appl_status == 'Rejected'){
                    $date = date('Y-m-d H:i:s');
                    $data = mySQLi_fetch_assoc(mySQLi_query($con, "SELECT * from tbl_applicants where appl_id = '$appl_id'"));
                    mysqli_query($con, "UPDATE tbl_applicants SET appl_status = '".$appl_status."', appl_datesubmitted = '".$date."' WHERE appl_id = '$appl_id'");

                    // Send notification
                    $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_sms_shortcode,page_website_title,page_email,page_contactno FROM `tbl_pages` WHERE page_id = 1 "));
                    // SMS
                    if($_POST['update_pensioner_notify'] == 'sms'){
                        $shortcode = $pages['page_sms_shortcode'];
                        $clientCorrelator = "264823";
                        $access_token = $data['appl_accesstoken'];
                        $address = $data['appl_contactno'];
                        $message = "Hi ".$pages['page_website_title']." applicant,"."\\n\\n".
                                    "Good day!"."\\n\\n".
                                    "We are sorry to inform you that your application for Social Pension for Indigent Senior Citizens has been rejected."."\\n\\n".
                                    "For inquiries, you can email us at ".$pages['page_email']." or message us at 0".$pages['page_contactno'];
                        
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
                            echo "cURL Error #:" . $err;
                        }
                        if(end($_POST['appl_id']) == $appl_id){
                            $noti_action = 'SMS Send';
                            //Activity Log
                            $c = $count + 1;
                            mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$c."', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                        }
                    }
                    // Email
                    elseif($_POST['update_pensioner_notify'] == 'email'){
                        ini_set( 'display_errors', 1 );
                        error_reporting( E_ALL );
    
                        $from = "noreply@".$_SERVER['SERVER_NAME'];
                        $to = $data['appl_email'];
                        $subject = $pages['page_website_title']." - Application";
    
                        $message = "Hi ".$pages['page_website_title']." applicant,"." \r\n\r\n".
                                    "Good day!"." \r\n\r\n".
                                    "We are sorry to inform you that your application for Social Pension for Indigent Senior Citizens has been rejected."." \r\n\r\n".
                                    "For inquiries, you can email us at ".$pages['page_email']." or message us at 0".$pages['page_contactno'];
                        
                        $headers = "From: ".$pages['page_website_title'].'<'.$from.'>';
    
                        mail($to,$subject,$message, $headers);
                    }

                    $count++;
                }else if($appl_status == 'Deceased'){
                    mysqli_query($con, "UPDATE tbl_applicants SET appl_status = '".$appl_status."' WHERE appl_id = '".$appl_id."'");
                    mysqli_query($con, "UPDATE tbl_accounts SET acc_status = 'Inactive' WHERE acc_appl_id = '".$appl_id."'");
                    $count++;
                }else{
                    mysqli_query($con, "UPDATE tbl_applicants SET appl_status = '".$appl_status."' WHERE appl_id = '".$appl_id."'");
                    $count++;
                }

                if ($appl_status == 'Active') {
                    $data = mySQLi_fetch_assoc(mySQLi_query($con, "SELECT * from tbl_applicants where appl_id = '$appl_id'"));
                    //Set Acc to Active
                    if(mysqli_num_rows(mySQLi_query($con, "SELECT * from tbl_accounts where acc_appl_id = '$appl_id'")) == 1){
                        mysqli_query($con, "UPDATE tbl_accounts SET acc_status = 'Active' WHERE acc_appl_id = '".$appl_id."'");
                    }
                    //Create Pensioner Account
                    else{
                        // Generate Username
                        $acc_username = preg_replace('/\s+/','',$data['appl_lastname']) . '_' . round(microtime(true));
                        // Generate Random Password
                        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
                        $acc_password = substr( str_shuffle( $chars ), 0, 8 );

                        // Create Pensioner Account
                        if(!mysqli_query($con, "INSERT INTO tbl_accounts (acc_appl_id, acc_username, acc_firstname, acc_middlename, acc_lastname, acc_contactno, acc_password, acc_role, acc_picture, acc_email, acc_date_created) 
                            VALUES ('".$appl_id."', '".$acc_username."', '".$data['appl_firstname']."', '".$data['appl_middlename']."', '".$data['appl_lastname']."', '".$data['appl_contactno']."', '".md5($acc_password)."', 'Pensioner', '".$data['appl_picture']."', '".$data['appl_email']."', '".date('Y-m-d H:i:s')."')")){
                            // Error
                            $_SESSION['succeserror'] = '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="height: auto;">
                                    <small>
                                        '. "<strong>Failed!</strong> " . mysqli_error($con) .'
                                    </small>
                                </div>';
                        }else{
                            // Success
                            // Send Account Credentials
                            $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_sms_shortcode,page_website_title,page_email,page_contactno FROM `tbl_pages` WHERE page_id = 1 "));
                            // SMS
                            if($_POST['update_pensioner_notify'] == 'sms'){
                                $shortcode = $pages['page_sms_shortcode'];
                                $clientCorrelator = "264823";
                                $access_token = $data['appl_accesstoken'];
                                $address = $data['appl_contactno'];
                                $message = "Greetings from ".$pages['page_website_title']."\\n".
                                            "Your application has been approved!"."\\n\\n".
                                            "Account Username: ".$acc_username."\\n".
                                            "Account Password: ".$acc_password."\\n\\n".
                                            "We strictly prohibit sharing this information with anyone"."\\n\\n".
                                            "For inquiries, you can email us at ".$pages['page_email']." or message us at 0".$pages['page_contactno'];
                                
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
                                    echo "cURL Error #:" . $err;
                                }
                                if(end($_POST['appl_id']) == $appl_id){
                                    $noti_action = 'SMS Send';
                                    //Activity Log
                                    $c = $count + 1;
                                    mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$c."', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                                }
                            }
                            // Email
                            elseif($_POST['update_pensioner_notify'] == 'email'){
                                ini_set( 'display_errors', 1 );
                                error_reporting( E_ALL );

                                $from = "noreply@".$_SERVER['SERVER_NAME'];
                                $to = $data['appl_email'];
                                $subject = $pages['page_website_title']." - Application";

                                $message = "Greetings from ".$pages['page_website_title']." \r\n".
                                            "Your application has been approved!"." \r\n\r\n".
                                            "Account Username: ".$acc_username." \r\n".
                                            "Account Password: ".$acc_password." \r\n\r\n".
                                            "We strictly prohibit sharing this information with anyone"." \r\n\r\n".
                                            "For inquiries, you can email us at ".$pages['page_email']." or message us at 0".$pages['page_contactno'];
                                
                                $headers = "From: ".$pages['page_website_title'].'<'.$from.'>';

                                if(!(mail($to,$subject,$message, $headers))) {
                                    echo "The email message was not sent.";
                                }
                            }
                        }
                    }
                } else if ($appl_status == 'Deceased') {
                    // Set acc to Inactive
                    mysqli_query($con, "UPDATE tbl_accounts SET acc_status = 'Inactive' WHERE acc_appl_id = '".$appl_id."'");
                } else {
                    if($acc = mysqli_fetch_assoc(mysqli_query($con, "SELECT acc_id FROM tbl_accounts WHERE acc_appl_id = '$appl_id'"))){
                        // Delete Pensioner Purchases
                        mySQLi_query($con, "DELETE FROM tbl_purchases WHERE acc_id = '".$acc['acc_id']."'");
                        // Delete Pensioner Account
                        mySQLi_query($con, "DELETE FROM tbl_accounts WHERE acc_appl_id = '$appl_id'");
                    }
                }
                if($count > 1){
                    $noti_data_id .= ','.$appl_id;
                } else {
                    $noti_data_id .= $appl_id;
                }
            }
            if($count == 1){
                $noti_action = 'Pensioner '.$appl_status;
            }else{
                $noti_action = 'Pensioner '.$appl_status.' Bulk';
            }
            //Activity Log
            mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
            //Insert to tbl_notifications
            mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
        }
        // Bulk Delete Rejected Applicants
        else if (isset($_POST['update_pensioner_status']) && ($_POST['pensioner_status'] != '' && $_POST['pensioner_status'] == 'Delete')) {
            $noti_data_id = '';
            $count = 0;
            foreach($_POST['appl_id'] as $appl_id){
                $count++;
                mySQLi_query($con, "DELETE FROM tbl_applicants WHERE appl_id = '$appl_id'");
                // Delete Pensioner Account
                mySQLi_query($con, "DELETE FROM tbl_accounts WHERE acc_appl_id = '$appl_id'");
                if($count > 1){
                    $noti_data_id .= ','.$appl_id;
                } else {
                    $noti_data_id .= $appl_id;
                }
            }
            if($count == 1){
                $noti_action = 'Pensioner Deleted';
            }else{
                $noti_action = 'Pensioner Deleted Bulk';
            }
            //Activity Log
            mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
            //Insert to tbl_notifications
            mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
        }
    }
    // Delete all rejected applicant
    else if (isset($_GET['d']) && $_GET['d'] == 1){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        date_default_timezone_set('Asia/Manila');
        include '../../../assets/php/database.php';
        $count = 0;
        while($appl = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_applicants WHERE appl_status = 'Rejected'"))){
            $count += 1;
            if($count > 1){
                $noti_data_id .= ','.$appl['appl_id'];
            } else {
                $noti_data_id .= $appl['appl_id'];
            }
            if($appl['appl_picture'] != 'profile.svg'){
                unlink("../../../assets/img/applicant_picture/".$appl['appl_picture']);
            }
            if($appl['appl_proof'] != ''){
                unlink("../../../assets/img/applicant_proof/".$appl['appl_proof']);
            }
            mysqli_query($con, "DELETE FROM tbl_applicants WHERE appl_id = '".$appl['appl_id']."'");
        }
        $noti_action = 'Pensioner Deleted Bulk';
        //Activity Log
        mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
        //Insert to tbl_notifications
        mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
    }
    //Close Connection
    if(isset($con)){mysqli_close($con);}
    // //Reload to Previous Page
    // header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>