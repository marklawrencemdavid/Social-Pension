<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        date_default_timezone_set('Asia/Manila');
        include '../../../assets/php/database.php';
        
        // Approve
        if (isset($_POST['update_purchase_a'])) {
            if(mysqli_query($con, "UPDATE tbl_purchases SET pur_status = 'Approved' WHERE pur_id = '".$_POST['update_purchase_a']."'")){
                //Notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', 'Pensioner Purchase Approve', '".$_POST['update_purchase_a']."', '".date('Y-m-d H:i:s')."')");
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_POST['update_purchase_a']."', 'Pensioner Purchase Approve', '".date('Y-m-d H:i:s')."')");
            }
        }
        // Reject
        elseif(isset($_POST['update_purchase_r'])){
            if(mysqli_query($con, "UPDATE tbl_purchases SET pur_status = 'Rejected' WHERE pur_id = '".$_POST['update_purchase_r']."'")){
                //Notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', 'Pensioner Purchase Rejected', '".$_POST['update_purchase_r']."', '".date('Y-m-d H:i:s')."')");
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_POST['update_purchase_r']."', 'Pensioner Purchase Rejected', '".date('Y-m-d H:i:s')."')");
            }
        }
        // Pending
        elseif(isset($_POST['update_purchase_p'])){
            if(mysqli_query($con, "UPDATE tbl_purchases SET pur_status = 'Pending' WHERE pur_id = '".$_POST['update_purchase_p']."'")){
                //Notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', 'Pensioner Purchase Pending', '".$_POST['update_purchase_p']."', '".date('Y-m-d H:i:s')."')");
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_POST['update_purchase_p']."', 'Pensioner Purchase Pending', '".date('Y-m-d H:i:s')."')");
            }
        }
        // Bulk
        elseif(isset($_POST['update_purchase_bulk_submit'])){
            $pur_data_id = '';
            $updated_count = 0;
            foreach($_POST['pur_id'] as $pur_id){
                $pur = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_purchases WHERE pur_id = '".$pur_id."'"));
                if($pur['pur_status'] != $_POST['update_purchase_bulk']){

                    if(!mysqli_query($con, "UPDATE tbl_purchases SET pur_status = '".$_POST['update_purchase_bulk']."' WHERE pur_id = '".$pur_id."'")){
                        $_SESSION['error'] = mysqli_error($con);
                    }else{
                        $updated_count++;
                    }
                    
                    //updated_count
                    if($updated_count > 1){
                        $pur_data_id .= ','.$pur_id;
                    } else {
                        $pur_data_id .= $pur_id;
                    }
                }
            }
            if($updated_count > 0){
                if($updated_count == 1){
                    $pur_action = 'Pensioner Purchase '.$_POST['update_purchase_bulk'];
                }else{
                    $pur_action = 'Pensioner Purchase '.$_POST['update_purchase_bulk'].' Bulk';
                }
            }
            //Activity Log
            mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', '".$pur_action."', '".$pur_data_id."', '".date('Y-m-d H:i:s')."')");
            //Notifications
            mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$pur_action."', '".$pur_data_id."', '".date('Y-m-d H:i:s')."')");
        }
    }
    else if(isset($_GET['d']) && $_GET['d'] == 1){
        include '../../../assets/php/database.php';
        while($pur = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_purchases WHERE pur_status = 'Rejected'"))){
            unlink("../../../assets/img/pensioner_proof/".$pur['pur_proof']);
            mysqli_query($con, "DELETE FROM tbl_purchases WHERE pur_id = '".$pur['pur_id']."'");
        }
    }

    //Reload to Previous Page
    header('Location: ' . $_SERVER["HTTP_REFERER"] );
    //Close Connection
    if(isset($con)){mysqli_close($con);}
?>