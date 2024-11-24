<?php
    include "connection.php";
    include "sidenav.php";
    include ('userAccess.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <title>FAQ</title>
    <link rel = "stylesheet" href = "faq.css">
</head>
<body>
    <div id = "main">
        <div id="faq">
            <h1>FAQ</h1>

            <?php
                
                $query = "SELECT question, answer FROM faq";  
                $result = mysqli_query($connect, $query);  

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $question = $row['question'];
                        $answer = $row['answer'];
                        echo '
                            <button class="accordion">' . htmlspecialchars($question) . '<span class="plus-minus">+</span></button>
                            <div class="panel">
                                <p>' . htmlspecialchars($answer) . '</p>
                            </div>
                        ';
                    }
                } else {
                    echo "<p>No FAQs found.</p>";
                }
            ?>

            <script>
                var acc = document.getElementsByClassName("accordion");
                var i;

                for (i = 0; i < acc.length; i++) {
                    acc[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var panel = this.nextElementSibling;
                        var plusMinus = this.querySelector('.plus-minus');
                        
                        if (panel.style.display === "block") {
                            panel.style.display = "none";
                            plusMinus.innerHTML = "+";
                        } else {
                            panel.style.display = "block";
                            plusMinus.innerHTML = "-";
                        }
                    });
                }
            </script>
        </div>
        <?php include 'footer.php';?>
    </div>
</body>
</html>
<?php mysqli_close($connect);?>