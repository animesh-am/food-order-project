<?php include('partials/menu.php') ?>

<!-- Main section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>DASHBOARD</h1>

        <br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        ?>

        <br>

        <div class="col-4 text-center">
            <?php
            // SQL query to get all the rows in category table
            $sql = "SELECT * FROM tbl_category";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Count the rows
            $count = mysqli_num_rows($res);

            ?>
            <h1><?php echo $count; ?></h1>
            <br>
            <a href="<?php echo SITEURL; ?>admin/manage-category.php">Categories</a>
        </div>

        <div class="col-4 text-center">
            <?php
            // SQL query to get all the rows in food table
            $sql2 = "SELECT * FROM tbl_food";

            // Execute the query
            $res2 = mysqli_query($conn, $sql2);

            // Count the rows
            $count2 = mysqli_num_rows($res2);

            ?>
            <h1><?php echo $count2; ?></h1>
            <br>
            <a href="<?php echo SITEURL; ?>admin/manage-food.php">Foods</a>

        </div>

        <div class="col-4 text-center">
            <?php
            // SQL query to get all the rows in order table
            $sql3 = "SELECT * FROM tbl_order";

            // Execute the query
            $res3 = mysqli_query($conn, $sql3);

            // Count the rows
            $count3 = mysqli_num_rows($res3);

            ?>
            <h1><?php echo $count3; ?></h1>
            <br>
            <a href="<?php echo SITEURL; ?>admin/manage-order.php">Total Orders</a>

        </div>

        <div class="col-4 text-center">
            <?php
            // SQL query to get revenue generated
            $sql4 = "SELECT SUM(total) as Total FROM tbl_order WHERE status='Delivered'";

            // Execute the query
            $res4 = mysqli_query($conn, $sql4);

            $row4 = mysqli_fetch_assoc($res4);

            // Get the total revenue
            $total_revenue = $row4['Total'];

            ?>
            <h1>Rs.<?php echo $total_revenue; ?></h1>
            <br>
            <a href="<?php echo SITEURL; ?>admin/manage-order.php">Revenue Generated</a>

        </div>



        <div class="clearfix"></div>
    </div>
</div>
<!-- Main section ends -->

<?php include('partials/footer.php') ?>