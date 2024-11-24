<?php
include 'connection.php';
session_start();

if(isset($_POST['watchlist_id']) && isset($_POST['status'])){
    $watchlist_id=$_POST['watchlist_id'];
    $new_status=$_POST['status'];

    $query="UPDATE watchlist SET status='$new_status' 
    WHERE watchlist_id='$watchlist_id'";
    
    if(mysqli_query($connect,$query)){
        if ($new_status === 'Watching') {
            include 'set-start-date.php'; // Call the separate file to set the start date
        } elseif ($new_status === 'Completed'){
            include 'set-completed-date.php'; // Call the separate file to set the completed date
            
            //change progress count to total episodes
            include 'max-progress-count.php';
        }

        echo "<script> alert('Status successfully updated');
        window.location.href = 'watchlist.php';
        </script>";
        
    }
    else{
        echo "<script>alert('Error updating status".mysqli_error($connect)."');
        </script>";
    }
}
else
{
    die("<script>alert('Error updating status');
    </script>");
}


?>