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
    <a href="index.php">Home</a>
    <a href="all-routes.php">All routes</a>
    <a href="favorites.php">Favorites</a>
    <a href="my-account.php" title="My account" class="bx bx-user-circle icon" id="my-account-button"></a>
    <!-- Theme change button -->
    <i title="Change theme" class="bx bx-moon change-theme" id="theme-button"></i>
    <!--    <i title="Change theme" class="bx bx-toggle-left bx-user"></i>-->

</nav>
<main>

    <?php
    require_once "user-controller.php";
    global $userController;
    $userController->generateForm('signup');

    if (filter_input(INPUT_POST, 'submit',
        FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
        $userController->submitForm('signup');
    }
    ?>

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