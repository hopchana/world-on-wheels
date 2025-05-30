<?php
require_once "View.php";
class RouteView extends View
{
    function renderDistance($distance, $distance_unit): string
    {
        if ($distance_unit == "miles") {
            $km = round($distance * 1.609344, 2);
            return "$distance miles ($km km)";
        } else {
            $miles = round($distance * 0.621371192, 2);
            return "$miles miles ($distance km)";
        }
    }
    function generateCard($routeData)
    {
        echo "
        <!-- container for route brief information and image -->
        <article class='article-section'>
            <!-- photo from place where route is located -->
            <img src='{$routeData['main_img_path']}' alt='{$routeData['main_img_alt']}'>
            <!-- section with brief information about route and like button -->
            <div class='section-content'>
                <!-- Container for name of route and like button -->
                <div class='section-heading'>
                    <!-- Tittle with name of route -->
                    <h2>{$routeData['title']}</h2>
                     <!-- unfilled like button with function to like/unlike routes -->
                     <form method='POST' action='update-like.php'>
                        <button name = 'routeID' id='{$routeData['id']}' value='{$routeData['id']}' class='like-btn'>
                        <!-- Heart SVG Icon -->
                        <svg viewBox='0 0 24 24' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                            <path d='M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572'/>
                        </svg>
                    <!-- end of the like button -->
                    </button>
                    </form>
                    
                </div>
                <!-- Bolder text for the starting point of the route -->
                <b>Start:</b> {$routeData['start']}
                <!-- Bolder text for the ending point of the route -->
                <br><b>End:</b> {$routeData['end']}
                <!-- Bolder text for the distance of the route -->
                <br><b>Distance:</b> ".$this->renderDistance($routeData['distance'], $routeData['distance_unit'])." 
                <!-- Regular text for short description of the route -->
                <div class='text-wrap'>{$routeData['short_description']}</div>
            <!-- end of the section with brief information about route and like button -->
            </div>
            <!-- Button to open more information about the route-->
            <button class='more-info-btn center' onclick=\"generateMoreInfo('{$routeData['id']}')\">More</button>
        <!-- end of the container for route brief information and image -->
        </article>
        ";
    }

    function addLikedClassToButtons($likedRoutesID)
    {
        echo "<script>
                let button";
        foreach ($likedRoutesID as $likedRouteID) {
            echo "
                button = document.getElementById(`$likedRouteID`);
                // Check if button exists
                if (button !== null) {
                    // Add the 'liked' class to the button if condition above is fulfilled
                    button.classList.add('liked');
                }";
        }

        echo "</script>";
    }

    function nothingIsHere()
    {
        echo "<script>

        const favSectionsContainer = document.getElementById('fav-routes');
        // If no liked routes, display text informing about it and suggest where user can add routes to favourites
        favSectionsContainer.innerHTML = `
        <!-- center message with center class -->
        <article class='center' id='nothing-is-here'>
            <!-- Bold text with 'problem' -->
            <b>Nothing is here</b>
            <!-- paragraph of regular text with suggestion -->
            <p>Try to like some routes in All routes tab</p>
            <!-- Button that navigates to All Routes page -->
                <button id='all-routes-btn' onclick='navigateToPage(\"all-routes.php\")'>All routes</button>
        </article>`;
    </script>";
    }

    function showInfo($routeData)
    {
        echo "<section id='more-info' class='more-info'>
        <!-- Heading -->
        <h1 class='more-info'>{$routeData['title']}</h1>
        <!-- Main image -->
        <img src='{$routeData['main_img_path']}' alt='{$routeData['main_img_alt']}'>
        <!-- Information about start point -->
        <h3>Start: {$routeData['start']}</h3>
        <!-- Information about end point -->
        <h3>End: {$routeData['end']}</h3>
        <!-- Information about distance -->
        <h3>Distance: ".$this->renderDistance($routeData['distance'], $routeData['distance_unit'])
            ."</h3>
        <div class='text-wrap'>{$routeData['long_description']}</div><br>

        <!-- Images section -->
        <article class='more-info-images'>";

        $images = [
            $routeData['img1_path'] => $routeData['img1_alt'],
            $routeData['img2_path'] => $routeData['img2_alt'],
            $routeData['img3_path'] => $routeData['img3_alt'],
            $routeData['img4_path'] => $routeData['img4_alt'],
            $routeData['img5_path'] => $routeData['img5_alt'],
            $routeData['img6_path'] => $routeData['img6_alt'],
        ];
        foreach ($images as $path => $alt) {
            echo "
            <div class='more-info-img'>
                <img
                    src='$path'
                    alt='$alt'
                >
            </div>
            ";
        }
        echo "</article></<section>";
        $this->showWeather($routeData['start']);
        $this->showMap($routeData['gpx_path'], $routeData['markers_lat'], $routeData['markers_lon']);
        if ($routeData['author_name']!='anonymous') {
            echo "<br>Author: {$routeData['author_name']}";
        }

        require_once "user-controller.php";
        $userController->getComments($routeData['route_id']);


    }

