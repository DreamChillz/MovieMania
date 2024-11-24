<?php
    include 'connection.php'; 
    include 'sidenav.php';
    include('userAccess.php');
    
    if (isset($_GET['tvshow_id'])) {
        $movie_id = isset($_GET['tvshow_id']) ? $_GET['tvshow_id'] : '';
        $movie_id = mysqli_real_escape_string($connect, $movie_id);

        $query = "SELECT * FROM tvshow WHERE tvshow_id = '$movie_id'";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $movie = mysqli_fetch_assoc($result);
            $sql = "SELECT * FROM review WHERE tvshow_id = '$movie_id'";
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
        $movie_id = $_GET['tvshow_id'];
        $user_id = $_SESSION['user_id'];

        $validateQuery = "SELECT * FROM watchlist WHERE user_id='$user_id' AND tvshow_id = '$movie_id'";
        $validateResult = mysqli_query($connect, $validateQuery);

        if ($validateQuery && mysqli_num_rows($validateResult)>0){
            echo"<script>
                    alert('Fail to add to watchlist. TV Show has already existed in watchlist.');
                    window.location='tvshow_detail.php?tvshow_id=" . $movie['tvshow_id'] . "';
                </script>";
        }else{
            $query = "INSERT INTO watchlist(user_id, tvshow_id) VALUES ('$user_id', '$movie_id')"; 

            $result = mysqli_query($connect, $query);
            if($result){
                echo"<script>
                    alert('TV Show is successfully added to watchlist.');
                    window.location='tvshow_detail.php?tvshow_id=" . $movie['tvshow_id'] . "';
                </script>";
            }else{
                echo"<script>
                    alert('Failed adding tv show to watchlist.');
                    window.location='tvshow_detail.php?tvshow_id=" . $movie['tvshow_id'] . "';
                </script>";
            }
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
                <img src="data:image/jpeg;base64,<?php echo base64_encode($movie['tv_show_image']); ?>" alt="<?php echo $movie['title']; ?>">
                <br>
                <form action="" method="POST">
                <input type="submit" value="Add to Watchlist" class="detailBtn" name="addWatchlistBtn">
                </form>
                <br>
                <a href="tvshows.php"><input type="button" value="Back" class="detailBtn"></a>
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
                        <td>Episodes:</td>
                        <td><?php echo $movie['episodes']; ?></td>
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
                    $castQuery = "SELECT a.actor_id, a.actor_image, a.actor_name, at.role FROM actor a INNER JOIN actor_tvshow at ON a.actor_id = at.actor_id INNER JOIN tvshow t ON at.tvshow_id = t.tvshow_id WHERE t.tvshow_id = '$movie_id'";

                    $castResult = mysqli_query($connect, $castQuery);
                    if ($castResult && mysqli_num_rows($castResult) > 0) {
                        while ($cast = mysqli_fetch_assoc($castResult)) {
                            echo "
                            <div>
                                <a href='actor.php?actor_id=".$cast['actor_id']."'><img src='data:image/jpeg;base64,".base64_encode($cast['actor_image'])."' class='cast-img'></a>
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
            <a href="review.php?tvshow_id=<?php echo $movie['tvshow_id']?>"><input type="button" value="Write A Review" class="submitBtn"></a>
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
        <?php include 'footer.php';?>
    </div>
</body>
</html>
<?php mysqli_close($connect);?>