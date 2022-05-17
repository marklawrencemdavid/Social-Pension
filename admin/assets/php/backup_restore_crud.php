<?php 
    $response = 0;
    if(isset($_GET['id'])){
        if (session_status() == PHP_SESSION_NONE) {session_start();}
        if(isset($_SESSION['acc_id'])){
            include '../../../assets/php/database.php';
            date_default_timezone_set('Asia/Manila');
            $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
            if($acc['acc_role'] == 'Super Admin'){
                $page = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') );

                // Backup
                if ($_GET['id'] == '1'){
                    // Make sure the script can handle large folders/files
                    ini_set('max_execution_time', 600);
                    ini_set('memory_limit', '1024M');

                    // Check file name
                    $website_name = $page['page_website_title'];
                    $folder_name = $website_name."_".time();
                    while (file_exists("../../../backup/" . $folder_name)) {
                        // New filename with time
                        $name_actual_name = (string)$website_name."_".time();
                        $folder_name = $name_actual_name;
                    }
                    // Create folder
                    if(mkdir('../../../backup/'.$folder_name)){
                        // Get real path for our folder
                        $rootPath = realpath('../../../');
                        // Zip and DB file name
                        $zip_file_name = "files.zip";
                        $db_file_name = "database.sql";

                        // Initialize archive object
                        $zip = new ZipArchive();
                        if($zip->open('../../../backup/'.$folder_name.'/'.$zip_file_name, ZipArchive::CREATE) === TRUE){
                            // Create recursive directory iterator
                            /** @var SplFileInfo[] $files */
                            $files = new RecursiveIteratorIterator(
                                new RecursiveDirectoryIterator($rootPath),
                                RecursiveIteratorIterator::LEAVES_ONLY
                            );
                            // Add files on zip file
                            foreach ($files as $zip_file_name => $file){
                                // Skip directories (they would be added automatically)
                                if (!$file->isDir()){
                                    // Get real and relative path for current file
                                    $filePath = $file->getRealPath();
                                    $relativePath = substr($filePath, strlen($rootPath) + 1);

                                    // Add current file to archive
                                    $zip->addFile($filePath, $relativePath);
                                }
                            }
                            $zip->close();

                            //Get database data
                            $tables = array();
                            $result = mysqli_query($con,"SHOW TABLES");
                            while($row = mysqli_fetch_row($result)){
                                $tables[] = $row[0];
                            }
                            $return = '';
                            foreach($tables as $table){
                                $result = mysqli_query($con,"SELECT * FROM ".$table);
                                $num_fields = mysqli_num_fields($result);
                                
                                $return .= 'DROP TABLE '.$table.';;';
                                $row2 = mysqli_fetch_row(mysqli_query($con,"SHOW CREATE TABLE ".$table));
                                $return .= "\n\n".$row2[1].";;\n\n";
                                
                                for($i=0;$i<$num_fields;$i++){
                                    while($row = mysqli_fetch_row($result)){
                                        $return .= "INSERT INTO ".$table." VALUES(";
                                        for($j=0;$j<$num_fields;$j++){
                                            $row[$j] = addslashes($row[$j]);
                                            if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}
                                            else{ $return .= '""';}
                                            if($j<$num_fields-1){ $return .= ',';}
                                        }
                                        $return .= ");;\n";
                                    }
                                }
                                $return .= "\n\n\n";
                            }
                            //Save file
                            $handle = fopen("../../../backup/".$folder_name.'/'.$db_file_name,"w+");
                            fwrite($handle,$return);
                            fclose($handle);

                            // Initialize archive object
                            $zip = new ZipArchive();
                            if($zip->open('../../../backup/'.$folder_name.'/database.zip', ZipArchive::CREATE) === TRUE){
                                $zip->addFile('../../../backup/'.$folder_name.'/database.sql', 'database.sql');
                                $zip->close();
                                
                                //Insert tbl_backup
                                mySQLi_query($con, "INSERT INTO tbl_backup (back_name, back_date) VALUES ('$folder_name', '".date('Y-m-d H:i:s')."')");
                                // Data inserted id
                                $noti_data_id = mysqli_insert_id($con);
                                //Insert tbl_activitylog
                                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', 'Backup', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                                //Insert to tbl_notifications
                                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', 'Backup', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");

                                // Delete file
                                unlink('../../../backup/'.$folder_name.'/database.sql');

                                $response = 1;
                            }else{
                                $response = $zip->error_log;
                            }
                        }else{
                            $response = $zip->error_log;
                        }
                    }else{
                        $response = "Failed to create a folder!";
                    }
                } 
                // Restore
                else if ($_GET['id'] == '2'){
                    // Make sure the script can handle large folders/files
                    ini_set('max_execution_time', 600);
                    ini_set('memory_limit', '1024M');

                    // Get real path for our folder
                    $rootPath = realpath('../../../');
                    //Start restore
                    $back = mySQLi_fetch_assoc(mySQLi_query($con, "SELECT * from tbl_backup WHERE back_id = '".$_GET['back_id']."'"));
                    // FIle name
                    $backup_folder = $back['back_name'];
                    //Check file if it exist
                    if(file_exists("../../../backup/".$backup_folder)){
                        // Move the folder to root folder
                        if(rename("../../../backup/".$backup_folder, $rootPath.$backup_folder)){
                            // // Delete all files
                            $directory = new RecursiveDirectoryIterator(realpath($rootPath),  FilesystemIterator::SKIP_DOTS);
                            $files = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
                            foreach ($files as $file) {
                                if(!(strpos($file, $backup_folder))){
                                    if (is_dir($file)) {
                                        rmdir($file);
                                    } else {
                                        unlink($file);
                                    }
                                }
                            }
                            
                            // Move all the files outside
                            $zip = new ZipArchive;
                            if ($zip->open($rootPath.$backup_folder.'/files.zip') === TRUE) {
                                $zip->extractTo(realpath($rootPath));
                                $zip->close();

                                // Restore Database
                                $zip = new ZipArchive;
                                if ($zip->open($rootPath.$backup_folder.'/database.zip') === TRUE) {
                                    $zip->extractTo($rootPath.$backup_folder.'/');
                                    $zip->close();

                                    $back = mySQLi_fetch_assoc(mySQLi_query($con, "SELECT * from tbl_backup WHERE back_name = '".$backup_folder."'"));
                                    $filename = $rootPath.$backup_folder.'/database.sql';

                                    $handle = fopen($filename,"r+");
                                    $contents = fread($handle,filesize($filename));
                                    $sql = explode(';;',$contents);
                                    foreach($sql as $query){
                                        $result = mysqli_query($con,$query);
                                    }
                                    fclose($handle);
                        
                                    // Data  id
                                    $noti_data_id = $back['back_id'];
                                    //Insert tbl_activitylog
                                    mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', 'Restore', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                                    //Insert to tbl_notifications
                                    mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', 'Restore', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                                    
                                    // Delete backup
                                    array_map('unlink', glob($rootPath.$backup_folder."/*.*"));
                                    rmdir($rootPath.$backup_folder);

                                    $response = 1;
                                }else{
                                    $response = $zip->error_log;
                                }
                            } else {
                                $response = $zip->error_log;
                            }
                        }else{
                            $response = 'Failed to move the folder!';
                        }
                    }else{
                        $response = 'Folder does not exist!';
                    }
                }
                // Upload a backup
                else if($_GET['id'] == '3'){
                    // Check if file already exist
                    $website_name = $page['page_website_title'];
                    $time = time();
                    $name = $website_name."_".$time.'.zip';
                    $folder_name = $website_name."_".$time;
                    while (file_exists("../../../backup/" . $name)) {
                        // New filename with time
                        $time = time();
                        $name_actual_name = (string)$website_name."_".$time;
                        $name = $name_actual_name.".zip";
                        $folder_name = $website_name."_".$time;
                    }
                    // Create folder
                    if(mkdir('../../../backup/'.$folder_name)){
                        // Upload file to server
                        if(move_uploaded_file($_FILES["back_name"]["tmp_name"], "../../../backup/".$folder_name.'/'.$name)){
                            // Initialize archive object
                            $zip = new ZipArchive();
                            if($zip->open('../../../backup/'.$folder_name.'/'.$name) === TRUE){
                                $zip->extractTo('../../../backup/'.$folder_name.'/');
                                $zip->close();
                                // Delete file
                                unlink('../../../backup/'.$folder_name.'/'.$name);
                                //Insert tbl_backup
                                mySQLi_query($con, "INSERT INTO tbl_backup (back_name, back_date) VALUES ('$folder_name', '".date('Y-m-d H:i:s')."')");
                                // Data inserted id
                                $noti_data_id = mysqli_insert_id($con);
                                //Insert tbl_activitylog
                                mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('".$_SESSION['acc_id']."', 'Backup Upload', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                                //Insert to tbl_notifications
                                mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', 'Backup Upload', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                                $response = 1;
                            }else{
                                $response = $zip->error_log;
                            }
                        }else{
                            $response = mysqli_error($con);
                        }
                    }else{
                        $response = "Failed to create a folder!";
                    }
                }
                // Autobackup Days Update
                else if($_GET['id'] == '4'){
                    $days = ',';
                    if(isset($_POST['Monday'])){$days .= $_POST['Monday'].',';}
                    if(isset($_POST['Tuesday'])){$days .= $_POST['Tuesday'].',';}
                    if(isset($_POST['Wednesday'])){$days .= $_POST['Wednesday'].',';}
                    if(isset($_POST['Thursday'])){$days .= $_POST['Thursday'].',';}
                    if(isset($_POST['Friday'])){$days .= $_POST['Friday'].',';}
                    if(isset($_POST['Saturday'])){$days .= $_POST['Saturday'].',';}
                    if(isset($_POST['Sunday'])){$days .= $_POST['Sunday'].',';}
                    $days = substr($days, 0, -1);

                    if(mysqli_query($con, "UPDATE tbl_pages SET page_autobackup_days = '".$days."' WHERE page_id = 1")){
                        $noti_action = 'Backup Days';
                        //Activity Log
                        mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_data_id, log_action, log_date) VALUES ('".$_SESSION['acc_id']."', '1', '".$noti_action."', '".date('Y-m-d H:i:s')."')");
                        //Insert to tbl_notifications
                        mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('".$_SESSION['acc_id']."', '".$noti_action."', '1', '".date('Y-m-d H:i:s')."')");
                        $response = 1;
                    }else{
                        $response = mysqli_error($con);
                    }
                }
                // Delete backup
                else if($_GET['id'] == '5'){
                    $back = mySQLi_fetch_assoc(mySQLi_query($con, "SELECT * from tbl_backup WHERE back_id = '".$_GET['back_id']."'"));
                    if(mysqli_query($con, "DELETE FROM tbl_backup WHERE back_id = '".$_GET['back_id']."'")){
                        // Delete backup
                        array_map('unlink', glob("../../../backup/".$back['back_name']."/*.*"));
                        rmdir("../../../backup/".$back['back_name']);
                        $response = '1';
                    }else{
                        $response = mysqli_error($con);
                    }
                }
                // Download a backup
                else if($_GET['id'] == '6'){
                    $back = mySQLi_fetch_assoc(mySQLi_query($con, "SELECT * from tbl_backup WHERE back_id = '".$_GET['back_id']."'"));
                    // Get real path for our folder
                    $rootPath = '../../../backup/'.$back['back_name'];
                    // $rootPath = str_replace('\\','/',$rootPath);
                    $response = $rootPath;
                    // Zip and DB file name
                    $zip_file_name = $back['back_name'].".zip";
                    // Initialize archive object
                    $zip = new ZipArchive();
                    if($zip->open('../../../backup/'.$zip_file_name, ZipArchive::CREATE) === TRUE){
                        // Add files
                        $zip->addFile('../../../backup/'.$back['back_name'].'/database.zip', 'database.zip');
                        $zip->addFile('../../../backup/'.$back['back_name'].'/files.zip', 'files.zip');
                        $zip->close();
                        // Force download
                        header("Cache-Control: public");
                        header("Content-Description: File Transfer");
                        header("Content-Disposition: attachment; filename=$zip_file_name");
                        header("Content-Type: application/zip");
                        header("Content-Transfer-Encoding: binary");
                        // read the file from disk
                        readfile('../../../backup/'.$zip_file_name);
                        // Delete the zip file
                        unlink('../../../backup/'.$zip_file_name);
                        $response = 1;
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                    }else{
                        $response = $zip->error_log;
                    }
                }
                // Check Password
                else if($_GET['id'] == '7'){
                    $password = $_POST['password'];

                    $numrows = mysqli_num_rows(mysqli_query($con, "SELECT acc_id FROM tbl_accounts WHERE acc_password = '".md5($password)."' AND acc_id = '".$_SESSION['acc_id']."'"));
                    if($numrows == 1){
                        $response = 1;
                    }else{
                        $response = 'Password is incorrect';
                    }
                }
            }else{
                $response = 'Failed!';
            }
            mysqli_close($con);
        }
    }
    echo $response;
?>