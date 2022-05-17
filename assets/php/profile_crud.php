<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (session_status() == PHP_SESSION_NONE){session_start();}
        date_default_timezone_set('Asia/Manila');
        include 'database.php';
        $acc = mysqli_fetch_assoc(mysqli_query($con, "SELECT acc_password FROM tbl_accounts WHERE acc_id = '".$_SESSION['acc_id']."'"));

        if(isset($_POST['new_username'])){
            // New Username
            $usernmae = trim($_POST['new_username']);
            $username = mysqli_real_escape_string($con,$usernmae);
            if(mysqli_num_rows(mysqli_query($con, "SELECT acc_username FROM tbl_accounts WHERE acc_username = '".$username."'")) < 1){
                if(md5($_POST['cur_password']) == $acc['acc_password']){
                    //Update account username
                    if (mysqli_query($con, "UPDATE tbl_accounts SET acc_username = '".$usernmae."' WHERE acc_id = '".$_SESSION['acc_id']."'")) {
                        //Activity Log
                        mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'Account Username Update', '".date('Y-m-d H:i:s')."')");
                        //Success Message
                        $msg = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill h5"></i> Username updated successfully.<br><a href="#" onClick="window.location.reload();">Reload to see changes.</a></div>';
                    } else {
                        //Error Message
                        $msg = '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-circle-fill h5"></i> Failed to updated username. "'.mysqli_error($con).'"</div>';
                    }
                } else {
                    //Error Message
                    $msg = '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-circle-fill h5"></i> Password is incorrect.</div>';
                }
            }else{
                $msg = '<div class="alert alert-info" role="alert"><i class="bi bi-exclamation-circle-fill h5"></i> Username is already taken.</div>';
            }
        }elseif(isset($_POST['cur_password'])){
            // Check if current password is correct
            if(md5($_POST['cur_password']) == $acc['acc_password']){
                // Check if new password is the same with current one
                if(md5($_POST['new_password']) != $acc['acc_password']){
                    //Update account password
                    if (mysqli_query($con, "UPDATE tbl_accounts SET acc_password = '".md5($_POST['new_password'])."' WHERE acc_id = '".$_SESSION['acc_id']."'")) {
                        //Activity Log
                        mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'Account Password Update', '".date('Y-m-d H:i:s')."')");
                        //Success Message
                        $msg = '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle-fill h5"></i> Password updated successfully.<br>Click <a href="/assets/php/logout.php"">here</a> to logout and try your new password.</div>';
                    } else {
                        //Error Message
                        $msg = '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-circle-fill h5"></i> Failed to updated username. "'.mysqli_error($con).'"</div>';
                    }
                } else {
                    //Error Message
                    $msg = '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-circle-fill h5"></i> You cannot use your current password as your new one. Please try a new one.</div>';
                }
            } else {
                //Error Message
                $msg = '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-circle-fill h5"></i> Password is incorrect.</div>';
            }
        }
        //Close Connection
        mysqli_close($con);
        //Message output
        echo $msg;
    }
?>