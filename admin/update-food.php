<?php include("partials/menu.php");  ?>

<?php
    // Check if id is set or not
    if(isset($_GET['id']))
    {
        // Get all the details
        $id = $_GET['id'];
        $sql2 = "SELECT * FROM tbl_food WHERE id='$id'";

        // Execute the query
        $res2 = mysqli_query($conn, $sql2);

        if($res2) 
        {
            // Get the values
            $row2 = mysqli_fetch_assoc($res2);

            $title = $row2['title'];
            $description = $row2['description'];
            $price = $row2['price'];
            $current_image = $row2['image_name'];
            $current_category = $row2['category_id'];
            $featured = $row2['featured'];
            $active = $row2['active'];
        }
        else 
        {
            // If the query fails, redirect to manage food
            header('location:'.SITEURL.'admin/manage-food.php');
            exit(); // Stop further execution
        }
    }
    else
    {
        // Redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
        exit();
    }


    if(isset($_POST['submit']))
    {
        // Get the details from form 
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $current_image = $_POST['current_image'];
        $category = $_POST['category'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];


        // Upload image
        if(isset($_FILES['image']['name']))
        {
            $image_name = $_FILES['image']['name'];

            // Check whether the file is available or not
            if($image_name != "")
            {
                $parts = explode('.', $image_name);
                $ext = end($parts); // Extension of the image

                $image_name = "Food-Name-".rand(0000,9999) .".". $ext;

                $src_path = $_FILES['image']['tmp_name']; // source path
                $dest_path = "../images/food/".$image_name; // destination path

                // Upload the image
                $upload = move_uploaded_file($src_path, $dest_path);

                // Check whether the image is uploaded or not
                if($upload == false)
                {
                    // Failed to upload
                    $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>";

                    // Redirect to manage food
                    header('location:'.SITEURL.'admin/manage-food.php');

                    exit();
                }

                // Remove the image if new image is uploaded and current image exists
                if($current_image != "")
                {
                    $remove_path = "../images/food/".$current_image;
                    $remove = unlink( $remove_path );

                    // Check whether image is removed or not
                    if($remove == false)
                    {
                        // Failed to remove current image
                        $_SESSION["remove-failed"] = "<div class='error'>Failed to Remove Current Image.</div>";
                        header("location:".SITEURL."admin/manage-food.php");
                        exit();
                    }
                }

            }
            else
            {
                $image_name = $current_image;  // Default image when image is not selected
            }

        }
        else
        {
            $image_name = $current_image; // Default image when button is not clicked
        }

        
        // Update the food in database
        $sql3 = "UPDATE tbl_food SET
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id='$category',
                featured='$featured',
                active='$active'
                WHERE id=$id
                ";

        // Execute sql query
        $res3 = mysqli_query($conn, $sql3);

        // Check whether the query is executed or not
        if($res3)
        {
            // Database updated
            echo "Redirecting...";

            $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
            header("location:".SITEURL."admin/manage-food.php");
        }
        else
        {
            // Failed to update database
            echo "Redirecting...";

            $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
            header("location:".SITEURL."admin/manage-food.php");
        }

        // Redirect to manage food with message
    }
?>



<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td class="label-cell">Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>" class="input-field"></td>
                </tr>

                <tr>
                    <td class="label-cell">Description: </td>
                    <td>
                        <textarea name="description" cols="37" rows="5" value="Hello"
                            class="input-field"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>" class="input-field">
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Current Image: </td>
                    <td>
                        <?php 
                            if($current_image == "")
                            {
                                // Image Not Available
                                echo "<div class='error'>Image Not Available.</div>";
                            }
                            else
                            {
                                // Image Available
                                ?>

                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>"
                            alt="<?php echo $title; ?>" width="280px" height="150px">

                        <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Select New Image: </td>
                    <td>
                        <input type="file" name="image" class="input-field">
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Category:</td>
                    <td>
                        <select name="category" class="input-field">
                            <?php
                                // Query to get active categories
                                $sql = "SELECT * FROM tbl_category WHERE active='YES'";
                                // Execute the query
                                $res = mysqli_query($conn, $sql);

                                // Count rows
                                $count = mysqli_num_rows($res);

                                if ($count > 0)
                                {
                                    // Category Available
                                    while ($row = mysqli_fetch_assoc($res)) 
                                    {
                                        $category_title = $row["title"];
                                        $category_id = $row['id'];

                                        ?>
                            <option <?php if($current_category == $category_id){echo 'selected';} ?>
                                value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                            <?php
                                    }

                                }
                                else
                                {
                                    // Category Unavailable
                                    echo "<option value='0'>Category Not Available.</option>";
                                }
                            ?>
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Featured:</td>
                    <td>
                        <input <?php if($featured=='Yes'){echo 'checked';} ?> type="radio" name="featured"
                            value="Yes">Yes
                        <input <?php if($featured=='No'){echo 'checked';} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Active:</td>
                    <td>
                        <input <?php if($active=='Yes'){echo 'checked';} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=='No'){echo 'checked';} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="1"><br><br><br></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>


    </div>
</div>

<?php include("partials/footer.php"); ?>