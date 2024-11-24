<?php
include 'connection.php';

$query = "SELECT w.watchlist_id,
CASE 
        WHEN w.movie_id IS NOT NULL THEN 1 
        WHEN w.tvshow_id IS NOT NULL THEN t.episodes
    END AS episodes
FROM 
    watchlist w
LEFT JOIN 
    tvshow t ON w.tvshow_id = t.tvshow_id
WHERE w.watchlist_id = '$watchlist_id'
";
$result=mysqli_query($connect, $query);
if($result){

    $row = mysqli_fetch_assoc($result);
    $total_episodes = $row['episodes'];

    $update_query = "UPDATE watchlist SET progress_count = '$total_episodes' WHERE watchlist_id = '$watchlist_id'";

    if (!mysqli_query($connect, $update_query)) {
        echo "<script>alert('Error updating progress count: " . mysqli_error($connect) . "');</script>";
    }
} else {
    echo "<script>alert('Error fetching total episodes: " . mysqli_error($connect) . "');</script>";
}


?>
