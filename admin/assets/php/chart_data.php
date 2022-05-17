<?php
    if($_POST["action"] == 'fetch'){
        include '../../../assets/php/database.php';
        $data = array();
        $count = 1;
        if($_POST['status'] == 'municipality'){
            $page = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_barangay FROM tbl_pages"));
            $barangay =  explode(',',$page['page_barangay']); 
            foreach($barangay as $barangay){
                if($count==1){$color='rgb(255, 99, 132)';}
                else if($count==2){$color='rgb(54, 162, 235)';}
                else if($count==3){$color='rgb(72, 184, 184)';}
                else if($count==4){$color='rgb(255, 205, 86)';}
                else if($count==5){$color='rgb(153, 102, 255)';}
                else if($count==6){$color='rgb(255, 159, 64)';}
                else{$color='rgb('.rand(1, 255).','.rand(1, 255).','.rand(1, 255).')';}
                $count += 1;
                $active_total = mysqli_num_rows(mysqli_query($con, "SELECT appl_barangay FROM tbl_applicants WHERE appl_status = 'Active' AND appl_barangay = '$barangay';"));
                $deceased_total = mysqli_num_rows(mysqli_query($con, "SELECT appl_barangay FROM tbl_applicants WHERE appl_status = 'Deceased' AND appl_barangay = '$barangay';"));
                $data[] = array(
                    'barangay'	        =>  $barangay,
                    'totalactive'	    =>	$active_total,
                    'totaldeceased'	    =>	$deceased_total,
                    'backgroundColor'   =>	$color,
                    'borderColor'       =>	$color,
                );
            }
            $sort = array_column($data, 'totalactive');
            array_multisort($sort, SORT_DESC, $data);

            echo json_encode($data);
        }else if($_POST['status'] == 'gender'){
            $genders =  "Male,Female";
            $gender =  explode(',',$genders); 
            foreach($gender as $gender){
                if($count==1){$color='rgb(255, 99, 132)';}
                else if($count==2){$color='rgb(54, 162, 235)';}
                else if($count==3){$color='rgb(72, 184, 184)';}
                else if($count==4){$color='rgb(255, 205, 86)';}
                else if($count==5){$color='rgb(153, 102, 255)';}
                else if($count==6){$color='rgb(255, 159, 64)';}
                else{$color='rgb('.rand(1, 255).','.rand(1, 255).','.rand(1, 255).')';}
                $count += 1;
                $active_total = mysqli_num_rows(mysqli_query($con, "SELECT appl_gender FROM tbl_applicants WHERE appl_status = 'Active' AND appl_gender = '".$gender."';"));
                $data[] = array(
                    'gender'	        =>  $gender,
                    'total'		        =>	$active_total,
                    'backgroundColor'   =>	$color,
                    'borderColor'       =>	$color,
                );
            }
            $sort = array_column($data, 'total');
            array_multisort($sort, SORT_DESC, $data);

            echo json_encode($data);
        }else if($_POST['status'] == 'civilstatus'){
            $civilstatus =  "Single,Married,Divorced,Separated,Widowed";
            $civilstatus =  explode(',',$civilstatus); 
            foreach($civilstatus as $civilstatus){
                if($count==1){$color='rgb(255, 99, 132)';}
                else if($count==2){$color='rgb(54, 162, 235)';}
                else if($count==3){$color='rgb(72, 184, 184)';}
                else if($count==4){$color='rgb(255, 205, 86)';}
                else if($count==5){$color='rgb(153, 102, 255)';}
                else if($count==6){$color='rgb(255, 159, 64)';}
                else{$color='rgb('.rand(1, 255).','.rand(1, 255).','.rand(1, 255).')';}
                $count += 1;
                $active_total = mysqli_num_rows(mysqli_query($con, "SELECT appl_gender FROM tbl_applicants WHERE appl_status = 'Active' AND appl_civilstatus = '".$civilstatus."';"));
                $data[] = array(
                    'civilstatus'	    =>  $civilstatus,
                    'total'		        =>	$active_total,
                    'backgroundColor'   =>	$color,
                    'borderColor'       =>	$color,
                );
            }
            $sort = array_column($data, 'total');
            array_multisort($sort, SORT_DESC, $data);

            echo json_encode($data);
        }else if($_POST['status'] == 'applicant'){
            include '../../../assets/php/database.php';

            $data = array();

            function yearly(){
                include '../../../assets/php/database.php';
                $data = array();

                $months = 'January,February,March,April,May,June,July,August,September,October,November,December';
                $month =  explode(',',$months); 
                foreach($month as $month){
                    if($month == 'January') {
                        $from = date('Y-01-01 00:00:00');
                        $to = date('Y-02-01 00:00:00');
                    }else if($month == 'February') {
                        $from = date('Y-02-01 00:00:00');
                        $to = date('Y-03-01 00:00:00');
                    }else if($month == 'March') {
                        $from = date('Y-03-01 00:00:00');
                        $to = date('Y-04-01 00:00:00');
                    }else if($month == 'April') {
                        $from = date('Y-04-01 00:00:00');
                        $to = date('Y-05-01 00:00:00');
                    }else if($month == 'May') {
                        $from = date('Y-05-01 00:00:00');
                        $to = date('Y-06-01 00:00:00');
                    }else if($month == 'June') {
                        $from = date('Y-06-01 00:00:00');
                        $to = date('Y-07-01 00:00:00');
                    }else if($month == 'July') {
                        $from = date('Y-07-01 00:00:00');
                        $to = date('Y-08-01 00:00:00');
                    }else if($month == 'August') {
                        $from = date('Y-08-01 00:00:00');
                        $to = date('Y-09-01 00:00:00');
                    }else if($month == 'September') {
                        $from = date('Y-09-01 00:00:00');
                        $to = date('Y-10-01 00:00:00');
                    }else if($month == 'October') {
                        $from = date('Y-10-01 00:00:00');
                        $to = date('Y-11-01 00:00:00');
                    }else if($month == 'November') {
                        $from = date('Y-11-01 00:00:00');
                        $to = date('Y-12-01 00:00:00');
                    }else if($month == 'December'){
                        $from = date('Y-12-01 00:00:00');
                        $to = (date('Y')+1).'-01-01 00:00:00';
                    } 
                    $query_applicant = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_datesubmitted >= "'.$from.'" AND appl_datesubmitted < "'.$to.'"');
                    $numrow_applicant = mysqli_num_rows($query_applicant);

                    $query_accepted = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Active" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                    $numrow_accepted = mysqli_num_rows($query_accepted);

                    $query_rejected = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Rejected" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                    $numrow_rejected = mysqli_num_rows($query_rejected);

                    $data[] = array(
                        'label'	    =>  $month,
                        'applicant' =>	$numrow_applicant,
                        'accepted'	=>	$numrow_accepted,
                        'rejected'  =>	$numrow_rejected
                    );
                }
                return $data;
            }

            if($_POST['day'] == 'Today'){
                $hours = '1am,2am,3am,4am,5am,6am,7am,8am,9am,10am,11am,12am,1pm,2pm,3pm,4pm,5pm,6pm,7pm,8pm,9pm,1pm,11pm,12pm';
                $hour =  explode(',',$hours); 
                foreach($hour as $hour){
                    if($hour == '1am'){$from = date('Y-m-d').' 00:00:00'; $to = date('Y-m-d').' 01:00:00';}
                    else if($hour == '2am'){$from = date('Y-m-d').' 01:00:01'; $to = date('Y-m-d').' 02:00:00';}
                    else if($hour == '3am'){$from = date('Y-m-d').' 02:00:01'; $to = date('Y-m-d').' 03:00:00';}
                    else if($hour == '4am'){$from = date('Y-m-d').' 03:00:01'; $to = date('Y-m-d').' 04:00:00';}
                    else if($hour == '5am'){$from = date('Y-m-d').' 04:00:01'; $to = date('Y-m-d').' 05:00:00';}
                    else if($hour == '6am'){$from = date('Y-m-d').' 05:00:01'; $to = date('Y-m-d').' 06:00:00';}
                    else if($hour == '7am'){$from = date('Y-m-d').' 06:00:01'; $to = date('Y-m-d').' 07:00:00';}
                    else if($hour == '8am'){$from = date('Y-m-d').' 07:00:01'; $to = date('Y-m-d').' 08:00:00';}
                    else if($hour == '9am'){$from = date('Y-m-d').' 08:00:01'; $to = date('Y-m-d').' 09:00:00';}
                    else if($hour == '10am'){$from = date('Y-m-d').' 09:00:01'; $to = date('Y-m-d').' 10:00:00';}
                    else if($hour == '11am'){$from = date('Y-m-d').' 10:00:01'; $to = date('Y-m-d').' 11:00:00';}
                    else if($hour == '12am'){$from = date('Y-m-d').' 11:00:01'; $to = date('Y-m-d').' 12:00:00';}
                    else if($hour == '1pm'){$from = date('Y-m-d').' 12:00:01'; $to = date('Y-m-d').' 13:00:00';}
                    else if($hour == '2pm'){$from = date('Y-m-d').' 13:00:01'; $to = date('Y-m-d').' 14:00:00';}
                    else if($hour == '3pm'){$from = date('Y-m-d').' 13:00:01'; $to = date('Y-m-d').' 15:00:00';}
                    else if($hour == '4pm'){$from = date('Y-m-d').' 14:00:01'; $to = date('Y-m-d').' 16:00:00';}
                    else if($hour == '5pm'){$from = date('Y-m-d').' 15:00:01'; $to = date('Y-m-d').' 17:00:00';}
                    else if($hour == '6pm'){$from = date('Y-m-d').' 16:00:01'; $to = date('Y-m-d').' 18:00:00';}
                    else if($hour == '7pm'){$from = date('Y-m-d').' 17:00:01'; $to = date('Y-m-d').' 19:00:00';}
                    else if($hour == '8pm'){$from = date('Y-m-d').' 19:00:01'; $to = date('Y-m-d').' 20:00:00';}
                    else if($hour == '9pm'){$from = date('Y-m-d').' 20:00:01'; $to = date('Y-m-d').' 21:00:00';}
                    else if($hour == '10pm'){$from = date('Y-m-d').' 21:00:01'; $to = date('Y-m-d').' 22:00:00';}
                    else if($hour == '11pm'){$from = date('Y-m-d').' 22:00:01'; $to = date('Y-m-d').' 23:00:00';}
                    else if($hour == '12pm'){$from = date('Y-m-d').' 23:00:01'; $to = date('Y-m-d 00:00:00', strtotime(date('Y-m-d 00:00:00') . ' +1 day'));}
                    
                    $query_applicant = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_datesubmitted >= "'.$from.'" AND appl_datesubmitted < "'.$to.'"');
                    $numrow_applicant = mysqli_num_rows($query_applicant);

                    $query_accepted = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Active" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                    $numrow_accepted = mysqli_num_rows($query_accepted);

                    $query_rejected = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Rejected" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                    $numrow_rejected = mysqli_num_rows($query_rejected);

                    $data[] = array(
                        'label'	    =>  $hour,
                        'applicant' =>	$numrow_applicant,
                        'accepted'	=>	$numrow_accepted,
                        'rejected'  =>	$numrow_rejected
                    );
                }
            } else if($_POST['day'] == 'Weekly'){
                $days = 'Monday,Teusday,Wednesday,Thursday,Friday,Saturday,Sunday';
                $day =  explode(',',$days); 
                
                foreach($day as $day){
                    $dto = new DateTime();
                    $dto->setISODate(date('Y'), date("W", strtotime(date('Y-m-d H:i:s'))));
                    if($day == 'Monday'){
                        $from = $dto->format('Y-m-d 00:00:00');
                        $dto->modify('+1 days');
                        $to = $dto->format('Y-m-d 00:00:00');
                    }else if($day == 'Teusday'){
                        $dto->modify('+1 days');
                        $from = $dto->format('Y-m-d 00:00:00');
                        $dto->modify('+2 days');
                        $to = $dto->format('Y-m-d 00:00:00');
                    }else if($day == 'Wednesday'){
                        $dto->modify('+2 days');
                        $from = $dto->format('Y-m-d 00:00:00');
                        $dto->modify('+3 days');
                        $to = $dto->format('Y-m-d 00:00:00');
                    }else if($day == 'Thursday'){
                        $dto->modify('+3 days');
                        $from = $dto->format('Y-m-d 00:00:00');
                        $dto->modify('+4 days');
                        $to = $dto->format('Y-m-d 00:00:00');
                    }else if($day == 'Friday'){
                        $dto->modify('+4 days');
                        $from = $dto->format('Y-m-d 00:00:00');
                        $dto->modify('+5 days');
                        $to = $dto->format('Y-m-d 00:00:00');
                    }else if($day == 'Saturday'){
                        $dto->modify('+5 days');
                        $from = $dto->format('Y-m-d 00:00:00');
                        $dto->modify('+6 days');
                        $to = $dto->format('Y-m-d 00:00:00');
                    }else if($day == 'Sunday'){
                        $dto->modify('+6 days');
                        $from = $dto->format('Y-m-d 00:00:00');
                        $dto->modify('+7 days');
                        $to = $dto->format('Y-m-d 00:00:00');
                    }

                    $query_applicant = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_datesubmitted >= "'.$from.'" AND appl_datesubmitted < "'.$to.'"');
                    $numrow_applicant = mysqli_num_rows($query_applicant);

                    $query_accepted = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Active" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                    $numrow_accepted = mysqli_num_rows($query_accepted);

                    $query_rejected = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Rejected" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                    $numrow_rejected = mysqli_num_rows($query_rejected);

                    $data[] = array(
                        'label'	    =>  $day,
                        'applicant' =>	$numrow_applicant,
                        'accepted'	=>	$numrow_accepted,
                        'rejected'  =>	$numrow_rejected
                    );
                }
            } else if($_POST['day'] == 'Monthly'){
                $info = cal_info(CAL_GREGORIAN );
                $days = '';
                for($ctr = 1; $ctr <= $info['maxdaysinmonth'];  $ctr++){
                    if($ctr==1){ $days .=$ctr;}
                    else{ $days .=','.$ctr;}
                }
                $day =  explode(',',$days); 
                foreach($day as $day){
                    $from = date("Y-m-".$day." 00:00:00");
                    $to = date('Y-m-d 00:00:00', strtotime(date('Y-m-'.$day.' 00:00:00') . ' +1 day'));

                    $query_applicant = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_datesubmitted >= "'.$from.'" AND appl_datesubmitted < "'.$to.'"');
                    $numrow_applicant = mysqli_num_rows($query_applicant);

                    $query_accepted = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Active" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                    $numrow_accepted = mysqli_num_rows($query_accepted);

                    $query_rejected = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Rejected" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                    $numrow_rejected = mysqli_num_rows($query_rejected);

                    $data[] = array(
                        'label'	    =>  $day,
                        'applicant' =>	$numrow_applicant,
                        'accepted'	=>	$numrow_accepted,
                        'rejected'  =>	$numrow_rejected
                    );
                }
            } else if($_POST['day'] == 'Quarterly'){
                $quarters = '1stQuarter,2ndQuarter,3rdQuarter,4thQuarter';
                $quarter =  explode(',',$quarters); 
                foreach($quarter as $quarter){
                    if($quarter == '1stQuarter') {
                        $from = date('Y-01-01 00:00:00');
                        $to = date('Y-04-01 00:00:00');
                    }else if($quarter == '2ndQuarter') {
                        $from = date('Y-04-01 00:00:00');
                        $to = date('Y-07-01 00:00:00');
                    }else if($quarter == '3rdQuarter') {
                        $from = date('Y-07-01 00:00:00');
                        $to = date('Y-10-01 00:00:00');
                    }else if($quarter == '4thQuarter'){
                        $from = date('Y-10-01 00:00:00');
                        $to = (date('Y')+1).'-01-01 00:00:00';
                    } 
                    $query_applicant = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_datesubmitted >= "'.$from.'" AND appl_datesubmitted < "'.$to.'"');
                    $numrow_applicant = mysqli_num_rows($query_applicant);

                    $query_accepted = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Active" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                    $numrow_accepted = mysqli_num_rows($query_accepted);

                    $query_rejected = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Rejected" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                    $numrow_rejected = mysqli_num_rows($query_rejected);

                    $data[] = array(
                        'label'	    =>  $quarter,
                        'applicant' =>	$numrow_applicant,
                        'accepted'	=>	$numrow_accepted,
                        'rejected'  =>	$numrow_rejected
                    );
                }
            } else if($_POST['day'] == 'Yearly'){
                $data = yearly();
            } else if($_POST['day'] == 'All'){
                $query = mysqli_query($con, 'SELECT vis_date FROM tbl_visitor GROUP BY YEAR(vis_date)');
                $numrow = mysqli_num_rows($query);
                if($numrow == 1){
                    $data = yearly();
                }else{
                    while($years = mysqli_fetch_assoc($query)){
                        $year = date('Y', strtotime($years['vis_date']));
                        $from = date($year.'-01-01 00:00:00');
                        $to = ($year+1).'-01-01 00:00:00';

                        $query_applicant = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_datesubmitted >= "'.$from.'" AND appl_datesubmitted < "'.$to.'"');
                        $numrow_applicant = mysqli_num_rows($query_applicant);

                        $query_accepted = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Active" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                        $numrow_accepted = mysqli_num_rows($query_accepted);

                        $query_rejected = mysqli_query($con, 'SELECT * FROM tbl_applicants WHERE appl_status = "Rejected" AND appl_date_accept_reject >= "'.$from.'" AND appl_date_accept_reject < "'.$to.'"');
                        $numrow_rejected = mysqli_num_rows($query_rejected);

                        $data[] = array(
                            'label'	    =>  $year,
                            'applicant' =>	$numrow_applicant,
                            'accepted'	=>	$numrow_accepted,
                            'rejected'  =>	$numrow_rejected
                        );
                    }
                }
            }

            echo json_encode($data);
        }else if($_POST['status'] == 'applicantsPie'){
            $total = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants'));
            $applicants = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants WHERE appl_status = "Applicant"'));
            $active = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants WHERE appl_status = "Active"'));
            $deceased = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants WHERE appl_status = "Deceased"'));
            $rejected = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants WHERE appl_status = "Rejected"'));
            $deleted = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants WHERE appl_status = "Deleted"'));

            $data[] = array(
                'label' =>  "Applicant",
                'color'	=>  "rgb(63, 103, 145)",
                'data'  =>  $applicants,
            );
            $data[] = array(
                'label' =>  "Active",
                'color'	=>  "rgb(0, 188, 140)",
                'data'  =>  $active,
            );
            $data[] = array(
                'label' =>  "Deceased",
                'color'	=>  "rgb(243, 156, 18)",
                'data'  =>  $deceased,
            );
            $data[] = array(
                'label' =>  "Rejected",
                'color'	=>  "rgb(231, 76, 60)",
                'data'  =>  $rejected,
            );
            $data[] = array(
                'label' =>  "Deleted",
                'color'	=>  "rgb(248, 249, 250)",
                'data'  =>  $deleted,
            );

            echo json_encode($data);
        }else if($_POST['status'] == 'pension'){
            $page = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_barangay FROM tbl_pages"));
            $barangay =  explode(',',$page['page_barangay']); 
            foreach($barangay as $barangay){
                if($count==1){$color='rgb(255, 99, 132)';}
                else if($count==2){$color='rgb(54, 162, 235)';}
                else if($count==3){$color='rgb(72, 184, 184)';}
                else if($count==4){$color='rgb(255, 205, 86)';}
                else if($count==5){$color='rgb(153, 102, 255)';}
                else if($count==6){$color='rgb(255, 159, 64)';}
                else{$color='rgb('.rand(1, 255).','.rand(1, 255).','.rand(1, 255).')';}
                $count += 1;
                $fetch = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(appl_pension_recieved) AS appl_sum FROM tbl_applicants WHERE appl_barangay = '$barangay';"));
                $data[] = array(
                    'barangay'  =>  $barangay,
                    'sum'	    =>	$fetch['appl_sum'],
                    'color'     =>	$color,
                );
            }
            $sort = array_column($data, 'sum');
            array_multisort($sort, SORT_DESC, $data);

            echo json_encode($data);
        }else if($_POST['status'] == 'expense'){
            $page = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_barangay FROM tbl_pages"));
            $barangay =  explode(',',$page['page_barangay']); 
            foreach($barangay as $barangay){
                if($count==1){$color='rgb(255, 99, 132)';}
                else if($count==2){$color='rgb(54, 162, 235)';}
                else if($count==3){$color='rgb(72, 184, 184)';}
                else if($count==4){$color='rgb(255, 205, 86)';}
                else if($count==5){$color='rgb(153, 102, 255)';}
                else if($count==6){$color='rgb(255, 159, 64)';}
                else{$color='rgb('.rand(1, 255).','.rand(1, 255).','.rand(1, 255).')';}
                $count += 1;

                $fetch = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(tbl_purchases.pur_amount) AS pur_amount_sum 
                    FROM tbl_accounts, tbl_purchases, tbl_applicants
                    WHERE tbl_accounts.acc_id = tbl_purchases.acc_id AND tbl_applicants.appl_id = tbl_accounts.acc_appl_id AND tbl_applicants.appl_barangay = '$barangay';"
                ));

                $data[] = array(
                    'barangay'  =>  $barangay,
                    'sum'	    =>	$fetch['pur_amount_sum'],
                    'color'     =>	$color,
                );
            }
            $sort = array_column($data, 'sum');
            array_multisort($sort, SORT_DESC, $data);

            echo json_encode($data);
        }
    }
?>