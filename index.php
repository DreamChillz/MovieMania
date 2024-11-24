<?php
    session_start();
    include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Mania</title>

    <link rel="stylesheet" href="index.css">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Navigation bar -->
    <nav>
        <div class="logo">
            <a href="index.php"><img src="images/logo2.png" alt="Logo">Movie Mania</a>
        </div>
            <ul class="menu">
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
    <!-- Content Area -->
    <div class="content-area">
        <h1>Discover the Best of Asian Cinema and TV!</h1>
        <h3>Unlimited Access to Korean Dramas, Japanese Anime, Bollywood Hits, and More.</h3>
    </div>
    <section id="trendingMTVShows" class="section-p1">
        <h2>Trending Movies & TV Shows</h2>
        <p class="subtitle">Discover the heart of Asian cinema and TV with our trending picks! From heartwarming romances to pulse-pounding thrillers, explore the classics and new favorites that everyone's talking about.</p>
        <div class="tre-container">
            <?php
                $moviequery = "SELECT * FROM movie WHERE rating > 3";
                $movieresult = mysqli_query($connect, $moviequery);
                if ($movieresult && mysqli_num_rows($movieresult) > 0 ){
                    while($row = mysqli_fetch_assoc($movieresult)) {
                        echo "
                        <div class='tre'>
                        <img src='data:image/jpeg;base64,".base64_encode($row['movie_image']) . "'>
                        <div class='des'>
                            <span>Movie</span>
                            <h5>".$row['title']."</h5>";
                                
                        $average = round($row['rating'] * 2) / 2; 
                        $avgRating = $row['rating'];
                        echo "<div class='ratingStar'>" . displayStars($average) . " (".$avgRating."/5)</div></div></div>";

                    }                    
                }

                $tvshowquery = "SELECT * FROM tvshow WHERE rating > 3";
                $tvshowresult = mysqli_query($connect, $tvshowquery);
                if ($tvshowresult && mysqli_num_rows($tvshowresult) > 0 ){
                    while($row = mysqli_fetch_assoc($tvshowresult)) {
                        echo "
                        <div class='tre'>
                        <img src='data:image/jpeg;base64,".base64_encode($row['tv_show_image']) . "'>
                        <div class='des'>
                            <span>TV Show</span>
                            <h5>".$row['title']."</h5>";
                                
                        $average = round($row['rating'] * 2) / 2; 
                        $avgRating = $row['rating'];
                        echo "<div class='ratingStar'>" . displayStars($average) . " (".$avgRating."/5)</div></div></div>";

                    }                    
                }
                function displayStars($rating) {
                    $stars = '';
                    for ($i = 1; $i <= floor($rating); $i++) {
                        $stars .= '★';
                    }
                    if ($rating - floor($rating) == 0.5) {
                        $stars .= '☆';
                    }
                    for ($i = ceil($rating); $i < 5; $i++) {
                        $stars .= '☆';
                    }
                    return $stars;
                }
            ?>
        </div>
    </section>
</body>
</html>
<?php include('footer.php');?>