<?php
include 'connection.php';

$user_id = $_SESSION['user_id'];

// Query to get the total count of each status
$query="SELECT status, COUNT(*) AS count FROM watchlist
WHERE user_id='$user_id'
GROUP BY status
";
$result=mysqli_query($connect,$query);

$statuses = ['Plan to Watch' => 0, 'Watching' => 0, 'Completed' => 0, 'On Hold' => 0, 'Dropped' => 0];
$total = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $statuses[$row['status']] = $row['count'];
    $total += $row['count'];
}

// Calculate percentages
foreach ($statuses as $status => $count) {
    $percentages[$status] = ($total > 0) ? round(($count / $total) * 100) : 0;
}


// Fetch total completed
$query = "SELECT COUNT(*) AS total_completed FROM watchlist WHERE user_id = '$user_id' AND status = 'Completed'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);
$total_completed = $row['total_completed'];

// Fetch total watching
$query = "SELECT COUNT(*) AS total_watching FROM watchlist WHERE user_id = '$user_id' AND status = 'Watching'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);
$total_watching = $row['total_watching'];

// Fetch total plan to watch
$query = "SELECT COUNT(*) AS total_plan_to_watch FROM watchlist WHERE user_id = '$user_id' AND status = 'Plan to Watch'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);
$total_plan_to_watch = $row['total_plan_to_watch'];

// Fetch total on-hold or dropped
$query = "SELECT COUNT(*) AS total_on_hold FROM watchlist WHERE user_id = '$user_id' AND status ='On Hold'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);
$total_on_hold = $row['total_on_hold'];

//fetch total dropped
$query = "SELECT COUNT(*) AS total_dropped FROM watchlist WHERE user_id = '$user_id' AND status = 'dropped'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);
$total_dropped = $row['total_dropped'];

// Fetch favorite genre
$query = "SELECT COALESCE(m.genre, t.genre) AS genre,
COUNT(*) AS count 
FROM watchlist w 
LEFT JOIN movie m ON w.movie_id = m.movie_id
LEFT JOIN tvshow t ON w.tvshow_id = t.tvshow_id 
WHERE w.user_id = '$user_id' 
GROUP BY genre 
ORDER BY count DESC LIMIT 1";
$result = mysqli_query($connect, $query);
// Check if the result exists
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $favorite_genre = $row['genre'];
} else {
    $favorite_genre = 'No favorite genre yet'; // Default message for new users
}


// Fetch total episodes watched
$query = "SELECT SUM(progress_count)  AS total_episodes FROM watchlist w 
LEFT JOIN tvshow ON w.tvshow_id = tvshow.tvshow_id
LEFT JOIN movie m ON w.movie_id = m.movie_id 
WHERE w.user_id = '$user_id' ";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);
$total_episodes_watched = $row['total_episodes'] ? $row['total_episodes'] : 0;

// Fetch average ratings given
$query = "SELECT AVG(rating) AS avg_rating FROM review WHERE user_id = '$user_id'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);
$avg_rating = $row['avg_rating'];

// Close the connection
mysqli_close($connect);
?>



