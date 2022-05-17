<?php 
    if($_POST["action"] == 'countryDetails'){
        include '../../../assets/php/database.php';
        if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS']==='on'){ $server_name="https://".$_SERVER['SERVER_NAME'];}else{ $server_name="http://".$_SERVER['SERVER_NAME'];}
        $parse = parse_url($server_name);
        $server_name = preg_replace('#^www\.(.+\.)#i', '$1', $parse['host']);

        $data = array();
        $region = $_POST['region'];

        $query_all = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_country = "'.$region.'"');
        $numrow_all = mysqli_num_rows($query_all);

        $query_organic = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_country = "'.$region.'"');
        $numrow_organic = mysqli_num_rows($query_organic);

        $query_referral = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%") AND vis_country = "'.$region.'"');
        $numrow_referral = mysqli_num_rows($query_referral);

        $query = mysqli_query($con, 'SELECT vis_date FROM tbl_visitor WHERE vis_country = "'.$region.'" GROUP BY YEAR(vis_date)');
        $numrow = mysqli_num_rows($query);

        if($numrow == 1){
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
                $query_all = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_date >= "'.$from.'" AND vis_date < "'.$to.'" AND vis_country = "'.$region.'"');
                $numrow_all = mysqli_num_rows($query_all);

                $query_organic = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'" AND vis_country = "'.$region.'"');
                $numrow_organic = mysqli_num_rows($query_organic);

                $query_referral = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'" AND vis_country = "'.$region.'"');
                $numrow_referral = mysqli_num_rows($query_referral);

                $data[] =array(
                    'label'                 =>  $month, 
                    'all'	                =>	$numrow_all,
                    'organic'	            =>	$numrow_organic,
                    'referral'              =>	$numrow_referral,
                    'region_total_views'    =>  $numrow_all, 
                    'region_organic_views'	=>	$numrow_organic,
                    'region_referral_views' =>	$numrow_referral,
                );
            }
        }else{
            while($years = mysqli_fetch_assoc($query)){
                $year = date('Y', strtotime($years['vis_date']));
                $from = date($year.'-01-01 00:00:00');
                $to = ($year+1).'-01-01 00:00:00';

                $query_all = mysqli_query($con, 'SELECT vis_id FROM tbl_visitor WHERE vis_date >= "'.$from.'" AND vis_date < "'.$to.'" AND vis_country = "'.$region.'"');
                $numrow_all = mysqli_num_rows($query_all);

                $query_organic = mysqli_query($con, 'SELECT vis_id FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'" AND vis_country = "'.$region.'"');
                $numrow_organic = mysqli_num_rows($query_organic);

                $query_referral = mysqli_query($con, 'SELECT vis_id FROM tbl_visitor WHERE (vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'" AND vis_country = "'.$region.'"');
                $numrow_referral = mysqli_num_rows($query_referral);

                $data[] = array(
                    'label'                 =>  $year, 
                    'all'	                =>	$numrow_all,
                    'organic'	            =>	$numrow_organic,
                    'referral'              =>	$numrow_referral,
                    'region_total_views'    =>  $numrow_all, 
                    'region_organic_views'	=>	$numrow_organic,
                    'region_referral_views' =>	$numrow_referral,
                );
            }
        }

        echo json_encode($data);
    }else if($_POST["action"] == 'labelshow'){
        include '../../../assets/php/database.php';
        $region = $_POST['region'];

        $query_all = mysqli_query($con, "SELECT vis_id FROM tbl_visitor");
        $numrows_all = mysqli_num_rows($query_all);

        $query_specific = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_country = "'.$region.'"');
        $numrows_specific = mysqli_num_rows($query_specific);

        $percentage = round(($numrows_specific / $numrows_all) * 100, 2);

        echo '<h5><b>' . $region . '</b></h5>
            <h6><b>View count:</b></h6>
            <h6>' . $numrows_specific . '/' . $numrows_all . '</h6>
            <h6><b>Percentage:</b></h6><h6>' . $percentage . '%</h6>';
    }else if($_POST["action"] == 'unknown'){
        include '../../../assets/php/database.php';
        if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS']==='on'){ $server_name="https://".$_SERVER['SERVER_NAME'];}else{ $server_name="http://".$_SERVER['SERVER_NAME'];}
        $parse = parse_url($server_name);
        $server_name = preg_replace('#^www\.(.+\.)#i', '$1', $parse['host']);

        $data = array();

        $query_all = mysqli_query($con, "SELECT vis_id FROM tbl_visitor");
        $numrows_all = mysqli_num_rows($query_all);

        $query_specific = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_country = ""');
        $numrows_specific = mysqli_num_rows($query_specific);
        
        $organic_query = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%"');
        $organic_numrows = mysqli_num_rows($organic_query);
        $organic_percentage = round(($organic_numrows / $numrows_all) * 100, 2);

        $referrals_query = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%"');
        $referrals_numrows = mysqli_num_rows($referrals_query);
        $referrals_percentage = round(($referrals_numrows / $numrows_all) * 100, 2);

        $percentage = round(($numrows_specific / $numrows_all) * 100, 2);

        $data['unknown'] = "<i class='fas fa-user-secret'></i> Unknown Visits Count: ".$numrows_specific."/".$numrows_all." | ".$percentage."%";
        $data['total_views'] = $numrows_all;
        $data['specific_views'] = $numrows_specific;
        $data['percentage'] = $percentage.'%';
        $data['organic_total'] = $organic_numrows;
        $data['organic_percentage'] = $organic_percentage;
        $data['referrals_total'] = $referrals_numrows;
        $data['referrals_percentage'] = $referrals_percentage;

        echo json_encode($data);
    }else if($_POST["action"] == 'doughnut'){
        include '../../../assets/php/database.php';
        $data = array();
        $count = 1;
        $query = mysqli_query($con, "SELECT DISTINCT vis_browser_name,COUNT(vis_browser_name) AS vis_count FROM tbl_visitor GROUP BY vis_browser_name ORDER BY vis_count DESC");
        $total = mysqli_num_rows(mysqli_query($con, "SELECT vis_browser_name FROM tbl_visitor"));
        while($browser_name = mysqli_fetch_assoc($query)){
            if($count==1){$color='rgb(255, 99, 132)';}
            else if($count==2){$color='rgb(54, 162, 235)';}
            else if($count==3){$color='rgb(72, 184, 184)';}
            else if($count==4){$color='rgb(255, 205, 86)';}
            else if($count==5){$color='rgb(153, 102, 255)';}
            else if($count==6){$color='rgb(255, 159, 64)';}
            else{$color='rgb('.rand(1, 255).','.rand(1, 255).','.rand(1, 255).')';}
            $count++;
            $totalviews = mysqli_num_rows(mysqli_query($con, "SELECT vis_browser_name FROM tbl_visitor WHERE vis_browser_name = '".$browser_name['vis_browser_name']."'"));
            $percentage = round(($totalviews / $total) * 100, 2);
            $data[] = array(
                'browser_name'	    =>  $browser_name['vis_browser_name'],
                'totalviews'	    =>	$totalviews,
                'backgroundColor'   =>	$color,
                'percentage'        =>  $percentage.'%'
            );
        }
        echo json_encode($data);
    }else if($_POST["action"] == 'line'){
        include '../../../assets/php/database.php';
        if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS']==='on'){ $server_name="https://".$_SERVER['SERVER_NAME'];}else{ $server_name="http://".$_SERVER['SERVER_NAME'];}
        $parse = parse_url($server_name);
        $server_name = preg_replace('#^www\.(.+\.)#i', '$1', $parse['host']);

        $data = array();

        function yearly(){
            include '../../../assets/php/database.php';
            if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS']==='on'){ $server_name="https://".$_SERVER['SERVER_NAME'];}else{ $server_name="http://".$_SERVER['SERVER_NAME'];}
            $parse = parse_url($server_name);
            $server_name = preg_replace('#^www\.(.+\.)#i', '$1', $parse['host']);
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
                $query_all = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_all = mysqli_num_rows($query_all);

                $query_organic = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_organic = mysqli_num_rows($query_organic);

                $query_referral = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_referral = mysqli_num_rows($query_referral);

                $data[] =array(
                    'label'     =>  $month, 
                    'all'	    =>	$numrow_all,
                    'organic'	=>	$numrow_organic,
                    'referral'  =>	$numrow_referral
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
                
                $query_all = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_all = mysqli_num_rows($query_all);

                $query_organic = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_organic = mysqli_num_rows($query_organic);

                $query_referral = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_referral = mysqli_num_rows($query_referral);

                $data[] = array(
                    'label'	    =>  $hour,
                    'all'	    =>	$numrow_all,
                    'organic'	=>	$numrow_organic,
                    'referral'=>	$numrow_referral
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

                $query_all = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_all = mysqli_num_rows($query_all);

                $query_organic = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_organic = mysqli_num_rows($query_organic);

                $query_referral = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_referral = mysqli_num_rows($query_referral);

                $data[] = array(
                    'label'	    =>  $day,
                    'all'	    =>	$numrow_all,
                    'organic'	=>	$numrow_organic,
                    'referral'  =>	$numrow_referral
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

                $query_all = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_all = mysqli_num_rows($query_all);

                $query_organic = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_organic = mysqli_num_rows($query_organic);

                $query_referral = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_referral = mysqli_num_rows($query_referral);

                $data[] =array(
                    'label'     =>  $day, 
                    'all'	    =>	$numrow_all,
                    'organic'	=>	$numrow_organic,
                    'referral'  =>	$numrow_referral
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
                $query_all = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_all = mysqli_num_rows($query_all);

                $query_organic = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_organic = mysqli_num_rows($query_organic);

                $query_referral = mysqli_query($con, 'SELECT * FROM tbl_visitor WHERE (vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                $numrow_referral = mysqli_num_rows($query_referral);

                $data[] =array(
                    'label'     =>  $quarter, 
                    'all'	    =>	$numrow_all,
                    'organic'	=>	$numrow_organic,
                    'referral'  =>	$numrow_referral
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

                    $query_all = mysqli_query($con, 'SELECT vis_id FROM tbl_visitor WHERE vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                    $numrow_all = mysqli_num_rows($query_all);

                    $query_organic = mysqli_query($con, 'SELECT vis_id FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                    $numrow_organic = mysqli_num_rows($query_organic);

                    $query_referral = mysqli_query($con, 'SELECT vis_id FROM tbl_visitor WHERE (vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%") AND vis_date >= "'.$from.'" AND vis_date < "'.$to.'"');
                    $numrow_referral = mysqli_num_rows($query_referral);

                    $data[] =array(
                        'label'     =>  $year, 
                        'all'	    =>	$numrow_all,
                        'organic'	=>	$numrow_organic,
                        'referral'  =>	$numrow_referral
                    );
                }
            }
        }

        echo json_encode($data);
    }else if($_POST["action"] == 'horizontalLineDevice'){
        include '../../../assets/php/database.php';
        $data = array();
        $count = 1;
        $query = mysqli_query($con, "SELECT DISTINCT vis_device,COUNT(vis_id) AS dev_count FROM tbl_visitor GROUP BY vis_device ORDER BY dev_count DESC");
        while($vis = mysqli_fetch_assoc($query)){
            if($count==1){$color='rgb(255, 99, 132)';}
            else if($count==2){$color='rgb(54, 162, 235)';}
            else if($count==3){$color='rgb(72, 184, 184)';}
            else if($count==4){$color='rgb(255, 205, 86)';}
            else if($count==5){$color='rgb(153, 102, 255)';}
            else if($count==6){$color='rgb(255, 159, 64)';}
            else{$color='rgb('.rand(1, 255).','.rand(1, 255).','.rand(1, 255).')';}
            $count += 1;
            $data[] = array(
                'label'	    =>  $vis['vis_device'],
                'total'	    =>	$vis['dev_count'],
                'color'     =>  $color
            );
        }
        echo json_encode($data);
    }else if($_POST["action"] == 'horizontalLinePlatform'){
        include '../../../assets/php/database.php';
        $data = array();
        $count = 1;
        $query = mysqli_query($con, "SELECT DISTINCT vis_platform,COUNT(vis_id) AS dev_count FROM tbl_visitor GROUP BY vis_platform ORDER BY dev_count DESC");
        while($vis = mysqli_fetch_assoc($query)){
            if($count==1){$color='rgb(255, 99, 132)';}
            else if($count==2){$color='rgb(54, 162, 235)';}
            else if($count==3){$color='rgb(72, 184, 184)';}
            else if($count==4){$color='rgb(255, 205, 86)';}
            else if($count==5){$color='rgb(153, 102, 255)';}
            else if($count==6){$color='rgb(255, 159, 64)';}
            else{$color='rgb('.rand(1, 255).','.rand(1, 255).','.rand(1, 255).')';}
            $count += 1;
            $data[] = array(
                'label'	    =>  $vis['vis_platform'],
                'total'	    =>	$vis['dev_count'],
                'color'     =>  $color
            );
        }
        echo json_encode($data);
    }else if($_POST["action"] == 'smsSpent'){
        include '../../../assets/php/database.php';
        $data = array();
        $query = mysqli_query($con, 'SELECT YEAR(sms_date) FROM tbl_sms GROUP BY YEAR(sms_date)');
        $numrow = mysqli_num_rows($query);
        if($numrow == 1){
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
                $query_all = mysqli_query($con, 'SELECT SUM(sms_receiver_total) as sum FROM tbl_sms WHERE sms_date >= "'.$from.'" AND sms_date < "'.$to.'"');
                $fetch = mysqli_fetch_assoc($query_all);

                $data[] =array(
                    'label'     =>  $month, 
                    'data'	    =>	$fetch['sum']*0.5,
                );
            }
        }else{
            while($years = mysqli_fetch_assoc($query)){
                $year = date('Y', strtotime($years['sms_date']));
                $from = date($year.'-01-01 00:00:00');
                $to = ($year+1).'-01-01 00:00:00';

                $query_all = mysqli_query($con, 'SELECT SUM(sms_receiver_total) as sum FROM tbl_sms WHERE sms_date >= "'.$from.'" AND sms_date < "'.$to.'"');
                $fetch = mysqli_fetch_assoc($query_all);

                $data[] =array(
                    'label'     =>  $year, 
                    'data'	    =>	$fetch['sum']*0.5,
                );
            }
        }

        echo json_encode($data);
    }
?>