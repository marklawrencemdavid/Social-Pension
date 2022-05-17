<?php
    $response = 0;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include 'database.php';
        date_default_timezone_set('Asia/Manila');
        $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_pages` WHERE page_id=1 "));

        $email = trim($_POST['email']);
        $email = mysqli_real_escape_string($con,$email);

        if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_subscribers WHERE subs_email = '".$email."'")) == 0){
            //Insert to tbl_subscribers
            if (mysqli_query($con, "INSERT into `tbl_subscribers` (subs_email, subs_date) VALUES ('".$email."', '".date('Y-m-d H:i:s')."')")) {
                // Data inserted id
                $noti_data_id = mysqli_insert_id($con);
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('Someone', '".$noti_data_id."', 'Subscriber', '".date('Y-m-d H:i:s')."')");
                //Insert to tbl_notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('Someone', 'Subscriber', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')" );
                
                ini_set( 'display_errors', 1 );
                error_reporting( E_ALL );
                
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
                $headers .= "From: ".$pages['page_website_title']."<".$pages['page_email'].">" . "\r\n";
                $subject = "Welcome to ".$pages['page_website_title'];

                $message = '
                <html>
                <head>
                </head>
                <div style="margin:0;padding:0;font-family: Arial, sans-serif;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#F5F8FA;"><tr><td align="center" style="padding:0;">
                        <table role="presentation" style="width:602px;text-align:left;background:#ffffff;">
                            <tr>
                                <td>
                                    <tr>
                                        <tr>
                                            <td style="padding:24px 24px 0 24px;">
                                                <a href="'.$_SERVER['HTTP_HOST'].'" style="float:left; margin:0.67em 0.67em 0.67em 0;">
                                                    <img src="'.$_SERVER['HTTP_HOST'].'/assets/img/uploads/'.$pages['page_website_icon'].'" style="width: 50px;height:50px;">
                                                </a>
                                                <h1 style="float:left;">'.$pages['page_website_title'].'</h1>
                                            </td>
                                        </tr>
                                    </tr>
                                    <tr>
                                        <tr>
                                            <td style="padding:0 24px 0 24px"><hr></td>
                                        </tr>
                                        <tr> 
                                            <td style="padding:0 24px 0 24px;"> 
                                                <img src="https://images.unsplash.com/photo-1580191947416-62d35a55e71d?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=871&q=80" style="width: 100%;height:602px;">
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 24px 0 24px">
                                                <p>Hi there,</p>
                                                <p>Thank you for following '.$pages['page_website_title'].' email newsletter.</p>
                                            </td>
                                        </tr>
                                    </tr>
                                    <tr>
                                        <td style="padding:0 24px 0 24px;" align="center">
                                            <a href="'.$_SERVER['HTTP_HOST'].'">Go to website</a>
                                        </td>
                                    </tr>
                                </td>
                            </tr>
                        </table>
                    </td></tr></table>
                </div>
                </html>';

                mail($email,$subject,$message, $headers);

                $response = 1;
            }
        }else{
            $response = 2;
        }
        
        //Close Connection
        mysqli_close($con);
    }
    echo $response;
?>