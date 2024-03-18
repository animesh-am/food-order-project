<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td class="label-cell">Title:</td>
                    <td><input type="text" name="title" placeholder="Enter title of the food" class="input-field"></td>
                </tr>

                <tr>
                    <td class="label-cell">Description: </td>
                    <td>
                        <textarea name="description" id="" cols="37" rows="5" placeholder="Description of the Food"
                            class="input-field"></textarea>
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Price:</td>
                    <td>
                        <input type="number" name="price" placeholder="Enter price of item" class="input-field">
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Select Image: </td>
                    <td>
                        <input type="file" name="image" class="input-field">
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Category:</td>
                    <td>
                        <select name="category" class="input-field">

                            <?php 
                            // PHP code to display categories from database
                            // SQL Query to display categories from database which are 'active'
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            // Execute the query
                            $res = mysqli_query($conn, $sql);

                            // Count rows to check whether we have categories or not
                            $count = mysqli_num_rows($res);

                            if ($count > 0)
                            {
                                // We have categories
                                while( $row = mysqli_fetch_assoc($res) )    
                                {
                                    // Get the details of category
                                    $id = $row['id'];
                                    $title = $row['title'];

                                    ?>
                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                            <?php
                                }
                            }
                            else
                            {
                                // We do not have categories
                                ?>
                            <option value="0">No Category Found.</option>
                            <?php
                            }
                        ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="1"><br><br><br></td>
                    <td>
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>


        <?php
            // Check whether the button is clicked or not
            if(isset($_POST['submit']))
            {
                // Get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                
                // Check whether radio button are clicked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; // Setting default value
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; // Setting default value
                }

                // Upload the image if selected
                if(isset($_FILES["image"]['name']))
                {
                    // Get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    // Check wheteher the image is selected or not
                    if($image_name != "")
                    {
                        // Rename the image --> Get the extension (.jpg, .png, ,jpeg, etc.)
                        $ext = end(explode('.', $image_name));
                        
                        // Create new name for image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                        // Upload the image
                        $src = $_FILES['image']['tmp_name']; // source path

                        $dst = "../images/food/".$image_name;
                        // Upload image
                        $upload = move_uploaded_file($src, $dst);
                        // Check whether image uploaded or not
                        if($upload == false)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            // Redirect to add food
                            header('location:'.SITEURL.'admin/food.php');

                            // Stop the process
                        }

                        
                        
                    }
                }
                else
                {
                    $image_name = ""; // Setting default value as button is not clicked
                }


                // Insert into database
                // For numerical we do not need to pass value inside quotes '' but for string value it is compulsory to add quotes ''
                $sql2 = "INSERT INTO tbl_food SET
                        title='$title',
                        description='$description', 
                        price=$price,     
                        image_name='$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                        ";

                $res2 = mysqli_query($conn, $sql2);

                // Check whether data is inserted or not
                if($res2)
                {
                    // Data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    // Redirect to manage food
                    header("location:".SITEURL."admin/manage-food.php");
                }
                else
                {
                    // Failed to insert data
                    $_SESSION['add'] = "<div class='error'>FAILED to Add Food.</div>";
                    // Redirect to manage food
                    header("location:".SITEURL."admin/manage-food.php");
                }


                // Redirect to manage food page with message

            }
        ?>

    </div>
</div>


<?php include("partials/footer.php"); ?>