<?php
include('sidenav_admin.php');
include('connection.php');
include('adminAccess.php');

// Check if the actor_id is set in the URL
if (isset($_GET['actor_id'])) {
    // Retrieve the actor_id from the URL
    $actor_id = $_GET['actor_id'];
}

// Fetch actor information
$sql_actor = "SELECT * FROM actor WHERE actor_id = '$actor_id'";
$result_actor = mysqli_query($connect, $sql_actor);
$actor = mysqli_fetch_assoc($result_actor);

// Fetch all movies that are NOT linked to the actor
$sql_availableMovies = "SELECT * FROM movie 
                        WHERE movie_id NOT IN (
                            SELECT movie_id FROM actor_movie WHERE actor_id = '$actor_id'
                        )";
$result_availableMovies = mysqli_query($connect, $sql_availableMovies);

// Fetch all TV shows that are NOT linked to the actor
$sql_availableTvShows = "SELECT * FROM tvshow 
                         WHERE tvshow_id NOT IN (
                             SELECT tvshow_id FROM actor_tvshow WHERE actor_id = '$actor_id'
                         )";
$result_availableTvShows = mysqli_query($connect, $sql_availableTvShows);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie or TV Show</title>
    <link rel="stylesheet" href="aAMTVS.css">
</head>
<body>
    <div id="main">
        <div class="container">
            <div class="header">
                <a href="update_actor.php?actor_id=<?php echo $actor['actor_id']?>" class="back-button">Back</a>
            </div>

            <div class="actor-info">
                <h2>Selected Actor: <?php echo htmlspecialchars($actor['actor_name']); ?></h2>
            </div>

            <div class="content">
                <!-- Add Movie Section -->
                <div class="add-section">
                    <h3>Add Movie</h3>
                    <form action="actorAddMovie.php" method="POST">
                        <label for="movie">Movie:</label>
                        <select id="movie" name="movie">
                            <option value="">Select a movie</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($result_availableMovies)) {
                                echo '<option value="' . htmlspecialchars($row['movie_id']) . '">' . htmlspecialchars($row['title']) . '</option>';
                            }
                            ?>
                        </select>
                        
                        <label for="movie-role">Role:</label>
                        <select id="movie-role" name="movie_role">
                            <option value="Main Character">Main Character</option>
                            <option value="Side Character">Side Character</option>
                        </select>
                        
                        <input type="hidden" name="actor_id" value="<?php echo htmlspecialchars($actor_id); ?>">
                        <button type="submit" class="add-button">Add Movie</button>
                    </form>
                </div>

                <!-- Add TV Show Section -->
                <div class="add-section">
                    <h3>Add TV Show</h3>
                    <form action="actorAddTVShow.php" method="POST">
                        <label for="tvshow">TV Show:</label>
                        <select id="tvshow" name="tvshow">
                            <option value="">Select a TV Show</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($result_availableTvShows)) {
                                echo '<option value="' . htmlspecialchars($row['tvshow_id']) . '">' . htmlspecialchars($row['title']) . '</option>';
                            }
                            ?>
                        </select>
                        
                        <label for="tvshow-role">Role:</label>
                        <select id="tvshow-role" name="tvshow_role">
                            <option value="Main Character">Main Character</option>
                            <option value="Side Character">Side Character</option>
                        </select>
                        
                        <input type="hidden" name="actor_id" value="<?php echo htmlspecialchars($actor_id); ?>">
                        <button type="submit" class="add-button">Add TV Show</button>
                    </form>
                </div>
            </div>
        </div>
        <?php include 'footer_admin.php';?>
    </div>
</body>
</html>