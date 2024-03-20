<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <?php
        // Check whether id is set or not
        if ($_GET['id']) {
            // Get order details
            $id = $_GET['id'];

            $sql = "SELECT * FROM tbl_order WHERE id='$id'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                // Order available
                $row = mysqli_fetch_array($res);

                $food = $row['food'];
                $price = $row['price'];
                $status = $row['status'];
                $quantity = $row['quantity'];
                $customer_name = $row['customer_name'];
                $customer_email = $row['customer_email'];
                $customer_contact = $row['customer_contact'];
                $customer_address = $row['customer_address'];
            } else {
                // Order unavailable
                header("location:" . SITEURL . "admin/manage-order.php");
            }
        } else {
            // Redirect
            header('location:' . SITEURL . 'admin/manage-order.php');
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td class="label-cell">Food Name :</td>
                    <td><strong><em><?php echo $food; ?></em></strong></td>
                </tr>

                <tr>
                    <td class="label-cell">Price :</td>
                    <td><strong><em>Rs. <?php echo $price; ?></em></strong></td>
                </tr>

                <tr>
                    <td class="label-cell">Quantity :</td>
                    <td>
                        <input type="number" name="quantity" class="input-field" value="<?php echo $quantity; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="label-cell">Status :</td>
                    <td>
                        <select name="status" class="input-field">
                            <option <?php if ($status == 'Ordered') {
                                        echo "selected";
                                    } ?> value="Ordered">Ordered</option>
                            <option <?php if ($status == 'On Delivery') {
                                        echo "selected";
                                    } ?> value="On Delivery">On Delivery</option>
                            <option <?php if ($status == 'Delivered') {
                                        echo "selected";
                                    } ?> value="Delivered">Delivered</option>
                            <option <?php if ($status == 'Cancelled') {
                                        echo "selected";
                                    } ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Customer Name : </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" class="input-field">
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Customer Contact : </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>" class="input-field">
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Customer Email : </td>
                    <td>
                        <input type="text" name="customer_email" value=<?php echo $customer_email; ?>" class="input-field">
                    </td>
                </tr>

                <tr>
                    <td class="label-cell">Customer Address : </td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5" class="input-field"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan=" 1"><br><br><br></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        // Check whether update button is clicked or not
        if (isset($_POST['submit'])) {
            // Get all the details from form
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $price = mysqli_real_escape_string($conn, $_POST['price']);
            $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

            $total = $price * $quantity;

            $status = mysqli_real_escape_string($conn, $_POST['status']);
            $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
            $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
            $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
            $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);

            // Update the values
            $sql2 = "UPDATE tbl_order SET
                        quantity=$quantity,
                        total=$total,
                        status='$status',
                        customer_name='$customer_name',
                        customer_contact='$customer_contact',
                        customer_email='$customer_email',
                        customer_address='$customer_address'
                        WHERE id=$id
                        ";

            // Execute the query
            $res2 = mysqli_query($conn, $sql2);

            if ($res2) {
                // Updated
                $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-order.php');
            } else {
                // Failed to update
                $_SESSION['update'] = "<div class='error'>Failed to Update the Order.</div>";
                header('location:' . SITEURL . 'admin/manage-order.php');
            }

            // Redirect to manage order
        }
        ?>
    </div>
</div>

<?php include("partials/footer.php"); ?>