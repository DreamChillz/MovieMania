<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <style>
        * {
            box-sizing: border-box;
            font-family: "Lato", sans-serif;
        }
        
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 99;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            overflow-y: auto;
            transition: 0.5s;
            padding-top: 40px;
            color: #818181;
            box-sizing: border-box;
        }

        .sidenav p {
            padding-left: 32px;
            text-decoration: none;
            text-align:left;
            font-size: 25px;
            color: white;
            display: block;
            transition: 0.3s;
            margin-top:20px;
            margin-bottom:20px;
        } 

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 20px;
            color: #818181;
            display: block;
            transition: 0.3s;
        } 

        .sidenav a:hover {
            color: white;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        #menu-bar{
            width: 100%;
            background-color: #111;
            color:white;
            padding:20px 20px 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            z-index:98;
            top:0;
            left:0;
        }

        .logo{
            height:40px;
            width:200px;
        }

        #openNav{
            font-size:30px;
            cursor:pointer;
        }

        #profileIcon{
            width:30px;
            height:30px;
            border-radius:50%;
        }
    </style>
</head>
<body>
<div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <p>Pages</p>
        <a href="home.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="tvshows.php">TV Shows</a>
        <a href="news.php">News</a>
        <a href="watchlist.php">Watchlist</a>
        <a href="profile.php">Profile</a>
        <a href="faq.php">FAQ</a>
        <a href="logout.php">Logout</a>
        <br><br><br>
    </div>
    <div id="menu-bar">
        <span id="openNav" onclick="openNav()">&#9776;</span>
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
                document.getElementById("main").style.marginLeft = "250px";
                document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("main").style.marginLeft= "0";
                document.body.style.backgroundColor = "white";
            }
        </script>
        <img src="images/moviemanialogo.png" alt="movie mania logo" class="logo">
        <a href="profile.php"><img src="images/profileIcon.png" alt="profile icon" id="profileIcon"></a>
    </div>
</body>
</html>
