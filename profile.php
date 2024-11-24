<?php
include('connection.php');
include('loginAccess.php');
mysqli_set_charset($connect, "utf8mb4");


$user_id = $_SESSION['user_id'];
$role=$_SESSION['role'];
?>
<?php
//get user data from database
if($role==='user'){
    include('sidenav.php') ;
    $query="SELECT * 
            FROM user
            WHERE user_id='$user_id'
            ";
    
} elseif($role==='admin'){
    include('sidenav_admin.php') ;
    $query="SELECT * 
    FROM admin
    WHERE admin_id='$user_id'
    ";
}

$results=mysqli_query($connect,$query);

if(mysqli_num_rows($results)==1){
    $row=mysqli_fetch_assoc($results);
    

    // Check if the user has a profile image
    if (!empty($row['profile_image'])) {
        // If the user has uploaded a profile picture
        $imageData = base64_encode($row["profile_image"]);
        $src = 'data:image/jpeg;base64,' . $imageData;
    } else {
        // If no profile picture exists, use a default image
        $src='images/blank_pp.webp';
    }

};


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
    <!-- stylesheet -->
    <link rel="stylesheet" href="profile-css.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <div id='main'>
    <div class="profile-container">
        <div class="profile-left-container">
            <img class="profile-image" src="<?php echo $src ?>" alt="profile picture">
            
            
            <a href="update_profile.php">Edit Profile</a>

            <div class="profile-info">
                <span class="user-info">Gender: 
                    <span class="info-values"><?php echo ucfirst($row['gender']) ?></span>
                </span>

                <span class="user-info">Country: 
                    <span class="info-values"><?php echo ucfirst($row['country']) ?></span>
                </span>

                <span class="user-info">Email: 
                <span class="info-values"><?php echo $row['email'] ?></span>
                </span>

                <span class="user-info">Phone Number: 
                <span class="info-values"><?php echo $row['phone_number'] ?></span>
            </span>

                <span class="user-info">Date of Birth: 
                <span class="info-values">    
                <?php echo $row['date_of_birth'] ?></span></span>

                <span class="user-info">Constellation: 
                <span class="info-values"><?php echo $row['constellation'] ?></span></span>
                <span class="user-info">Date joined: 
                <span class="info-values"><?php echo $row['date_joined'] ?></span></span>
                
            </div>

        </div>
        <div class="profile-right-container <?php echo $role === 'admin' ? 'no-watchlist' : ''; ?>">

            <div class="profile-header">

            <?php echo"<h1>".$user_id."'s Profile</h1>" ?>

            <span class="name"><?php echo $row['name'] ?></span>
            <h4>Bio</h4>
            <div class="profile-bio"><?php echo $row['bio'] ?></div>

            </div>

            <!-- only display this content is role is user -->
            <?php if ($role === 'user'): ?>
            <div class="profile-content">
                <h4>Statistics</h4>

                <!-- to calculate percentage of status in watchlist -->
                <?php include('stats-calc.php');?>

                <div class="status-progress-bar">
                    <div class="status plan" style="width: <?php echo $percentages['Plan to Watch']; ?>%"></div>
                    <div class="status watching" style="width: <?php echo $percentages['Watching']; ?>%"></div>
                    <div class="status completed" style="width: <?php echo $percentages['Completed']; ?>%"></div>
                    <div class="status hold" style="width: <?php echo $percentages['On Hold']; ?>%"></div>
                    <div class="status dropped" style="width: <?php echo $percentages['Dropped']; ?>%"></div>
                </div>

                <div class="status-percentage">
                    <span class="plan">Plan to Watch:   <?php echo $percentages['Plan to Watch']; ?>%</span>
                    <span class="watching">Watching:   <?php echo $percentages['Watching']; ?>%</span>
                    <span class="completed">Completed:   <?php echo $percentages['Completed']; ?>%</span>
                    <span class="hold">On Hold:   <?php echo $percentages['On Hold']; ?>%</span>
                    <span class="dropped">Dropped:   <?php echo $percentages['Dropped']; ?>%</span>
                    
                </div>
                <hr>
                <div class="stats">
                    <div class="total-status">
                    <p>Total Completed:   <?php echo $total_completed; ?></p>
                    <p>Total Currently Watching:   <?php echo $total_watching; ?></p>
                    <p>Total Planned to Watch:   <?php echo $total_plan_to_watch; ?></p>
                    <p>Total On-Hold :   <?php echo $total_on_hold; ?></p>
                    <p>Total Dropped:   <?php echo $total_dropped; ?></p>
                    </div>
                    <div class="other-stats">
                    <p>Favorite Genre:   <?php echo ucfirst($favorite_genre); ?></p>
                    <p>Total Episodes Watched:   <?php echo $total_episodes_watched; ?></p>
                    <p>Average Rating Given:   <?php echo round($avg_rating, 1); ?>/5</p>
                    </div>

                </div>
            
            
            </div>
            <?php endif; ?>

        </div>
</div>    




    </div>
    
        

</body>
</html>

<?php

if($role==='user'){
    include('footer.php') ;
    
} elseif($role==='admin'){
    include('footer_admin.php') ;
}
?>
