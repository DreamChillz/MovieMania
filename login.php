<?php
    session_start();
    include 'connection.php';

    if(isset($_POST['loginbtn'])){
        $username = $_POST['txtUsername'];
        $password = $_POST['txtPassword'];

        $query = "SELECT * FROM user WHERE user_id = '$username' AND password = '$password' ";
        $results = mysqli_query($connect, $query);
        if(mysqli_num_rows($results) == 1){
            while($row = mysqli_fetch_assoc($results)) {
            $_SESSION['password'] = $row['password'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = 'user';
            echo "<script>alert('Login successful!');window.location.href = 'home.php'</script>";
            }
        }
        else {
            $adminQuery = "SELECT * FROM admin WHERE admin_id = '$username' AND password = '$password' ";
            $adminResults = mysqli_query($connect, $adminQuery);
            if(mysqli_num_rows($adminResults) == 1){
                while($row = mysqli_fetch_assoc($adminResults)) {
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['user_id'] = $row['admin_id'];
                    $_SESSION['role'] = 'admin';
                    echo "<script>alert('Login successful!');window.location.href = 'home_admin.php'</script>";
                    }
            }else{
                echo "<script>alert('Login Failed! Please try again');</script>";
            }
        }
    }

    $emailExists = false;
    if (isset($_POST['forgot-email'])) {
        $email = mysqli_real_escape_string($connect,$_POST['forgot-email']);

        $sql = "SELECT email FROM user WHERE email = '$email'";
        $results = mysqli_query($connect, $sql);
        $adminSql = "SELECT email FROM admin WHERE email = '$email'";
        $adminResults = mysqli_query($connect, $adminSql);

        if (mysqli_num_rows($results) == 1 || mysqli_num_rows($adminResults) == 1) {
            $emailExists = true;
            echo "<script>
            alert('Email exists. You can reset your password.');
            document.getElementById('reset_email').value = '$email';
            </script>";
        } else {
            echo "<script>alert('Email does not exist in our database.');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Movie Mania</title>

    <link rel="stylesheet" href="log_sign.css">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<!-- Navigation bar -->
<nav>
    <div class="logo">
        <a href="index.php"><img src="images/logo2.png" alt="Logo">Movie Mania</a>
    </div>
</nav>

<!-- Login Form -->
<div class="form-wrapper">
    <div class="form" id="loginForm">
        <h2>Login</h2>
        <form action="" method="POST">
            <div class="input-group">
                <label for="user_id">User ID:</label>
                <input type="text" id="username" name="txtUsername" placeholder="Username" required>
                <i class="fa-regular fa-user"></i>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="txtPassword" placeholder="Password" required>
                <i class="fa-solid fa-lock"></i>
            </div>
        <label><input type="checkbox" name="rememberme" id="rememberme">Remember me</label>
        <br>
        <button type="submit" class="btn" name="loginbtn">Login</button>
        </form>
        <p>Dont have an account? <a href="signup.php">Sign Up </a> Here.</p>
        <a href="resetp.php" id="forgot-password-link">Forgot Password?</a>
    </div>
</div>

<!-- Forgot password -->
<div id="forgotPassword" class="wrapper-hidden">
    <div class="fPass-content">
        <span class="close">&times;</span>
        <h2>Forgor Password</h2>
        <p>Please enter your email address. If it exists in our system, you'll be able to reset your password.</p>
        <form id="forgotPasswordForm" method="POST">
            <input type="email" id="forgot-email" name="forgot-email" placeholder="Enter your email" required>
            <button type="submit" id="resetPasswordBtn">Submit</button>
        </form>
    </div>
</div>
<script src="forgotp.js"></script>
</body>
</html>
<?php include('footer.php');?>