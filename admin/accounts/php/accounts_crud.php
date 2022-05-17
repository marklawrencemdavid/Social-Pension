<?php
    $response = 0;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (session_status() == PHP_SESSION_NONE) { session_start(); }
        date_default_timezone_set('Asia/Manila');
        include '../../../assets/php/database.php';
        $acc_session = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_accounts WHERE acc_id = '".$_SESSION['acc_id']."'"));
        // Create Account
        if ( isset($_POST['create_account'] ) ) {
            if($_POST['pot'] == ''){
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
                    $username = strtolower($_POST['appl_username']);
                    $username = ucfirst($username);
                    $username = trim($username);
                    $username = mysqli_real_escape_string($con,$username);
                    if($username != ''){
                        if(strlen($username) > 5){
                            $middlename = strtolower($_POST['appl_middlename']);
                            $middlename = ucfirst($middlename);
                            $middlename = trim($middlename);
                            $middlename = mysqli_real_escape_string($con,$middlename);

                            $contactNumber = $_POST['appl_contactNumber'];
                            $contactNumber = trim($contactNumber);
                            $contactNumber = mysqli_real_escape_string($con,$contactNumber);

                            $acc_email = $_POST['appl_email'];
                            $acc_email = trim($acc_email);
                            $acc_email = mysqli_real_escape_string($con,$acc_email);

                            $acc_password = $_POST['appl_password'];
                            $acc_password = trim($acc_password);
                            $acc_password = mysqli_real_escape_string($con,$acc_password);

                            // Get image name
                            $appl_picture = $_FILES["appl_picture"]["name"];
                            // Divide Filename to the filename and extension
                            $appl_picture_actual_name = pathinfo($appl_picture,PATHINFO_FILENAME);
                            $appl_picture_original_name = $appl_picture_actual_name;
                            $appl_picture_extension = pathinfo($appl_picture, PATHINFO_EXTENSION);
                            // Check if file already exist
                            $count = 1;
                            while (file_exists("../../../assets/img/account_picture/" . $appl_picture)) {
                                // New filename with number
                                $appl_picture_actual_name = (string)$appl_picture_original_name."-".$count;
                                $appl_picture = $appl_picture_actual_name.".".$appl_picture_extension;
                                $count++;
                            }
                            // Upload image to server
                            if(!move_uploaded_file($_FILES["appl_picture"]["tmp_name"], "../../../assets/img/account_picture/" . $appl_picture)){
                                // if not uploaded, the default file will be selected
                                $appl_picture = 'profile.svg';
                            }
                            
                            //Role
                            if (isset($_POST['role'])) {
                                $acc_role = $_POST['role'];
                            }else{
                                $acc_role = 'Staff';
                            }

                            //Insert to tbl_accounts
                            if(mysqli_query($con,"INSERT into `tbl_accounts` (acc_username, acc_lastname, acc_firstname, acc_middlename, acc_contactno, acc_picture, acc_password, acc_role, acc_email, acc_date_created)
                                VALUES ('$username', '$lastname', '$firstname', '$middlename', '$contactNumber', '$appl_picture', '".md5($acc_password)."', '$acc_role', '$acc_email', '".date('Y-m-d H:i:s')."')")){
                                // Data inserted id
                                $noti_data_id = mysqli_insert_id($con);
                                //Activity Log
                                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_data_id."', 'Account Create', '".date('Y-m-d H:i:s')."')");
                                //Insert to tbl_notifications
                                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', 'Account Create', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')" );
                                $response = 1;
                            }else{
                                $response = mysqli_error($con);
                            }
                        }else{
                            $response = 'Username should be at least 6 characters with no spaces. Pleass try again.';
                        }
                    }else{
                        $response = 'Username should not be composed of spaces. Pleass try again.';
                    }
                }else{
                    $response = 'Name should not be composed of spaces. Pleass try again.';
                }
            }
        } 
        // Update Account
        else if ( isset($_POST['update_account_submit']) ) {
            $noti_data_id = '';
            $count = 0;
            foreach($_POST['acc_id'] as $acc_id){
                $acc = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_accounts WHERE acc_id = '".$acc_id."'"));
                if($acc['acc_role'] != 'Super Admin'){
                    //Role
                    if(($_POST['update_account_select'] == 'Admin' || $_POST['update_account_select'] == 'Staff') && $acc['acc_role'] != 'Pensioner'){
                        if($acc_session['acc_role'] == 'Super Admin'){
                            mysqli_query($con, "UPDATE tbl_accounts SET acc_role = '".$_POST['update_account_select']."' WHERE acc_id = '$acc_id'");
                            $count++;
                        }else if($acc_session['acc_role'] == 'Admin' && $acc['acc_role'] == 'Staff'){
                            mysqli_query($con, "UPDATE tbl_accounts SET acc_role = '".$_POST['update_account_select']."' WHERE acc_id = '$acc_id'");
                            $count++;
                        }
                    }
                    //Status
                    else if($_POST['update_account_select'] == 'Active' || $_POST['update_account_select'] == 'Inactive'){
                        if($acc['acc_appl_id'] != '0'){
                            $appl = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_applicants WHERE appl_id = '".$acc['acc_appl_id']."'"));
                        }
                        
                        if($acc_session['acc_role'] == 'Super Admin'){
                            if(!($acc['acc_appl_id'] != '0' && $appl['appl_status'] == 'Deceased')){
                                mysqli_query($con, "UPDATE tbl_accounts SET acc_status = '".$_POST['update_account_select']."' WHERE acc_id = '$acc_id'");
                                $count++;
                            }
                        }else if($acc_session['acc_role'] == 'Admin' && ($acc['acc_role'] == 'Staff' || $acc['acc_role'] == 'Pensioner')){
                            if(!($acc['acc_appl_id'] != '0' && $appl['appl_status'] == 'Deceased')){
                                mysqli_query($con, "UPDATE tbl_accounts SET acc_status = '".$_POST['update_account_select']."' WHERE acc_id = '$acc_id'");
                                $count++;
                            }
                        }
                    }
                    //Delete
                    else if($_POST['update_account_select'] == 'Delete' && $_SESSION['acc_id'] != $acc_id && $acc['acc_role'] != 'Pensioner'){
                        if($acc_session['acc_role'] == 'Super Admin'){
                            mysqli_query($con, "DELETE FROM tbl_accounts WHERE acc_id = '$acc_id'");
                            $count++;
                        }else if($acc_session['acc_role'] == 'Admin' && $acc['acc_role'] == 'Staff'){
                            mysqli_query($con, "DELETE FROM tbl_accounts WHERE acc_id = '$acc_id'");
                            $count++;
                        }
                    }
                    //Count
                    if($count > 1){
                        $noti_data_id .= ','.$acc_id;
                    } else {
                        $noti_data_id .= $acc_id;
                    }
                }
            }
            if($count > 0){
                if($count == 1){
                    //Delete
                    if($_POST['update_account_select'] == 'Delete'){
                        $noti_action = 'Account Deleted';
                    }
                    //Role || Status
                    else if($_POST['update_account_select'] == 'Admin' || $_POST['update_account_select'] == 'Staff' || $_POST['update_account_select'] == 'Active' || $_POST['update_account_select'] == 'Inactive'){
                        $noti_action = 'Account '.$_POST['update_account_select'];
                    }
                }else{
                    //Delete
                    if($_POST['update_account_select'] == 'Delete'){
                        $noti_action = 'Account Deleted Bulk';
                    }
                    //Role || Status
                    else if($_POST['update_account_select'] == 'Admin' || $_POST['update_account_select'] == 'Staff' || $_POST['update_account_select'] == 'Active' || $_POST['update_account_select'] == 'Inactive'){
                        $noti_action = 'Account '.$_POST['update_account_select'].' Bulk';
                    }
                }
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                //Insert to tbl_notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                $response = 1;
            }else{
                $response = 'No account was update.';
            }
        }
        // Query (Filtering)
        else if ( isset($_POST['view_role_status']) ) {
            // No Selected
            if ( $_POST['select_role'] == 'All' && $_POST['select_status'] == 'All' ) {
                unset($_SESSION['select_role']);
                unset($_SESSION['select_status']);
                $_SESSION['query'] = "SELECT * from tbl_accounts order by acc_id ASC";
            // Only Role has value
            } else if ( $_POST['select_role'] != 'All' && $_POST['select_status'] == 'All' ) {
                $_SESSION['select_role'] = $_POST['select_role'];
                unset($_SESSION['select_status']);
                $_SESSION['query'] = "SELECT * from tbl_accounts WHERE acc_role = '".$_SESSION['select_role']."' order by acc_id ASC";
            // Only Status has value
            } else if ( $_POST['select_role'] == 'All' && $_POST['select_status'] != 'All ' ) {
                unset($_SESSION['select_role']);
                $_SESSION['select_status'] = $_POST['select_status'];
                $_SESSION['query'] = "SELECT * from tbl_accounts WHERE acc_status = '".$_SESSION['select_status']."' order by acc_id ASC";
            // Both have value
            } else if ( $_POST['select_role'] != 'All' && $_POST['select_status'] != 'All' ) {
                $_SESSION['select_role'] = $_POST['select_role'];
                $_SESSION['select_status'] = $_POST['select_status'];
                $_SESSION['query'] = "SELECT * from tbl_accounts WHERE acc_role = '".$_SESSION['select_role']."' AND acc_status = '".$_SESSION['select_status']."' order by acc_id ASC";
            }
        }
        // Query (Clear Filter)
        else if ( isset($_POST['reset_role_status']) ) {
            unset($_SESSION['select_role']);
            unset($_SESSION['select_status']);
            $_SESSION['query'] = "SELECT * from tbl_accounts order by acc_id ASC";
        }
        //Close Connection
        mysqli_close($con);
    }
    echo $response;
?>