<?php
    $response = 'error';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        date_default_timezone_set('Asia/Manila');
        include '../../../assets/php/database.php';
        
        if(isset($_GET['insert'])){
            if(($_POST['todo_date_due'] >= date("Y-m-d")) || ($_POST['todo_date_due'] == date("Y-m-d")  && date('H:i', strtotime($_POST['todo_time_due'])) > date("H:i"))){
                // Action
                $todo_action = $_POST['todo_action'];
                $todo_action = ucfirst($todo_action);
                $todo_action = trim($todo_action);
                $todo_action = mysqli_real_escape_string($con,$todo_action);

                $todo_acc_id = $_SESSION['acc_id'];

                $todo_date_due = $_POST['todo_date_due'];

                $todo_time_due = $_POST['todo_time_due'];

                //Insert to tbl_todo
                if(mysqli_query( $con,"INSERT into `tbl_todo` (todo_acc_id, todo_action, todo_date_due, todo_time_due) VALUES ('$todo_acc_id', '$todo_action', '$todo_date_due', '$todo_time_due')" )){
                    //Activity Log
                    mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'To Do Create', '".date('Y-m-d H:i:s')."')");
                    //Success Message
                }
            }
        } else if (isset($_GET['update'])) {
            if(($_POST['todo_date_due'] >= date("Y-m-d")) || ($_POST['todo_date_due'] == date("Y-m-d")  && date('H:i', strtotime($_POST['todo_time_due'])) > date("H:i"))){
                // Action
                $todo_action = strtolower($_POST['todo_action']);
                $todo_action = ucfirst($todo_action);
                $todo_action = trim($todo_action);
                $todo_action = mysqli_real_escape_string($con,$todo_action);

                $todo_id = $_POST['todo_id'];

                $todo_date_due = strtolower($_POST['todo_date_due']);

                $todo_time_due = strtolower($_POST['todo_time_due']);
                
                if(mysqli_query($con, "UPDATE tbl_todo SET todo_action = '".$todo_action."', todo_date_due = '".$todo_date_due."', todo_time_due = '".$todo_time_due."' WHERE todo_id = '".$todo_id."'")){
                    //Activity Log
                    mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'To Do Update', '".date('Y-m-d H:i:s')."')");
                    $response = 'success';
                }
            }
        } else if (isset($_POST['todo_delete'])) {
            $todo_id = $_POST['todo_id'];

            if(mySQLi_query($con, "DELETE FROM tbl_todo WHERE todo_id = '$todo_id'")){
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'To Do Delete', '".date('Y-m-d H:i:s')."')");
            }
        } else if(isset($_POST['id'])){
            $todo = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_todo WHERE todo_id = '".$_POST['id']."'"));
            if($todo['todo_status'] == 0){
                $new_status = 1;
            }else{
                $new_status = 0;
            }
            if(mysqli_query($con, "UPDATE tbl_todo SET todo_status = '".$new_status."' WHERE todo_id = '".$_POST['id']."'")){
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$_SESSION['acc_id']."', 'To Do Update', '".date('Y-m-d H:i:s')."')");
            }
        }

        //Close Connection
        mysqli_close($con);
    }
    echo $response;
?>