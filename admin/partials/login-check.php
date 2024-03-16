<?php 
    // Authorization or Access Control
    // Check whether the user is logged in or not
    if(!isset($_SESSION['user']))  // if user session is not set
    {
        // User is not logged in
        // Redirect to login page with message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to access Admin Panel.</div>";
        header("location:".SITEURL."admin/login.php");

    }

?>