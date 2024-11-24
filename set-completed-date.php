<?php
// Include the database connection
include 'connection.php';

// Set the completed date only if it is NULL or empty
$query = "UPDATE watchlist 
            SET completedDate = NOW() 
            WHERE watchlist_id='$watchlist_id' 
            AND (completedDate IS NULL OR completedDate = '')";
mysqli_query($connect, $query);
?>
