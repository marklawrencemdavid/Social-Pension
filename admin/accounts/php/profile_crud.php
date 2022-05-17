<?php
    $response = 0;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        date_default_timezone_set('Asia/Manila');
        include '../../../assets/php/database.php';
        $userdata = mysqli_fetch_array( mysqli_query($con, "SELECT * FROM `tbl_accounts` WHERE acc_id = '".$_SESSION['acc_id']."'") );
        // Details
        if (isset($_POST['update_details'])) {
            $uname_update = strtolower($_POST['uname_update']);
            $uname_update = ucfirst($uname_update);
            $uname_update = trim($uname_update);
            $uname_update = mysqli_real_escape_string($con,$uname_update);
            if(strlen($uname_update) > 5){
                if(mysqli_num_rows(mysqli_query($con, "SELECT acc_username FROM tbl_accounts WHERE acc_id != '".$_SESSION['acc_id']."' AND acc_username = '".$uname_update."'")) == 0){
                    $lname_update = strtolower($_POST['lname_update']);
                    $lname_update = ucfirst($lname_update);
                    $lname_update = trim($lname_update);
                    $lname_update = mysqli_real_escape_string($con,$lname_update);

                    $fname_update = strtolower($_POST['fname_update']);
                    $fname_update = ucfirst($fname_update);
                    $fname_update = trim($fname_update);
                    $fname_update = mysqli_real_escape_string($con,$fname_update);

                    $mname_update = strtolower($_POST['mname_update']);
                    $mname_update = ucfirst($mname_update);
                    $mname_update = trim($mname_update);
                    $mname_update = mysqli_real_escape_string($con,$mname_update);

                    $contactno_update = $_POST['contactno_update'];
                    $contactno_update = trim($contactno_update);
                    $contactno_update = mysqli_real_escape_string($con,$contactno_update);

                    $email_update = $_POST['email_update'];
                    $email_update = trim($email_update);
                    $email_update = mysqli_real_escape_string($con,$email_update);

                    $dm_update = '0';
                    if (isset($_POST['dm_update'])) {
                        $dm_update = "1";  
                    }

                    if($_POST['img_label'] != $userdata['acc_picture']){
                        // Get image name
                        $temp = explode(".", $_FILES["piture_update"]["name"]);
                        // New name based on time and usernamename
                        $picture = round(microtime(true)) . '_' . $userdata['acc_username'] . '.' . end($temp);
                        // Upload image to server
                        if(!move_uploaded_file($_FILES["piture_update"]["tmp_name"], "../../../assets/img/account_picture/" . $picture)){
                            // if not uploaded, the default file will be selected
                            $picture = 'profile.svg';
                        }else{
                            // Delete Prev Picture if not set to default
                            if ($userdata['acc_picture'] != 'profile.svg') {
                                unlink("../../../assets/img/account_picture/".$userdata['acc_picture']);
                            }
                        }
                    }else{
                        $picture = $userdata['acc_picture'];
                    }

                    if(mysqli_query($con, "UPDATE tbl_accounts 
                                        SET acc_lastname = '$lname_update', acc_firstname = '$fname_update', acc_middlename = '$mname_update', acc_contactno = '$contactno_update',
                                            acc_email = '$email_update', acc_picture = '$picture', acc_darkmode = '$dm_update', acc_username = '$uname_update'
                                        WHERE  acc_id = '".$_SESSION['acc_id']."'")){
                        //Activity Log
                        mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'Profile Details', '".date('Y-m-d H:i:s')."')");
                        $response = 1;
                    }else{
                        // Mysqli error
                        $response = mysqli_error($con);
                    }
                }else{
                    // Taken username
                    $response = 'Username is already taken';
                }
            }else{
                // Blank username
                $response = 'Username should not contain spaces';
            }
        }
        // Password
        else if (isset($_POST['update_password'])) {
            $new_password = $_POST['new_password'];
            $new_password = trim($new_password);
            $new_password = mysqli_real_escape_string($con,$new_password);
            
            $re_password = $_POST['re_password'];
            $re_password = trim($re_password);
            $re_password = mysqli_real_escape_string($con,$re_password);
            if(strlen($new_password) > 7 && strlen($re_password) > 7){
                if ($new_password == $re_password) {
                    $old_password = $_POST['old_password'];
                    $old_password = mysqli_real_escape_string($con,$old_password);
                    
                    if ($userdata['acc_password'] == md5($old_password)) {
                        if (md5($new_password) != $userdata['acc_password']) {
                            if (mysqli_query($con, "UPDATE tbl_accounts SET acc_password = '".md5($new_password)."' WHERE acc_id = '".$_SESSION['acc_id']."'")) {
                                //Activity Log
                                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'Profile Password', '".date('Y-m-d H:i:s')."')");
                                $response = 1;
                            } else {
                                // Mysqli error
                                $response = mysqli_error($con);
                            } 
                        } else {
                            //error New passord is same as the old/current password
                            $response = 'New passwords is the same as current password';
                        }
                    } else {
                        //error Wrong old/current password
                        $response = 'Password is incorrect';
                    }
                } else {
                    //error new and re passwords are not the same
                    $response = 'New passwords are not the same';
                }
            } else {
                // has whitespaces
                $response = 'Password should not contain spaces';
            }
        }
        // Delete Account
        else if (isset($_POST['delete_account'])) {
            if($userdata['acc_password'] == md5($_POST['del_password'])){
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'Delete Account', '".date('Y-m-d H:i:s')."')");
                if($userdata['acc_role'] == 'Super Admin'){
                    mysqli_query($con, "UPDATE tbl_accounts SET acc_role = 'Super Admin' WHERE acc_username = '".$_POST['new_sa']."'");
                }
                mysqli_query($con, "DELETE FROM tbl_accounts WHERE acc_id = '".$_SESSION['acc_id']."'");
                session_destroy();
                $response = '1';
                // header('Location: /');
            }else{
                //error Wrong old/current password
                $response = 'Password is incorrect';
            }
        }
        //Close Connection
        mysqli_close($con);
    }
    echo $response;
?>