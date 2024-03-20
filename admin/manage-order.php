<?php include('partials/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br><br>

        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>

        <br><br>



        <table class="tbl-full">
            <tr>
                <th class="text-center">S.No.</th>
                <th class="text-center">Food</th>
                <th class="text-center">price</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Total</th>
                <th class="text-center">Order</th>
                <th class="text-center">Status</th>
                <th class="text-center">Customer Name</th>
                <th class="text-center">Customer Contact</th>
                <th class="text-center">Email</th>
                <th class="text-center">Address</th>
                <th class="text-center">Actions</th>
            </tr>

            <?php
            // Get all the details from database
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; // Display latest order at first

            // Execute query
            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            $sn = 1; // Serial number

            if ($count > 0) {
                // Order Available
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get all the order details
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $quantity = $row['quantity'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_address = $row['customer_address'];
                    $customer_email = $row['customer_email'];

            ?>
                    <tr>
                        <td class="text-center"><?php echo $sn++; ?>.</td>
                        <td class="text-center"><?php echo $food; ?></td>
                        <td class="text-center"><?php echo $price; ?></td>
                        <td class="text-center"><?php echo $quantity; ?></td>
                        <td class="text-center"><?php echo $total; ?></td>
                        <td class="text-center"><?php echo $order_date; ?></td>
                        <td class="text-center">

                            <?php
                            // Ordered, On Delivery, Cancelled and Delivered
                            if ($status == "Ordered") {
                                echo "<label>$status</label>";
                            } else if ($status == "On Delivery") {
                                echo "<label style='color: orange; font-weight: bold;'>$status</label>";
                            } else if ($status == "Delivered") {
                                echo "<label style='color: green; font-weight: bold;'>$status</label>";
                            } else if ($status == "Cancelled") {
                                echo "<label style='color: red;  font-weight: bold;'>$status</label>";
                            }
                            ?>
                        </td>
                        <td class="text-center"><?php echo $customer_name; ?></td>
                        <td class="text-center"><?php echo $customer_contact; ?></td>
                        <td class="text-center"><?php echo $customer_email; ?></td>
                        <td class="text-center"><?php echo $customer_address; ?></td>
                        <td class="text-center">
                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary" style="display: inline-block;">Update Order</a>
                        </td>
                    </tr>
            <?php

                }
            } else {
                // Order Unavailable
                echo "<tr><td colspan='12' class='error text-center'>Order Not Available</td></tr>";
            }
            ?>


        </table>
    </div>
</div>
<?php include('partials/footer.php') ?>