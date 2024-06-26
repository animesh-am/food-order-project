<?php include('partials/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>

        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['unauthorised-access'])) {
            echo $_SESSION['unauthorised-access'];
            unset($_SESSION['unauthorised-access']);
        }

        if (isset($_SESSION['no-category-found'])) {
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        ?>

        <br><br>

        <!-- Button to add Admin -->
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th class="text-center">S.N.</th>
                <th class="text-center">Title</th>
                <th class="text-center">Image</th>
                <th class="text-center">Fearured</th>
                <th class="text-center">Active</th>
                <th class="text-center">Actions</th>
            </tr>

            <?php
            // Query to get all categories
            $sql = "SELECT * FROM tbl_category";

            // Execute Query
            $res = mysqli_query($conn, $sql);

            // Count rows
            $count = mysqli_num_rows($res);

            // Create serial number variable
            $sn = 1;

            // Check whether we have data in database or not
            if ($count > 0) {
                // We have data in database
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

            ?>

                    <tr>
                        <td class="text-center"><?php echo $sn++ ?></td>
                        <td class="text-center">
                            <?php echo $title; ?>
                        </td>
                        <td class="text-center">
                            <?php
                            // Check whether image name is available or not
                            if ($image_name != "") {
                                // Display the Image
                            ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="150px" />

                            <?php
                            } else {
                                // Display the message
                                echo "<div style='color:red; font-weight:bold '>❌ Image Not Available</div>";
                            }
                            ?>

                        </td>
                        <td class="text-center">
                            <?php echo $featured; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $active; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                        </td>
                    </tr>


                <?php
                }
            } else {
                // We do not have data
                ?>

                <tr>
                    <div class="error">No Category Added.</div>
                </tr>

            <?php
            }
            ?>

        </table>
    </div>

</div>
<?php include('partials/footer.php') ?>