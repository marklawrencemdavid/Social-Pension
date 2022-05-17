<?php 
    $response = 'error';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include '../../../assets/php/database.php';

        // Update
        if($_GET['btn'] == 0 || $_GET['btn'] == 1){
            $value = $_POST['schedule_value'];
            $date = $_POST['schedule_date'];
            $message = trim($_POST['schedule_message']);

            if( $value > 499 ){
                if( date('Y-m-d', strtotime($date)) > date('Y-m-d') ){
                    if($message != ''){
                        if(mysqli_query($con, "UPDATE tbl_pages 
                            SET page_pension_value = '$value', page_pension_date = '$date', page_pension_message = '$message'
                            WHERE page_id = 1")){
                            // $noti_action = 'Page Settings';
                            // //Activity Log
                            // mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '1', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                            // //Insert to tbl_notifications
                            // mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '1', '".date('Y-m-d H:i:s')."')");
                        
                            $response = 1;
                        }
                    }else{
                        $response = 'Message should not be composed of all spaces.';
                    }
                }else{
                    $response = 'Date should be at least 1 day ahead.';
                }
            }else{
                $response = 'The value pensioners will recieved should be at least Php 500.';
            }
        }
        // Dalete
        else if($_GET['btn'] == 2){
            if(mysqli_query($con, "UPDATE tbl_pages 
                SET page_pension_value = '', page_pension_date = '', page_pension_message = ''
                WHERE page_id = 1")){
                // $noti_action = 'Page Settings';
                // //Activity Log
                // mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '1', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                // //Insert to tbl_notifications
                // mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '1', '".date('Y-m-d H:i:s')."')");
            
                $response = 2;
            }
        }
    }
    echo $response;
?>