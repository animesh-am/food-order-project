<?php include('partials-front/menu.php'); ?>

<!-- FOOD SEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- FOOD SEARCH Section Ends Here -->

<br><br>

<?php
if (isset($_SESSION['order'])) {
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}

?>

<!-- Categories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        // Create SQL to display categories from database
        $sql = "SELECT * FROM tbl_category WHERE active='Yes' and featured='Yes' LIMIT 3";
        // Execute the query
        $res = mysqli_query($conn, $sql);
        // Count the number of rows returned
        $count = mysqli_num_rows($res);
        if ($count > 0) {
            // Categories present
            while ($row = mysqli_fetch_assoc($res)) {
                // Get the values
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
        ?>

                <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php
                        // Check whether image is available or not
                        if ($image_name == "") {
                            echo "<div class='error'>Image Not Available</div>";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                        <?php
                        }
                        ?>


                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>

        <?php
            }
        } else {
            // Categories Not Present
            echo "<div class='error'>Category Not Added.</div>";
        }


        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Getting foods from database that are active and featured
        $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' and featured='Yes' LIMIT 6";
        $res2 = mysqli_query($conn, $sql2);
        $count2 = mysqli_num_rows($res2);
        if ($count2 > 0) {
            // Food available
            while ($row = mysqli_fetch_assoc($res2)) {
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
                $description = $row['description'];
                $price = $row['price'];

        ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        // Check if image available or not
                        if ($image_name == '') {
                            // Image not available
                            echo "<div class='error'>Image Not Availble.</div>";
                        } else {
                            // Image Available
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Food Image" class="img-responsive img-curve">
                        <?php

                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">Rs. <?php echo $price; ?></p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>

                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-danger">Order
                            Now</a>
                    </div>
                </div>
        <?php
            }
        } else {
            // Food Not Available
            echo "<div class='error'>Food Not Available.</div>";
        }

        ?>

        <div class="clearfix"></div>

    </div>

    <p class="text-center">
        <a href="#">See All Foods</a>
    </p>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>