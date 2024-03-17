<?php
    include("../config/constants.php");


    // Check whether the id and image_name value is set or not
    if (isset($_GET["id"]) && isset($_GET["image_name"]))
    {
        // Get the value and delete
        $id = $_GET["id"];
        $image_name = $_GET["image_name"];

        // Remove the image file if available
        if($image_name != "")
        {
            // First remove the image
            $path = "../images/category/" . $image_name;
            $remove = unlink($path);

            // If failed to remove image then add error message an stop the process
            if($remove == false)
            {
                // Set the session message
                $_SESSION['remove'] = "<div class='error'>FAILED to remove Category Image</div>";
                // Redirect to Manage category page
                header("location:".SITEURL."admin/manage-category.php");
                // Stop the process
                die();
            }
        }

        // Delete the data from database
        $sql = "DELETE FROM tbl_category WHERE id='$id'";

        // Exexute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the data is deleted from database or not
        if($res)
        {
            // Successful
            $_SESSION["delete"] = "<div class='success'>Category DELETED Successfully.</div>";
            // Redirect to manage-category
            header("location:".SITEURL."admin/manage-category.php");
        }
        else
        {
            // Failed to execute query
            $_SESSION["delete"] = "<div class='error'>FAILED to Delete Category.</div>";
            // Redirect to manage-category
            header("location:".SITEURL."admin/manage-category.php");
        }
        // Redirect to manage-category page
        
    }
    else
    {
        // Redirect to manage_category page
        header("location:".SITEURL."admin/manage-category.php");
    }
?>