    function showMap($gpx_path, $markers_lat, $markers_lon)
    {
        echo "<!--     Route on map section-->
        <section>
            <br>
            <!-- Heading for route on map -->
            <h2 class='center'>Route on map</h2>
            <br>
            <!-- Map container -->
            <div id='map'>
                <script>
                    // Initialize the Leaflet map
                    let map = L.map('map');
                    // Add a layer of map tiles from the OpenStreetMap server to the Leaflet map,
                    // allowing users to view a map based on OpenStreetMap data
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                    
                    // Load GPX file for the specified route
                    // create a new instance of the Leaflet GPX class
                    new L.GPX('$gpx_path', {
                        async: true, // indicate that loading of the GPX file should be asynchronous
                        display_wpt: false //indicate that waypoints from the GPX file should not be displayed
                    // listen for the 'loaded' event, which indicates that the GPX file has been successfully loaded
                    }).on('loaded', function (e) {
                        // adjust the map's viewport to contain the bounding box of the GPX track
                        map.fitBounds(e.target.getBounds());
                    // add the GPX layer to the map
                    }).addTo(map);
                </script>";
        for ($j = 0; $j < count($markers_lat); $j++) {
            $lat = $markers_lat[$j];
            $lon = $markers_lon[$j];
            echo "<script>L.marker([$lat, $lon]).addTo(map);</script>";
        }
        echo "</div></section>";
    }

    function showWeather($start) {
        echo "<!-- Weather section -->
    <section id='weather'  class='center'>
        <!-- Location heading -->
        <h2 id='location'></h2>
        <!-- Weather information container -->
        <div id='weather-info'>
            
        </div>
    </section>
        <script>fetchWeather('$start')</script>
        ";
    }

