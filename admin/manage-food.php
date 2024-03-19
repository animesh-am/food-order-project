<?php include('partials/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br><br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>

        <!-- Button to add Food -->
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S.No.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                // Create a SQL query to get all the food
                $sql = "SELECT * FROM tbl_food";

                // Execute the query
                $res = mysqli_query($conn,$sql);

                // Count rows ro check whether we have foods or not
                $count = mysqli_num_rows($res);

                // Create Serial Number variable
                $sn = 1;

                if($count > 0)
                {
                    // We have food in database
                    while($row = mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>

            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $title; ?></td>
                <td><?php echo $price; ?></td>
                <td>
                    <?php 
                        // Check whether we have image or not
                        if($image_name == "")
                        {
                            // We do not have image, Display error message
                            echo "<div class='error'>Image Not Added.</div>";
                        }
                        else
                        {
                            // We have Image, Display Image
                            ?>
                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width='150px'>
                    <?php
                        }
                    ?>
                </td>
                <td><?php echo $featured; ?></td>
                <td><?php echo $active; ?></td>
                <td>
                    <a href="#" class="btn-secondary">Update Food</a>
                    <a href="#" class="btn-danger">Delete Food</a>
                </td>
            </tr>

            <?php
                    }
                }
                else
                {
                    // Food Not added in database
                    echo "<tr><td colspan='7' class='error'>Food not Added Yet</td></tr>";
                }

            ?>

        </table>
    </div>
</div>
<?php include('partials/footer.php') ?>