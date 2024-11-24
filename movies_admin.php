<?php
    include 'connection.php';
    include ('adminAccess.php');

    $sql = "SELECT movie_id, movie_image, title, rating FROM movie";
    $result = mysqli_query($connect, $sql);


    if (isset($_POST['filterBtn'])){
        $genre = isset($_POST['genre']) ? $_POST['genre'] : [];
        $year = isset($_POST['year']) ? $_POST['year'] : [];
        $language = isset($_POST['language']) ? $_POST['language'] : [];

        $query = "SELECT movie_id, movie_image, title, rating FROM movie WHERE 1=1"; 

        if (!empty($genre)) {
            $genres = "'" . implode("','", $genre) . "'";
            $query .= " AND genre IN ($genres)";
        }
    
        if (!empty($year)) {
            $years = "'" . implode("','", $year) . "'";
            $query .= " AND release_year IN ($years)";
        }
    
        if (!empty($language)) {
            $languages = "'" . implode("','", $language) . "'";
            $query .= " AND language IN ($languages)";
        }


        $result = mysqli_query($connect, $query);

    }

    if(isset($_POST['searchBtn'])){
        $search = $_POST['searchBar'];

        $searchQuery = "SELECT * FROM movie WHERE title LIKE '%$search%'";
        $result = mysqli_query($connect, $searchQuery);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <title>Movies</title>
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <p>Filter</p>
        <form action="" method="POST">
            <p>Genre</p>
            <input type="checkbox" name="genre[]" value="romance">Romance <br>
            <input type="checkbox" name="genre[]" value="thriller">Thriller <br>
            <input type="checkbox" name="genre[]" value="comedy">Comedy <br>

            <p>Year</p>
            <input type="checkbox" name="year[]" value="2024">2024 <br>
            <input type="checkbox" name="year[]" value="2023">2023 <br>
            <input type="checkbox" name="year[]" value="2022">2022 <br>

            <p>Language</p>
            <input type="checkbox" name="language[]" value="japanese">Japanese <br>
            <input type="checkbox" name="language[]" value="chinese">Chinese <br>
            <input type="checkbox" name="language[]" value="korean">Korean <br>

            <input type="submit" value="Filter" name="filterBtn" class="button">
            <input type="reset" value="Reset" class="button" id="resetBtn"> 
        </form>

        <hr>

        <p>Pages</p>
        <a href="home_admin.php">Home</a>
        <a href="movies_admin.php">Movies</a>
        <a href="tvshow_admin.php">TV Shows</a>
        <a href="news.php">News</a>
        <a href="profile.php">Profile</a>
        <a href="faq_admin.php">FAQ</a>
        <a href="logout.php">Logout</a>
        <br><br><br>
    </div>

    <div id="main">
        <div id="menu-bar">
            <!-- <img src="images/logo2.png" alt=""> -->
            <span id="openNav" onclick="openNav()">&#9776;</span>
            <img src="images/moviemanialogo.png" alt="movie mania logo" class="logo">
            <a href="profile.php"><img src="images/profileIcon.png" alt="profile icon" id="profileIcon"></a>
        </div>

        <form action="" method="POST" class="search-form">
            <h1 id="title">Movies</h1>
            <div id="searchContainer">
                <input type="text" name="searchBar" id="searchBar" placeholder="Search for movies...">
                <button type="submit" name="searchBtn" id="searchButton">
                    <img src="images/searchIcon.png" alt="search icon">
                </button>
            </div>
        </form>

        <div class="gallery">
            <div class="add-movie-card">
                <a href="add_movie.php"><span>+</span></a>
                <div class="movie-title">Add Movie</div>
            </div>
            <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $imageData = base64_encode($row["movie_image"]);
                        $src = 'data:image/jpeg;base64,' . $imageData;
                        echo '<div class="movie-card">';
                        echo '<a href="movie_detail_admin.php?movie_id=' . $row["movie_id"] . '"><img src="' . $src . '" alt="' . $row["title"] . '"></a>';
                        echo '<div class="movie-title">' . $row["title"] . '</div>';
                        $average = round($row['rating'] * 2) / 2; 
                        $avgRating = $row['rating'];
                        echo "<div class='ratingStar'>" . displayStars($average) . " </div>";
                        echo '</div>';
                    }
                } else {
                    echo "<p>No movies found.</p>";
                }
                function displayStars($rating) {
                    $stars = '';
                    for ($i = 1; $i <= floor($rating); $i++) {
                        $stars .= '★';
                    }
                    if ($rating - floor($rating) == 0.5) {
                        $stars .= '☆';
                    }
                    for ($i = ceil($rating); $i < 5; $i++) {
                        $stars .= '☆';
                    }
                    return $stars;
                }
            ?>
        </div>
        <script>
            window.onload = function() {
                const selectedGenres = <?php echo json_encode(isset($_POST['genre']) ? $_POST['genre'] : []); ?>;
                const selectedYears = <?php echo json_encode(isset($_POST['year']) ? $_POST['year'] : []); ?>;
                const selectedLanguages = <?php echo json_encode(isset($_POST['language']) ? $_POST['language'] : []); ?>;

                document.querySelectorAll('input[name="genre[]"]').forEach(checkbox => {
                    if (selectedGenres.includes(checkbox.value)) {
                        checkbox.checked = true;
                    }
                });
                document.querySelectorAll('input[name="year[]"]').forEach(checkbox => {
                    if (selectedYears.includes(checkbox.value)) {
                        checkbox.checked = true;
                    }
                });
                document.querySelectorAll('input[name="language[]"]').forEach(checkbox => {
                    if (selectedLanguages.includes(checkbox.value)) {
                        checkbox.checked = true;
                    }
                });
            }
        </script>
        <?php include 'footer_admin.php';?>
    </div>
</body>
</html>
<?php mysqli_close($connect);?>