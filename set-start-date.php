<?php
// Include the database connection
include 'connection.php';

// Set the start date only if it is NULL or empty
$query = "UPDATE watchlist 
            SET startDate = NOW() 
            WHERE watchlist_id='$watchlist_id' 
            AND (startDate IS NULL OR startDate = '')";
mysqli_query($connect, $query);
?>
