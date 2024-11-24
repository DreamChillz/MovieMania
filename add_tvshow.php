<?php
    include 'connection.php'; 
    include 'sidenav_admin.php';
    include ('adminAccess.php');

    if (isset($_POST['submitBtn'])){
        $movie_id = $_POST['txtMovieId'];
        $title = $_POST['txtTitle'];
        $genre = $_POST['txtGenre'];
        $year = $_POST['txtYear'];
        $language = $_POST['txtLanguage'];
        $director = $_POST['txtDirector'];
        $duration = $_POST['txtDuration'];
        $age = $_POST['txtAge'];
        $description = $_POST['txtDescription'];
        $movieUrl = $_POST['txtUrl'];
        $episodes = $_POST['txtEpisode'];
        $imageData = file_get_contents($_FILES['movieImage']['tmp_name']);
        $imageData = mysqli_real_escape_string($connect, $imageData);

        $query = "INSERT INTO tvshow(tvshow_id, title, release_year, language, director, video_url, genre, description, duration, tv_show_image, episodes, age_group) VALUES ('$movie_id', '$title', '$year', '$language', '$director', '$movieUrl', '$genre', '$description', '$duration', '$imageData', '$episodes','$age')";
    
        if (mysqli_query($connect, $query)) {
            echo"<script>
                alert('You have successfully added the tv show: ".$title."');
                window.location='tvshow_admin.php';
            </script>";
        } else {
            if (mysqli_errno($connect) == 1062) {
                echo"<script>
                    alert('Failed to add the tv show: ".$title." - TV Show ID already exists.');
                    window.location='add_tvshow.php';
                </script>";
            } else {
                // General error message for other failures
                $errorMessage = mysqli_error($connect);
                echo"<script>
                    alert('Failed to add the tv show: ".$title."');
                    window.location='add_tvshow.php';
                </script>";
            }
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
    <title>Add TV Show</title>
</head>
<body>
    <div id="main"> 
        <form method="POST" enctype="multipart/form-data">
            <div class="details">
                <div class="detail1">
                    <img id="movieImagePreview" src="images/uploadImage.png">
                    <br>
                    <input type="file" name="movieImage" id="movieImageInput" accept="image/*" style="display: none;" required>
                    <button type="button" class="detailBtn" id="changeImageBtn">Upload Image</button>
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
                    <h1>New TV Show</h1>
                    <table>
                        <tr>
                            <td>TV Show ID:</td>
                            <td><input type="text" name="txtMovieId" required pattern="[A-Za-z0-9]{1,10}"
						        oninput="this.setCustomValidity('')"
						        oninvalid="this.setCustomValidity('maximum 10 letters and numbers')"></td>
                        </tr>
                        <tr>
                            <td>Title:</td>
                            <td><input type="text" name="txtTitle" required></td>
                        </tr>
                        <tr>
                            <td>Genre:</td>
                            <td>
                                <select name="txtGenre" id="txtGenre" required>
                                    <option value="anime">Anime</option>
                                    <option value="drama">Drama</option>
                                    <option value="reality tv">Reality TV</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Release Year:</td>
                            <td><input type="text" name="txtYear" required></td>
                        </tr>
                        <tr>
                            <td>Language:</td>
                            <td>
                                <input type="radio" name="txtLanguage" value="japanese">Japanese
                                <input type="radio" name="txtLanguage" value="chinese">Chinese
                                <input type="radio" name="txtLanguage" value="korean">Korean
                            </td>
                        </tr>
                        <tr>
                            <td>Director:</td>
                            <td><input type="text" name="txtDirector"></td>
                        </tr>
                        <tr>
                            <td>Duration:</td>
                            <td><input type="text" name="txtDuration" pattern="[0-9]{1,10}"
						        oninput="this.setCustomValidity('')"
						        oninvalid="this.setCustomValidity('only numbers allowed!')"> minutes</td>
                        </tr>
                        <tr>
                            <td>Episodes:</td>
                            <td>
                                <input type="text" name="txtEpisode" pattern="[0-9]{1,10}"
						        oninput="this.setCustomValidity('')"
						        oninvalid="this.setCustomValidity('only numbers allowed!')">
                            </td>
                        </tr>
                        <tr>
                            <td>Age Group:</td>
                            <td>
                                <input type="text" name="txtAge"
                                pattern="[0-9]{1,10}"
						        oninput="this.setCustomValidity('')"
						        oninvalid="this.setCustomValidity('only numbers allowed!')"> +
                            </td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td><textarea name="txtDescription" id="" class="txtReview" rows="3"></textarea></td>
                        </tr>
                        <tr>
                            <td>Trailer URL:</td>
                            <td><textarea name="txtUrl" id="" class="txtReview" rows="2"></textarea></td>
                        </tr>
                    </table>
                    <div id="buttons">
                        <input type="reset" value="Reset" class="submitBtn" style="margin-left: 0px;">
                        <input type="submit" value="Submit" name="submitBtn" class="submitBtn">
                    </div>
                    
                </div>
            </div>
        </form>
        <?php include 'footer_admin.php';?>
    </div>
</body>
</html>
<?php mysqli_close($connect);?>