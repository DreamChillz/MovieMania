<?php
include ('sidenav.php');
include ('connection.php');
include ('userAccess.php');
mysqli_set_charset($connect, "utf8mb4");

if (isset($_GET['actor_id'])){
    $actor_id = isset($_GET['actor_id']) ? $_GET['actor_id'] : '';
    if ($actor_id) {
        $sql_actor = "SELECT * FROM actor WHERE actor_id = '$actor_id'";
    } else {
        echo "<p>No valid ID provided.</p>";
        exit;
    }
    $result_actor = mysqli_query($connect, $sql_actor);
    $actor = mysqli_fetch_assoc($result_actor);

    // Convert the LONGBLOB to a base64 string
    $imageData = base64_encode($actor['actor_image']); // Assuming 'actorImage' is the LONGBLOB field
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;

    $sql_movieImage = "SELECT movie.movie_id, movie.title, movie.movie_image
                    FROM movie
                    JOIN actor_movie ON movie.movie_id = actor_movie.movie_id
                    WHERE actor_movie.actor_id = '$actor_id'";
    $result_movieImage = mysqli_query($connect, $sql_movieImage);

    // Fetch TV show data
    $sql_tvshowImage = "SELECT tvshow.tvshow_id, tvshow.title, tvshow.tv_show_image
                        FROM tvshow
                        JOIN actor_tvshow ON tvshow.tvshow_id = actor_tvshow.tvshow_id
                        WHERE actor_tvshow.actor_id = '$actor_id'";
    $result_tvshowImage = mysqli_query($connect, $sql_tvshowImage);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleLatest.css">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
    
</head>
<body>
    <div id="main">
        <div class="ActorInfo">  

            <div class = "image-box">
                <img src="<?php echo $imageSrc; ?>" alt="Actor Image" >
            </div>

            <div class = "bio-box">
                <h3>Biography</h3>
                <p><?php  echo htmlspecialchars($actor['bio']); ?></p>
            </div>

            <div class="details-box">
                <h3>Details</h3>
                <ul>
                    <li><strong>Actor ID:</strong> <?php echo htmlspecialchars($actor['actor_id']); ?></li>
                    <li><strong>Name:</strong> <?php echo htmlspecialchars($actor['actor_name']); ?></li>
                    <li><strong>Gender:</strong> <?php echo htmlspecialchars($actor['gender']); ?></li>
                    <li><strong>Country:</strong> <?php echo htmlspecialchars($actor['country']); ?></li>
                    <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($actor['date_of_birth']); ?></li>
                    <li><strong>Constellation:</strong> <?php echo htmlspecialchars($actor['constellation']); ?></li>
                    <li><strong>Age:</strong> <?php echo htmlspecialchars($actor['age']); ?></li>
                    <li><strong>Height:</strong> <?php echo htmlspecialchars($actor['height']); ?> cm</li>
                    <li><strong>Nationality:</strong> <?php echo htmlspecialchars($actor['nationality']); ?></li>
                </ul>
            </div>

            
        </div>
        <div class="MoviesAndTVShows">
            <h1>Movies and TV Shows</h1>
            
            <div class="movie-list">
            <?php
            // Display movie titles and images
            if (mysqli_num_rows($result_movieImage) > 0) {
                while ($movie = mysqli_fetch_assoc($result_movieImage)) {
                    $movieImageData = base64_encode($movie['movie_image']);
                    $movieImageSrc = "data:image/jpeg;base64," . $movieImageData;
            ?>
                <div class="movie-box">
                    <div class="movie-image-box">
                    <a href="movie_detail.php?movie_id=<?php echo $movie['movie_id']?>"><img src="<?php echo $movieImageSrc; ?>" alt="Movie Image"></a>
                    </div>
                    <div class="movie-name">
                        <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                    </div>
                </div>
            <?php
                }
            } else {
                ;
            }
            ?>
            </div>

            <div class="tvshow-list">
            <?php
            // Display TV show titles and images
            if (mysqli_num_rows($result_tvshowImage) > 0) {
                while ($tvshow = mysqli_fetch_assoc($result_tvshowImage)) {
                    $tvshowImageData = base64_encode($tvshow['tv_show_image']);
                    $tvshowImageSrc = "data:image/jpeg;base64," . $tvshowImageData;
            ?>
                <div class="tvshow-box">
                    <div class="tvshow-image-box">
                        <a href="tvshow_detail.php?tvshow_id=<?php echo $tvshow['tvshow_id']?>"><img src="<?php echo $tvshowImageSrc; ?>" alt="TV Show Image"></a>
                    </div>
                    <div class="tvshow-name">
                        <h3><?php echo htmlspecialchars($tvshow['title']); ?></h3>
                    </div>
                </div>
            <?php
                }
            } else {
                ;
            }
            ?>
            </div>
        </div>
 
        <?php include ('footer.php');?>
    </div>

</body>
</html>