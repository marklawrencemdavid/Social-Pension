<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include '../../../assets/php/database.php';
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        // Published
        if (isset($_POST['view_report_published'])) {
            unset($_SESSION['queryReports']);
            unset($_SESSION['queryReportsButton']);
        // Drafts
        }else if (isset($_POST['view_report_drafts'])) {
            $_SESSION['queryReports'] = "SELECT * from tbl_reports where rep_status = 'Draft' order by rep_id ASC";
            $_SESSION['queryReportsButton'] = 'Draft';
        // Trash
        }else if (isset($_POST['view_report_trash'])) {
            $_SESSION['queryReports'] = "SELECT * from tbl_reports where rep_status = 'Trashed' order by rep_id ASC";
            $_SESSION['queryReportsButton'] = 'Trashed';
        }
        //Close Connection
        mysqli_close($con);
    }
    //Reload to Previous Page
    header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>