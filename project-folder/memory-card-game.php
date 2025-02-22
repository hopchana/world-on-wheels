<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Set the viewport to the width of the device's screen and ensure that the initial scale is set to 1.0-->
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <!-- Link to an external CSS file with BoxIcons -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>World on wheels</title>
</head>
<body>
<!-- Button to open side navigation menu -->
<div id="nav-btn"><span id="open-nav" onclick="openNav()">&#9776;</span></div>
<!-- Navigation menu -->
<nav id="sidenav">
    <!-- Button to close side navigation menu -->
    <!-- prevent the link from navigating to a new page or reloading the current page when clicked-->
    <!-- to allow closeNav() to run without any interference from the browser's default link behavior-->
    <a href="javascript:void(0)" class="close-nav-btn" onclick="closeNav()">&times;</a>
    <!-- Navigation links -->
    <a href="index.php">Home</a>
    <a href="all-routes.php">All routes</a>
    <a href="favorites.php">Favorites</a>
    <a href="my-account.php" title="My account" class="bx bx-user-circle icon" id="my-account-button"></a>
    <!-- Theme change button -->
    <i title="Change theme" class="bx bx-moon change-theme" id="theme-button"></i>
</nav>
<main>
    <!-- Header section -->
    <header><h2 class="center">Memory Card Game</h2></header>
    <h3 id="score">Score: </h3>
    <h3 id="best-score">Best score: </h3>
    <!-- section with Memory card game cards -->
    <section id="memory-card-game">
        <div class="game-wrapper">
            <!-- List of cards -->
            <ul id="cards">
                <!-- Card in the top left corner -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- Second card from the left in the first row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- Second card from the right in the first row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- Card in the top right corner -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- First card from the left in the second row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- Second card from the left in the second row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- Third card from the left in the second row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- First card from the right in the second row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- First card from the left in the third row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- Second card from the left in the third row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- Third card from the left in the third row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- First card from the right in the third row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- First card from the left in the last row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- Second card from the left in the last row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- Third card from the left in the last row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
                <!-- First card from the right in the last row -->
                <li class="card">
                    <!-- Front view of the card -->
                    <div class="view front-view">
                        <!-- Icon for the card -->
                        <img src="img/games/memory-card-game/icon-bike.png" alt="icon">
                    </div>
                    <!-- Back view of the card -->
                    <div class="view back-view">
                        <!-- Image for the card -->
                        <img src="img/games/memory-card-game/img-1.png" alt="card-img">
                    </div>
                </li>
            </ul>
        </div>
        <!-- end section with Memory card game cards -->
    </section>
</main>

<!-- Footer section -->
<!-- will be generated with JS -->
<footer id="footer"></footer>
<?php include_once "generate-footer.php" ?>
<!-- JavaScript files -->
<!-- main script (footer, dark theme) -->
<script src="js/script.js"></script>
<!-- script for navigation -->
<script src="js/sidenav.js"></script>
<!-- script for game -->
<script src="js/memory-card-game.js"></script>

</body>
</html>