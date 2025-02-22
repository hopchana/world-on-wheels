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

    <script>
        const apiKey = '1a39c7f482744820bfd114740241004';
        // const to store basic path where request should be sent
        const apiUrl = 'https://api.weatherapi.com/v1/';

        // Function to fetch weather information for a location
        function fetchWeather(location) {
            // Get the container for weather information header
            let locationElement = document.getElementById('location');
            let weatherDiv = document.getElementById('weather-info');
            // create url for fetching
            let url = `${apiUrl}current.json?key=${apiKey}&q=${location}&aqi=no`;
            // Fetch weather data from the API
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    weatherDiv.innerHTML = `<!-- Weather icon -->
                        <img id='icon' src='' alt='icon'>
                        <!-- Temperature heading -->
                    <h2 id='temperature'></h2>`;
                    // Get the container for weather icon
                    let icon = document.getElementById('icon');
                    // Get the container for temperature
                    let temperatureElement = document.getElementById('temperature');
                    // Update weather information in the HTML elements
                    // set locationElement based on response
                    locationElement.innerHTML = "Current weather in " + data.location.name;
                    // set temperatureElement from response
                    temperatureElement.textContent = `${Math.round(data.current.temp_c)}°C`;
                    // set icon from response
                    icon.src = data.current.condition.icon;
                })
                // Handle errors in fetching weather information
                .catch(() => {
                    // erase locationElement
                    locationElement.textContent = "";
                    // erase weatherDiv
                    weatherDiv.innerHTML = ``;
                });
        }
    </script>
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

        <?php

        require_once "route-controller.php";

        if (isset($_GET['id']) and filter_input(INPUT_GET, 'id',
            FILTER_VALIDATE_INT)) {
            $id = filter_input(INPUT_GET, 'id',
                FILTER_VALIDATE_INT);
            global $routeController;
            $routeController->generateMoreInfo($id);
        } else {
            echo "<script type='text/javascript'>
                window.location.href='404.php'
                </script>";
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