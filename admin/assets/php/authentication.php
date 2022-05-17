<?php
    //Start Session
    if (session_status() == PHP_SESSION_NONE) {session_start();}
    if(isset($_SESSION['acc_id'])){
        date_default_timezone_set('Asia/Manila');
        
        $acc_id = $_SESSION['acc_id'];
        $acc  = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_accounts` WHERE acc_id='$acc_id'"));
        $page = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') );

        if ($acc['acc_role'] == 'Pensioner') {
            // Redirect user to index of main website
            header("Location: /");
        } else if ($acc['acc_status'] == 'Inactive') {
            if (session_status() == PHP_SESSION_NONE) {
                header("Location: /");
            }else if(session_status() == PHP_SESSION_ACTIVE){
                // Destroy Session
                session_destroy();
                // Redirecting To login Page
                header("Location: /");
            }
        } else if ($acc['acc_status'] == 'Active') {
            // Autobackup
            // PHP 8
            // if (str_contains($page['page_autobackup_days'], date('l'))) {
            // PHP 7
            $curPageName = basename($_SERVER['PHP_SELF']);
            if ($curPageName == 'activity_log.php' || $curPageName == 'dashboard.php' || $curPageName == 'email_read.php' || $curPageName == 'email.php' || $curPageName == 'multitab.php' || $curPageName == 'notifications.php' || $curPageName == 'website.php'){
                // $backup_dir = '../backup/';
                $pen_proof_dir = '../assets/img/pensioner_proof/';
            }else{
                // $backup_dir = '../../backup/';
                $pen_proof_dir = '../../assets/img/pensioner_proof/';
            }

            // Delete To Do item after due
            mysqli_query($con, "DELETE FROM tbl_todo WHERE todo_date_due <= '".date('Y-m-d')."' AND todo_time_due < '".date('H:i')."'");
            // Delete Rejected Purchase items after a day
            while($pur = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_purchases WHERE pur_status = 'Rejected' AND pur_date < DATE_SUB(NOW(), INTERVAL 1 DAY)"))){
                unlink($pen_proof_dir.$pur['pur_proof']);
                mysqli_query($con, "DELETE FROM tbl_purchases WHERE pur_id = '".$pur['pur_id']."'");
            }
            // Delete Rejected Applicants after 30 days
            while($appl = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_applicants WHERE appl_status = 'Rejected' AND appl_datesubmitted < DATE_SUB(NOW(), INTERVAL 1 DAY)"))){
                //Set Pensioner as DELETED
                mysqli_query($con, "UPDATE tbl_applicants SET appl_status = 'Deleted', appl_date_decease_delete = '".$date."' WHERE appl_id = '".$appl['appl_id']."'");
            }
        }
    }else{
        // Redirect user to index of main website
        header("Location: /login");
    }
?>