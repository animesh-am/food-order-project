<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>

        <!-- Add Category Form starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td class="label-cell">Title:</td>
                    <td><input type="text" name="title" placeholder="Enter title" class="input-field"></td>
                </tr>
                <tr>
                    <td class="label-cell">Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="1"><br><br><br></td>
                    <td>
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add Category Form ends -->

        <?php
        // Check whether is clicked or not
        if (isset($_POST["submit"])) {
            // Get the value from category form
            $title = mysqli_real_escape_string($conn, $_POST['title']);

            // For radio input type we need to check whether the button is selected or not
            if (isset($_POST['featured'])) {
                // Get the featured value
                $featured = mysqli_real_escape_string($conn, $_POST['featured']);
            } else {
                // Set the dea=fault value
                $featured = 'No';
            }

            if (isset($_POST['active'])) {
                $active = mysqli_real_escape_string($conn, $_POST['active']);
            } else {
                $active = 'No';
            }

            // Check whether the image is selected or not and set the value for image accordingly
            if (isset($_FILES['image']['name'])) {
                // Upload the Image
                $image_name = $_FILES['image']['name'];

                // Upload the image only if the image name is available
                if ($image_name != "") {
                    // Auto-Renaming the image
                    // First get the extension of the image (jpg, png, gif, etc.)
                    $parts = explode('.', $image_name);
                    $ext = end($parts);

                    // Rename the image
                    $image_name = "Food_category_" . rand(000, 999) . '.' . $ext;


                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/" . $image_name;

                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Check whether the image is uploaded or not
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>FAILED to Upload Image.</div>";
                        // Redirect to add category page
                        header('location:' . SITEURL . 'admin/add-category.php');
                        // Stop the process
                        die();
                    }
                }
            } else {
                // Do not upload the image and set the image name value as blank
                $image_name = "";
            }

            // SQL query to insert category into database
            $sql = "INSERT INTO tbl_category SET
                        title='$title',
                        featured='$featured',
                        active='$active',
                        image_name='$image_name'
                        ";

            // Execute the query and save in database
            $res = mysqli_query($conn, $sql);

            // Check whether the query is execute and data is inserted or not
            if ($res) {
                // Query executed and category added
                $_SESSION['add'] = "<div class='success'>Category <strong>ADDED</strong> Successfully.</div>";
                // Redirect to manage category
                header('location:' . SITEURL . 'admin/manage-category.php');
                die();
            } else {
                // Failed to add category

                $_SESSION['add'] = "<div class='error'>FAILED to add Category.</div>";
                // Redirect to add category
                header('location:' . SITEURL . 'admin/add-category.php');
                die();
            }
        }
        ?>

    </div>
</div>

<?php include("partials/footer.php"); ?>