<?php
    // Include constants.php
    include("../config/constants.php");

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        // Delete the food
        // Get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];
        
        // Remove the image if available
        if($image_name != "")
        {
            $path = "../images/food/".$image_name; // path for image location

            // Remove image from folder
            $remove = unlink($path);

            if($remove == false)  // check if image is removed or not
            {
                // Failed to remove image from folder
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image.</div>";
                // Redirect to manage food
                header("location:".SITEURL."admin/manage-food.php");
                // Stop the process
                die();
            }
        }

        // Delete food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        $res = mysqli_query($conn,$sql);

        if($res)
        {
            // Food deleted
            $_SESSION["delete"] = "<div class='success'>Food Deleted Successfully.</div>";
            header("location:".SITEURL."admin/manage-food.php");
        }
        else
        {
            // Food Not Deleted
            $_SESSION["delete"] = "<div class='error'>Failed to Delete Food.</div>";
            header("location:".SITEURL."admin/manage-food.php");
        }


    }
    else
    {
        // Redirect to manage food
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
        header("location:".SITEURL."admin/manage-food.php");
    }
?>