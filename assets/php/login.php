<?php 
    if (isset($_POST['login_submit'])){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        date_default_timezone_set('Asia/Manila');
        include 'database.php';
    
        ob_start();
    
        //removes backslashes
        $username = stripslashes($_REQUEST['username']);
        $password = stripslashes($_REQUEST['password']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con,$username);
        $password = mysqli_real_escape_string($con,$password);

        $username = strtolower($username);

        //Checking if user is existing in the database or not
        $acc = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `tbl_accounts` WHERE (acc_username='".$username."' and acc_password='".md5($password)."')"));

        // Dashboard
        if(isset($acc) && $acc["acc_status"] == 'Active' && $acc["acc_role"] != 'Pensioner'){
            $_SESSION['acc_id'] = $acc['acc_id'];
            
            // Activity Log
            mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'Login', '".date('Y-m-d H:i:s')."')");
            
            mysqli_close($con);
            ob_end_flush();
            header("Location: ../../admin/dashboard");
        }
        // Website
        elseif(isset($acc) && $acc["acc_status"] == 'Active' && $acc["acc_role"] == 'Pensioner'){
            $_SESSION['acc_id'] = $acc['acc_id'];
            
            // Activity Log
            mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'Login', '".date('Y-m-d H:i:s')."')");
            
            mysqli_close($con);
            ob_end_flush();
            header("Location: ../../profile");
        }
        // None
        else{
            $_SESSION['succeserror'] = '<div class="alert alert-danger" role="alert"><span class="bi bi-check-circle-fill" style="width:24px; height:24px" ></span> Incorrect login details.</div>';
            mysqli_close($con);
            ob_end_flush();
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
        }
    }
?>