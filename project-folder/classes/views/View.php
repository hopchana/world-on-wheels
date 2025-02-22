<?php

class View
{
    function confirm($text, $name, $value)
    {
        echo "
                    <div id='popup' class='confirm'>
                        <form method='post' action='#'>
                            <h2>$text</h2>
                            <input id='yes-btn' name=$name type='submit' value=$value />                           
                        </form>
                        <div>
                            <label id='close-btn'>No</label>
                        </div>
                    </div>";

        echo '<script type="text/javascript">
                // Get the elements by their ID
                const popup = document.getElementById("popup");
                const closeButton = document.getElementById("close-btn");
                
                // Show the pop-up window
                popup.style.display = "grid";
                
                // Hide the pop-up window when the close button is clicked
                closeButton.addEventListener("click", function() {
                    popup.style.display = "none";
                });

            </script>';
    }


    function alert($text, $name, $value)
    {
        echo "
                    <div id='popup' class='alert'>
                            <h2>$text</h2>
                            <form method='post' action='#'>
                            <input id='yes-btn' name=$name type='submit' value=$value />                           
                        </form>
                    </div>";

        echo '<script type="text/javascript">
                // Get the elements by their ID
                const popup = document.getElementById("popup");
                const closeButton = document.getElementById("close-btn");
                
                // Show the pop-up window
                popup.style.display = "grid";
                
                // Hide the pop-up window when the close button is clicked
                closeButton.addEventListener("click", function() {
                    popup.style.display = "none";
                });

            </script>';
    }
}