<?php
include 'connection.php';
session_start();

//check if the form is submitted
if((isset($_POST['watchlist_id']) && isset($_POST['progress_count']) && isset($_POST['status'])) || 
(isset($_GET['watchlist_id']) && isset($_GET['progress_count']) && isset($_GET['status']))){
    $watchlist_id = isset($_POST['watchlist_id']) ? $_POST['watchlist_id'] : $_GET['watchlist_id'];
    $new_progress_count = isset($_POST['progress_count']) ? $_POST['progress_count'] : $_GET['progress_count'];
    $current_status = isset($_POST['status']) ? $_POST['status'] : $_GET['status'];

    // Query to get the total episode count
    $total_query = "SELECT 
    CASE 
        WHEN w.movie_id IS NOT NULL THEN 1 
        WHEN w.tvshow_id IS NOT NULL THEN t.episodes
    END AS episodes
    FROM 
        watchlist w
    LEFT JOIN 
        movie m ON w.movie_id = m.movie_id
    LEFT JOIN 
    tvshow t ON w.tvshow_id = t.tvshow_id
    WHERE w.watchlist_id = '$watchlist_id'";
    $total_result = mysqli_query($connect, $total_query);

    // Check if the query executed successfully
    if ($total_result) {
        $total_row = mysqli_fetch_assoc($total_result);
        $total_episodes = $total_row['episodes'];


        // Check if progress count equals total episodes
        if ($new_progress_count == $total_episodes) {
            // If the current status is not already 'Completed', prompt user to confirm status change
            if ($current_status !== 'Completed') {
                echo "<script>
                    if (confirm('You have finished all episodes. Do you want to mark this as completed?')) {
                        window.location.href = 'update-progress.php?watchlist_id=$watchlist_id&progress_count=$new_progress_count&status=Completed';
                    } else {
                        // If they choose not to mark as completed, update with the current status
                        window.location.href = 'update-progress.php?watchlist_id=$watchlist_id&progress_count=$new_progress_count&status=$current_status';
                    }
                </script>";
            } // If already 'Completed', just skip to the update logic below
        }

            
        // Update the database
        $query = "UPDATE watchlist 
        SET progress_count='$new_progress_count',
            status='$current_status' 
        WHERE watchlist_id='$watchlist_id'";
        

        $results = mysqli_query($connect, $query);
        if ($current_status === 'Completed') {
            include 'set-completed-date.php'; // Call the separate file to set the end date
        }

        if ($results) {
            
        echo "<script>alert('Progress successfully saved'); window.location.href = 'watchlist.php';</script>";
        } else {
        echo "<script>alert('Error updating progress: " . mysqli_error($connect) . "');</script>";
        }

    } else {
        die("<script>alert('Error fetching total episodes: " . mysqli_error($connect) . "');</script>");
    }
 
        
}
else
{
    die("<script>alert('Invalid request');
    </script>");
}
mysqli_close($connect);


?>