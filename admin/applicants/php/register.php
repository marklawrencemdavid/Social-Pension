<?php
    $response = 0;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_POST['pot'] == ''){
            if (session_status() == PHP_SESSION_NONE) {session_start();}
            date_default_timezone_set('Asia/Manila');
            include '../../../assets/php/database.php';

            // Full Name
            $lastname = strtolower($_POST['appl_lastname']);
            $lastname = ucfirst($lastname);
            $lastname = trim($lastname);
            $lastname = mysqli_real_escape_string($con,$lastname);

            $firstname = strtolower($_POST['appl_firstname']);
            $firstname = ucfirst($firstname);
            $firstname = trim($firstname);
            $firstname = mysqli_real_escape_string($con,$firstname);
            if($lastname != '' && $firstname != ''){
                // Address
                $houseno = $_POST['appl_houseno'];
                $houseno = ucfirst($houseno);
                $houseno = trim($houseno);
                $houseno = mysqli_real_escape_string($con,$houseno);
                if($houseno != ''){
                    // Birthdate | Birth place | gender
                    $birthdate = $_POST['appl_birthdate'];
                    if(strtotime($birthdate)<strtotime('-60 year')){
                        $birthplace = $_POST['appl_birthplace'];
                        $birthplace = ucfirst($birthplace);
                        $birthplace = trim($birthplace);
                        $birthplace = mysqli_real_escape_string($con,$birthplace);
                        if($birthplace != ''){
                            $prevOccupation = $_POST['appl_prevOccupation'];
                            $prevOccupation = ucfirst($prevOccupation);
                            $prevOccupation = trim($prevOccupation);
                            $prevOccupation = mysqli_real_escape_string($con,$prevOccupation);
                            if($prevOccupation != ''){
                                $middlename = strtolower($_POST['appl_middlename']);
                                $middlename = ucfirst($middlename);
                                $middlename = trim($middlename);
                                $middlename = mysqli_real_escape_string($con,$middlename);

                                $barangay = $_POST['appl_barangay'];
                                $barangay = ucfirst($barangay);
                                $barangay = trim($barangay);
                                $barangay = mysqli_real_escape_string($con,$barangay);

                                $municipality = $_POST['appl_municipality'];
                                $municipality = ucfirst($municipality);
                                $municipality = trim($municipality);
                                $municipality = mysqli_real_escape_string($con,$municipality);

                                $province = $_POST['appl_province'];
                                $province = ucfirst($province);
                                $province = trim($province);
                                $province = mysqli_real_escape_string($con,$province);

                                $gender = $_POST['appl_gender'];

                                // Civil Status | Contact No. | Prev Occupation
                                $civilstatus = $_POST['appl_civilStatus'];

                                $contactNumber = $_POST['appl_contactNumber'];
                                $contactNumber = trim($contactNumber);
                                $contactNumber = mysqli_real_escape_string($con,$contactNumber);
                                $contactNumber = substr($contactNumber, 1);
                                $numrows = mysqli_num_rows(mysqli_query($con, "SELECT appl_id FROM tbl_applicants WHERE appl_contactno = '".$contactNumber."'"));
                                if($numrows == 0){
                                    $appl_email = $_POST['appl_email'];
                                    $appl_email = trim($appl_email);
                                    $appl_email = mysqli_real_escape_string($con,$appl_email);
                                    $numrows2 = mysqli_num_rows(mysqli_query($con, "SELECT appl_id FROM tbl_applicants WHERE appl_email = '".$appl_email."'"));
                                    if($numrows2 == 0){
                                        // Pensioner implode()explode()
                                        $pensioner = '';
                                        if (isset($_POST['appl_sss'])) {
                                            $pensioner .= $_POST['appl_sss'] . ",";  
                                        }
                                        if (isset($_POST['appl_gsis'])) {
                                            $pensioner .= $_POST['appl_gsis'] . ",";  
                                        }
                                        if (isset($_POST['appl_pvao'])) {
                                            $pensioner .= $_POST['appl_pvao'] . ",";  
                                        }
                                        if (isset($_POST['appl_fps'])) {
                                            $pensioner .= $_POST['appl_fps'] . ",";  
                                        }
                                        if (isset($_POST['appl_other'])) {
                                            $appl_other = mysqli_real_escape_string($con,$_POST['appl_other']);
                                            $appl_other = trim($appl_other);
                                            $appl_other = ucfirst($appl_other);
                                            $pensioner .= $appl_other . ", ";  
                                        }
                                        if ($pensioner == null || $pensioner == '') {
                                            $pensioner = 'None';
                                        }
                                        $pensioner = rtrim($pensioner, ", ");

                                        // Get image name
                                        $appl_picture = $_FILES["appl_picture"]["name"];
                                        // Divide Filename to the filename and extension
                                        $appl_picture_actual_name = pathinfo($appl_picture,PATHINFO_FILENAME);
                                        $appl_picture_original_name = $appl_picture_actual_name;
                                        $appl_picture_extension = pathinfo($appl_picture, PATHINFO_EXTENSION);
                                        // Check if file already exist
                                        $count = 1;
                                        while (file_exists('../../../assets/img/applicant_picture/' . $appl_picture)) {
                                            // New filename with number
                                            $appl_picture_actual_name = (string)$appl_picture_original_name."-".$count;
                                            $appl_picture = $appl_picture_actual_name.".".$appl_picture_extension;
                                            $count++;
                                        }
                                        // Upload image to server
                                        if(!move_uploaded_file($_FILES["appl_picture"]["tmp_name"], '../../../assets/img/applicant_picture/' . $appl_picture)){
                                            // if not uploaded, the default file will be selected
                                            $appl_picture = 'default.png';
                                        }

                                        //Status
                                        $status = $_POST['appl_status'];
                                        $numrows3 = mysqli_num_rows(mysqli_query($con, "SELECT appl_id FROM tbl_applicants WHERE appl_lastname = '".$lastname."' AND appl_firstname = '".$firstname."' AND appl_middlename = '".$middlename."' AND appl_houseno = '".$houseno."' AND appl_barangay = '".$barangay."'"));
                                        if($numrows3 > 0){
                                            $status='Spam';
                                        }

                                        //Get Proof name
                                        $appl_proof = $_FILES["appl_proof"]["name"];
                                        // Divide Filename to the filename and extension
                                        $appl_proof_actual_name = pathinfo($appl_proof,PATHINFO_FILENAME);
                                        $appl_proof_original_name = $appl_proof_actual_name;
                                        $appl_proof_extension = pathinfo($appl_proof, PATHINFO_EXTENSION);
                                        // Check if file already exist
                                        $count = 1;
                                        while (file_exists('../../../assets/img/applicant_proof/' . $appl_proof)) {
                                            // New filename with number
                                            $appl_proof_actual_name = (string)$appl_proof_original_name."-".$count;
                                            $appl_proof = $appl_proof_actual_name.".".$appl_proof_extension;
                                            $count++;
                                        }
                                        // Upload image to server
                                        if(!move_uploaded_file($_FILES["appl_proof"]["tmp_name"], '../../../assets/img/applicant_proof/' . $appl_proof)){
                                            // if not uploaded, the default file will be selected
                                            $appl_proof = '';
                                        }

                                        //Insert to tbl_applicants
                                        if (mysqli_query($con, "INSERT into `tbl_applicants` (appl_status, appl_lastname, appl_firstname, appl_middlename, appl_birthdate, appl_placeofbirth, appl_gender, appl_houseno, appl_barangay, appl_municipality, appl_province, appl_civilstatus, appl_prevoccupation, appl_contactno, appl_email, appl_pensioner, appl_picture, appl_datesubmitted, appl_proof)
                                            VALUES ('$status', '$lastname', '$firstname', '$middlename', '$birthdate', '$birthplace', '$gender', '$houseno', '$barangay', '$municipality', '$province', '$civilstatus', '$prevOccupation', '$contactNumber', '$appl_email', '$pensioner', '$appl_picture', '".date('Y-m-d H:i:s')."', '".$appl_proof."')")) {
                                            // Data inserted id
                                            $noti_data_id = mysqli_insert_id($con);
                                            // Create account   
                                            if($status == "Active" || $status == "Deceased"){
                                                if($status == "Active"){
                                                    $acc_status = 'Active';
                                                }else{
                                                    $acc_status = 'Inactive';
                                                }
                                                // Generate Username
                                                $acc_username = preg_replace('/\s+/','',$lastname) . '_' . round(microtime(true));
                                                // Generate Random Password
                                                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
                                                $acc_password = substr( str_shuffle( $chars ), 0, 8 );
                                                mysqli_query($con, "INSERT INTO tbl_accounts 
                                                (acc_appl_id, acc_username, acc_firstname, acc_middlename, acc_lastname, acc_contactno, acc_password, acc_role, acc_picture, acc_email, acc_date_created, acc_status) 
                                                VALUES ('".$noti_data_id."', '".$acc_username."', '".$firstname."', '".$middlename."', '".$lastname."', '".$contactNumber."', '".md5($acc_password)."', 'Pensioner', '".$appl_picture."', '".$appl_email."', '".date('Y-m-d H:i:s')."', '".$acc_status."')");
                                            
                                                if($status == "Active"){
                                                    $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_website_title,page_email,page_contactno,page_sms_appid FROM tbl_pages WHERE page_id = 1"));
                                                    ini_set( 'display_errors', 1 );
                                                    error_reporting( E_ALL );
                    
                                                    $from = "noreply@".$_SERVER['SERVER_NAME'];
                                                    $to = $appl_email;
                                                    $subject = $pages['page_website_title']." - Application";
                    
                                                    $message = "Greetings from ".$pages['page_website_title']." \r\n".
                                                                "Here is your account credentials to our website"." \r\n\r\n".
                                                                "Account Username: ".$acc_username." \r\n".
                                                                "Account Password: ".$acc_password." \r\n\r\n".
                                                                "You can now try loggin to your account in ".$_SERVER['SERVER_NAME']." \r\n".
                                                                "To recieve updates, kindly register your number \"$contactNumber\" in http://developer.globelabs.com.ph/dialog/oauth/".$pages['page_sms_appid'].""." \r\n".
                                                                "Note: If you register a different number from the number registered to your account, you will not recieve any updates."." \r\n\r\n".
                                                                "We strictly prohibit sharing this information with anyone"." \r\n\r\n".
                                                                "For inquiries, you can email us at ".$pages['page_email']." or message us at 0".$pages['page_contactno'];
                                                    
                                                    $headers = "From: ".$pages['page_website_title'].'<'.$from.'>';
                                                }
                
                                                mail($to,$subject,$message, $headers);
                                            }
                                            //Activity Log
                                            mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_data_id."', 'Pensioner Applicant', '".date('Y-m-d H:i:s')."')");
                                            //Insert to tbl_notifications
                                            mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', 'Pensioner Applicant', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')" );
                                            $response = 1;
                                        } else {
                                            $response = mysqli_error($con);
                                        }
                                    }else{
                                        $response = 'Email is already in used. Pleass try again.';
                                    }
                                }else{
                                    $response = 'Contact number is already in used. Pleass try again.';
                                }
                            }else{
                                $response = 'Previous occupation should not be composed of spaces. Pleass try again.';
                            }
                        }else{
                            $response = 'Place of birth should not be composed of spaces. Pleass try again.';
                        }
                    }else{
                        $response = 'Birthdate should be at least 60 years from now. Pleass try again.';
                    }
                }else{
                    $response = 'Address should not be composed of spaces. Pleass try again.';
                }
            }else{
                $response = 'Name should not be composed of spaces. Pleass try again.';
            }
        }else{
            $response = 1;
        }
        //Close Connection
        mysqli_close($con);
    }
    echo $response;
?>