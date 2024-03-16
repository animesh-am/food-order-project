<?php

    // Include constants.php
    include("../config/constants.php");

    // Get the id to be deleted
    $id = $_GET["id"];

    // Create SQL query to delete
    $sql = "DELETE from tbl_admin WHERE id=$id";
    
    $res = mysqli_query($conn,$sql);

    // Check whether the query is executed successfully
    if($res){
        // Create session variable to display message
        $_SESSION["delete"] = "<div class='success'>Admin <strong>DELETED</strong> Successfully.</div>";
        // Redirect to the manage-admin page with message (success/error)
        header("location:".SITEURL."admin/manage-admin.php");
    }
    else{
        $_SESSION["delete"] = "<div class='error'><strong>FAILED</strong> to delete Admin. Try after some time.</div>";
        header("location:".SITEURL."admin/manage-admin.php");
    }

    

?>