<?php

echo "<script>

// Footer content setup
let footer = document.getElementById('footer');
footer.innerHTML = `
    <!-- grid for footer columns -->
    <div class='footer-columns'>
        <!-- Company links -->
        <section>
            <h3>Company</h3>
            <ul>
                <!-- Links to various pages -->
                <li>
                    <a href='#'>About World on wheels</a>
</li>
                <li>
                    <!-- Link to Write for us page -->
                    <a href='write-for-us.php'>Write For Us</a>
                </li>
                <li>
                    <!-- Link to page with sources -->
                    <a href='sources.php'>Sources</a>
                </li>
                <li>
                    <a href='#' >Privacy Policy</a>
                </li>
            </ul>
        <!-- end of the Company links -->
        </section>
        <!-- Top destinations links -->
        <section id='top-routes'>
        
        <!-- end of the Top destinations links -->
        </section>
        <!-- Games links -->
        <section>
            <h3>Games</h3>
            <ul>
            <!-- Links to games -->
                <li>
                    <!-- Link to page with Memory Card Game -->
                    <a href='memory-card-game.php' title='Memory Card Game'>Memory Card Game</a>
                </li>
            </ul>
        <!-- end of the Games links -->
        </section>
    <!-- end of the grid for footer columns -->
    </div>
<!-- Footer bottom section -->
<div class='footer-bottom center'>
        <!-- Display current year -->
© <span id='year'></span> Anastasiia Hopchuk </div>`
// Update the year dynamically
// Get the current year using the Date object and the getFullYear() method.
// Convert the current year to a string.
// Find the element with the id 'year' using the getElementById() method.
// Set the text of the element to the current year.
document.getElementById('year').innerHTML = new Date().getFullYear().toString();

</script>";

require "route-controller.php";
$text = $routeController->generateTop3Routes();

echo "<script>document.getElementById('top-routes').innerHTML = `$text` </script>";
