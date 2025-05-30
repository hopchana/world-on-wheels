// Function to open the side navigation bar
function openNav() {
    // select an element with the id "sidenav" using getElementById.
    // set the width of the selected element to "100%" to open side navigation
    document.getElementById("sidenav").style.width = "100%";
}

// Function to close the side navigation bar
function closeNav() {
    // select an element with the id "sidenav" using getElementById.
    // set the width of the selected element to "0" to close side navigation
    document.getElementById("sidenav").style.width = "0";
}

// Function to check the screen width and open/close the side navigation accordingly
function checkScreenWidth() {
    // Check if the screen width is at least 480px
    if (window.matchMedia("(min-width: 480px)").matches) {
        openNav(); // If yes, open the side navigation, to make menu options visible on top of the page
    } else {
        // If not, close the side navigation, so the right nav panel wouldn't open on resize from 480+px to 479-px
        closeNav();
    }
}

// Check the screen width when the page loads to make side nav initially hidden
// if page is opened on devices with less than 480px width
checkScreenWidth();

// Listen for resize events and check screen width again
window.addEventListener('resize', checkScreenWidth);
