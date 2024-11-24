<?php
    include 'connection.php'; 
    include 'sidenav_admin.php';
    include('adminAccess.php');


    if (isset($_GET['movie_id']) || isset($_GET['tvshow_id'])) {
        $movie_id = isset($_GET['movie_id']) ? mysqli_real_escape_string($connect, $_GET['movie_id']) : '';
        $tvshow_id = isset($_GET['tvshow_id']) ? mysqli_real_escape_string($connect, $_GET['tvshow_id']) : '';
        
        if ($movie_id) {
            $query = "SELECT * FROM movie WHERE movie_id = '$movie_id'";
        } elseif ($tvshow_id) {
            $query = "SELECT * FROM tvshow WHERE tvshow_id = '$tvshow_id'";
        } else {
            echo "<p>No valid ID provided.</p>";
            exit;
        }

        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $item = mysqli_fetch_assoc($result); 
        } else {
            echo "<p>Item not found.</p>";
            exit;
        }
    } else {
        echo "<p>No item selected.</p>";
        exit;
    }

    if (isset($_POST['sbmReviewBtn'])){
        $rate = isset($_POST['rating']) ? (6 - $_POST['rating']) : 0;
        $review = isset($_POST['txtReview']) ? $_POST['txtReview'] : "";
        $user_id = $_SESSION['user_id']; 
        
        if ($movie_id) {
            $validateQuery = "SELECT * FROM review WHERE user_id = '$user_id' AND movie_id='$movie_id'";
            $validateResult = mysqli_query($connect, $validateQuery);
            if(mysqli_num_rows($validateResult) > 0){
                echo "<script>alert('You already commented on this movie.');</script>";
            }else{
                $query = "INSERT INTO review (user_id, movie_id, rating, comment, review_date) 
                      VALUES ('$user_id', '$movie_id', '$rate', '$review', CURDATE())";
                $ratingQuery = "UPDATE movie m
                            INNER JOIN (
                                SELECT movie_id, AVG(rating) AS avg_rating
                                FROM review
                                WHERE movie_id = '$movie_id'
                            ) r ON m.movie_id = r.movie_id
                            SET m.rating = r.avg_rating;";
            }  
        } elseif ($tvshow_id) {
            $validateQuery = "SELECT * FROM review WHERE user_id = '$user_id' AND tvshow_id='$tvshow_id'";
            $validateResult = mysqli_query($connect, $validateQuery);
            if(mysqli_num_rows($validateResult) > 0){
                echo "<script>alert('You already commented on this tv show.');</script>";
            }else{
                $query = "INSERT INTO review (user_id, tvshow_id, rating, comment, review_date) 
                      VALUES ('$user_id', '$tvshow_id', '$rate', '$review', CURDATE())";
                $ratingQuery = "UPDATE tvshow t
                INNER JOIN (
                    SELECT tvshow_id, AVG(rating) AS avg_rating
                    FROM review
                    WHERE tvshow_id = '$tvshow_id'
                ) r ON t.tvshow_id = r.tvshow_id
                SET t.rating = r.avg_rating;";
            }
            
        }

        $result = mysqli_query($connect, $query);
        $ratingResult = mysqli_query($connect, $ratingQuery);
        if ($result && $ratingResult) {
            echo "<script>
                alert('You have successfully submitted a review');
                window.location='review.php?" . ($movie_id ? "movie_id=" . $movie_id : "tvshow_id=" . $tvshow_id) . "';
            </script>";
        } else {
            echo "<script>
                alert('Your review submission attempt was unsuccessful');
                window.location='review.php?" . ($movie_id ? "movie_id=" . $movie_id : "tvshow_id=" . $tvshow_id) . "';
            </script>";
        }
    }

    if(isset($_POST['addWatchlistBtn'])){
        $user_id = $_SESSION['user_id'];

        if ($movie_id) {
            $query = "INSERT INTO watchlist(user_id, movie_id) VALUES ('$user_id', '$movie_id')";
        } elseif ($tvshow_id) {
            $query = "INSERT INTO watchlist(user_id, tvshow_id) VALUES ('$user_id', '$tvshow_id')";
        }

        $result = mysqli_query($connect, $query);
        if ($result) {
            echo "<script>
                alert('Successfully added to watchlist.');
                window.location='review_admin.php?" . ($movie_id ? "movie_id=" . $movie_id : "tvshow_id=" . $tvshow_id) . "';
            </script>";
        } else {
            echo "<script>
                alert('Failed to add to watchlist.');
                window.location='review_admin.php?" . ($movie_id ? "movie_id=" . $movie_id : "tvshow_id=" . $tvshow_id) . "';
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
    <title>Review</title>
</head>
<body>
    <div id="main"> 
        <div class="details">
            <div class="detail1">
                <img src="data:image/jpeg;base64,<?php echo ($movie_id ? base64_encode($item['movie_image']) : base64_encode($item['tv_show_image'])); ?>" alt="<?php echo $item['title']; ?>">
                <br>
                <form action="" method="POST">
                    <input type="submit" value="Add to Watchlist" class="detailBtn" name="addWatchlistBtn">
                </form>
                <br>
                <a href="<?php echo ($movie_id ? "movie_detail.php?movie_id=" . $movie_id : "tvshow_detail.php?tvshow_id=" . $tvshow_id)?>"><input type="button" value="Back" class="detailBtn"></a>
            </div>
            <div class="detail2">
                <h1><?php echo $item['title']; ?></h1>
                <form action="" method="POST">
                    <h3>Rate:</h3>
                    <div class="star-rating">
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1" class="star">★</label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2" class="star">★</label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3" class="star">★</label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4" class="star">★</label>
                        <input type="radio" id="star5" name="rating" value="5"><label for="star5" class="star">★</label>
                    </div>
                    <h3>Review:</h3>
                    <textarea rows="5" name="txtReview" id="txtReview" class="txtReview"></textarea>

                    <input type="submit" value="Submit" name="sbmReviewBtn" class="submitBtn">
                </form>
            </div>
        </div>
        <?php include 'footer_admin.php';?>
    </div>
</body>
</html>
<?php mysqli_close($connect);?>