<?php
    include 'connection.php'; 
    include 'sidenav_admin.php';
    include ('adminAccess.php');
    
    if (isset($_GET['movie_id'])) {
        $movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : '';
        $movie_id = mysqli_real_escape_string($connect, $movie_id);

        $query = "SELECT * FROM movie WHERE movie_id = '$movie_id'";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $movie = mysqli_fetch_assoc($result);
            $sql = "SELECT * FROM review WHERE movie_id = '$movie_id'";
            $result1 = mysqli_query($connect, $sql);
        } else {
            echo "<p>Movie not found.</p>";
            exit;
        }
    } else {
        echo "<p>No movie selected.</p>";
        exit;
    }

    if(isset($_POST['addWatchlistBtn'])){
        $movie_id = $_GET['movie_id'];
        $user_id = $_SESSION['user_id'];

        $query = "INSERT INTO watchlist(user_id, movie_id) VALUES ('$user_id', '$movie_id')"; 

        $result = mysqli_query($connect, $query);
        if($result){
            echo"<script>
                alert('Movie is successfully added to watchlist.');
                window.location='movie_detail_admin.php?movie_id=" . $movie['movie_id'] . "';
            </script>";
        }else{
            echo"<script>
                alert('Failed adding movie to watchlist.');
                window.location='movie_detail_admin.php?movie_id=" . $movie['movie_id'] . "';
            </script>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <title><?php echo $movie['title']; ?></title>
</head>
<body>
    <div id="main"> 
        <div class="details">
            <div class="detail1">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($movie['movie_image']); ?>" alt="<?php echo $movie['title']; ?>">
                <br>
                <a href="update_movie.php?movie_id=<?php echo $movie['movie_id']?>"><input type="button" value="Update" class="detailBtn"></a>
                <br>
                <a href="movies_admin.php"><input type="button" value="Back" class="detailBtn"></a>
            </div>
            <div class="detail2">
                <h1><?php echo $movie['title']; ?></h1>
                <table>
                    <tr>
                        <td>Genre:</td>
                        <td><?php echo ucwords(strtolower($movie['genre'])); ?></td>
                    </tr>
                    <tr>
                        <td>Release Year:</td>
                        <td><?php echo $movie['release_year']; ?></td>
                    </tr>
                    <tr>
                        <td>Language:</td>
                        <td><?php echo ucwords(strtolower($movie['language'])); ?></td>
                    </tr>
                    <tr>
                        <td>Director:</td>
                        <td><?php echo $movie['director']; ?></td>
                    </tr>
                    <tr>
                        <td>Duration:</td>
                        <td><?php echo $movie['duration']; ?> minutes</td>
                    </tr>
                    <tr>
                        <td>Age Group:</td>
                        <td><?php echo $movie['age_group']; ?> +</td>
                    </tr>
                    <tr>
                        <td>Rating:</td>
                        <td>
                            <?php 
                                $avgRating = $movie['rating'];
                                $average = round($movie['rating'] * 2) / 2; 

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
                            
                                echo "<div class='ratingStar'>" . displayStars($average) . " (".$avgRating."/5)</div>";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><div class="description">
                        <?php echo ucfirst(strtolower($movie['description'])); ?>
                        </div></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="detail3">
            <h1>Trailer:</h1>
            <iframe width="100%" height="400" src="<?php echo $movie['video_url']; ?>"></iframe>
        </div>
        <div class="detail3">
            <h1>Cast:</h1>
            <div class="cast">
                <?php
                    $castQuery = "SELECT a.actor_id, a.actor_image, a.actor_name, am.role FROM actor a INNER JOIN actor_movie am ON a.actor_id = am.actor_id INNER JOIN movie m ON am.movie_id = m.movie_id WHERE m.movie_id = '$movie_id'";

                    $castResult = mysqli_query($connect, $castQuery);
                    if ($castResult && mysqli_num_rows($castResult) > 0) {
                        while ($cast = mysqli_fetch_assoc($castResult)) {
                            echo "
                            <div>
                                <a href='actor_admin.php?actor_id=".$cast['actor_id']."'><img src='data:image/jpeg;base64,".base64_encode($cast['actor_image'])."' class='cast-img'></a>
                                <p class='role'>".$cast['role']."</p>
                                <p>".$cast['actor_name']."</p>
                            </div>";
                        }
                    }else{
                        echo "<p>Cast not available.</p>";
                    }
                ?>
            </div>
        </div>
        <div class="detail3">
            <h1>Rating & Reviews:</h1>
            <!-- <a href="review_admin.php?movie_id=<?php echo $movie['movie_id']?>"><input type="button" value="Write A Review" class="submitBtn"></a> -->
            <div class="reviews">
                <?php
                    if ($result1 && mysqli_num_rows($result1) > 0) {
                        while ($review = mysqli_fetch_assoc($result1)) {
                            echo "<div class='review'>";
                            echo "<strong>".$review['user_id']."</strong><br>";
                            echo "<p>" .$review['rating'] . " ★</p>";
                            echo "<p>" . htmlspecialchars($review['comment']) . "</p>";
                            echo "<p><em>Reviewed on: " . date('F j, Y', strtotime($review['review_date'])) . "</em></p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No reviews yet.</p>";
                    }
                ?>
            </div>
        </div>
        <?php include 'footer_admin.php';?>
    </div>
</body>
</html>
<?php mysqli_close($connect);?>