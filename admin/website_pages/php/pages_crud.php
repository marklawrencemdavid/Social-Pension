<?php
    $response = '0';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        date_default_timezone_set('Asia/Manila');
        include '../../../assets/php/database.php';
        $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_pages` WHERE page_id=1 "));
        
        if (isset($_POST['update_general'])) {
            //About 
            $page_about_title = $_POST['page_about_title'];
            $page_about_title = trim($page_about_title);
            $page_about_title = mysqli_real_escape_string($con, $page_about_title);

            // Get image name
            $page_about_image = $_FILES["page_about_image"]["name"];
            // Divide Filename to the filename and extension
            $page_about_image_actual_name = pathinfo($page_about_image,PATHINFO_FILENAME);
            $page_about_image_original_name = $page_about_image_actual_name;
            $page_about_image_extension = pathinfo($page_about_image, PATHINFO_EXTENSION);
            // Check if file already exist
            $count = 1;
            while (file_exists("../../../assets/img/uploads/" . $page_about_image)) {
                // New filename with number
                $page_about_image_actual_name = (string)$page_about_image_original_name."-".$count;
                $page_about_image = $page_about_image_actual_name.".".$page_about_image_extension;
                $count++;
            }
            // Upload image to server
            if(!move_uploaded_file($_FILES["page_about_image"]["tmp_name"], "../../../assets/img/uploads/" . $page_about_image)){
                // if not uploaded, the default file will be selected
                if ($_POST['page_about_image_label'] == '') {
                    $page_about_image = 'no_image.png';
                } else {
                    $page_about_image = $pages['page_about_image'];
                }
            }else{
                // Delete Prev Picture if not set to default
                if ($pages['page_about_image'] != 'no_image.png') {
                    unlink("../../../assets/img/uploads/".$pages['page_about_image']);
                }
            }
            
            $page_about_description = $_POST['page_about_description'];
            $page_about_description = trim($page_about_description);
            $page_about_description = mysqli_real_escape_string($con, $page_about_description);
            
            $page_about_par_title = $_POST['page_about_par_title'];
            $page_about_par_title = trim($page_about_par_title);
            $page_about_par_title = mysqli_real_escape_string($con, $page_about_par_title);
            
            $page_about_para_text = $_POST['page_about_para_text'];
            $page_about_para_text = trim($page_about_para_text);
            $page_about_para_text = mysqli_real_escape_string($con, $page_about_para_text);
            
            // Header
            // Get image name
            $page_header_back_image = $_FILES["page_header_back_image"]["name"];
            // Divide Filename to the filename and extension
            $page_header_back_image_actual_name = pathinfo($page_header_back_image,PATHINFO_FILENAME);
            $page_header_back_image_original_name = $page_header_back_image_actual_name;
            $page_header_back_image_extension = pathinfo($page_header_back_image, PATHINFO_EXTENSION);
            // Check if file already exist
            $count = 1;
            while (file_exists("../../../assets/img/uploads/" . $page_header_back_image)) {
                // New filename with number
                $page_header_back_image_actual_name = (string)$page_header_back_image_original_name."-".$count;
                $page_header_back_image = $page_header_back_image_actual_name.".".$page_header_back_image_extension;
                $count++;
            }
            // Upload image to server
            if(!move_uploaded_file($_FILES["page_header_back_image"]["tmp_name"], "../../../assets/img/uploads/" . $page_header_back_image)){
                // if not uploaded, the default file will be selected
                if ($_POST['page_header_back_image_label'] == '') {
                    $page_header_back_image = 'no_image.png';
                } else {
                    $page_header_back_image = $pages['page_header_back_image'];
                }
            }
            
            $page_header_info_title = $_POST['page_header_info_title'];
            $page_header_info_title = trim($page_header_info_title);
            $page_header_info_title = mysqli_real_escape_string($con, $page_header_info_title);
            
            $page_header_info_text = $_POST['page_header_info_text'];
            $page_header_info_text = trim($page_header_info_text);
            $page_header_info_text = mysqli_real_escape_string($con, $page_header_info_text);
            
            // Footer 
            $page_footer_desc = $_POST['page_footer_desc'];
            $page_footer_desc = trim($page_footer_desc);
            $page_footer_desc = mysqli_real_escape_string($con, $page_footer_desc);
            
            $page_footer_news_title = $_POST['page_footer_news_title'];
            $page_footer_news_title = trim($page_footer_news_title);
            $page_footer_news_title = mysqli_real_escape_string($con, $page_footer_news_title);
            
            $page_footer_news_text = $_POST['page_footer_news_text'];
            $page_footer_news_text = trim($page_footer_news_text);
            $page_footer_news_text = mysqli_real_escape_string($con, $page_footer_news_text);

            $page_demo_website = $_POST['page_demo_website'];
            $page_demo_website = trim($page_demo_website);
            $page_demo_website = mysqli_real_escape_string($con, $page_demo_website);

            $page_demo_dashboard = $_POST['page_demo_dashboard'];
            $page_demo_dashboard = trim($page_demo_dashboard);
            $page_demo_dashboard = mysqli_real_escape_string($con, $page_demo_dashboard);

            if(mysqli_query($con, "UPDATE tbl_pages 
                                SET page_about_image = '$page_about_image',page_about_title = '$page_about_title',page_about_description = '$page_about_description',page_about_par_title = '$page_about_par_title',page_about_para_text = '$page_about_para_text',
                                    page_header_back_image = '$page_header_back_image',page_header_info_title = '$page_header_info_title',page_header_info_text = '$page_header_info_text',page_footer_desc = '$page_footer_desc',
                                    page_footer_news_title = '$page_footer_news_title',page_footer_news_text = '$page_footer_news_text',page_demo_website = '$page_demo_website',page_demo_dashboard = '$page_demo_dashboard'
                                WHERE page_id = 1")){
                $noti_action = 'Page General';
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '1', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                //Insert to tbl_notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '1', '".date('Y-m-d H:i:s')."')");
            }
        } else if (isset($_POST['update_missionvision'])) {
            // Mission
            $page_mission = $_POST['page_mission'];
            $page_mission = trim($page_mission);
            $page_mission = mysqli_real_escape_string($con, $page_mission);

            // Mission Image
            $page_mission_image = $_FILES["page_mission_image"]["name"];
            // Divide Filename to the filename and extension
            $page_mission_image_actual_name = pathinfo($page_mission_image,PATHINFO_FILENAME);
            $page_mission_image_original_name = $page_mission_image_actual_name;
            $page_mission_image_extension = pathinfo($page_mission_image, PATHINFO_EXTENSION);
            // Check if file already exist
            $count = 1;
            while (file_exists("../../../assets/img/uploads/" . $page_mission_image)) {
                // New filename with number
                $page_mission_image_actual_name = (string)$page_mission_image_original_name."-".$count;
                $page_mission_image = $page_mission_image_actual_name.".".$page_mission_image_extension;
                $count++;
            }
            // Upload image to server
            if(!move_uploaded_file($_FILES["page_mission_image"]["tmp_name"], "../../../assets/img/uploads/" . $page_mission_image)){
                // if not uploaded, the default file will be selected
                if ($_POST['page_mission_label'] == '') {
                    $page_mission_image = 'no_image.png';
                } else {
                    $page_mission_image = $pages['page_mission_image'];
                }
            }else{
                // Delete Prev Picture if not set to default
                if ($pages['page_mission_image'] != 'no_image.png') {
                    unlink("../../../assets/img/uploads/".$pages['page_mission_image']);
                }
            }

            // Vision
            $page_vision = $_POST['page_vision'];
            $page_vision = trim($page_vision);
            $page_vision = mysqli_real_escape_string($con, $page_vision);

            // Vision Image
            $page_vision_image = $_FILES["page_vision_image"]["name"];
            // Divide Filename to the filename and extension
            $page_vision_image_actual_name = pathinfo($page_vision_image,PATHINFO_FILENAME);
            $page_vision_image_original_name = $page_vision_image_actual_name;
            $page_vision_image_extension = pathinfo($page_vision_image, PATHINFO_EXTENSION);
            // Check if file already exist
            $count = 1;
            while (file_exists("../../../assets/img/uploads/" . $page_vision_image)) {
                // New filename with number
                $page_vision_image_actual_name = (string)$page_vision_image_original_name."-".$count;
                $page_vision_image = $page_vision_image_actual_name.".".$page_vision_image_extension;
                $count++;
            }
            // Upload image to server
            if(!move_uploaded_file($_FILES["page_vision_image"]["tmp_name"], "../../../assets/img/uploads/" . $page_vision_image)){
                // if not uploaded, the default file will be selected
                if ($_POST['page_vision_label'] == '') {
                    $page_vision_image = 'no_image.png';
                } else {
                    $page_vision_image = $pages['page_vision_image'];
                }
            }else{
                // Delete Prev Picture if not set to default
                if ($pages['page_vision_image'] != 'no_image.png') {
                    unlink("../../../assets/img/uploads/".$pages['page_vision_image']);
                }
            }

            if(mysqli_query($con, "UPDATE tbl_pages 
                                SET page_mission = '$page_mission', page_mission_image = '$page_mission_image', page_vision = '$page_vision', page_vision_image = '$page_vision_image'
                                WHERE page_id = 1")){
                $noti_action = 'Page Mission Vision';
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '1', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                //Insert to tbl_notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '1', '".date('Y-m-d H:i:s')."')");
            }
        } else if (isset($_POST['update_officials'])) {
            // Vision Image
            $page_officials_org_chart = $_FILES["page_officials_org_chart"]["name"];
            // Divide Filename to the filename and extension
            $page_officials_org_chart_actual_name = pathinfo($page_officials_org_chart,PATHINFO_FILENAME);
            $page_officials_org_chart_original_name = $page_officials_org_chart_actual_name;
            $page_officials_org_chart_extension = pathinfo($page_officials_org_chart, PATHINFO_EXTENSION);
            // Check if file already exist
            $count = 1;
            while (file_exists("../../../assets/img/uploads/" . $page_officials_org_chart)) {
                // New filename with number
                $page_officials_org_chart_actual_name = (string)$page_officials_org_chart_original_name."-".$count;
                $page_officials_org_chart = $page_officials_org_chart_actual_name.".".$page_officials_org_chart_extension;
                $count++;
            }
            // Upload image to server
            if(!move_uploaded_file($_FILES["page_officials_org_chart"]["tmp_name"], "../../../assets/img/uploads/" . $page_officials_org_chart)){
                // if not uploaded, the default file will be selected
                if ($_POST['page_officials_org_chart_label'] == '') {
                    $page_officials_org_chart = 'no_image.png';
                } else {
                    $page_officials_org_chart = $pages['page_officials_org_chart'];
                }
            }else{
                // Delete Prev Picture if not set to default
                if ($pages['page_officials_org_chart'] != 'no_image.png') {
                    unlink("../../../assets/img/uploads/".$pages['page_officials_org_chart']);
                }
            }

            if(mysqli_query($con, "UPDATE tbl_pages 
                                SET page_officials_org_chart = '$page_officials_org_chart'
                                WHERE page_id = 1")){
                $noti_action = 'Page Officials';
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '1', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                //Insert to tbl_notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '1', '".date('Y-m-d H:i:s')."')");
            }
        } else if (isset($_POST['rep_content'])) {
            if($_POST['rep_content'] != '<p><br></p>'){
                // Report Title
                $rep_title = $_POST['rep_title'];
                $rep_title = trim($rep_title);
                $rep_title = mysqli_real_escape_string($con, $rep_title);

                // Report Notes
                $rep_notes = $_POST['rep_notes'];
                $rep_notes = trim($rep_notes);
                $rep_notes = mysqli_real_escape_string($con, $rep_notes);

                // Report Content
                $rep_content = $_POST["rep_content"];
                // $rep_content = trim($rep_content);
                $rep_content = mysqli_real_escape_string($con, $rep_content);

                // Report Id
                if(isset($_POST['rep_id'])){
                    $rep_id = $_POST['rep_id'];
                }

                // Insert
                if (isset($_POST['create_report_publish'])) {
                    $rep_status = 'Published';
                    $noti_action = 'Page Report Insert Published';
                    $query = "INSERT into tbl_reports (rep_title, rep_content, rep_notes, rep_status) VALUES ('".$rep_title."', '".$rep_content."', '".$rep_notes."', '".$rep_status."')";
                }else if (isset($_POST['create_report_draft'])) {
                    $rep_status = 'Draft';
                    $noti_action = 'Page Report Insert Draft';
                    $query = "INSERT into tbl_reports (rep_title, rep_content, rep_notes, rep_status) VALUES ('".$rep_title."', '".$rep_content."', '".$rep_notes."', '".$rep_status."')";
                }
                // Update
                else if (isset($_POST['update_report_sd'])) {
                    $rep_status = 'Draft';
                    $noti_action = 'Page Report Update Draft';
                    $query = "UPDATE tbl_reports 
                            SET rep_title = '".$rep_title."', rep_content = '".$rep_content."', rep_notes = '".$rep_notes."', rep_status = '".$rep_status."'
                            WHERE rep_id = '".$rep_id."'";
                }else if (isset($_POST['update_report_sp'])) {
                    $rep_status = 'Published';
                    $noti_action = 'Page Report Update Published';
                    $query = "UPDATE tbl_reports 
                            SET rep_title = '".$rep_title."', rep_content = '".$rep_content."', rep_notes = '".$rep_notes."', rep_status = '".$rep_status."'
                            WHERE rep_id = '".$rep_id."'";
                }else if (isset($_POST['update_report_t'])) {
                    $rep_status = 'Trashed';
                    $noti_action = 'Page Report Update Trashed';
                    $query = "UPDATE tbl_reports 
                            SET rep_title = '".$rep_title."', rep_content = '".$rep_content."', rep_notes = '".$rep_notes."', rep_status = '".$rep_status."'
                            WHERE rep_id = '".$rep_id."'";
                }
                //Delete
                else if (isset($_POST['update_report_d'])) {
                    $noti_action = 'Page Report Deleted';
                    $query = "DELETE FROM tbl_reports WHERE rep_id = '".$rep_id."'";
                }

                // Execute query
                if(mysqli_query($con, $query)){
                    if($noti_action == 'Page Report Insert Published' || $noti_action == 'Page Report Insert Draft'){
                        $noti_data_id = mysqli_insert_id($con);
                    }else{
                        $noti_data_id = $rep_id;
                    }
                    //Activity Log
                    mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                    //Insert to tbl_notifications
                    mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                
                    //Send email
                    if(isset($_POST['send_email'])){
                        ini_set( 'display_errors', 1 );
                        error_reporting( E_ALL );
                        
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
                        $headers .= "From: ".$pages['page_website_title']."<".$pages['page_email'].">" . "\r\n";
                        $subject = $pages['page_website_title']." - New Report";

                        if(strlen($rep_content) > 1000){
                            $rep_content = substr(substr($rep_content." ",0,1000),0,strrpos($rep_content,' '))."...";
                        }

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
                                                <td style="padding:0 24px 0 24px"><h1 align="center">'.$rep_title.'</h1></td>
                                            </tr>
                                            <tr>
                                                <tr>
                                                    <td style="padding:0 24px 0 24px"><hr></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:0 24px 0 24px">
                                                        <p>'.$rep_content.'</p>
                                                    </td>
                                                </tr>
                                            </tr>
                                            <tr>
                                                <td style="padding:0 24px 0 24px;" align="center">
                                                    <a href="'.$_SERVER['HTTP_HOST'].'/transparency/accomplishment-report'.'">View Reports</a>
                                                </td>
                                            </tr>
                                        </td>
                                    </tr>
                                </table>
                            </td></tr></table>
                        </div>
                        </html>';

                        $query_subs = mysqli_query($con, "SELECT subs_email FROM tbl_subscribers");
                        if(mysqli_num_rows($query_subs) > 0){
                            while($email = mysqli_fetch_assoc($query_subs)){
                                if(!mail($email['subs_email'],$subject,$message, $headers)){
                                    if($response == '0'){
                                        $response = '';
                                    }
                                    $response .= error_get_last()['message'] . '\r\n';
                                }
                            }
                        }
                    }
                    
                    if($response == '0'){
                        $response = '1';
                    }
                }else{
                    $response = mysqli_error($con);
                }
            }else{
                $response = 'Content should not be blank';
            }
        } else if (isset($_POST['update_form_avail'])) {
            $page_form_avail_day_from = $_POST['page_form_avail_day_from'];
            $page_form_avail_day_to = $_POST['page_form_avail_day_to'];
            $page_form_avail_time_from = $_POST['page_form_avail_time_from'];
            $page_form_avail_time_to = $_POST['page_form_avail_time_to'];
            
            if(mysqli_query($con, "UPDATE tbl_pages SET page_form_avail_day_from = '".$page_form_avail_day_from."', page_form_avail_day_to = '".$page_form_avail_day_to."', page_form_avail_time_from = '".$page_form_avail_time_from."', page_form_avail_time_to = '".$page_form_avail_time_to."' WHERE page_id = 1")){
                $noti_action = 'Page Register';
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '1', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                //Insert to tbl_notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '1', '".date('Y-m-d H:i:s')."')");
            }
        } else if (isset($_POST['port_title'])){
            // Activity Title
            $port_title = $_POST['port_title'];
            $port_title = trim($port_title);
            $port_title = mysqli_real_escape_string($con, $port_title);

            // Activity Notes
            $port_notes = $_POST['port_notes'];
            $port_notes = trim($port_notes);
            $port_notes = mysqli_real_escape_string($con, $port_notes);

            // Report Id
            if(isset($_POST['port_id'])){
                $port_id = $_POST['port_id'];
            }

            // Insert
            $port_images = ''; 
            if (isset($_POST['port_save_p']) || isset($_POST['port_save_d'])) {
                $fileNames = array_filter($_FILES['port_image']['name']);
                foreach($_FILES['port_image']['name'] as $key=>$val){ 
                    // File upload path 
                    $fileName = basename($_FILES['port_image']['name'][$key]); 
                    // Divide Filename to the filename and extension
                    $fileName_actual_name = pathinfo($fileName,PATHINFO_FILENAME);
                    $fileName_original_name = $fileName_actual_name;
                    $fileName_extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    // Check if file already exist
                    $count = 1;
                    while (file_exists("../../../assets/img/portfolio/" . $fileName)) {
                        // New filename with number
                        $fileName_actual_name = (string)$fileName_original_name."-".$count;
                        $fileName = $fileName_actual_name.".".$fileName_extension;
                        $count++;
                    }

                    // Upload image to server 
                    if(move_uploaded_file($_FILES["port_image"]["tmp_name"][$key], "../../../assets/img/portfolio/" . $fileName)){ 
                        if($port_images == ''){
                            $port_images .= $fileName;
                        }else{
                            $port_images .= '|'.$fileName;
                        }
                    }
                }
            }
            // Update
            //Delete
            else if(isset($_POST['port_update_de'])){
                $row = mysqli_fetch_array(mysqli_query($con, " SELECT * FROM tbl_portfolios WHERE port_id = '".$port_id."' "));
                $image_explode = explode('|',$row['port_image']);
                foreach ($image_explode as $image) {
                    unlink("../../../assets/img/portfolio/".$image);
                }
            }

            // Insert
            if (isset($_POST['port_save_p'])) {
                $noti_action = 'Page Portfolio Insert Published';
                $query = "INSERT into tbl_portfolios (port_title, port_notes, port_status, port_image, port_date) VALUES ('".$port_title."', '".$port_notes."', 'Published', '".$port_images."', '".date('Y-m-d H:i:s')."')";
            }else if (isset($_POST['port_save_d'])) {
                $noti_action = 'Page Portfolio Insert Draft';
                $query = "INSERT into tbl_portfolios (port_title, port_notes, port_status, port_image, port_date) VALUES ('".$port_title."', '".$port_notes."', 'Draft', '".$port_images."', '".date('Y-m-d H:i:s')."')";
            }
            // Update
            else if (isset($_POST['port_update_d'])) {
                $rep_status = 'Draft';
                $noti_action = 'Page Portfolio Update Draft';
                $query = "UPDATE tbl_portfolios 
                        SET port_title = '".$port_title."', port_notes = '".$port_notes."', port_status = 'Draft'
                        WHERE port_id = '".$port_id."'";
            }else if (isset($_POST['port_update_p'])) {
                $rep_status = 'Published';
                $noti_action = 'Page Portfolio Update Published';
                $query = "UPDATE tbl_portfolios 
                        SET port_title = '".$port_title."', port_notes = '".$port_notes."', port_status = 'Published'
                        WHERE port_id = '".$port_id."'";
            }else if (isset($_POST['port_update_t'])) {
                $rep_status = 'Trashed';
                $noti_action = 'Page Portfolio Update Trashed';
                $query = "UPDATE tbl_portfolios 
                        SET port_title = '".$port_title."', port_notes = '".$port_notes."', port_status = 'Trashed'
                        WHERE port_id = '".$port_id."'";
            }
            //Delete
            else if (isset($_POST['port_update_de'])) {
                $noti_action = 'Page Portfolio Deleted';
                $query = "DELETE FROM tbl_portfolios WHERE port_id = '".$port_id."'";
            }

            // Execute query
            if(mysqli_query($con, $query)){
                if($noti_action == 'Page Portfolio Insert Published' || $noti_action == 'Page Portfolio Insert Draft'){
                    $noti_data_id = mysqli_insert_id($con);
                }else{
                    $noti_data_id = $port_id;
                }
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                //Insert to tbl_notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                
                //Send email
                if(isset($_POST['send_email'])){
                    ini_set( 'display_errors', 1 );
                    error_reporting( E_ALL );
                    
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
                    $headers .= "From: ".$pages['page_website_title']."<".$pages['page_email'].">" . "\r\n";
                    $subject = $pages['page_website_title']." - New Activity";
                    $image = explode('|',$port_images);
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
                                            <td style="padding:0 24px 0 24px"><h1 align="center">'.$port_title.'</h1></td>
                                        </tr>
                                        <tr>
                                            <tr>
                                                <td style="padding:0 24px 0 24px"><hr></td>
                                            </tr>
                                            <tr> 
                                                <td style="padding:0 24px 0 24px;"> 
                                                    <img src="'.$_SERVER['HTTP_HOST'].'/assets/img/portfolio/'.$image[0].'" style="width: 100%;height:602px;">
                                                    <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:0 24px 0 24px">
                                                    <p>'.$port_notes.'</p>
                                                </td>
                                            </tr>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 24px 0 24px;" align="center">
                                                <a href="'.$_SERVER['HTTP_HOST'].'/transparency/portfolio'.'">View All Activity</a>
                                            </td>
                                        </tr>
                                    </td>
                                </tr>
                            </table>
                        </td></tr></table>
                    </div>
                    </html>';

                    $query_subs = mysqli_query($con, "SELECT subs_email FROM tbl_subscribers");
                    if(mysqli_num_rows($query_subs) > 0){
                        while($email = mysqli_fetch_assoc($query_subs)){
                            if(!mail($email['subs_email'],$subject,$message, $headers)){
                                if($response == '0'){
                                    $response = '';
                                }
                                $response .= error_get_last()['message'] . '\r\n';
                            }
                        }
                    }
                }
                
                if($response == '0'){
                    $response = '1';
                }
            }else{
                if($noti_action == 'Page Portfolio Insert Published' || $noti_action == 'Page Portfolio Insert Draft'){
                    $image_explode = explode('|',$port_images);
                    foreach ($image_explode as $image) {
                        if (file_exists("../../../assets/img/portfolio/" . $image)) {
                            unlink("../../../assets/img/portfolio/".$image);
                        }
                    }
                }
                $response = mysqli_error($con);
            }
        } else if (isset($_POST['faq_question'])){
            // faq_question
            $faq_question = $_POST['faq_question'];
            $faq_question = trim($faq_question);
            $faq_question = mysqli_real_escape_string($con, $faq_question);

            // faq_answer
            $faq_answer = $_POST['faq_answer'];
            $faq_answer = trim($faq_answer);
            $faq_answer = mysqli_real_escape_string($con, $faq_answer);

            // Report Id
            $faq_id = $_POST['faq_id'];

            // Insert
            if (isset($_POST['faq_save_p'])) {
                $noti_action = 'Page FAQ Insert Published';
                $query = "INSERT into tbl_faqs (faq_question, faq_answer, faq_status) VALUES ('".$faq_question."', '".$faq_answer."', 'Published')";
            }else if (isset($_POST['faq_save_d'])) {
                $noti_action = 'Page FAQ Insert Draft';
                $query = "INSERT into tbl_faqs (faq_question, faq_answer, faq_status) VALUES ('".$faq_question."', '".$faq_answer."', 'Draft')";
            }
            // Update
            else if (isset($_POST['faq_update_d'])) {
                $rep_status = 'Draft';
                $noti_action = 'Page FAQ Update Draft';
                $query = "UPDATE tbl_faqs 
                        SET faq_question = '".$faq_question."', faq_answer = '".$faq_answer."', faq_status = 'Draft'
                        WHERE faq_id = '".$faq_id."'";
            }else if (isset($_POST['faq_update_p'])) {
                $rep_status = 'Published';
                $noti_action = 'Page FAQ Update Published';
                $query = "UPDATE tbl_faqs 
                        SET faq_question = '".$faq_question."', faq_answer = '".$faq_answer."', faq_status = 'Published'
                        WHERE faq_id = '".$faq_id."'";
            }else if (isset($_POST['faq_update_t'])) {
                $rep_status = 'Trashed';
                $noti_action = 'Page FAQ Update Trashed';
                $query = "UPDATE tbl_faqs 
                        SET faq_question = '".$faq_question."', faq_answer = '".$faq_answer."', faq_status = 'Trashed'
                        WHERE faq_id = '".$faq_id."'";
            }
            //Delete
            else if (isset($_POST['faq_update_de'])) {
                $noti_action = 'Page FAQ Deleted';
                $query = "DELETE FROM tbl_faqs WHERE faq_id = '".$faq_id."'";
            }

            // Execute query
            if(mysqli_query($con, $query)){
                if($noti_action == 'Page FAQ Insert Published' || $noti_action == 'Page FAQ Insert Draft'){
                    $noti_data_id = mysqli_insert_id($con);
                }else{
                    $noti_data_id = $faq_id;
                }
                //Activity Log
                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                //Insert to tbl_notifications
                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
            }
        }
        //Close Connection
        mysqli_close($con);
    }
    echo $response;
?>