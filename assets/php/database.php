<?php
    // Enter Host, username, password, name.
    $con = mysqli_connect("localhost","root","","db_socialpension");
    // $con = mysqli_connect("localhost","u881221189_socialpension","ElitC4p5ton3","u881221189_socialpension");
    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    date_default_timezone_set('Asia/Manila');
?>