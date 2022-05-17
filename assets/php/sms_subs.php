<?php
    $response = 0;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_POST['pot'] == ''){
            if (session_status() == PHP_SESSION_NONE){session_start();}
            date_default_timezone_set('Asia/Manila');
            include 'database.php';

            // Full Name
            $lastname = strtolower($_POST['appl_lastname']);
            $lastname = ucfirst($lastname);
            $lastname = trim($lastname);
            $lastname = mysqli_real_escape_string($con,$lastname);

            $firstname = strtolower($_POST['appl_firstname']);
            $firstname = ucfirst($firstname);
            $firstname = trim($firstname);
            $firstname = mysqli_real_escape_string($con,$firstname);
            if($lastname != '' && $firstname != ''){
                // Address
                $houseno = $_POST['appl_houseno'];
                $houseno = ucfirst($houseno);
                $houseno = trim($houseno);
                $houseno = mysqli_real_escape_string($con,$houseno);
                if($houseno != ''){
                    // Birthdate | Birth place | gender
                    $birthdate = $_POST['appl_birthdate'];
                    if(strtotime($birthdate)<strtotime('-60 year')){
                        $birthplace = $_POST['appl_birthplace'];
                        $birthplace = ucfirst($birthplace);
                        $birthplace = trim($birthplace);
                        $birthplace = mysqli_real_escape_string($con,$birthplace);
                        if($birthplace != ''){
                            $prevOccupation = $_POST['appl_prevOccupation'];
                            $prevOccupation = ucfirst($prevOccupation);
                            $prevOccupation = trim($prevOccupation);
                            $prevOccupation = mysqli_real_escape_string($con,$prevOccupation);
                            if($prevOccupation != ''){
                                $middlename = strtolower($_POST['appl_middlename']);
                                $middlename = ucfirst($middlename);
                                $middlename = trim($middlename);
                                $middlename = mysqli_real_escape_string($con,$middlename);

                                $barangay = $_POST['appl_barangay'];

                                $municipality = $_POST['appl_municipality'];

                                $province = $_POST['appl_province'];

                                $gender = $_POST['appl_gender'];

                                // Civil Status | Contact No. | Prev Occupation
                                $civilstatus = $_POST['appl_civilStatus'];

                                // $contactNumber = $_POST['appl_contactNumber'];
                                // $contactNumber = trim($contactNumber);
                                // $contactNumber = mysqli_real_escape_string($con,$contactNumber);

                                $appl_email = $_POST['appl_email'];
                                $appl_email = trim($appl_email);
                                $appl_email = mysqli_real_escape_string($con,$appl_email);

                                // Pensioner implode()explode()
                                $pensioner = '';
                                if (isset($_POST['appl_sss'])) {
                                    $pensioner .= $_POST['appl_sss'] . ",";  
                                }
                                if (isset($_POST['appl_gsis'])) {
                                    $pensioner .= $_POST['appl_gsis'] . ",";  
                                }
                                if (isset($_POST['appl_pvao'])) {
                                    $pensioner .= $_POST['appl_pvao'] . ",";  
                                }
                                if (isset($_POST['appl_fps'])) {
                                    $pensioner .= $_POST['appl_fps'] . ",";  
                                }
                                if (isset($_POST['appl_other'])) {
                                    $appl_other = mysqli_real_escape_string($con,$_POST['appl_other']);
                                    $appl_other = trim($appl_other);
                                    $appl_other = ucfirst($appl_other);
                                    $pensioner .= $appl_other . ", ";  
                                }
                                if ($pensioner == null || $pensioner == '') {
                                    $pensioner = 'None';
                                }
                                $pensioner = rtrim($pensioner, ", ");

                                // Get image name
                                $appl_picture = $_FILES["appl_picture"]["name"];
                                // Divide Filename to the filename and extension
                                $appl_picture_actual_name = pathinfo($appl_picture,PATHINFO_FILENAME);
                                $appl_picture_original_name = $appl_picture_actual_name;
                                $appl_picture_extension = pathinfo($appl_picture, PATHINFO_EXTENSION);
                                // Check if file already exist
                                $count = 1;
                                while (file_exists('../img/applicant_picture/' . $appl_picture)) {
                                    // New filename with number
                                    $appl_picture_actual_name = (string)$appl_picture_original_name."-".$count;
                                    $appl_picture = $appl_picture_actual_name.".".$appl_picture_extension;
                                    $count++;
                                }
                                // Upload image to server
                                if(!move_uploaded_file($_FILES["appl_picture"]["tmp_name"], '../img/applicant_picture_temp/' . $appl_picture)){
                                    // if not uploaded, the default file will be selected
                                    $appl_picture = 'profile.svg';
                                }

                                //Get Proof name
                                $appl_proof = $_FILES["appl_proof"]["name"];
                                // Divide Filename to the filename and extension
                                $appl_proof_actual_name = pathinfo($appl_proof,PATHINFO_FILENAME);
                                $appl_proof_original_name = $appl_proof_actual_name;
                                $appl_proof_extension = pathinfo($appl_proof, PATHINFO_EXTENSION);
                                // Check if file already exist
                                $count = 1;
                                while (file_exists('../img/applicant_proof/' . $appl_proof)) {
                                    // New filename with number
                                    $appl_proof_actual_name = (string)$appl_proof_original_name."-".$count;
                                    $appl_proof = $appl_proof_actual_name.".".$appl_proof_extension;
                                    $count++;
                                }
                                // Upload image to server
                                if(!move_uploaded_file($_FILES["appl_proof"]["tmp_name"], '../img/applicant_proof_temp/' . $appl_proof)){
                                    // if not uploaded, the default file will be selected
                                    $appl_proof = '';
                                }

                                // "contactno"=>"$contactNumber",
                                $_SESSION['appl_data'] = array("lastname"=>"$lastname", "firstname"=>"$firstname", 
                                "middlename"=>"$middlename", "houseno"=>"$houseno", "barangay"=>"$barangay", "municipality"=>"$municipality", 
                                "province"=>"$province", "birthdate"=>"$birthdate", "birthplace"=>"$birthplace", "gender"=>"$gender", 
                                "civilstatus"=>"$civilstatus", "email"=>"$appl_email", "prevOccupation"=>"$prevOccupation", 
                                "appl_picture"=>"$appl_picture", "pensioner"=>"$pensioner", "appl_proof"=>"$appl_proof");
                                
                                $response = 1;
                            }else{
                                $response = 'Previous occupation should not be composed of spaces. Pleass try again.';
                            }
                        }else{
                            $response = 'Place of birth should not be composed of spaces. Pleass try again.';
                        }
                    }else{
                        $response = 'Your birthdate should be at least 60 years from now. Pleass try again.';
                    }
                }else{
                    $response = 'Address should not be composed of spaces. Pleass try again.';
                }
            }else{
                $response = 'Name should not be composed of spaces. Pleass try again.';
            }
            //Close Connection
            mysqli_close($con);
        }else{
            $response = 1;
        }
    }
    echo $response;
?>