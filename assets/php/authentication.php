<?php
    // Start Session
    if (session_status() == PHP_SESSION_NONE){session_start();}
    // Set timezone
    date_default_timezone_set('Asia/Manila');
    // Set current page name
    $curPageName = basename($_SERVER['PHP_SELF']);

    // Prevent access on Log in Page and redirect to index if already log in.
    if(isset($_SESSION['acc_id'])){
        include 'database.php';
        $acc = mysqli_fetch_assoc(mysqli_query($con, "SELECT acc_role,acc_status FROM tbl_accounts WHERE acc_id = '".$_SESSION['acc_id']."'"));
        mysqli_close($con);

        if($acc['acc_role'] != 'Pensioner' && $acc['acc_status'] == 'Active'){
            header('Location: /admin/dashboard');
        }else if($curPageName == 'login.php' && $acc['acc_role'] == 'Pensioner' && $acc['acc_status'] == 'Active'){
            header('Location: /');
        }else if($curPageName == 'profile.php' && $acc['acc_status'] == 'Inactive'){
            session_destroy();
            header('Location: /');
        }
    }
    // If accessing pages that need to be logged in but not logged in, redirect to index
    else if(!isset($_SESSION['acc_id']) && $curPageName == 'profile.php'){
        session_destroy();
        header('Location: /login');
    }
?>