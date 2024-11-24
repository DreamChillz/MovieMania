<?php
    include 'connection.php'; 
    include 'sidenav_admin.php';
    include('adminAccess.php');
    
    if (isset($_GET['tvshow_id'])) {
        $movie_id = isset($_GET['tvshow_id']) ? $_GET['tvshow_id'] : '';
        $movie_id = mysqli_real_escape_string($connect, $movie_id);

        $query = "SELECT * FROM tvshow WHERE tvshow_id = '$movie_id'";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $movie = mysqli_fetch_assoc($result);
            $sql = "SELECT * FROM review WHERE tvshow_id = '$movie_id'";
            $result1 = mysqli_query($connect, $sql);
        } else {
            echo "<p>Movie not found.</p>";
            exit;
        }
    } else {
        echo "<p>No movie selected.</p>";
        exit;
    }

    if (isset($_POST['updateBtn'])){
        $genre = $_POST['txtGenre'];
        $year = $_POST['txtYear'];
        $language = $_POST['txtLanguage'];
        $director = $_POST['txtDirector'];
        $duration = $_POST['txtDuration'];
        $episodes = $_POST['txtEpisodes'];
        $age = $_POST['txtAge'];
        $description = $_POST['txtDescription'];
        $movieUrl = $_POST['txtUrl'];
        
        if (isset($_FILES['movieImage']) && $_FILES['movieImage']['error'] == 0) {
            $imageData = file_get_contents($_FILES['movieImage']['tmp_name']);
            $imageData = mysqli_real_escape_string($connect, $imageData);
    
            $updateQuery = "UPDATE tvshow SET 
                genre='$genre', 
                release_year='$year', 
                language='$language', 
                director='$director', 
                duration='$duration', 
                age_group='$age', 
                description='$description', 
                episodes='$episodes',
                video_url='$movieUrl', 
                tv_show_image='$imageData' 
                WHERE tvshow_id='$movie_id'";
        } else {
            $updateQuery = "UPDATE tvshow SET 
                genre='$genre', 
                release_year='$year', 
                language='$language', 
                director='$director', 
                duration='$duration',
                episodes='$episodes', 
                age_group='$age', 
                description='$description', 
                video_url='$movieUrl' 
                WHERE tvshow_id='$movie_id'";
        }
        echo "<script>alert('".$updateQuery."')</script>";
    
        if (mysqli_query($connect, $updateQuery)) {
            echo"<script>
                alert('You have successfully updated the tv show: ".$movie['title']."');
                window.location='update_tvshow.php?tvshow_id=" . $movie['tvshow_id'] . "';
            </script>";
        } else {
            echo"<script>
                alert('Failed to update the tv show: ".$movie['title']."');
                window.location='update_tvshow.php?tvshow_id=" . $movie['tvshow_id'] . "';
            </script>";
        }
    }

    if(isset($_POST['deleteBtn'])){
        $sql = "DELETE FROM tvshow WHERE tvshow_id = '$movie_id'";
        if (mysqli_query($connect, $sql)) {
            echo"<script>
                alert('You have successfully deleted the tv show: ".$movie['title']."');
                window.location='tvshow_admin.php';
            </script>";
        } else {
            echo"<script>
                alert('Failed to delete the tv show: ".$movie_id."');
                window.location='update_tvshow.php?tvshow_id=" . $movie['tvshow_id'] . "';
            </script>";
        }
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
    <title><?php echo $movie['title']; ?></title>
</head>
<body>
    <div id="main"> 
        <form method="POST" enctype="multipart/form-data">
            <div class="details">
                <div class="detail1">
                    <img id="movieImagePreview" src="data:image/jpeg;base64,<?php echo base64_encode($movie['tv_show_image']); ?>" alt="<?php echo $movie['title']; ?>">
                    <br>
                    
                    <input type="file" name="movieImage" id="movieImageInput" accept="image/*" style="display: none;">
                    <button type="button" class="detailBtn" id="changeImageBtn">Change Image</button>
                    <br>
                    <input type="submit" value="Delete" class="detailBtn" name="deleteBtn">
                    <br>
                    <a href="tvshow_admin.php"><input type="button" value="Back" class="detailBtn"></a>

                    <script>
                        document.getElementById('changeImageBtn').addEventListener('click', function() {
                            document.getElementById('movieImageInput').click();
                        });

                        document.getElementById('movieImageInput').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    document.getElementById('movieImagePreview').src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>
                </div>
                <div class="detail2">
                    <h1><?php echo $movie['title']; ?></h1>
                    <table>
                        <tr>
                            <td>Genre:</td>
                            <td>
                                <select name="txtGenre" id="txtGenre" required>
                                <?php
                                    echo "<option value='".$movie['genre']."' selected>".ucwords(strtolower($movie['genre']))."</option>";
                                ?>
                                    <option value="anime">Anime</option>
                                    <option value="drama">Drama</option>
                                    <option value="reality tv">Reality TV</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Release Year:</td>
                            <td>
                                <input type="text" name="txtYear" value="<?php echo ucwords(strtolower($movie['release_year'])); ?>" required pattern="[0-9]{1,10}"
						        oninput="this.setCustomValidity('')"
						        oninvalid="this.setCustomValidity('only numbers allowed')">
                            </td>
                        </tr>
                        <tr>
                            <td>Language:</td>
                            <td>
                                <input type="radio" name="txtLanguage" value="japanese" <?php if(strtolower($movie['language']) == 'japanese') echo 'checked'; ?>>Japanese
                                <input type="radio" name="txtLanguage" value="chinese" <?php if(strtolower($movie['language']) == 'chinese') echo 'checked'; ?>>Chinese
                                <input type="radio" name="txtLanguage" value="korean" <?php if(strtolower($movie['language']) == 'korean') echo 'checked'; ?>>Korean
                            </td>
                        </tr>
                        <tr>
                            <td>Director:</td>
                            <td><input type="text" name="txtDirector" value="<?php echo ucwords(strtolower($movie['director'])); ?>"></td>
                        </tr>
                        <tr>
                            <td>Duration:</td>
                            <td><input type="text" name="txtDuration" value="<?php echo ucwords(strtolower($movie['duration'])); ?>" pattern="[0-9]{1,10}"
						        oninput="this.setCustomValidity('')"
						        oninvalid="this.setCustomValidity('only numbers allowed')"> minutes</td>
                        </tr>
                        <tr>
                            <td>Episodes:</td>
                            <td><input type="text" name="txtEpisodes" value="<?php echo ucwords(strtolower($movie['episodes'])); ?>" pattern="[0-9]{1,10}"
						        oninput="this.setCustomValidity('')"
						        oninvalid="this.setCustomValidity('only numbers allowed')"></td>
                        </tr>
                        <tr>
                            <td>Age Group:</td>
                            <td><input type="text" name="txtAge" value="<?php echo ucwords(strtolower($movie['age_group'])); ?>" pattern="[0-9]{1,10}"
						        oninput="this.setCustomValidity('')"
						        oninvalid="this.setCustomValidity('only numbers allowed')"> +</td>
                        </tr>
                        <tr>
                            <td>Rating:</td>
                            <td>
                                <?php 
                                    $sql2 = "SELECT AVG(rating) as average_rating FROM review WHERE tvshow_id = '$movie_id'";  
                                    $result2 = mysqli_query($connect, $sql2);
                                    $avgRating = mysqli_fetch_assoc($result2);
                                    $average = round($avgRating['average_rating'] * 2) / 2; 
                                    $formattedAverageRating = number_format($avgRating['average_rating'], 1);

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
                                
                                    echo "<div class='ratingStar'>" . displayStars($average) . " (".$formattedAverageRating."/5)</div>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td><textarea name="txtDescription" id="" class="txtReview" rows="3"><?php echo ucwords(strtolower($movie['description'])); ?></textarea></td>
                        </tr>
                        <tr>
                            <td>Trailer URL:</td>
                            <td><textarea name="txtUrl" id="" class="txtReview" rows="2"><?php echo $movie['video_url']; ?></textarea></td>
                        </tr>
                    </table>
                    <input type="submit" value="Update" name="updateBtn" class="submitBtn">
                    
                </div>
            </div>
        </form>
        <?php include 'footer_admin.php';?>
    </div>
</body>
</html>
<?php mysqli_close($connect);?>