<?php
    include '../../../assets/php/database.php';
    date_default_timezone_set('Asia/Manila');
    $page = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') );
    $response = 'Success!';
    if (strpos($page['page_autobackup_days'], date('l'))) {
        // Check if file already exist
        $website_name = $page['page_website_title'];
        $folder_name = 'Autobackup_'.$website_name."_".date("M-d-Y");
        if (!file_exists("../../../backup/".$folder_name)) {
            // Make sure the script can handle large folders/files
            ini_set('max_execution_time', 600);
            ini_set('memory_limit', '1024M');

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
                        mysqli_query($con, "INSERT into `tbl_activitylog` (log_author, log_action, log_data_id, log_date) VALUES ('Auto', 'Backup Auto', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");
                        //Insert to tbl_notifications
                        mysqli_query($con, "INSERT into `tbl_notifications` (noti_author, noti_action, noti_data_id, noti_date_created) VALUES ('Auto', 'Backup Auto', '".$noti_data_id."', '".date('Y-m-d H:i:s')."')");

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
        }else{
            $response = "File already exist!";
        }
    }else{
        $response = 'No schedule today.';
    }
    echo $response;
?>