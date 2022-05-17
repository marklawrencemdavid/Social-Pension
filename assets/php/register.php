<?php
    // Start Session
    if (session_status() == PHP_SESSION_NONE){session_start();}
    // Insert new applicant
    if(isset($_SESSION['appl_data'])){
        include 'database.php';
        $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_sms_appsecret,page_sms_appid FROM `tbl_pages` WHERE page_id = 1 "));

        $app_id = $pages['page_sms_appid'];
        $app_secret = $pages['page_sms_appsecret'];
        $code = $_GET['code'];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://developer.globelabs.com.ph/oauth/access_token?app_id=".$app_id."&app_secret=".$app_secret."&code=".$code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array( "cache-control: no-cache" ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            header("Location: ../../register-for-social-pension.php?result=".$err);
        } else {
            $explode = explode(',', substr($response, 1, -1));
            $explode0 = explode(':', $explode[0]);
            $explode1 = explode(':', $explode[1]);
            $access_token = substr($explode0[1], 1, -1);
            $subscriber_number = substr($explode1[1], 1, -1);

            // print_r($_SESSION['appl_data']); echo '<br>';
            $lastname = $_SESSION['appl_data']['lastname'];
            $firstname = $_SESSION['appl_data']['firstname'];
            $middlename = $_SESSION['appl_data']['middlename'];
            $birthdate = $_SESSION['appl_data']['birthdate'];
            $birthplace = $_SESSION['appl_data']['birthplace'];
            $gender = $_SESSION['appl_data']['gender'];
            $houseno = $_SESSION['appl_data']['houseno'];
            $barangay = $_SESSION['appl_data']['barangay'];
            $municipality = $_SESSION['appl_data']['municipality'];
            $province = $_SESSION['appl_data']['province'];
            $civilstatus = $_SESSION['appl_data']['civilstatus'];
            $prevOccupation = $_SESSION['appl_data']['prevOccupation'];
            $contactNumber = $subscriber_number;
            $pensioner = $_SESSION['appl_data']['pensioner'];
            $appl_email = $_SESSION['appl_data']['email'];
            $appl_picture = $_SESSION['appl_data']['appl_picture'];
            $appl_proof = $_SESSION['appl_data']['appl_proof'];
            $appl_status = "Applicant";

            if(mysqli_num_rows(mysqli_query($con, "SELECT appl_id FROM tbl_applicants 
                WHERE appl_lastname = '".$lastname."' AND 
                appl_firstname = '".$firstname."' AND 
                appl_middlename = '".$middlename."' AND 
                appl_houseno = '".$houseno."' AND 
                appl_barangay = '".$barangay."'")) > 0){
                $appl_status='Spam';
            }
            
            // Check if file already exist
            $new_appl_picture = $appl_picture;
            $count_appl_picture = 1;
            while (file_exists('../img/applicant_picture/' . $new_appl_picture)) {
                // New filename with number
                $new_appl_picture = $count_appl_picture.'-'.$new_appl_picture;
                $count_appl_picture++;
            }
            if(file_exists('../img/applicant_picture_temp/'.$appl_picture)){
                rename("../img/applicant_picture_temp/".$appl_picture, "../img/applicant_picture/".$new_appl_picture);
            }
            // Check if file already exist
            $new_appl_proof = $appl_proof;
            $count_appl_proof = 1;
            while (file_exists('../img/applicant_proof/' . $new_appl_proof)) {
                // New filename with number
                $new_appl_proof = $count_appl_proof.'-'.$new_appl_proof;
                $count_appl_proof++;
            }
            if(file_exists('../img/applicant_proof_temp/'.$appl_proof)){
                rename("../img/applicant_proof_temp/".$appl_proof, "../img/applicant_proof/".$new_appl_proof);
            }

            $appl_picture = $new_appl_picture;
            $appl_proof = $new_appl_proof;

            // Insert to tbl_applicants
            if (mysqli_query($con, "INSERT into `tbl_applicants` (appl_lastname, appl_firstname, appl_middlename, appl_birthdate, appl_placeofbirth, appl_gender, appl_houseno, appl_barangay, appl_municipality, appl_province, appl_civilstatus, appl_prevoccupation, appl_contactno, appl_pensioner, appl_picture, appl_email, appl_status, appl_datesubmitted, appl_accesstoken, appl_proof)
                VALUES ('$lastname', '$firstname', '$middlename', '$birthdate', '$birthplace', '$gender', '$houseno', '$barangay', '$municipality', '$province', '$civilstatus', '$prevOccupation', '$contactNumber', '$pensioner', '$appl_picture', '$appl_email', '$appl_status', '".date('Y-m-d H:i:s')."', '".$access_token."', '".$appl_proof."')")) {
                // Data inserted id
                $noti_data_id = mysqli_insert_id($con);
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('Someone', '".$noti_data_id."', 'Pensioner Applicant', '".date('Y-m-d H:i:s')."')");
                //Insert to tbl_notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('Someone', 'Pensioner Applicant', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')" );
                
                // Redir
                header("Location: ../../register-for-social-pension.php?result=success");
                $response = 1;
            }else{
                $response = mysqli_error($con);
                header("Location: ../../register-for-social-pension.php?result=".$response);
            }
        }

        //Close Connection
        mysqli_close($con);
        // Clear Var
        if (isset($_SESSION['appl_data'])){unset($_SESSION['appl_data']);}
    }
    // Update applicant that was added on dashboard
    else if(isset($_GET['code'])){
        include 'database.php';
        $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_sms_appsecret,page_sms_appid FROM `tbl_pages` WHERE page_id = 1 "));

        $code = $_GET['code'];
        $app_id = $pages['page_sms_appid'];
        $app_secret = $pages['page_sms_appsecret'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://developer.globelabs.com.ph/oauth/access_token?app_id=".$app_id."&app_secret=".$app_secret."&code=".$code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array( "cache-control: no-cache" ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            header("Location: ../../register-for-social-pension.php?result=". $err);
        } else {
            $explode = explode(',', substr($response, 1, -1));
            $explode0 = explode(':', $explode[0]);
            $explode1 = explode(':', $explode[1]);
            $access_token = substr($explode0[1], 1, -1);
            $subscriber_number = substr($explode1[1], 1, -1);

            if(mysqli_query($con, "UPDATE tbl_applicants SET appl_accesstoken = '".$access_token."' WHERE  appl_contactno = '".$subscriber_number."'")){
                    echo 'Success!!<br>';
                    header("Location: ../../register-for-social-pension.php?result=success");
            }else{
                    $response = mysqli_error($con);
                    header("Location: ../../register-for-social-pension.php?result=".$response);
            }
        }
    }
    // Destroy Session
    if (session_status() == PHP_SESSION_ACTIVE){session_destroy();}
?>