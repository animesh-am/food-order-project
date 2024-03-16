<?php include("../config/constants.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Moody Foody</title>
    <link rel="stylesheet" href="../css/admin.css">

    <style>
    /* Add custom CSS styles here */
    body {
        font-family: Arial, sans-serif;
        background-color: #dff9fb;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login {
        background-color: #c7ecee;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 40px;
        text-align: center;
        width: 300px;
    }

    .login h1 {
        margin-bottom: 20px;

    }

    .login label {
        display: block;
        margin-bottom: 10px;
        text-align: left;
    }

    .login input[type="text"],
    .login input[type="password"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .link-color {
        color: blue;
        text-decoration: none;
    }

    .link-color:hover {
        color: skyblue;
    }
    </style>
</head>

<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br>

        <?php 
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }

        ?>

        <br>

        <!-- Login form starts here -->
        <form action="" method="POST" class="text-center">
            <label for="">Username:</label>
            <input type="text" name="username" placeholder="Enter username">

            <label for="">Password:</label>
            <input type="password" name="password" placeholder="Enter password">

            <input type="submit" value="Login" name="submit" class="btn-primary">
        </form>

        <!-- Login form ends here -->
        <br><br>
        <p class="text-center">Developed with ❤️ by <a href="https://github.com/animesh-am" target="_blank"
                class="link-color">Animesh Maity</a></p>
    </div>
</body>

</html>

<?php
    // Check whether the submit button is clicked or not
    if(isset($_POST["submit"]))
    {
        // Process for Login
        // 1. Get the data from Login from
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // 2. SQL query to check whether the username and password exist or not
        $sql = "SELECT * FROM tbl_admin
                WHERE username='$username'
                AND password='$password'";

        // 3. Execute the query
        $res = mysqli_query($conn, $sql);
        

        // 4. Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);
        if($count == 1)
        {
            /// User available 
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username; // To check user is logged in or not

            // Redirect to dashboard
            header('location:'.SITEURL.'admin/');

        }
        else
        {
            // User not available
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
            // Redirect to login page
            header('location:'.SITEURL.'admin/login.php');
        }
    }

?>