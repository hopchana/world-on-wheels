<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>World on Wheels</title>
</head>
<body>
<div id="nav-btn"><span id="open-nav" onclick="openNav()">&#9776;</span></div>
<nav id="sidenav">
    <a href="javascript:void(0)" class="close-nav-btn" onclick="closeNav()">&times;</a>
    <a href="index.php">Home</a>
    <a href="all-routes.php">All routes</a>
    <a href="favorites.php">Favorites</a>
    <a href="my-account.php" title="My account" class="bx bx-user-circle active" id="my-account-button"></a>
    <i title="Change theme" class="bx bx-moon change-theme" id="theme-button"></i>
</nav>
<main> <section>
        <?php

        require_once "user-controller.php";
        global $userController;
        $userController->myAccount();
        ?>

    </section></main>

<footer id="footer"></footer>
<?php include_once "generate-footer.php" ?>
<script src="js/script.js"></script>
<script src="js/sidenav.js"></script>
</body>
</html>