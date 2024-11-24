<?php
include('connection.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $actor_id = $_POST['actor_id'];
    $tvshow_id = $_POST['tvshow'];
    $role = $_POST['tvshow_role'];

    // Check if actor_id, tvshow_id, and role are set
    if (!empty($actor_id) && !empty($tvshow_id) && !empty($role)) {
        // Insert the data into the actor_tvshow table
        $sql_addTvShow = "INSERT INTO actor_tvshow (actor_id, tvshow_id, role) VALUES ('$actor_id', '$tvshow_id', '$role')";

        if (mysqli_query($connect, $sql_addTvShow)) {
            echo "<script>
                    alert('TV Show added successfully!');
                    window.location.href = 'update_actor.php?actor_id=$actor_id';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Failed to add TV show.');
                    window.location.href = 'update_actor.php?actor_id=$actor_id';
                  </script>";
        }
    } else {
        echo "<script>alert('Please make sure all fields are filled.');</script>";
    }
}

// Close the connection
mysqli_close($connect);
?>
