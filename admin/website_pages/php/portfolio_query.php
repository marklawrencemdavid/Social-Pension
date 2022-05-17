<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include '../../../assets/php/database.php';
        if (session_status() == PHP_SESSION_NONE){session_start();}
        // Published
        if (isset($_POST['view_portfolio_published'])) {
            unset($_SESSION['queryPortfolios']);
            unset($_SESSION['queryPortfoliosButton']);
        // Drafts
        }else if (isset($_POST['view_portfolio_drafts'])) {
            $_SESSION['queryPortfolios'] = "SELECT * from tbl_portfolios where port_status = 'Draft' order by port_id ASC";
            $_SESSION['queryPortfoliosButton'] = 'Draft';
        // Trash
        }else if (isset($_POST['view_portfolio_trash'])) {
            $_SESSION['queryPortfolios'] = "SELECT * from tbl_portfolios where port_status = 'Trashed' order by port_id ASC";
            $_SESSION['queryPortfoliosButton'] = 'Trashed';
        }
        //Close Connection
        mysqli_close($con);
    }
    //Reload to Previous Page
    header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>