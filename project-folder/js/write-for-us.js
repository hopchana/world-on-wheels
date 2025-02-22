var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("accordion-active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = "fit-content";
        }
    });
}

let markerCount = 2; // Counter for markers

function addMarker() {
    // Container where new marker fields will be added
    const container = document.getElementById("marker-container");

    // Create a new div to hold the marker inputs
    const markerDiv = document.createElement("div");
    markerDiv.className = "marker";
    markerDiv.id = `marker-${markerCount}`;

    // Generate the HTML for the marker
    markerDiv.innerHTML = `
        <div class="write-for-us-container">
        <label for="lat-marker${markerCount}">Latitude:</label>
        <input type="number" min="-90" max="90" step="0.000001" id="lat-marker${markerCount}" name="lat-marker${markerCount}" required>
        <label for="lon-marker${markerCount}">Longitude:</label>
        <input type="number" min="-180" max="180" step="0.000001" id="lon-marker${markerCount}" name="lon-marker${markerCount}" required>
        </div>
        <button id="remove-marker-btn" type="button" onclick="removeMarker(${markerCount})">Remove</button>

    `;

    // Append the new marker to the container
    container.appendChild(markerDiv);

    // Increment the marker counter
    markerCount++;
}

function removeMarker(markerId) {
    // Remove the specific marker div
    const markerDiv = document.getElementById(`marker-${markerId}`);
    if (markerDiv) {
        markerDiv.remove();
    }
}

// Function to enable/disable input field based on radio button
function inputDisabled(isEnabled) {
    // get a reference to the input field with the id "name"
    let nameElement = document.getElementById("name-input");
    // determine whether the input field should be disabled or enabled based on isEnabled parameter
    nameElement.disabled = isEnabled;
    // set to nameElement value an empty string, clearing its current value
    nameElement.value = "";
}

// Function to update character counter in a textarea
function updateCounter(counterId, textareaId) {
    // Get reference to the counter element
    let counter = document.getElementById(counterId);
    // Get reference to the textarea element
    let textarea = document.getElementById(textareaId);
    // Get current number of characters entered
    let currentLength = textarea.value.length;
    // Get maximum allowed characters
    let maxLength = textarea.maxLength;
    //  update counter element based on the number of characters in textarea
    counter.innerText = textarea.value.trim() === "" ? `0/${maxLength}` : `${currentLength}/${maxLength}`;
    // Change counter color to red when only 1/5 of the characters, that user can provide, left
    counter.style.color = currentLength >= (maxLength / 1.25).toFixed(0) ? 'red' : 'gray';
}

// Event listener for window resize
window.addEventListener('resize', areaAutoSize);

// Function to auto-adjust the width of textarea elements based on window resize
function areaAutoSize() {
    // Get references to the long and short description textarea elements
    let longD = document.getElementById("long-desc");
    let shortD = document.getElementById("short-desc");
    // Set the width of the long and short description textarea elements to 100%
    longD.style.width='100%';
    shortD.style.width='100%';
}