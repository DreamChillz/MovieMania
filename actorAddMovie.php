<?php
include('connection.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $actor_id = $_POST['actor_id'];
    $movie_id = $_POST['movie'];
    $role = $_POST['movie_role'];

    // Check if actor_id, movie_id, and role are set
    if (!empty($actor_id) && !empty($movie_id) && !empty($role)) {
        // Insert the data into the actor_movie table
        $sql_addMovie = "INSERT INTO actor_movie (actor_id, movie_id, role) VALUES ('$actor_id', '$movie_id', '$role')";

        if (mysqli_query($connect, $sql_addMovie)) {
            echo "<script>
                    alert('Movie added successfully!');
                    window.location.href = 'update_actor.php?actor_id=$actor_id';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Failed to add movie.');
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
