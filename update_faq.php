<?php
    include "connection.php";
    include "sidenav_admin.php";
    include('adminAccess.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['txtfaq_id']) && isset($_POST['txtquestion']) && isset($_POST['txtanswer'])) {
            $faq_id = $_POST['txtfaq_id'];
            $question = $_POST['txtquestion'];
            $answer = $_POST['txtanswer'];

            $updateQuery = "UPDATE faq SET question='$question', answer='$answer' WHERE faq_id='$faq_id'";

            if (mysqli_query($connect, $updateQuery)) {
                echo "<script>alert('FAQ updated successfully!')</script>";
            } else {
                echo "<script>alert('FAQ failed to update.')</script>>";
            }
        }

        if (isset($_POST['txtuploadfaq_id']) && isset($_POST['txtuploadquestion']) && isset($_POST['txtuploadanswer'])) {
            $uploadFaqId = $_POST['txtuploadfaq_id'];
            $uploadQuestion = $_POST['txtuploadquestion'];
            $uploadAnswer = $_POST['txtuploadanswer'];

            $insertQuery = "INSERT INTO faq (faq_id, question, answer) VALUES ('$uploadFaqId', '$uploadQuestion', '$uploadAnswer')";

            if (mysqli_query($connect, $insertQuery)) {
                echo "<script>alert('FAQ uploaded successfully!')</script>";
            } else {
                if (mysqli_errno($connect) == 1062) {
                    echo"<script>
                        alert('FAQ ID already exists.');
                        window.location='update_faq.php';
                    </script>";
                } else {
                    echo "<script>alert('FAQ failed to upload.')</script>";
                }
                
            }
        }
        if (isset($_POST['txtdelete'])) {
            $deleteFaqId = $_POST['txtdelete'];
            $deleteQuery = "DELETE FROM faq WHERE faq_id = '$deleteFaqId'";

            if (mysqli_query($connect, $deleteQuery)) {
                echo "<script>alert('FAQ deleted successfully!')</script>";
            } else {
                echo "<script>alert('FAQ failed to delete.')</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <title>Update FAQ</title>
    <link rel = "stylesheet" href = "faq.css">
</head>
<body>
    <div id = "main">
        <div id="faq">
            <h1>UPDATE FAQs</h1>

            <form action="" method = "POST">
                <p>FAQ ID: </p>
                <input class = "textbox" type="text" name = "txtfaq_id" placeholder = "enter faq_id" required>
                <p>Question: </p>
                <input class = "textbox" type="text" name = "txtquestion" placeholder = "enter question" required>
                <p>Answer: </p>
                <textarea rows = "5" name="txtanswer" placeholder = "enter answer" id="" style = "width:100%;" required></textarea>
                <button style = "margin-top:20px;"type = "submit" class = "update_button">Update</button>
            </form>
            <form action="" method = "POST">
                <p>FAQ ID: </p>
                <input class = "textbox" type="text" name = "txtuploadfaq_id" placeholder = "enter faq_id" required>
                <p>Question: </p>
                <input class = "textbox" type="text" name = "txtuploadquestion" placeholder = "enter question" required>
                <p>Answer: </p>
                <textarea rows = "5" name="txtuploadanswer" placeholder = "enter answer" id="" style = "width:100%;" required></textarea>
                <button style = "margin-top:20px;"type = "submit" class = "update_button">Upload</button>
            </form>
            <form action="" method = "POST">
                <p>FAQ ID: </p>
                <input class = "textbox" type="text" name = "txtdelete" placeholder = "enter faq_id" required>
                
                <button style = "margin-top:20px;"type = "submit" class = "update_button">Delete</button>
            </form>
        </div>
        <?php include 'footer_admin.php';?>
    </div>
</body>
</html>
<?php mysqli_close($connect);?>