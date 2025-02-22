<!--user: hopchana-->
<!--pass: World-On-Wheels1703!-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Set the viewport to the width of the device's screen and ensure that the initial scale is set to 1.0-->
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <!-- Link to an external CSS file with BoxIcons from the provided URL -->
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
    <a class="active" href="index.php">Home</a>
    <a href="all-routes.php">All routes</a>
    <a href="favorites.php">Favorites</a>
    <a href="my-account.php" title="My account" class="bx bx-user-circle icon" id="my-account-button"></a>
    <!-- Theme change button -->
    <i title="Change theme" class="bx bx-moon change-theme" id="theme-button"></i>
    <!--    <i title="Change theme" class="bx bx-toggle-left bx-user"></i>-->

</nav>
<main>
    <!-- Header section -->
    <header><h1>World on wheels</h1></header>
    <!-- Section containing call-to-action content -->
    <section id="above-the-fold">
        <!-- Images and introductory text -->
        <img  id="img1-top" alt="image of bike" src="img/main-page/img1-top.jpg">
        <span class="center">There is no better way to explore world than on a bicycle.
            Find picturesque landscapes, historical monuments and cool places travelling
            on wheels.<br>
        </span>
        <img id="img3-top" alt="image of bike" src="img/main-page/img3-top.jpg">
        <img id="img4-top" alt="image of bike" src="img/main-page/img4-top.jpg">
        <img id="img1-bottom" alt="image of bike" src="img/main-page/img1-bottom.jpg">
        <img id="img2" alt="image of bike" src="img/main-page/img2.jpg">
        <img id="img3-bottom" alt="image of bike" src="img/main-page/img3-bottom.jpg">
        <img id="img4-bottom" alt="image of bike" src="img/main-page/img4-bottom.jpg">


    </section>
    <!-- Button to navigate to all routes page -->
    <div class="center"><button id="all-routes-btn" onclick="navigateToPage('all-routes.php')">All routes</button></div>
    <!-- Section with additional content -->
    <section id="second-box">
        <div>
            <!-- Title -->
            <h2>Bicycle routes for everyone</h2>
            <!-- Descriptive text -->
            <p>
                For many, traveling by bike is the antithesis to the modern trend of fast, fly-in-fly-out travel.

                In fact, it’s hard to envisage a better way to explore a country than on two wheels, slowly meandering along
                as the landscape unfurls before you. Cycling gives you time to admire your surroundings, draws you away from the
                tourist crowds and, perhaps best of all, it’s sustainable – causing no harm to the environment you’ve traveled to see.
            </p>
        </div>
        <!-- Image -->
        <img id="img5" alt="image of bike" src="img/main-page/img5.jpg">
    </section><br><br>

        <section>
            <!-- Title -->
            <h2 class="center">Top viewed routes</h2>
            <!-- Content for all routes section goes here -->
            <?php
            session_start();

            require_once "route-controller.php";

            global $routeController;
            $routeController->generateTop3RoutesCards()

            ?>
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
</body>
</html>