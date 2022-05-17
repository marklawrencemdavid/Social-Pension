<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include '../../../assets/php/database.php';

        if(isset($_POST['excpected_date_all'])){
            // $fetch = mySQLi_fetch_assoc(mysqli_query($con, 'SELECT page_pension_status FROM tbl_pages WHERE page_id = 1'));
            // // Explode pension status
            // $explode = explode('|', $fetch['page_pension_status']);

            if(date('Y-m-d', strtotime($_POST['excpected_date_all'])) > date('Y-m-d')){
                // if(date('Y-m-d', strtotime($_POST['confirmed_date'])) > date('Y-m-d') && 
                //     date('Y-m-d', strtotime($_POST['confirmed_date'])) > date('Y-m-d', strtotime($_POST['excpected_date_all']))){
                if(date('Y-m-d', strtotime($_POST['confirmed_date'])) > date('Y-m-d')){

                    if($_POST['recieving_mode']=='Other'){ $recieving_mode=$_POST['recieving_mode_other'];}
                    else{ $recieving_mode=$_POST['recieving_mode'];}
                    $excpected_date = $_POST['excpected_date_all'];
                    $confirmed_date = $_POST['confirmed_date'];
                    $value = $_POST['schedule_value'];
                    $message = trim($_POST['schedule_message']);
                    $page_pension_status = $excpected_date.'|'.$confirmed_date.'|'.$recieving_mode.'|';
                    
                    if( $value > 499 ){
                        if($message != ''){
                            mySQLi_query($con, "UPDATE tbl_pages 
                                    SET page_pension_value = '$value', 
                                    page_pension_date = '$confirmed_date', 
                                    page_pension_message = '$message',
                                    page_pension_status = '".$page_pension_status."'
                                    WHERE page_id = 1"
                            );  
                        }
                    }
                }
            }
        }else if(isset($_POST['excpected_date'])){
            if(date('Y-m-d', strtotime($_POST['excpected_date'])) > date('Y-m-d')){
                // Set new pension status
                $page_pension_status = $_POST['excpected_date'].'|||';
                // Update pension status
                mySQLi_query($con, "UPDATE tbl_pages SET page_pension_status = '".$page_pension_status."' WHERE page_id = '1'");
            }
        }else if(isset($_POST['confirmed_date'])){
            $fetch = mySQLi_fetch_assoc(mysqli_query($con, 'SELECT page_pension_status FROM tbl_pages WHERE page_id = 1'));
            // Explode pension status
            $explode = explode('|', $fetch['page_pension_status']);
            // if(date('Y-m-d', strtotime($_POST['confirmed_date'])) > date('Y-m-d') && 
            //     date('Y-m-d', strtotime($_POST['confirmed_date'])) > date('Y-m-d', strtotime($explode[0]))){
            if(date('Y-m-d', strtotime($_POST['confirmed_date'])) > date('Y-m-d')){
                // Set new pension status
                $page_pension_status = $explode[0].'|'.$_POST['confirmed_date'].'||';
                // Set query
                if(isset($_POST['confirmed_date_radio'])){
                    $value = $_POST['schedule_value'];
                    $date = $_POST['confirmed_date'];
                    $message = trim($_POST['schedule_message']);
                    
                    if( $value > 499 ){
                        if( date('Y-m-d', strtotime($date)) > date('Y-m-d') ){
                            if($message != ''){
                                $query = "UPDATE tbl_pages 
                                    SET page_pension_value = '$value', 
                                    page_pension_date = '$date', 
                                    page_pension_message = '$message',
                                    page_pension_status = '".$page_pension_status."'
                                    WHERE page_id = 1";
                            }
                        }
                    }
                }else{
                    $query = "UPDATE tbl_pages SET page_pension_status = '".$page_pension_status."' WHERE page_id = '1'";
                }
                // Execute query
                if(isset($query)){
                    mySQLi_query($con, $query);
                }
            }

        }else if(isset($_POST['recieving_mode'])){
            $fetch = mySQLi_fetch_assoc(mysqli_query($con, 'SELECT page_pension_status FROM tbl_pages WHERE page_id = 1'));
            
            // Explode pension status
            $explode = explode('|', $fetch['page_pension_status']);
            if($_POST['recieving_mode'] == 'Other'){
                // Set new pension status
                $page_pension_status = $explode[0].'|'.$explode[1].'|'.$_POST['recieving_mode_other'].'|';
            }else{
                // Set new pension status
                $page_pension_status = $explode[0].'|'.$explode[1].'|'.$_POST['recieving_mode'].'|';
            }
            $value = $_POST['schedule_value'];
            $message = trim($_POST['schedule_message']);
            
            if( $value > 499 ){
                if($message != ''){
                    mySQLi_query($con, "UPDATE tbl_pages 
                            SET page_pension_value = '$value', 
                            page_pension_message = '$message',
                            page_pension_status = '".$page_pension_status."'
                            WHERE page_id = 1"
                    );  
                }
            }
        }else if(isset($_POST['reset_pension_status'])){
            if(mySQLi_query($con, "UPDATE tbl_pages SET page_pension_value='', page_pension_date='', page_pension_message='', page_pension_status='|||' WHERE page_id=1" )){
                echo '1';
            }else{
                echo '2';
            }
        }

        if(!isset($_POST['reset_pension_status'])){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
?>