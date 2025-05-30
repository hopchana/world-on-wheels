/*==================== Black theme ====================*/
// Theme toggle button and icon classes
// The theme toggle button element with the id "theme-button"
const themeButton = document.getElementById("theme-button");
// The class name "dark-theme" for the dark theme
const darkTheme = "dark-theme";
// The class name "bx-sun" for the default icon theme
const iconTheme = "bx-sun";

// Retrieve selected theme from the local storage (if user selected)
const selectedTheme = localStorage.getItem("selected-theme");
// Retrieve selected icon from the local storage (if user selected)
const selectedIcon = localStorage.getItem("selected-icon");

// Apply previously selected theme and icon to the webpage by adding or removing the corresponding classes
if (selectedTheme) {
    // check if the selectedTheme is "dark"
    // if it is, add the darkTheme class to the body of the document, otherwise, remove it
    document.body.classList[selectedTheme === darkTheme ? "add" : "remove"](darkTheme);
    // check if the selectedIcon is iconTheme
    // If it is, add the iconTheme class to the themeButton, otherwise, remove it.
    themeButton.classList[selectedIcon === iconTheme ? "add" : "remove"](iconTheme);
}

// event listener to toggle theme when the button is clicked
themeButton.addEventListener("click", () => {
    // Toggle the dark theme on body element
    document.body.classList.toggle(darkTheme);
    // Toggle the icon theme on themeButton button
    themeButton.classList.toggle(iconTheme);

    // Save the theme preference
    localStorage.setItem("selected-theme", getCurrentTheme());
    // Save the icon preference
    localStorage.setItem("selected-icon", getCurrentIcon());
});

// Function to get the current theme based on the presence of darkTheme class on the body element
function getCurrentTheme() {
    return document.body.classList.contains(darkTheme) ? darkTheme : "light-theme";
}

// Function to get the icon of the theme button based on the presence of "bx-sun" class on the themeButton button
function getCurrentIcon() {
    return themeButton.classList.contains(iconTheme) ? iconTheme : "bx-moon";
}

/*==================== Additional functions ====================*/

// Function takes a pageUrl as input and navigates the browser window to the specified URL
function navigateToPage(pageUrl) {
    // make the browser window to navigate to the specified URL
    window.location.href = pageUrl;
}

// Function to generate more information for a specific route
// by redirecting the user to a new page with the route name as a query parameter
function generateMoreInfo(id) {
    // redirect user to the new page with the specified route name as a query parameter
    window.location.href = `more-info.php?id=${id}`;
}