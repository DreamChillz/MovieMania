<?php
    session_start();
    include 'connection.php';

    if(isset($_POST['signupbtn'])){
        $username = $_POST['txtUsername'];
        $email = $_POST['txtEmail'];
        $password = $_POST['txtPassword'];
        $cpassword = $_POST['txtConfirmPassword'];

        $validateUser = "SELECT * FROM user WHERE user_id = '$username'";
        $validateResult = mysqli_query($connect, $validateUser);
        if(mysqli_num_rows($validateResult)>0){
            echo "<script>alert('Username already exist');</script>";
        }else{
            if ($password == $cpassword) {
                $query = "INSERT INTO 
                user(user_id, password, email, date_joined) 
                VALUES('$username', '$password', '$email', NOW())";
        
                if (mysqli_query($connect, $query)) {
                    echo "<script>alert('Register successful!');window.location.href = 'login.php'</script>";
                } else {
                    echo 'Error registering. Please try again!';
                }
            } else {
                echo 'Passwords do not match. Please try again!';
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Movie Mania</title>

    <link rel="stylesheet" href="log_sign.css">
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<!-- Navigation bar -->
<nav>
    <div class="logo">
        <a href="index.php"><img src="images/logo2.png" alt="Logo">Movie Mania</a>
    </div>
    <!-- <ul class="menu">
        <li><a href="#">Movies</a></li>
        <li><a href="#">TV Shows</a></li>
        <li><a href="#">News</a></li>
    </ul> -->
</nav>

<div class="form-wrapper">
    <div class="form" id="signUpForm">
        <h2>Sign Up</h2>
        <form action="" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="txtUsername" placeholder="Username" required pattern="[A-Za-z0-9]{1,10}"
						        oninput="this.setCustomValidity('')"
						        oninvalid="this.setCustomValidity('maximum 10 letters and numbers')">
                <i class="fa-regular fa-user"></i>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="txtEmail" placeholder="Email" required>
                <i class="fa-regular fa-envelope"></i>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="txtPassword" placeholder="Password" required>
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="txtConfirmPassword" placeholder="Confirm Password" required>
                <i class="fa-solid fa-lock"></i>
            </div>
        <button type="submit" class="btn" name="signupbtn">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Log in</a> here</p>
    </div>
</div>
</body>
</html>
<?php include('footer.php');?>