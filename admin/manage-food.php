<?php include('partials/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if (isset($_SESSION['unauthorize'])) {
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>

        <!-- Button to add Food -->
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th class="text-center">S.No.</th>
                <th class="text-center">Title</th>
                <th class="text-center">Price</th>
                <th class="text-center">Image</th>
                <th class="text-center">Featured</th>
                <th class="text-center">Active</th>
                <th class="text-center">Actions</th>
            </tr>

            <?php
            // Create a SQL query to get all the food
            $sql = "SELECT * FROM tbl_food";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Count rows ro check whether we have foods or not
            $count = mysqli_num_rows($res);

            // Create Serial Number variable
            $sn = 1;

            if ($count > 0) {
                // We have food in database
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
            ?>

            <tr>
                <td class="text-center"><?php echo $sn++; ?></td>
                <td class="text-center"><?php echo $title; ?></td>
                <td class="text-center"><?php echo $price; ?></td>
                <td class="text-center">
                    <?php
                            // Check whether we have image or not
                            if ($image_name == "") {
                                // We do not have image, Display error message
                                echo "<div class='error'>Image Not Added.</div>";
                            } else {
                                // We have Image, Display Image
                            ?>
                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width='150px'>
                    <?php
                            }
                            ?>
                </td>
                <td class="text-center"><?php echo $featured; ?></td>
                <td class="text-center"><?php echo $active; ?></td>
                <td class="text-center">
                    <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>"
                        class="btn-secondary">Update Food</a>
                    <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>"
                        class="btn-danger">Delete Food</a>
                </td>
            </tr>

            <?php
                }
            } else {
                // Food Not added in database
                echo "<tr><td colspan='7' class='error'>Food not Added Yet</td></tr>";
            }

            ?>

        </table>
    </div>
</div>
<?php include('partials/footer.php') ?>