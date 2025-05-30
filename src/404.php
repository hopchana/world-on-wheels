<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Viewport metadata for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- External stylesheet for boxicons -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <!-- External stylesheet for custom styles -->
    <link rel="stylesheet" href="css/style.css">
    <!-- External stylesheet for Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- External JavaScript library for Leaflet -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- External JavaScript plugin for GPX support in Leaflet -->
    <script type='text/javascript' src='https://cdn.jsdelivr.net/gh/shramov/leaflet-plugins@master/layer/vector/GPX.js'></script>
    <title>World on wheels</title>
    <!-- Internal CSS styles -->
    <style>
        body {
            max-width: 992px;
        }
    </style>
</head>
<body>
<!-- Navigation button -->
<div id="nav-btn"><span id="open-nav" onclick="openNav()">&#9776;</span></div>
<!-- Side navigation menu -->
<nav id="sidenav">
    <!-- Close navigation button -->
    <!-- prevent the link from navigating to a new page or reloading the current page when clicked-->
    <!-- to allow closeNav() to run without any interference from the browser's default link behavior-->
    <a href="javascript:void(0)" class="close-nav-btn" onclick="closeNav()">&times;</a>
    <!-- Navigation links -->
    <a href="index.php">Home</a>
    <a href="all-routes.php">All routes</a>
    <a href="favorites.php">Favorites</a>
    <a href="my-account.php" title="My account" class="bx bx-user-circle icon" id="my-account-button"></a>
    <!-- Theme change icon -->
    <i title="Change theme" class="bx bx-moon change-theme" id="theme-button"></i>
</nav>
<main>
    <!-- More info section -->
    <!-- Loads from server -->
    <section class="center">
        <header ><h1>Oops!</h1></header>
        <h2 class="center">404 - PAGE NOT FOUND</h2>
        <button id='all-routes-btn' onclick="navigateToPage('index.php')">GO TO HOMEPAGE</button>
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