<?php 
include ('loginAccess.php');

if($_SESSION['role'] == 'admin'){
    include 'sidenav_admin.php' ;
}else if($_SESSION['role'] == 'user'){
    include 'sidenav.php' ;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News and Article</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
    <!-- stylesheet -->
    <link rel="stylesheet" href="news-css.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <div class="main" id="main">
        <!-- Slideshow container -->
        <div class="slideshow-container">


            <!-- Full-width images with number and caption text -->
            <div class="newsSlides fade">
                <div class="numbertext">1 / 5</div>
                <img src="images/news5.jpg" style="width:100%">
                <div class="text-container">
                    <div class="text">
                        The World of Joy of Life</div>
                    <div class="mini-text">
                        22 September 2024, 4:42pm </div>
                </div>

            </div>

            <div class="newsSlides fade">
                <div class="numbertext">2 / 5</div>
                <img src="images/news3.png" style="width:100%">
                <div class="text-container">
                    <div class="text">28 Best Korean Movies Inspired By Real-Life Events</div>
                    <div class="mini-text">19 September 2024, 6:30pm </div>


                </div>

            </div>

            <div class="newsSlides fade">
                <div class="numbertext">3 / 5</div>
                <img src="images/news4.png" style="width:100%">
                <div class="text-container">
                    <div class="text">"Officer Black Belt" Ranks No. 1 on Netflix's Top 10 Chart in Non-English Category
                    </div>
                    <div class="mini-text">
                        18 September 2024, 8:00am </div>
                </div>
            </div>

            <div class="newsSlides fade">
                <div class="numbertext">4 / 5</div>
                <img src="images/news2.jpg" style="width:100%">
                <div class="text-container">
                    <div class="text">
                        A New Wave of Talent: Discovering the Rising Stars of China</div>
                    <div class="mini-text">
                        21 September 2024, 2:02pm </div>
                </div>

            </div>

            <div class="newsSlides fade">
                <div class="numbertext">5 / 5</div>
                <img src="images/news6.webp" style="width:100%">
                <div class="text-container">
                    <div class="text">
                        Son Ye Jin and Hyun Bin's surprise cameo lights up 'Queen of Tears'!</div>
                    <div class="mini-text">
                        15 September 2024, 3:02pm </div>
                </div>

            </div>

            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

        </div>
        <br>

        <!-- The dots/circles -->
        <div class="dots" style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
            <span class="dot" onclick="currentSlide(5)"></span>
        </div>

        <br>


        <div class="news-content-container">
            <h2>Recent News and Articles</h2>
            <div class="news">
                <img class="news-image" src="images/news5.jpg">

                <div class="news-text">
                    <h3 class="news-headings">The World of Joy of Life</h3>
                    <p class="news-content">Joy of Life (JOL) (native title: 庆余年), a Chinese drama adapted from Mao Ni’s
                        novel of the same name (庆余年), is well-loved by viewers for its political power struggles with
                        schemes within schemes and words within words, and peppered with lots of humour and martial
                        action scenes. </p>

                    <div class="news-footer">
                        <span>22 September 2024, 4:42pm</span>
                        <span><i class="fas fa-heart"></i> 34</span>
                        <span><i class="fas fa-eye"></i> 18k</span>
                    </div>
                </div>
            </div>

            <div class="news">
                <img class="news-image" src="images/news3.png">

                <div class="news-text">
                    <h3 class="news-headings">28 Best Korean Movies Inspired By Real-Life Events</h3>
                    <p class="news-content">Cinema is an escape from reality into the realm of fiction they say. Aliens
                        invading Earth, a magical time travel to the past for a second chance at life, or the
                        supernatural
                        stories of goblins and ghosts — the thrill of exploring scenarios we can never experience in
                        real
                        life pulls us into the world of storytelling. </p>

                    <div class="news-footer">
                        <span>19 September 2024, 6:30pm</span>
                        <span><i class="fas fa-heart"></i> 5555</span>
                        <span><i class="fas fa-eye"></i> 90k</span>
                    </div>
                </div>
            </div>

            <div class="news">
                <img class="news-image" src="images/news4.png">

                <div class="news-text">
                    <h3 class="news-headings">"Officer Black Belt" Ranks No. 1 on Netflix's Top 10 Chart in Non-English
                        Category</h3>
                    <p class="news-content">Kim Woo Bin's Officer Black Belt topped Netflix's Global Top 10 chart
                        (non-English), garnering 8.3 million views from September 13-15. The K-movie trends in Asian,
                        European, and Latin American countries.

                    </p>

                    <div class="news-footer">
                        <span>18 September 2024, 8:00am</span>
                        <span><i class="fas fa-heart"></i> 579</span>
                        <span><i class="fas fa-eye"></i> 114k</span>
                    </div>
                </div>
            </div>

            <div class="news">
                <img class="news-image" src="images/news1.webp">

                <div class="news-text">
                    <h3 class="news-headings">Omniscient Reader's Viewpoint Live-Action Movie Cast Includes Blackpink's
                        Jisoo, Lee Min Ho, Ahn Hyo Seop, and More</h3>
                    <p class="news-content">Omniscient Reader's Viewpoint, the South Korean web-novel and manhwa
                        (webtoon),
                        has revealed the stacked cast of its live-action film adaptation.

                        While it's still a working title for the project, the cast of the film officially confirmed (via
                        Soompi) on January 24..</p>

                    <div class="news-footer">
                        <span>16 September 2024, 7:20pm</span>
                        <span><i class="fas fa-heart"></i> 15558</span>
                        <span><i class="fas fa-eye"></i> 670k</span>
                    </div>
                </div>
            </div>


            <div class="news">
                <img class="news-image" src="images/news6.webp">

                <div class="news-text">
                    <h3 class="news-headings">Son Ye Jin and Hyun Bin's surprise cameo lights up 'Queen of Tears'!</h3>
                    <p class="news-content">The episode's highlights include the deepening connection between Hae In and
                        Hyun Woo, alongside revelations about their shared history. Notably, a heated exchange between
                        Hyun
                        Woo and his friend delves into comparisons with Son Ye Jin and Hyun Bin.
                    </p>

                    <div class="news-footer">
                        <span>15 September 2024, 3:02pm</span>
                        <span><i class="fas fa-heart"></i> 4009</span>
                        <span><i class="fas fa-eye"></i> 541k</span>
                    </div>
                </div>
            </div>



        </div>



    </div>





    <script>
        let slideIndex = 1;
        let timer;
        showSlides(slideIndex);

        function plusSlides(n) {
            clearTimeout(timer);  // Stop auto slideshow when clicking next/prev
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            clearTimeout(timer);  // Stop auto slideshow when clicking dots
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("newsSlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            timer = setTimeout(() => plusSlides(1), 4000); // Auto-scroll every 4 seconds
        }
    </script>

</body>

</html>
<?php if($_SESSION['role'] == 'admin'){
    include('footer_admin.php');
}else if($_SESSION['role'] == 'user'){
    include('footer.php');
} ?>