<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }
        ?>


        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="1"><br><br><br></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<?php
// Check whether the submit button is clicket=d or not
if (isset($_POST["submit"])) {
    // Get data from form
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $current_password = md5($_POST["current_password"]);
    $new_password = md5($_POST["new_password"]);
    $confirm_password = md5($_POST["confirm_password"]);


    // Check whether the user with current id and password exist or not
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            // User exist, Password can be changed
            // Check whether the new password and confirm password match or not
            if ($new_password == $confirm_password) {
                // Update Password
                $sql2 = "UPDATE tbl_admin SET
                            password='$new_password'
                            WHERE id=$id";

                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // Check if query is executed or not
                if ($res2) {
                    // Display success message
                    $_SESSION['change-pwd'] = "<div class='success'>Password changed successfully.</div>";
                    // Redirect to manage-admin.php using message (success)
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                } else {
                    // Display Error message
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to change Password.</div>";
                    // Redirect to manage-admin.php using message (success)
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            } else {
                // Redirect to manage-admin.php using message (error)
                $_SESSION['pwd-not-match'] = "<div class='error'>Password did not match.</div>";
                // Redirect the user to manage-admin.php
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            // User does not exist
            $_SESSION['user-not-found'] = "<div class='error'>User NOT Found.</div>";
            // Redirect the user to manage-admin.php
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }

    // Check whether the new password and confirm password match or not

    // Change password id all above truw
}

?>


<?php include("partials/footer.php"); ?>