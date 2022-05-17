<?php
    if (session_status() == PHP_SESSION_NONE){session_start();}
    date_default_timezone_set('Asia/Manila');
    include 'database.php';
    //Activity Log
    mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'Logout', '".date('Y-m-d H:i:s')."')");
    // Destroying All Sessions
    if(session_destroy()){
        // Redirecting To login Page
        header("Location: /");
    }
?>