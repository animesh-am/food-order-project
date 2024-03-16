<?php include("partials/menu.php") ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php 
            // Get the id of selected Admin
            $id = $_GET["id"];

            // Create SQL Query to update the details
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            // Execute the Query
            $res = mysqli_query($conn,$sql);

            // Check whether the query is executed or not
            if($res)
            {
                // Check whether data is available or not
                $count = mysqli_num_rows($res);
                // Check whether we have admin data or not
                if($count==1)
                {
                    // Get the details
                    $row = mysqli_fetch_assoc($res);

                    $full_name = $row["full_name"];
                    $username = $row["username"];



                }
                else
                {
                    // Redirect to manage-admin.php
                    header("location:".SITEURL."admin/manage-admin.php");
                }
            }
            
        ?>


        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <!-- <td colspan="1"></td> -->
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<?php
    // Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        // Get all the values from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        // Create SQL Query to update
        $sql = "UPDATE tbl_admin SET
                full_name = '$full_name',
                username = '$username'
                WHERE id=$id
                ";
        
        // Execute the query
        $res = mysqli_query($conn,$sql);

        // Check whether the query is executed successfully or not
        if($res){
            // Admin updated
            $_SESSION['update'] = "<div class='success'>Admin  <strong>UPDATED</strong> successfully.</div>";
            // Redirect to Admin Page
            header("location:".SITEURL."admin/manage-admin.php");
        }
        else{
            // Failed to update Admin
            $_SESSION['update'] = "<div class='error'><strong>FAILED</strong> to update Admin.</div>";
            // Redirect to Admin Page
            header("location:".SITEURL."admin/manage-admin.php");
        }
    }
?>

<?php include("partials/footer.php") ?>