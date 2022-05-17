<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_POST['pot'] == ''){
            include 'database.php';

            $page = mysqli_fetch_assoc(mysqli_query($con, "SELECT page_email,page_website_title FROM tbl_pages WHERE page_id = 1"));

            ini_set( 'display_errors', 1 );
            error_reporting( E_ALL );

            $name = $_POST['name'];
            $name = trim($name);
            $name = mysqli_real_escape_string($con,$name);

            $from = $_POST['email'];
            $from = trim($from);
            $from = mysqli_real_escape_string($con,$from);

            $to = $page['page_email'];

            $subject = $page['page_website_title']." - Contact Us";
            $message = $_POST['message'];
            $message = trim($message);
            $message = mysqli_real_escape_string($con,$message);
            
            $headers = "From: ".$name.'<'.$from.'>';

            if(mail($to,$subject,$message, $headers)) {
                echo "OK";
            } else {
                echo "The email message was not sent.";
            }
        }
    }
?>