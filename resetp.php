<?php
    session_start();
    include 'connection.php';

    if(isset($_GET['email'])){
        $email = isset($_GET['email']) ? mysqli_real_escape_string($connect, $_GET['email']) : '';
        $query = "SELECT * FROM user WHERE email = '$email'";
        $adminQuery = "SELECT * FROM admin WHERE email = '$email'";
        $result = mysqli_query($connect, $query);
        $adminResult = mysqli_query($connect, $adminQuery);

        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_type'] = 'user';
            $_SESSION['user_id'] = $row['user_id'];
        }else if(mysqli_num_rows($adminResult)>0){
            $row = mysqli_fetch_assoc($adminResult);
            $_SESSION['user_type'] = 'admin';
            $_SESSION['admin_id'] = $row['admin_id'];
        }else{
            echo "<script>alert('Fail to get user information'); window.location.href = 'login.php';</script>";
            exit();
        }
        
    }

    if (isset($_POST['resetpbtn'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        if ($_SESSION['user_type'] === 'user') {
            $user_id = $_SESSION['user_id'];
            $query = "UPDATE user SET password = '$confirm_password' WHERE user_id = '$user_id'";
        } elseif ($_SESSION['user_type'] === 'admin') {
            $admin_id = $_SESSION['admin_id'];
            $query = "UPDATE admin SET password = '$confirm_password' WHERE admin_id = '$admin_id'";
        }

        if (mysqli_query($connect, $query)) {
            echo "<script>alert('Password reset successful!'); window.location.href = 'login.php';</script>";
            exit();
        } else {
            echo 'Error updating password. Please try again!';
        }
    } else {
        echo 'New password and confirm password do not match. Please try agian!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Movie Mania</title>

    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="log_sign.css">
</head>
<body>
<!-- Navigation bar -->
<nav>
    <div class="logo">
        <a href="index.php"><img src="images/logo2.png" alt="Logo">Movie Mania</a>
    </div>
</nav>

<!-- Reset Password Form -->
<div class="form-wrapper">
    <div class="form" id="resetForm">
        <h2>Reset Password</h2>
        <form action="" method="POST" id="resetForm">
            <div class="input-group">
                <label for="user_id">User ID:</label>
                <input type="text" id="username" name="txtUsername" value="<?php if($_SESSION['user_type'] === 'user'){
                    echo $_SESSION['user_id'];
                } else if($_SESSION['user_type'] === 'admin'){
                    echo $_SESSION['admin_id'];
                }?>" readonly>
                <i class="fa-regular fa-user"></i>
            </div>
            <div class="input-group">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" placeholder="Enter new password" required>
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" placeholder="Confirm your new password" required>
                <i class="fa-solid fa-lock"></i>
            </div>
            <button type="submit" class="btn" name="resetpbtn">Reset Password</button>
        </form>
    </div>
</div>
</body>
</html>
<?php include('footer.php');?>