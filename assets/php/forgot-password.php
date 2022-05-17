<?php
    $response = 0;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_POST['pot'] == ''){
            include 'database.php';
            if(isset($_POST['username'])){
                $username = mysqli_real_escape_string($con,$_POST['username']);
                $query = mysqli_query($con, "SELECT acc_email FROM tbl_accounts WHERE acc_username = '".$username."'");
                if(mysqli_num_rows($query) == 1) {
                    $email = mysqli_fetch_assoc($query);
                    $response = $email['acc_email'];
                }
            }else if(isset($_POST['email'])){
                $query = mysqli_query($con,"SELECT acc_email,acc_role FROM tbl_accounts WHERE acc_username = '".$_POST['var_username']."'");
                if(mysqli_num_rows($query) == 1){
                    $email = mysqli_fetch_assoc($query);
                    $page = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_email,page_website_title,page_website_icon FROM tbl_pages WHERE page_id = 1"));

                    ini_set( 'display_errors', 1 );
                    error_reporting( E_ALL );
                    
                    $to = $email['acc_email'];
                    $subject = "Password reset request - ".$page['page_website_title'];
                    $code = substr( str_shuffle( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" ), 0, 8 );
                    if($email['acc_role'] == 'Pensioner'){$redirectto=$_SERVER['HTTP_HOST'].'/profile';}else{$redirectto=$_SERVER['HTTP_HOST'].'/admin/accounts/profile';}
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
                                                        <img src="'.$_SERVER['HTTP_HOST'].'/assets/img/uploads/'.$page['page_website_icon'].'" style="width: 50px;height:50px;">
                                                    </a>
                                                    <h1 style="float:left;">'.$page['page_website_title'].'</h1>
                                                </td>
                                            </tr>
                                        </tr>
                                        <tr>
                                            <tr>
                                                <td style="padding:0 24px 0 24px"><hr></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0 24px 0 24px"><h2>Reset your password?</h2></td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0 24px 0 24px">
                                                    <p>We received a request to reset your Account password. Enter the password reset code below to continue. If you didn\'t make this request, ignore this email. </p>
                                                </td>
                                            </tr>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 24px 0 24px;"> 
                                                <h3>'.$code.'</h3>
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 24px 0 24px;">
                                                <h3>Didn\'t make this request?</h3>
                                                <p>You can change your <a href="'.$redirectto.'">account password</a> on your profile.</p>
                                            </td>
                                        </tr>
                                    </td>
                                </tr>
                            </table>
                        </td></tr></table>
                    </div>
                    </html>';
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
                    $headers .= "From: ".$page['page_website_title']."<".$page['page_email'].">" . "\r\n";
                    
                    if(mysqli_query($con, "UPDATE tbl_accounts SET acc_resetpasscode = '".$code."' WHERE acc_username = '".$_POST['var_username']."'")){
                        if(mail($to,$subject,$message, $headers)) {
                            $response = 1;
                        }
                    }
                }
            }else if(isset($_POST['code'])){
                $query = mysqli_fetch_assoc(mysqli_query($con,"SELECT acc_resetpasscode FROM tbl_accounts WHERE acc_username = '".$_POST['var_username']."'"));
                
                if($_POST['code'] == $query['acc_resetpasscode']){
                    $response = 1;
                }
            }else if(isset($_POST['var_username_reset'])){
                $newpass = $_POST['newpassword'];
                $newpass = trim($newpass);
                $newpass = mysqli_real_escape_string($con, $newpass);
                $repass = $_POST['renewpassword'];
                $repass = trim($repass);
                $repass = mysqli_real_escape_string($con, $repass);
                if(strlen($repass) > 7 && strlen($newpass) > 7){
                    if($newpass == $repass){
                        if(mysqli_query($con,"UPDATE tbl_accounts SET acc_password = '".md5($newpass)."' WHERE acc_username = '".$_POST['var_username_reset']."'")){
                            $response = 1;
                        }else{
                            $response = mysqli_error($con);
                        }
                    }else{
                        $response = 3;
                    }
                }else{
                    $response = 2;
                }
            }else if(isset($_POST['remove_code'])){
                if(mysqli_query($con, "UPDATE tbl_accounts SET acc_resetpasscode = '' WHERE acc_username = '".$_POST['remove_code']."'")){
                    $response = 1;
                }
            }
            //Close Connection
            mysqli_close($con);
        }
    }
    echo $response;
?>