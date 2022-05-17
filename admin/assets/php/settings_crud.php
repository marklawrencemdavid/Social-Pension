<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        date_default_timezone_set('Asia/Manila');
        include '../../../assets/php/database.php';
        $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_pages` WHERE page_id=1 "));
        
        if (isset($_POST['update_settings'])) {
            // General
            $page_website_title = $_POST['page_website_title'];
            $page_website_title = trim($page_website_title);
            $page_website_title = mysqli_real_escape_string($con, $page_website_title);

            // Store filename in a variable
            $page_website_icon = $_FILES["page_website_icon_image"]["name"];
            // Divide Filename to the filename and extension
            $page_website_icon_actual_name = pathinfo($page_website_icon,PATHINFO_FILENAME);
            $page_website_icon_original_name = $page_website_icon_actual_name;
            $page_website_icon_extension = pathinfo($page_website_icon, PATHINFO_EXTENSION);
            // Check if file already exist
            $count = 1;
            while (file_exists("../../../assets/img/uploads/" . $page_website_icon)) {
                // New filename with number
                $page_website_icon_actual_name = (string)$page_website_icon_original_name."-".$count;
                $page_website_icon = $page_website_icon_actual_name.".".$page_website_icon_extension;
                $count++;
            }
            // Upload image to server
            if(!move_uploaded_file($_FILES["page_website_icon_image"]["tmp_name"], "../../../assets/img/uploads/" . $page_website_icon)){
                // if not uploaded, the default file will be selected
                if ($_POST['page_website_icon_label'] == '') {
                    $page_website_icon = 'no_image.png';
                } else {
                    $page_website_icon = $pages['page_website_icon'];
                }
            }else {
                // Delete Prev Picture if not set to default
                if ($pages['page_website_icon'] != 'no_image.png') {
                    unlink("../../../assets/img/uploads/".$pages['page_website_icon']);
                }
            }

            $page_email = $_POST['page_email'];
            $page_email = trim($page_email);
            $page_email = mysqli_real_escape_string($con, $page_email);

            $page_contactno = $_POST['page_contactno'];
            $page_contactno = trim($page_contactno);
            $page_contactno = mysqli_real_escape_string($con, $page_contactno);
            
            $page_address = $_POST['page_address'];
            $page_address = trim($page_address);
            $page_address = mysqli_real_escape_string($con, $page_address);

            $page_province = $_POST['page_province'];
            $page_province = trim($page_province);
            $page_province = mysqli_real_escape_string($con, $page_province);

            $page_city = $_POST['page_city'];
            $page_city = trim($page_city);
            $page_city = mysqli_real_escape_string($con, $page_city);

            $page_barangay = $_POST['page_barangay'];
            $page_barangay = trim($page_barangay);
            $page_barangay = mysqli_real_escape_string($con, $page_barangay);

            $page_facebook = $_POST['page_facebook'];
            $page_facebook = trim($page_facebook);
            $page_facebook = mysqli_real_escape_string($con, $page_facebook);
            
            $page_instagram = $_POST['page_instagram'];
            $page_instagram = trim($page_instagram);
            $page_instagram = mysqli_real_escape_string($con, $page_instagram);
            
            $page_twitter = $_POST['page_twitter'];
            $page_twitter = trim($page_twitter);
            $page_twitter = mysqli_real_escape_string($con, $page_twitter);
            
            $page_skype = $_POST['page_skype'];
            $page_skype = trim($page_skype);
            $page_skype = mysqli_real_escape_string($con, $page_skype);
            
            $page_avail_time_to = $_POST['page_avail_time_to'];
            $page_avail_time_from = $_POST['page_avail_time_from'];

            $page_sms_shortcode = $_POST['page_sms_shortcode'];
            $page_sms_shortcode = trim($page_sms_shortcode);
            $page_sms_shortcode = mysqli_real_escape_string($con, $page_sms_shortcode);
            
            $page_sms_appid = $_POST['page_sms_appid'];
            $page_sms_appid = trim($page_sms_appid);
            $page_sms_appid = mysqli_real_escape_string($con, $page_sms_appid);

            $page_sms_appsecret = $_POST['page_sms_appsecret'];
            $page_sms_appsecret = trim($page_sms_appsecret);
            $page_sms_appsecret = mysqli_real_escape_string($con, $page_sms_appsecret);

            $page_map = $_POST['page_map'];
            $page_map = trim($page_map);
            $page_map = mysqli_real_escape_string($con, $page_map);

            if(mysqli_query($con, "UPDATE tbl_pages 
                                SET page_website_title = '$page_website_title',page_website_icon = '$page_website_icon',page_avail_time_to = '$page_avail_time_to',
                                    page_avail_time_from = '$page_avail_time_from',page_email = '$page_email',page_contactno = '$page_contactno',page_address = '$page_address',page_province = '$page_province',page_city = '$page_city',page_barangay = '$page_barangay',
                                    page_facebook = '$page_facebook',page_instagram = '$page_instagram',page_twitter = '$page_twitter',page_skype = '$page_skype',
                                    page_sms_shortcode = '$page_sms_shortcode', page_sms_appid = '$page_sms_appid', page_sms_appsecret = '$page_sms_appsecret', page_map = '$page_map'
                                WHERE page_id = 1")){
                $noti_action = 'Page Settings';
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '1', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                //Insert to tbl_notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '1', '".date('Y-m-d H:i:s')."')");
            }
        }
        //Close Connection
        mysqli_close($con);
    }
    //Reload to Previous Page
    header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>
                                