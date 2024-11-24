<?php

include 'connection.php';
include('loginAccess.php');
if($_SESSION['role'] == 'admin'){
    include 'sidenav_admin.php' ;
}else if($_SESSION['role'] == 'user'){
    include 'sidenav.php' ;
}

$user_id = $_SESSION['user_id'];
// Set a default status if none is provided (e.g., on first page load)
if (!isset($_POST['status'])) {
    $status = 'All';  // Set 'All' as default
} else {
    $status = $_POST['status'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist</title>
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
    <!-- stylesheet -->
    <link rel="stylesheet" href="watchlist-css.css">
   <!-- fonts -->
   <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">


    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <div id='main'>
    <?php
    echo"<h1>".$user_id."'s Watchlist</h1>" 
    ?>
    <div class="status-menu-container">
        <div class="status-container">
        <form method="post">
        <input type="submit" name="status" value="All" class="tab <?php if ($status == 'All') echo 'active'; ?>" id="all">
        <input type="submit" name="status" value="Watching" class="tab <?php if($status == 'Watching') echo 'active'; ?>" id="watching">
        <input type="submit" name="status" value="On Hold" class="tab <?php if($status=='On Hold') echo 'active'; ?>" id="on-hold">
        <input type="submit" name="status" value="Dropped" class="tab <?php if($status== 'Dropped') echo 'active'; ?>" id="dropped">
        <input type="submit" name="status" value="Completed" class="tab <?php if($status == 'Completed') echo 'active'; ?>" id="completed">
        <input type="submit" name="status" value="Plan to Watch" class="tab <?php if($status=='Plan to Watch') echo 'active'; ?>" id="plan-to-watch">
        </form>

        </div>
    

        <div class="search-container">
            <form method="post" class="search" action="">
                <input type="text" placeholder="Search title" name="search-watchlist">
                <button type="submit" class="searchbtn" name="search-title-btn"><i class="fa fa-search"></i></button>
                <button type="submit" class="reset" name="reset-btn">Reset</button>
            </form>
        </div>
    </div>
 <div class='watchlist-table'>


    <table id="wl-table" border="1">
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Score</th>
            <th>Progress</th>
            <th>Status</th>
            <th>Start Date</th>
            <th>Completed Date</th>
        </tr>

    


<?php

// Check if search, status, or reset button is clicked and adjust the query accordingly
if (isset($_POST['search-title-btn'])) {
    $searchTitle =$_POST['search-watchlist'];

    $query="SELECT 
    w.watchlist_id,
    COALESCE(m.movie_image, t.tv_show_image) AS image,
    COALESCE(m.title, t.title) AS title,
    COALESCE(m.rating, t.rating) AS rating,
    COALESCE(m.genre, t.genre) AS genre,
    COALESCE(m.release_year, t.release_year) AS release_year,
    COALESCE(r.rating, 'Not rated') AS score,
    CASE 
        WHEN w.movie_id IS NOT NULL THEN 'Movie' 
        WHEN w.tvshow_id IS NOT NULL THEN 'TV Show' 
    END AS type,
    w.progress_count,
    w.status,
    COALESCE(w.startDate, '-') AS start_date,
    COALESCE(w.completedDate, '-') AS completed_date,
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
LEFT JOIN 
    review r ON (w.movie_id = r.movie_id OR w.tvshow_id = r.tvshow_id) AND r.user_id = '$user_id'
WHERE 
    w.user_id = '$user_id'
AND (m.title LIKE '%$searchTitle%' OR t.title LIKE '%$searchTitle%')
";

} 

elseif (isset($_POST['btnReset'])) {
    // Reset to default query
    $query="SELECT 
    w.watchlist_id,
    COALESCE(m.movie_image, t.tv_show_image) AS image,
    COALESCE(m.title, t.title) AS title,
    COALESCE(m.rating, t.rating) AS rating,
    COALESCE(m.genre, t.genre) AS genre,
    COALESCE(m.release_year, t.release_year) AS release_year,
    COALESCE(r.rating, 'Not rated') AS score,
    CASE 
        WHEN w.movie_id IS NOT NULL THEN 'Movie' 
        WHEN w.tvshow_id IS NOT NULL THEN 'TV Show' 
    END AS type,
    w.progress_count,
    w.status,
    COALESCE(w.startDate, '-') AS start_date,
    COALESCE(w.completedDate, '-') AS completed_date,
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
LEFT JOIN 
    review r ON (w.movie_id = r.movie_id OR w.tvshow_id = r.tvshow_id) AND r.user_id = '$user_id'
WHERE w.user_id = '$user_id'
    ";

} 
elseif(isset($_POST['status'])) {
    // Filter by status
    $status = $_POST['status'];
    
    // Start with the base query
    $query="SELECT 
    w.watchlist_id,
    COALESCE(m.movie_image, t.tv_show_image) AS image,
    COALESCE(m.title, t.title) AS title,
    COALESCE(m.rating, t.rating) AS rating,
    COALESCE(m.genre, t.genre) AS genre,
    COALESCE(m.release_year, t.release_year) AS release_year,
    COALESCE(r.rating, 'Not rated') AS score,
    CASE 
        WHEN w.movie_id IS NOT NULL THEN 'Movie' 
        WHEN w.tvshow_id IS NOT NULL THEN 'TV Show' 
    END AS type,
    w.progress_count,
    w.status,
    COALESCE(w.startDate, '-') AS start_date,
    COALESCE(w.completedDate, '-') AS completed_date,
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
LEFT JOIN 
    review r ON (w.movie_id = r.movie_id OR w.tvshow_id = r.tvshow_id) AND r.user_id = '$user_id'
WHERE 
    w.user_id = '$user_id'";
    
    // Append the status filter
    if ($status != 'All') {
        $query .= " AND w.status = '$status'";
    }


}


else {
    // Default state (e.g., on first load)
    $query="SELECT 
    w.watchlist_id,
    COALESCE(m.movie_image, t.tv_show_image) AS image,
    COALESCE(m.title, t.title) AS title,
    COALESCE(m.rating, t.rating) AS rating,
    COALESCE(m.genre, t.genre) AS genre,
    COALESCE(m.release_year, t.release_year) AS release_year,
    COALESCE(r.rating, 'Not rated') AS score,
    CASE 
        WHEN w.movie_id IS NOT NULL THEN 'Movie' 
        WHEN w.tvshow_id IS NOT NULL THEN 'TV Show' 
    END AS type,
    w.progress_count,
    w.status,
    COALESCE(w.startDate, '-') AS start_date,
    COALESCE(w.completedDate, '-') AS completed_date,
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
LEFT JOIN 
    review r ON (w.movie_id = r.movie_id OR w.tvshow_id = r.tvshow_id) AND r.user_id = '$user_id'
WHERE w.user_id = '$user_id'
";
}


$results=mysqli_query($connect,$query);
if (mysqli_num_rows($results) > 0) {
//numbering for table
$no=0;

    while ($row=mysqli_fetch_array($results))
    {

        // Convert binary image data to base64 and display it
        $imageData = base64_encode($row["image"]);
        $src = 'data:image/jpeg;base64,' . $imageData;
        
        echo"<tr>
            <td>" .++$no." </td>
            <td> 
            <div class='title-container'>
            <img class='watchlist-image' src=" . $src . " alt=''>
                <div class='details-container'>
                    <span class='title'>".$row['title']."</span>
                    <span>Type: ".$row['type']."</span>
                    <span>Rating: ".$row['rating']."</span>
                    <span>Genre: ".ucwords($row['genre'])."</span>
                    <span>Release Year: ".$row['release_year']."</span>
    
                </div>
            </div>
            </td>
            <td>".$row['score']. "</td>
            <td>";
?>

<?php       // Check if the status is not "completed"
    if ($row['status'] !== 'Completed') { ?>

        <form method='post' action='update-progress.php'>
                <input type='hidden' name='watchlist_id' value='<?php echo $row['watchlist_id']; ?>'>
                <input type='hidden' id='status' name='status' value='<?php echo $row['status']; ?>'>
                <input class='number-wheel' type='number' id='progress_count' name='progress_count' value='<?php echo $row['progress_count']; ?>' min='0' max='<?php echo $row['episodes']; ?>' required>
                / <?php echo $row['episodes']; ?>
                <button type='submit' class='save-button'><i class='fas fa-save'></i></button>
              </form>
<?php    } else {
        // Display progress without an editable input for completed status
        echo $row['progress_count'] . " / " . $row['episodes'];
    }

        echo "</td>

            <td>
            <form action='update-status.php' method='post'>

            <input type='hidden' name='watchlist_id' value='" . $row['watchlist_id'] . "'>
    <select class='custom-dropdown' name='status'  onchange='this.form.submit()'>
        <option value='Watching' " . ($row['status'] == 'Watching' ? 'selected' : '') . ">Watching</option>
        <option value='Completed' " . ($row['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>
        <option value='On Hold' " . ($row['status'] == 'On Hold' ? 'selected' : '') . ">On Hold</option>
        <option value='Dropped' " . ($row['status'] == 'Dropped' ? 'selected' : '') . ">Dropped</option>
        <option value='Plan to Watch' " . ($row['status'] == 'Plan to Watch' ? 'selected' : '') . ">Plan to Watch</option>
    </select>
</form>  
            </td>
            <td>".$row['start_date']."</td>
            <td>".$row['completed_date']."</td>

        </tr>";
    } 
}
else {
    echo "<tr><td colspan='7'>No results found</td></tr>";
}
?>

</table>
</div>
</div>

</body>
</html>

<?php 
if($_SESSION['role'] == 'admin'){
    include('footer_admin.php');
}else if($_SESSION['role'] == 'user'){
    include('footer.php');
}?>