    public function showForm(){
        echo"
<form id='write-for-us-form' action='#' method='post' enctype='multipart/form-data'>
    <!-- Container for form elements -->
        <button type='button' class='accordion'>General information</button>
        <div class='panel'>
            <div class='write-for-us-container'>
                <label for='title'>Title:</label>
                <input type='text' name='title' id='title' required>
                <!-- Label and input field for starting point -->
                <label for='start'>Start:</label>
                <input type='text' name='start' id='start' required>
                <!-- Label and input field for ending point -->
                <label for='end'>End:</label>
                <input type='text' name='end' id='end' required>
                <!-- Label for distance and input field with unit selection -->
                <label for='distance'>Distance:</label>
                <!-- Input field for distance -->
                <span><input type='number' min='1' name='distance' id='distance' step='0.1' required>
                        <label for='unit'>
                            <!-- Dropdown for unit selection -->
                            <select name='unit' id='unit'>
                                <!-- Option for miles -->
                                <option value='miles'>Miles</option>
                                <!-- Option for kilometers -->
                                <option value='kilometers'>Kilometers</option>
                            </select>
                        </label> </span>
            </div>
            <!-- Line break for spacing -->
            <br>
            <!-- Label for short description -->
            <label for='short-desc'>Write short description here:</label><br>
            <!-- Container for textarea and character counter for short description -->
            <div class='textarea-container'>
                <!-- Textarea for short description -->
                <textarea class='textarea' name='short-desc' id='short-desc' rows='12' cols='50' maxlength='500' oninput=\"updateCounter('counter-short', 'short-desc')\" required></textarea>
                <!-- Character counter for short description -->
                <div class='counter' id='counter-short'>0/500</div>
            </div>
            <!-- Line break for spacing -->
            <br>
            <!-- Label for long description -->
            <label for='long-desc'>Write long description here:</label><br>
            <!-- Container for textarea and character counter for long description -->
            <div class='textarea-container'>
                <!-- Textarea for long description -->
                <textarea class='textarea' name='long-desc' id='long-desc' rows='28' cols='100' maxlength='2500' oninput=\"updateCounter('counter-long', 'long-desc')\" required></textarea>
                <!-- Character counter for long description -->
                <div class='counter' id='counter-long'>0/2500</div>
            </div>
        </div>
        <button type='button' class='accordion'>Images</button>
        <div class='panel'>
            <h3>Main image</h3>
            <div class='write-for-us-container'>
                <label for='main'>File .jpg, .png:</label>
                <input type='file' name='main' id='main' required>
                <label for='main-alt'>Alternative text:</label>
                <input type='text' name='main-alt' id='main-alt'>
            </div><br>

                     <h3>Content images</h3>
                    <h4>First image</h4>
                    <div class='write-for-us-container'>
                        <label for='img1'>File .jpg, .png:</label>
                        <input type='file' name='img1' id='img1' required>
                        <label for='img1-alt'>Alternative text:</label>
                        <input type='text' id='img1-alt'>
                    </div><br>
                    <h4>Second image</h4>
                    <div class='write-for-us-container'>
                        <label for='img2'>File .jpg, .png:</label>
                        <input type='file' name='img2' id='img2' required>
                        <label for='img2-alt'>Alternative text:</label>
                        <input type='text' id='img2-alt'>
                    </div><br>
                    <h4>Third image</h4>
                    <div class='write-for-us-container'>
                        <label for='img3'>File .jpg, .png:</label>
                        <input type='file' name='img3' id='img3' required>
                        <label for='img3-alt'>Alternative text:</label>
                        <input type='text' id='img3-alt'>
                    </div><br>
                    <h4>Fourth image</h4>
                    <div class='write-for-us-container'>
                        <label for='img4'>File .jpg, .png:</label>
                        <input type='file' name='img4' id='img4' required>
                        <label for='img4-alt'>Alternative text:</label>
                        <input type='text' id='img4-alt'>
                    </div><br>
                    <h4>Fifth image</h4>
                    <div class='write-for-us-container'>
                        <label for='img5'>File .jpg, .png:</label>
                        <input type='file' name='img5' id='img5' required>
                        <label for='img5-alt'>Alternative text:</label>
                        <input type='text' id='img5-alt'>
                    </div><br>
                    <h4>Sixth image</h4>
                    <div class='write-for-us-container'>
                        <label for='img6'>File .jpg, .png:</label>
                        <input type='file' name='img6' id='img6' required>
                        <label for='img6-alt'>Alternative text:</label>
                        <input type='text' id='img6-alt'>
                    </div>
        </div>

        <button type='button' class='accordion'>Map</button>
        <div class='panel'>

            <h3>Route file</h3>
            <div class='write-for-us-container'>
                <label for='gpx'>File .gpx:</label>
                <input type='file' name='gpx' id='gpx' required>
            </div><br>
            <h3>Marker(s)</h3>


            <div id='marker-container'>
                <div class='marker' id='marker-1'>
                    <div class='write-for-us-container'>
                        <label for='lat-marker1'>Latitude:</label>
                        <input type='number' min='-90' max='90' step='0.000001' id='lat-marker1' name='lat-marker1' required>
                        <label for='lon-marker1'>Longitude:</label>
                        <input type='number' min='-180' max='180' step='0.000001' id='lon-marker1' name='lon-marker1' required>
                    </div>
                    <button id='remove-marker-btn' type='button' onclick='removeMarker(1)'>Remove</button>
                </div>
            </div>
            <button id='add-marker-btn' type='button' onclick='addMarker()'>Add marker</button>
        </div>

    <!-- Container for form elements -->
    <br>
    <!-- Information about how the contributor wants to be mentioned -->
    <span style='grid-column:1/3'>Please choose how you would like to be mentioned in the publication:</span>
    <!-- Radio button option for specifying name -->
    <br><label for='name-radio'>
    <input type='radio' name='name' value='name' id='name-radio' onclick='inputDisabled(false)' required>Name:
</label>
    <!-- Input field for name -->
    <input type='text' name='name-input' id='name-input' value='Napoléon Bonaparte' autocomplete='name' disabled>
    <!-- Radio button option for remaining anonymous -->
    <br><label for='anonymous' style='grid-column:1/3'>
    <input type='radio' name='name' id='anonymous' value='anonymous' onclick='inputDisabled(true)'>Remain Anonymous
</label><br>
    <!-- Line break for spacing -->
    <br>
    <!-- Checkbox for accepting terms of use and privacy policy -->
    <label for='accept'><input type='checkbox' name='accept' id='accept' required> I accept the Terms of Use & Privacy Policy</label>
    <div>
        <!-- Submit button -->
        <input id='submit-btn' name='submit' type='submit'>
        <!-- Reset button -->
        <input id='reset-btn' type='reset'>
    </div>
</form>";
    }

    function showTop3Routes($top3RoutesID, $top3RoutesName): string
    {
        $text = "";
        for ($i = 0; $i < sizeof($top3RoutesID); $i++) {
            $text .= "
                <li>
                    <!-- Link to page about Southern Namibia route -->
                    <a href='more-info.php?id=$top3RoutesID[$i]'>$top3RoutesName[$i]</a>
                </li>
            ";
        }
        return "
            <h3>Top routes</h3>
            <ul>
             <!-- Links to more-info pages -->
              $text
            </ul>

           ";
    }

    private function showComments()
    {

    }


}