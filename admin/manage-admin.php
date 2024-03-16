<?php include('partials/menu.php')?>
<!-- Main section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br><br>

        <?php 
            if(isset($_SESSION["add"])){
                echo $_SESSION["add"]; // Display session message if set
                unset($_SESSION["add"]); // Remove session message
            }

            if(isset($_SESSION["delete"])){
                    echo $_SESSION["delete"]; // Display session message if set
                    unset($_SESSION["delete"]); // Remove session message
            }

            if(isset($_SESSION["update"])){
                echo $_SESSION["update"]; // Display session message if set
                unset($_SESSION["update"]); // Remove session message
            }
            
            if(isset($_SESSION["user-not-found"])){
                echo $_SESSION["user-not-found"];
                unset($_SESSION["user-not-found"]);
            }

            if(isset($_SESSION["pwd-not-match"])){
                echo $_SESSION["pwd-not-match"];
                unset($_SESSION["pwd-not-match"]);
            
            }

            if(isset($_SESSION["change-pwd"])){
                echo $_SESSION["change-pwd"];
                unset($_SESSION["change-pwd"]);
            }
        ?>

        <br><br>

        <!-- Button to add Admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S.No.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query to get all Admin
                $sql = "SELECT * FROM tbl_admin";
                // Execute the Query
                $res = mysqli_query($conn,$sql);

                // Check whether the query is executed or not
                if($res){
                    // Count rows to check whether we have data in the database or not
                    $count = mysqli_num_rows($res); // Function to get all the rows

                    $sn = 1; 
                    if($count>0){
                        // We have data in the database
                        while($rows=mysqli_fetch_assoc($res)){
                            // Using while loop to get all the data from the database
                            // While loop will run as long as we have data in the database.

                            // Get individual data
                            $id = $rows['id'];
                            $full_name = $rows['full_name'];
                            $username = $rows['username'];

                            // Display the values in our table
                            ?>

            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $full_name; ?></td>
                <td><?php echo $username; ?></td>
                <td>
                    <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id ?>"
                        class="btn-primary">Change Password</a>
                    <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id ?>"
                        class="btn-secondary">Update Admin</a>
                    <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id; ?> "
                        class="btn-danger">Delete Admin</a>
                </td>
            </tr>



            <?php

                        }
                    }
                    else
                    {
                        // We do not have data in the database
                    }
                }
            ?>
        </table>
    </div>
</div>


<?php include('partials/footer.php')?>