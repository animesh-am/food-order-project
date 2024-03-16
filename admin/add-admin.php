<?php include('partials/menu.php')?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION["add"]; // Display session message if set
                unset($_SESSION["add"]); // Remove session message
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td class="label-cell">Full Name</td>
                    <td><input type="text" name="full_name" placeholder="Enter your name" class="input-field"></td>
                </tr>
                <tr>
                    <td class="label-cell">Username</td>
                    <td><input type="text" name="username" placeholder="Your username" class="input-field"></td>
                </tr>
                <tr>
                    <td class="label-cell">Password</td>
                    <td><input type="password" name="password" placeholder="Your password" class="input-field"></td>
                </tr>

                <tr>
                    <td colspan="4"><br></td>
                </tr>

                <tr>
                    <td colspan="1"></td>
                    <td>
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php')?>

<?php
    // Process the value from Form and save it in Database
    // Check whether the submit button is clicked or not

    if(isset($_POST['submit'])) {
        // TODO: Get the data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //password encrypted with md5
        
        // TODO: SQL query to save the data into database
        $sql = "INSERT INTO tbl_admin SET 
                full_name='$full_name',
                username = '$username',
                password = '$password';
                ";
        
        
        // Execute Query and Save data in Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // Check data is inserted into table and display message
        if($res){
            // Create session variable to Display Message
            $_SESSION['add'] = "<div class='success'>Admin <strong>ADDED</strong> Successfully.</div>";
            // Redirect Page to Manage Admin
            header("location:".SITEURL."admin/manage-admin.php");
        }
        else{
            // Create session variable to Display Message
            $_SESSION["add"] = "Failed to Add Admin.";
        }
    }
    
?>