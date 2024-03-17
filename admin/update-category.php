<?php include("partials/menu.php"); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
            // Check whether the id is set or not
            if(isset($_GET['id']))
            {
                // Get all other details
                $id = $_GET['id'];
                
                // Create SQL query to get all other details
                $sql = "SELECT * FROM tbl_category WHERE id='$id'";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Count the number of rows returned
                $row = mysqli_num_rows($res);

                if($row == 1) // There can be only one row with same id
                {
                    // Get all data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    // Redirect to manage category with message
                    $_SESSION['no-category-found'] = "<div class='error'>Category Not FOUND.</div>";
                    header("location:".SITEURL."admin/manage-category.php");
                }
            }
            else
            {
                // Give session message
                $_SESSION['unauthorised-access'] = "<div class='error'>This action is RESTRICTED.</div>";
                // Redirect to Manage Category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td class="label-cell">Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>" class="input-field"></td>
                </tr>
                <tr>
                    <td class="label-cell">Current Image: </td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                                // Display the image
                                ?>
                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>"
                            alt="Error in image retrieval" width="200px">
                        <?php
                            }
                            else
                            {
                                // Display message
                                echo "<div class='error'>Image not added</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes"){ echo "checked";} ?> type="radio" name="featured"
                            value="Yes">Yes
                        <input <?php if($featured == "No"){ echo "checked";} ?> type="radio" name="featured"
                            value="No">No
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Active: </td>
                    <td>
                        <input <?php if($active == "Yes"){ echo "checked";} ?> type="radio" name="active"
                            value="Yes">Yes
                        <input <?php if($active == "No"){ echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="1"><br><br><br></td>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit']))
            {
                // Get all the values from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // Updating New Image
                if(isset($_FILES['image']['name']))
                {
                    // Get the image details
                    $image_name = $_FILES['image']['name'];

                    // Check if image is available
                    if($image_name != "")
                    {
                        // Image Available
                        // Upload the new image

                        // Auto-Renaming the image
                        // First get the extension of the image (jpg, png, gif, etc.)
                        $ext = end(explode('.', $image_name));

                        // Rename the image
                        $image_name = "Food_category_" . rand(000,999) . '.' . $ext;
                                                

                        $source_path = $_FILES['image']['tmp_name'];
                        
                        $destination_path = "../images/category/" . $image_name;

                        $upload = move_uploaded_file($source_path, $destination_path);

                        // Check whether the image is uploaded or not
                        if($upload == false)
                        {
                            $_SESSION['upload'] = "<div class='error'>FAILED to Upload Image.</div>";
                            // Redirect to add category page
                            header('location:'.SITEURL.'admin/manage-category.php');
                            // Stop the process
                            die();
                        }

                        // Remove the current image if available
                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);
                        
                            // Check whether the image is removed or not
                            if($remove == false)
                            {
                                // Failed to remove image
                                $_SESSION["failed-remove"] = "<div class='error'>FAILED to Remove Current Image.</div>";
                                // Redirect to manage category
                                header('location:'.SITEURL.'admin/manage-category.php');
                                // Stop the process
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                // Update the database
                $sql2 = "UPDATE tbl_category SET 
                        title='$title',
                        image_name='$image_name',
                        featured='$featured',
                        active='$active'
                        WHERE id='$id'";
                
                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // Check whether query executed or not
                if($res2)
                {
                    // Category Updated
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    // Failed to update category
                    $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

                // Redirect to manage category
            }
        ?>
    </div>
</div>


<?php include("partials/footer.php"); ?>