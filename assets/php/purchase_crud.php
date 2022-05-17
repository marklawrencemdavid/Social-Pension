<?php
    $response = 0;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include 'database.php';
        date_default_timezone_set('Asia/Manila');
        session_start();
        // Insert
        if($_GET['id'] == '1'){
            if($_POST['pot'] == ''){
                $pur_commodity = trim($_POST['pur_commodity']);
                $pur_commodity = mysqli_real_escape_string($con,$pur_commodity);

                $pur_quantity = mysqli_real_escape_string($con,$_POST['pur_quantity']);

                $pur_amount = mysqli_real_escape_string($con,$_POST['pur_amount']);

                $pur_establishment = trim($_POST['pur_establishment']);
                $pur_establishment = mysqli_real_escape_string($con,$pur_establishment);

                // Get image name
                $pur_proof = $_FILES["pur_proof"]["name"];
                // Divide Filename to the filename and extension
                $pur_proof_actual_name = pathinfo($pur_proof,PATHINFO_FILENAME);
                $pur_proof_original_name = $pur_proof_actual_name;
                $pur_proof_extension = pathinfo($pur_proof, PATHINFO_EXTENSION);
                // Check if file already exist
                $count = 1;
                while (file_exists('../../assets/img/pensioner_proof/' . $pur_proof)) {
                    // New filename with number
                    $pur_proof_actual_name = (string)$pur_proof_original_name."-".$count;
                    $pur_proof = $pur_proof_actual_name.".".$pur_proof_extension;
                    $count++;
                }
                // Upload image to server
                if(!move_uploaded_file($_FILES["pur_proof"]["tmp_name"], '../../assets/img/pensioner_proof/' . $pur_proof)){
                    $response = 'Failed to upload image';
                }else{
                    //Insert to tbl_purchases
                    if (mysqli_query($con, "INSERT into `tbl_purchases` (pur_commodity, acc_id, pur_quantity, pur_amount, pur_establishment, pur_proof, pur_date) VALUES ('$pur_commodity', '".$_SESSION['acc_id']."', '$pur_quantity', '$pur_amount', '$pur_establishment', '$pur_proof', '".date('Y-m-d H:i:s')."')")) {
                        // Data inserted id
                        $noti_data_id = mysqli_insert_id($con);
                        //Activity Log
                        mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_data_id."', 'Pensioner Purchase', '".date('Y-m-d H:i:s')."')");
                        //Insert to tbl_notifications
                        mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', 'Pensioner Purchase Pending', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')" );
                        $response = 1;
                    } else {
                        unlink("../../../assets/img/pensioner_proof/".$pur_proof);
                        //Error Message
                        $response = 'Failed to add new purchase';
                    }

                }
                //Close Connection
                mysqli_close($con);
            }
        }
        // Update | Delete
        else if($_GET['id'] == '2'){
            // Update
            if(isset($_POST['pur_update'])){
                $pur_commodity = trim($_POST['pur_commodity']);
                $pur_commodity = mysqli_real_escape_string($con,$pur_commodity);

                $pur_quantity = mysqli_real_escape_string($con,$_POST['pur_quantity']);

                $pur_amount = mysqli_real_escape_string($con,$_POST['pur_amount']);

                $pur_establishment = trim($_POST['pur_establishment']);
                $pur_establishment = mysqli_real_escape_string($con,$pur_establishment);

                if (mysqli_query($con, "UPDATE `tbl_purchases` SET pur_commodity = '".$pur_commodity."', pur_quantity = '".$pur_quantity."', pur_amount = '".$pur_amount."', pur_establishment = '".$pur_establishment."', pur_date = '".date('Y-m-d H:i:s')."' WHERE pur_id = '".$_POST['pur_id']."'")) {
                    // Data inserted id
                    $noti_data_id = $_POST['pur_id'];
                    //Activity Log
                    mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_data_id."', 'Pensioner Purchase Update', '".date('Y-m-d H:i:s')."')");
                    $response = 1;
                }else{
                    $response = mysqli_error($con);
                }

            }
            // Delete
            else if(isset($_POST['pur_delete'])){
                $fetch = mysqli_fetch_assoc(mysqli_query($con, "SELECT pur_proof FROM tbl_purchases WHERE pur_id = '".$_POST['pur_id']."'"));
                if(mysqli_query($con, "DELETE FROM tbl_purchases WHERE pur_id = '".$_POST['pur_id']."'")){
                    //Delete proof
                    unlink('../../assets/img/pensioner_proof/'.$fetch['pur_proof']);
                    $response = 2;
                }else{
                    $response = mysqli_error($con);
                }
            }
        }
    }
    echo $response;
?>