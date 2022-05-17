<?php
    // //Start Session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include '../../../assets/php/database.php';
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );

    // Notification Number
    if (isset($_GET['id'])) {
        // All Notification
        if ($_GET['id'] == 1){
            if ($acc['acc_role'] != 'Staff') {
                // Super Admin and Admin
                $query = mysqli_query($con, "SELECT * FROM tbl_notifications WHERE noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."'");
            }else{
                // Staff
                $query = mySQLi_query($con, "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
                (noti_action = 'Pensioner Applicant' or noti_action = 'Pensioner Active' or noti_action = 'Pensioner Deceased' or noti_action = 'Pensioner Rejected' or noti_action = 'Pensioner Deleted'
                or noti_action = 'Pensioner Applicant Bulk' or noti_action = 'Pensioner Active Bulk' or noti_action = 'Pensioner Deceased Bulk' or noti_action = 'Pensioner Rejected Bulk' or noti_action = 'Pensioner Deleted Bulk'
                or noti_action = 'Email' 
                or noti_action = 'Account Create' or noti_action = 'Account Delete' or noti_action = 'Account Super Admin' or noti_action = 'Account Admin' or noti_action = 'Account Staff' or noti_action = 'Account Active' or noti_action = 'Account Inactive'
                or noti_action = 'Account Delete Bulk' or noti_action = 'Account Super Admin Bulk' or noti_action = 'Account Admin Bulk' or noti_action = 'Account Staff Bulk' or noti_action = 'Account Active Bulk' or noti_action = 'Account Inactive Bulk'
                or noti_action = 'Page General' or noti_action = 'Page Mission Vision' or noti_action = 'Page Officials' or noti_action = 'Page Register'  or noti_action = 'Page Report Deleted'
                or noti_action = 'Page Report Insert Published' or noti_action = 'Page Report Insert Draft' or noti_action = 'Page Report Update Published' or noti_action = 'Page Report Update Draft' or noti_action = 'Page Report Update Trashed'
                or noti_action = 'Pensioner Purchase' or noti_action = 'Pensioner Purchase Aprroved' or noti_action = 'Pensioner Purchase Rejected' 
                or noti_action = 'Pensioner Purchase Approved Bulk' or noti_action = 'Pensioner Purchase Rejected Bulk' 
                or noti_action = 'Page Portfolio Insert Published' or noti_action = 'Page Portfolio Insert Draft' or noti_action = 'Page Portfolio Update Published' or noti_action = 'Page Portfolio Update Draft' or noti_action = 'Page Portfolio Update Trashed' or noti_action = 'Page Portfolio Deleted'
                ) order by noti_id DESC") or die(mySQLi_error($con));
            }
            $count = 0;
            while($noti = mySQLi_fetch_assoc($query)){
                $noti_read = explode(',',$noti['noti_read']);
                $read = 0;
                foreach ($noti_read as $index => $value) {
                    if ($value == $_SESSION['acc_id']) {
                        $read = 1;
                    }
                }
                if ($read != 1) {
                    $count += 1;
                }
            }
            if ($count > 0) {
                echo $count;
            }
        } 
        // All Notification Dropdown
        else if ($_GET['id'] == 2) {
            if ($acc['acc_role'] != 'Staff') {
                // Super Admin and Admin
                $query = mySQLi_query($con, "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' order by noti_id DESC") or die(mySQLi_error($con));
            } else {
                // Staff
                $query = mySQLi_query($con, "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
                (noti_action = 'Pensioner Applicant' or noti_action = 'Pensioner Active' or noti_action = 'Pensioner Deceased' or noti_action = 'Pensioner Rejected' or noti_action = 'Pensioner Deleted'
                or noti_action = 'Pensioner Applicant Bulk' or noti_action = 'Pensioner Active Bulk' or noti_action = 'Pensioner Deceased Bulk' or noti_action = 'Pensioner Rejected Bulk' or noti_action = 'Pensioner Deleted Bulk'
                or noti_action = 'Email' 
                or noti_action = 'Account Create' or noti_action = 'Account Delete' or noti_action = 'Account Super Admin' or noti_action = 'Account Admin' or noti_action = 'Account Staff' or noti_action = 'Account Active' or noti_action = 'Account Inactive'
                or noti_action = 'Account Delete Bulk' or noti_action = 'Account Super Admin Bulk' or noti_action = 'Account Admin Bulk' or noti_action = 'Account Staff Bulk' or noti_action = 'Account Active Bulk' or noti_action = 'Account Inactive Bulk'
                or noti_action = 'Page General' or noti_action = 'Page Mission Vision' or noti_action = 'Page Officials' or noti_action = 'Page Register'  or noti_action = 'Page Report Deleted'
                or noti_action = 'Page Report Insert Published' or noti_action = 'Page Report Insert Draft' or noti_action = 'Page Report Update Published' or noti_action = 'Page Report Update Draft' or noti_action = 'Page Report Update Trashed'
                or noti_action = 'Pensioner Purchase' or noti_action = 'Pensioner Purchase Aprroved' or noti_action = 'Pensioner Purchase Rejected' 
                or noti_action = 'Pensioner Purchase Approved Bulk' or noti_action = 'Pensioner Purchase Rejected Bulk' 
                or noti_action = 'Page Portfolio Insert Published' or noti_action = 'Page Portfolio Insert Draft' or noti_action = 'Page Portfolio Update Published' or noti_action = 'Page Portfolio Update Draft' or noti_action = 'Page Portfolio Update Trashed' or noti_action = 'Page Portfolio Deleted'
                ) order by noti_id DESC") or die(mySQLi_error($con));
            }
            $noti_output = '';
            while($noti = mySQLi_fetch_assoc($query)){
                $noti_read = explode(',',$noti['noti_read']);
                $read = 0;
                foreach ($noti_read as $index => $value) {
                    if ($value == $_SESSION['acc_id']) {
                        $read = 1;
                    }
                }
                // Update noti_read to Read
                if ($read == 0) {
                    if ($noti['noti_read'] != '') {
                        $noti_read = implode(',',$noti_read).','.$_SESSION['acc_id'];
                    } else {
                        $noti_read = $_SESSION['acc_id'];
                    }
                    mysqli_query($con, " UPDATE tbl_notifications SET noti_read = '$noti_read' WHERE noti_id = '".$noti['noti_id']."' ");
                }
                // Notif is Pensioner 
                if ($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected' || $noti['noti_action'] == 'Pensioner Deleted') {
                    $query_appl = mysqli_query($con, " SELECT * from tbl_applicants where appl_id = '".$noti['noti_data_id']."' ");
                    if(mysqli_num_rows($query_appl) == 1){
                        $appl = mySQLi_fetch_assoc($query_appl);
                    }else{
                        $appl['appl_picture'] = 'profile.svg';
                        $appl['appl_lastname'] = 'Someone';
                        $appl['appl_firstname'] = 'a deleted pensioner';
                        $appl['appl_barangay'] = '...';
                        $appl['appl_municipality'] = '...';
                    }
                } 
                // Notif is Pensioner Bulk
                else if ($noti['noti_action'] == 'Pensioner Applicant Bulk' || $noti['noti_action'] == 'Pensioner Active Bulk' || $noti['noti_action'] == 'Pensioner Deceased Bulk' || $noti['noti_action'] == 'Pensioner Rejected Bulk' || $noti['noti_action'] == 'Pensioner Deleted Bulk') {
                    $noti_data_id_explode = explode(',',$noti['noti_data_id']);
                    $noti_data_id_bulk_count = count($noti_data_id_explode);
                } 
                // Notif is Account
                else if ($noti['noti_action'] == 'Account Create' || $noti['noti_action'] =='Account Delete' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive') {
                    $acc2 = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_accounts where acc_id = '".$noti['noti_data_id']."' "));
                }
                // Notif is Account Bulk
                else if ($noti['noti_action'] =='Account Delete Bulk' || $noti['noti_action'] == 'Account Super Admin Bulk' || $noti['noti_action'] == 'Account Admin Bulk' || $noti['noti_action'] == 'Account Staff Bulk' || $noti['noti_action'] == 'Account Active Bulk' || $noti['noti_action'] == 'Account Inactive Bulk') {
                    $noti_data_id_explode = explode(',',$noti['noti_data_id']);
                    $noti_data_id_bulk_count = count($noti_data_id_explode);
                }
                // Notif is Website
                else if ($noti['noti_action'] == 'Page General' || $noti['noti_action'] == 'Page Mission Vision' || $noti['noti_action'] == 'Page Officials' || $noti['noti_action'] == 'Page Register') {
                    $page = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_pages where page_id = '1' "));
                }
                // Notif is Website Report
                else if ($noti['noti_action'] == 'Page Report Deleted' || $noti['noti_action'] == 'Page Report Insert Published' || $noti['noti_action'] == 'Page Report Insert Draft' || $noti['noti_action'] == 'Page Report Update Published' || $noti['noti_action'] == 'Page Report Update Draft' || $noti['noti_action'] == 'Page Report Update Trashed') {
                    if(!($report = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_reports where rep_id = '".$noti['noti_data_id']."' ")))){
                        $report['rep_title'] = ' Item unavailable';
                        $report['rep_notes'] = ' Report is already deleted';
                    }
                }
                // Purchase
                else if ($noti['noti_action'] == 'Pensioner Purchase' || $noti['noti_action'] == 'Pensioner Purchase Aprroved' || $noti['noti_action'] == 'Pensioner Purchase Rejected') {
                    $pur = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_purchases where pur_id = '".$noti['noti_data_id']."' "));
                }
                // Purchase Bulk
                else if ($noti['noti_action'] == 'Pensioner Purchase Approved Bulk' || $noti['noti_action'] == 'Pensioner Purchase Rejected Bulk') {
                    $log_data_id_explode = explode(',',$noti['noti_data_id']);
                    $log_data_id_bulk_count = count($log_data_id_explode);
                }
                // Portfolio
                else if ($noti['noti_action'] == 'Page Portfolio Insert Published' || $noti['noti_action'] == 'Page Portfolio Insert Draft' || $noti['noti_action'] == 'Page Portfolio Update Published' || $noti['noti_action'] == 'Page Portfolio Update Draft' || $noti['noti_action'] == 'Page Portfolio Update Trashed' || $noti['noti_action'] == 'Page Portfolio Deleted') {
                    if(!($port = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_portfolios where port_id = '".$noti['noti_data_id']."' ")))){
                        $port['port_title'] = ' Item unavailable';
                        $port['port_notes'] = ' Portfolio activity is already deleted';
                    }
                }
                // Subscriber
                else if ($noti['noti_action'] == 'Subscriber') {
                    if(!($subs = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_subscribers where subs_id = '".$noti['noti_data_id']."' ")))){
                        $subs['subs_email'] = ' A deleted subscriber';
                    }
                }

                // Check Notif Author
                if($noti['noti_author'] == $_SESSION['acc_id']){
                    $name = 'You';
                }else if($noti['noti_author'] == 'Auto'){
                    $name = '';
                }else if($noti['noti_author'] != 'Someone'){
                    if($noti['noti_action'] != 'Subscriber'){
                        if($noti_author = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_accounts where acc_id = '".$noti['noti_author']."' "))){
                            $name = $noti_author['acc_username'];
                        }else{
                            $name = 'A deleted account';
                        }
                    }elseif($noti['noti_action'] == 'Subscriber'){
                        if($noti_author = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_subscribers where subs_id = '".$noti['noti_author']."' "))){
                            $name = $noti_author['subs_email'];
                        }else{
                            $name = 'A deleted subscriber';
                        }
                    }
                }else{
                    $name = 'Someone';
                }

                $noti_output .= '
                    <div class="dropdown-divider"></div>
                    <a href="';if($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Applicant Bulk')
                                {$noti_output .= '/admin/applicants/applicants';}
                            else if($noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Active Bulk')
                                {$noti_output .= '/admin/pensioners/active';}
                            else if($noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Deceased Bulk')
                                {$noti_output .= '/admin/pensioners/deceased';}
                            else if($noti['noti_action'] == 'Pensioner Rejected' || $noti['noti_action'] == 'Pensioner Rejected Bulk')
                                {$noti_output .= '/admin/applicants/rejected';}
                            else if($noti['noti_action'] == 'Pensioner Deleted' || $noti['noti_action'] == 'Pensioner Deleted Bulk')
                                {$noti_output .= '#';}
                            else if($noti['noti_action'] == 'Account Create' || $noti['noti_action'] =='Account Delete' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive'
                                || $noti['noti_action'] =='Account Delete Bulk' || $noti['noti_action'] == 'Account Super Admin Bulk' || $noti['noti_action'] == 'Account Admin Bulk' || $noti['noti_action'] == 'Account Staff Bulk' || $noti['noti_action'] == 'Account Active Bulk' || $noti['noti_action'] == 'Account Inactive Bulk')
                                    {$noti_output .= 'accounts_accounts';}
                            else{$noti_output .= '#';};
                    $noti_output .= '" class="dropdown-item">
                        <div class="card-header p-0 border-bottom-0">
                            <h6 class="text-muted text-wrap row mb-0"><div class="col-1 pr-0">';
                                //Icon
                                if($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected' || $noti['noti_action'] == 'Pensioner Deleted'
                                    || $noti['noti_action'] == 'Pensioner Applicant Bulk' || $noti['noti_action'] == 'Pensioner Active Bulk' || $noti['noti_action'] == 'Pensioner Deceased Bulk' || $noti['noti_action'] == 'Pensioner Rejected Bulk' || $noti['noti_action'] == 'Pensioner Deleted Bulk')
                                        {$noti_output .= '<h5 class="fas fa-file-alt"></h5> ';}
                                else if($noti['noti_action'] == 'Account Create' || $noti['noti_action'] =='Account Delete' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive'
                                    || $noti['noti_action'] =='Account Delete Bulk' || $noti['noti_action'] == 'Account Super Admin Bulk' || $noti['noti_action'] == 'Account Admin Bulk' || $noti['noti_action'] == 'Account Staff Bulk' || $noti['noti_action'] == 'Account Active Bulk' || $noti['noti_action'] == 'Account Inactive Bulk')
                                        {$noti_output .= '<h5 class="fas fa-user"></h5> ';}
                                else if($noti['noti_action'] == 'Page General' || $noti['noti_action'] == 'Page Mission Vision' || $noti['noti_action'] == 'Page Officials' || $noti['noti_action'] == 'Page Register' || $noti['noti_action'] == 'Page Report Deleted' || $noti['noti_action'] == 'Page Settings'
                                    || $noti['noti_action'] == 'Page Report Insert Published' || $noti['noti_action'] == 'Page Report Insert Draft' || $noti['noti_action'] == 'Page Report Update Published' || $noti['noti_action'] == 'Page Report Update Draft' || $noti['noti_action'] == 'Page Report Update Trashed')
                                        {$noti_output .= '<h5 class="fas fa-book"></h5> ';}
                                else if($noti['noti_action'] == 'Backup'){$noti_output .= '<i class="fas fa-hdd"></i>';}
                                else if($noti['noti_action'] == 'Backup Upload'){$noti_output .= '<i class="fas fa-upload"></i>';}
                                else if($noti['noti_action'] == 'Restore'){$noti_output .= '<i class="fas fa-undo-alt"></i>';}
                                else if($noti['noti_action'] == 'Backup Days'){$noti_output .= '<i class="fas fa-calendar"></i>';}
                                else if($noti['noti_action'] == 'Backup Auto'){$noti_output .= '<i class="fas fa-stopwatch"></i>';}
                                else if($noti['noti_action'] == 'Pensioner Purchase Pending' || $noti['noti_action'] == 'Pensioner Purchase' || $noti['noti_action'] == 'Pensioner Purchase Approved' || $noti['noti_action'] == 'Pensioner Purchase Rejected' || $noti['noti_action'] == 'Pensioner Purchase Approved Bulk' || $noti['noti_action'] == 'Pensioner Purchase Rejected Bulk')
                                    {$noti_output .= '<i class="fas fa-receipt"></i> ';}
                                else if ($noti['noti_action'] == 'Page Portfolio Insert Published' || $noti['noti_action'] == 'Page Portfolio Insert Draft' || $noti['noti_action'] == 'Page Portfolio Update Published' || $noti['noti_action'] == 'Page Portfolio Update Draft' || $noti['noti_action'] == 'Page Portfolio Update Trashed' || $noti['noti_action'] == 'Page Portfolio Deleted')
                                    {$noti_output .= '<i class="fas fa-folder"></i> ';}
                                else if ($noti['noti_action'] == 'Subscriber')
                                    {$noti_output .= '<i class="fas fa-plus"></i> ';}
                    $noti_output .= '</div><div class="col-11 pl-0">';
                                //Author
                                if($noti['noti_author'] != 'Someone'){$noti_output .= '<span class="text-primary">'.$name.'</span>';}
                                //Action Pensioner Solo
                                if($noti['noti_action'] == 'Pensioner Applicant'){if($noti['noti_author'] == 'Someone'){$noti_output .= 'New applicant.';}else{$noti_output .= ' added a new applicant.';}}
                                else if($noti['noti_action'] == 'Pensioner Active'){$noti_output .= ' approved pensioner.';}
                                else if($noti['noti_action'] == 'Pensioner Deceased'){$noti_output .= ' set a pensioner as deceased.';}
                                else if($noti['noti_action'] == 'Pensioner Rejected'){$noti_output .= ' rejected an applicant.';}
                                else if($noti['noti_action'] == 'Pensioner Deleted'){$noti_output .= ' deleted an applicant data.';}
                                //Action Pensioner Bulk
                                else if($noti['noti_action'] == 'Pensioner Applicant Bulk'){$noti_output .= ' added '.$noti_data_id_bulk_count.' new applicants.';}
                                else if($noti['noti_action'] == 'Pensioner Active Bulk'){$noti_output .= ' approved '.$noti_data_id_bulk_count.' pensioners.';}
                                else if($noti['noti_action'] == 'Pensioner Deceased Bulk'){$noti_output .= ' set '.$noti_data_id_bulk_count.' pensioners as deceased.';}
                                else if($noti['noti_action'] == 'Pensioner Rejected Bulk'){$noti_output .= ' rejected '.$noti_data_id_bulk_count.' applicants.';}
                                else if($noti['noti_action'] == 'Pensioner Deleted Bulk'){$noti_output .= ' deleted '.$noti_data_id_bulk_count.' applicant data.';}
                                //Action Account
                                else if($noti['noti_action'] == 'Account Create'){$noti_output .= ' added a new '.$acc2['acc_role'];}
                                else if($noti['noti_action'] == 'Account Delete'){$noti_output .= ' deleted an account';}
                                else if($noti['noti_action'] == 'Account Super Admin'){$noti_output .= ' added a new '.$acc2['acc_role'];}
                                else if($noti['noti_action'] == 'Account Admin'){$noti_output .= ' added a new '.$acc2['acc_role'];}
                                else if($noti['noti_action'] == 'Account Staff'){$noti_output .= ' added a new '.$acc2['acc_role'];}
                                else if($noti['noti_action'] == 'Account Active'){$noti_output .= ' set '.$acc2['acc_username'].' as Active.';}
                                else if($noti['noti_action'] == 'Account Inactive'){$noti_output .= ' set '.$acc2['acc_role'].' as Inactive';}
                                // Action Account Bulk
                                else if($noti['noti_action'] == 'Account Delete Bulk'){$noti_output .= ' deleted '.$noti_data_id_bulk_count.' accounts.';}
                                else if($noti['noti_action'] == 'Account Super Admin Bulk'){$noti_output .= ' set '.$noti_data_id_bulk_count.' accounts as Super Admin.';}
                                else if($noti['noti_action'] == 'Account Admin Bulk'){$noti_output .= ' set '.$noti_data_id_bulk_count.' accounts as Admin.';}
                                else if($noti['noti_action'] == 'Account Staff Bulk'){$noti_output .= ' set '.$noti_data_id_bulk_count.' accounts as Staff.';}
                                else if($noti['noti_action'] == 'Account Active Bulk'){$noti_output .= ' set '.$noti_data_id_bulk_count.' accounts as Active.';}
                                else if($noti['noti_action'] == 'Account Inactive Bulk'){$noti_output .= ' set '.$noti_data_id_bulk_count.' accounts as Inactive.';}
                                // Action Website
                                else if($noti['noti_action'] == 'Page General'){$noti_output .= ' updated website\'s general information.';}
                                else if($noti['noti_action'] == 'Page Mission Vision'){$noti_output .= ' update website\'s mission and vision page.';}
                                else if($noti['noti_action'] == 'Page Officials'){$noti_output .= ' updated website\'s officails page.';}
                                else if($noti['noti_action'] == 'Page Register'){$noti_output .= ' updated website\'s social pension registration page.';}
                                else if($noti['noti_action'] == 'Page Settings'){$noti_output .= ' updated website information.';}
                                // Action Website Report
                                else if($noti['noti_action'] == 'Page Report Insert Published'){$noti_output .= ' created and published a new report .';}
                                else if($noti['noti_action'] == 'Page Report Insert Draft'){$noti_output .= ' created and drafted a new report.';}
                                else if($noti['noti_action'] == 'Page Report Update Published'){$noti_output .= ' updated and published a report.';}
                                else if($noti['noti_action'] == 'Page Report Update Draft'){$noti_output .= ' updated and drafted a report.';}
                                else if($noti['noti_action'] == 'Page Report Update Trashed'){$noti_output .= ' more a report to trash.';}
                                else if($noti['noti_action'] == 'Page Report Deleted'){$noti_output .= ' deleted a report.';}
                                // Backup/Restore
                                else if($noti['noti_action'] == 'Backup'){$noti_output .= ' performed a backup.';}
                                else if($noti['noti_action'] == 'Backup Upload'){$noti_output .= ' uploaded a backup.';}
                                else if($noti['noti_action'] == 'Restore'){$noti_output .= ' performed a data restoration.';}
                                else if($noti['noti_action'] == 'Backup Days'){$noti_output .= ' updated the backup schedule.';}
                                else if($noti['noti_action'] == 'Backup Auto'){$noti_output .= ' System auto backup performed successfully.';}
                                // Purchase
                                else if($noti['noti_action'] == 'Pensioner Purchase'){$noti_output .= ' added new purchase item.';}
                                else if($noti['noti_action'] == 'Pensioner Purchase Pending'){$noti_output .= ' set an purchase item as pending.';}
                                else if($noti['noti_action'] == 'Pensioner Purchase Approved'){$noti_output .= ' approved an purchase item.';}
                                else if($noti['noti_action'] == 'Pensioner Purchase Rejected'){$noti_output .= ' rejected an purchase item.';}
                                // Purchase Bulk
                                else if($noti['noti_action'] == 'Pensioner Purchase Pending Bulk'){$noti_output .= ' set '.$log_data_id_bulk_count.' purchase item as pending.';}
                                else if($noti['noti_action'] == 'Pensioner Purchase Approved Bulk'){$noti_output .= ' approved '.$log_data_id_bulk_count.' purchase item.';}
                                else if($noti['noti_action'] == 'Pensioner Purchase Rejected Bulk'){$noti_output .= ' rejected '.$log_data_id_bulk_count.' purchase item.';}
                                // Action Website Portfolio
                                else if($noti['noti_action'] == 'Page Portfolio Insert Published'){$noti_output .= ' created and published a new portfolio activity.';}
                                else if($noti['noti_action'] == 'Page Portfolio Insert Draft'){$noti_output .= ' created and drafted a new portfolio activity.';}
                                else if($noti['noti_action'] == 'Page Portfolio Update Published'){$noti_output .= ' updated and published an portfolio activity.';}
                                else if($noti['noti_action'] == 'Page Portfolio Update Draft'){$noti_output .= ' updated and drafted an portfolio activity.';}
                                else if($noti['noti_action'] == 'Page Portfolio Update Trashed'){$noti_output .= ' move an portfolio activity to trash.';}
                                else if($noti['noti_action'] == 'Page Portfolio Deleted'){$noti_output .= ' deleted an portfolio activity.';}
                                // Subscriber
                                else if($noti['noti_action'] == 'Subscriber'){$noti_output .= ' Someone subscribed to the newsletter.';}
            if($noti['noti_action'] == 'Pensioner Deleted'){
                $noti_output .= '<br><small class="text-muted text-sm">'.$noti['noti_date_created'] .'</small></div>';
            }        
            $noti_output .= '</h6></div>';
                        if($noti['noti_action'] == 'Page Report Update Trashed' || $noti['noti_action'] == 'Page Report Update Draft' || $noti['noti_action'] == 'Page Report Update Published' || $noti['noti_action'] == 'Page Report Insert Draft' || $noti['noti_action'] == 'Page Report Insert Published'
                        || $noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected' 
                        || $noti['noti_action'] == 'Account Create' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive'
                        || $noti['noti_action'] == 'Page Portfolio Update Trashed' || $noti['noti_action'] == 'Page Portfolio Update Draft' || $noti['noti_action'] == 'Page Portfolio Update Published' || $noti['noti_action'] == 'Page Portfolio Insert Draft' || $noti['noti_action'] == 'Page Portfolio Insert Published'
                        ){
                            $noti_output .= '<div class="card-body p-0 text-muted">';
                            if($noti['noti_action'] == 'Page Report Update Trashed' || $noti['noti_action'] == 'Page Report Update Draft' || $noti['noti_action'] == 'Page Report Update Published' || $noti['noti_action'] == 'Page Report Insert Draft' || $noti['noti_action'] == 'Page Report Insert Published'){
                                $noti_output .= '<table>
                                    <tr>
                                        <td class="text-bold">Title: </td>
                                        <td class="h5">'.$report['rep_title'].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Note: </td>
                                        <td class="h6">';
                                            if(strlen($report['rep_notes']) < 50){
                                                $noti_output .= $report['rep_notes'];
                                            }else{
                                                $port_notes = $report['rep_notes']." ";
                                                $port_notes = substr($port_notes,0,50);
                                                $port_notes = substr($port_notes,0,strrpos($port_notes,' '));
                                                $port_notes = $port_notes."...";
                                                $noti_output .= $port_notes;
                                            }
                                $noti_output .= '</td>
                                    </tr>
                                </table>';
                            }elseif($noti['noti_action'] == 'Page Portfolio Update Trashed' || $noti['noti_action'] == 'Page Portfolio Update Draft' || $noti['noti_action'] == 'Page Portfolio Update Published' || $noti['noti_action'] == 'Page Portfolio Insert Draft' || $noti['noti_action'] == 'Page Portfolio Insert Published'){
                                $noti_output .= '<table>
                                    <tr>
                                        <td class="text-bold">Title: </td>
                                        <td class="h5">'.$port['port_title'].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Text: </td>
                                        <td class="h6">';
                                            if(strlen($port['port_notes']) < 50){
                                                $noti_output .= $port['port_notes'];
                                            }else{
                                                $port_notes = $port['port_notes']." ";
                                                $port_notes = substr($port_notes,0,50);
                                                $port_notes = substr($port_notes,0,strrpos($port_notes,' '));
                                                $port_notes = $port_notes."...";
                                                $noti_output .= $port_notes;
                                            }
                                $noti_output .= '</td>
                                    </tr>
                                </table>';
                            }else{
                                $noti_output .= '<div class="row mt-1">
                                            <img src="';
                                            if($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected')
                                                {$noti_output .= '/assets/img/applicant_picture/'.$appl['appl_picture'];}
                                            else if($noti['noti_action'] == 'Account Create' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive')
                                                {if($acc2['acc_appl_id'] == 0){$noti_output .= '/assets/img/account_picture/'.$acc2['acc_picture'];}else{$noti_output .= '/assets/img/applicant_picture/'.$acc2['acc_picture'];}}
                                $noti_output .= '" alt="Picture" class="img-circle img-responsive shadow col-2 p-0" style="height: 55px;background: gray;">
                                            <div class="col-10">
                                                <h6 class="mb-0">';
                                                if(($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected') && isset($appl['appl_lastname']))
                                                {$noti_output .= $appl['appl_lastname'].', '.$appl['appl_firstname'];
                                                }else if(($noti['noti_action'] == 'Account Create' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive') && isset($acc['acc_lastname']))
                                                {$noti_output .= $acc2['acc_lastname'].', '.$acc2['acc_firstname'];}
                                $noti_output .= '</h6><p>';
                                                if(($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected') && isset($appl['appl_barangay']))
                                                {$noti_output .= 'From '.$appl['appl_barangay'].', '.$appl['appl_municipality'].'.';
                                                }else if(($noti['noti_action'] == 'Account Create' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive') && isset($acc['acc_role']))
                                                {if($acc2['acc_role'] == 'Admin'){$noti_output .= 'An ';}else{$noti_output .= 'A ';}$noti_output .= $acc2['acc_role'].'.';}
                                $noti_output .= '</p>
                                                <small class="text-muted text-sm">'.$noti['noti_date_created'] .'</small>
                                            </div>
                                        </div>';
                            }
                            $noti_output .= '</div>';
                        }
            $noti_output .= '</a>
                ';
            }
            if ($noti_output != '') {
                echo $noti_output;
            }else{
                echo '<div class="dropdown-divider"></div><div class="d-flex justify-content-center"><div class="text-center"><i class="fas fa-bell display-1"></i></div></div>';
            }
        }
    } 
    // Notification Page All
    else if (isset($_POST['noti_all'])) {
        unset($_SESSION['queryNotification']);
        unset($_SESSION['queryNotificationButton']);
        //Reload to Previous Page
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    } 
    // // Notification Page Pensioner All
    // else if (isset($_POST['noti_pensioner_all'])) {
    //     $_SESSION['queryNotification'] = "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
    //     (noti_action = 'Pensioner Applicant' or noti_action = 'Pensioner Active' or noti_action = 'Pensioner Deceased' or noti_action = 'Pensioner Rejected' or noti_action = 'Pensioner Deleted'
    //     or noti_action = 'Pensioner Applicant Bulk' or noti_action = 'Pensioner Active Bulk' or noti_action = 'Pensioner Deceased Bulk' or noti_action = 'Pensioner Rejected Bulk' or noti_action = 'Pensioner Deleted Bulk') 
    //     order by noti_id DESC";
    //     $_SESSION['queryNotificationButton'] = 'Pensioner All';
    //     //Reload to Previous Page
    //     header('Location: ' . $_SERVER["HTTP_REFERER"] );
    // } 
    // Notification Page Pensioner Applicant
    else if (isset($_POST['noti_pensioner_application'])) {
        $_SESSION['queryNotification'] = "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
        (noti_action = 'Pensioner Applicant' or noti_action = 'Pensioner Applicant Bulk') order by noti_id DESC";
        $_SESSION['queryNotificationButton'] = 'Pensioner Applicant';
        //Reload to Previous Page
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    } 
    // Notification Page Pensioner Active
    else if (isset($_POST['noti_pensioner_active'])) {
        $_SESSION['queryNotification'] = "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
        (noti_action = 'Pensioner Active' or noti_action = 'Pensioner Active Bulk') order by noti_id DESC";
        $_SESSION['queryNotificationButton'] = 'Pensioner Active';
        //Reload to Previous Page
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    } 
    // Notification Page Pensioner Purchase
    else if (isset($_POST['noti_purchase'])) {
        $_SESSION['queryNotification'] = "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
        (noti_action = 'Pensioner Purchase Pending' or noti_action = 'Pensioner Purchase Approved' or noti_action = 'Pensioner Purchase Pending') order by noti_id DESC";
        $_SESSION['queryNotificationButton'] = 'Pensioner Purchase';
        //Reload to Previous Page
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    } 
    // Notification Page Pensioner Deceased
    else if (isset($_POST['noti_pensioner_deceased'])) {
        $_SESSION['queryNotification'] = "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
        (noti_action = 'Pensioner Deceased' or noti_action = 'Pensioner Deceased Bulk') order by noti_id DESC";
        $_SESSION['queryNotificationButton'] = 'Pensioner Deceased';
        //Reload to Previous Page
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    } 
    // Notification Page Pensioner Rejected
    else if (isset($_POST['noti_pensioner_rejected'])) {
        $_SESSION['queryNotification'] = "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
        (noti_action = 'Pensioner Rejected' or noti_action = 'Pensioner Rejected Bulk') order by noti_id DESC";
        $_SESSION['queryNotificationButton'] = 'Pensioner Rejected';
        //Reload to Previous Page
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    } 
    // // Notification Page Email
    // else if (isset($_POST['noti_email'])) {
    //     $_SESSION['queryNotification'] = "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and noti_action = 'Email' order by noti_id DESC";
    //     $_SESSION['queryNotificationButton'] = 'Email';
    //     //Reload to Previous Page
    //     header('Location: ' . $_SERVER["HTTP_REFERER"] );
    // } 
    // Notification Page Account
    else if (isset($_POST['noti_account'])) {
        $_SESSION['queryNotification'] = "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
        (noti_action = 'Account Create' or noti_action = 'Account Delete' or noti_action = 'Account Super Admin' or noti_action = 'Account Admin' or noti_action = 'Account Staff' or noti_action = 'Account Active' or noti_action = 'Account Inactive'
        or noti_action = 'Account Delete Bulk' or noti_action = 'Account Super Admin Bulk' or noti_action = 'Account Admin Bulk' or noti_action = 'Account Staff Bulk' or noti_action = 'Account Active Bulk' or noti_action = 'Account Inactive Bulk')
        order by noti_id DESC";
        $_SESSION['queryNotificationButton'] = 'Account';
        //Reload to Previous Page
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    }
    // Notification Page Email
    else if (isset($_POST['noti_website'])) {
        $_SESSION['queryNotification'] = "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
        (noti_action = 'Page General' or noti_action = 'Page Mission Vision' or noti_action = 'Page Officials' or noti_action = 'Page Register' or noti_action = 'Page Settings' or noti_action = 'Page Report Deleted'
        or noti_action = 'Page Report Insert Published' or noti_action = 'Page Report Insert Draft' or noti_action = 'Page Report Update Published' or noti_action = 'Page Report Update Draft' or noti_action = 'Page Report Update Trashed') 
        order by noti_id DESC";
        $_SESSION['queryNotificationButton'] = 'Website';
        //Reload to Previous Page
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    } 
    mysqli_close($con);
?>