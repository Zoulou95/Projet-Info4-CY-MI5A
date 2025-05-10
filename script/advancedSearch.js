// advancedSearch.js : display drop-down lists

// Manage the display of drop-down lists
document.addEventListener("DOMContentLoaded", function() {

    function setupDropdown(buttonClass, contentClass) {
        const dropdownButton = document.querySelector(`.${buttonClass}`);
        const dropdownContent = document.querySelector(`.${contentClass}`);

        if (dropdownButton && dropdownContent) {
            dropdownButton.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevents immediate closing
                const isVisible = dropdownContent.style.display === "block";
                closeAllDropdowns(); // Closes all other menus
                // Check if the dropdown content is currently visible
                if (isVisible) {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });

            dropdownContent.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevents closing on internal click
            });
        }
    }

    // Function to close all dropdowns
    function closeAllDropdowns() {
        document.querySelectorAll(".dropdown_content").forEach(content => {
            content.style.display = "none";
        });
    }

    // Close menus when clicked elsewhere
    document.addEventListener("click", closeAllDropdowns);

    // Initialize dropdowns
    setupDropdown("price_button", "price_content");
    setupDropdown("type_button", "type_content");
    setupDropdown("duration_button", "duration_content");
});

// Prevent empty search
document.querySelector('.search_bar_form').addEventListener('submit', function(event) {
    const form = this;
    const textInput = form.querySelector('input[name="tag"]');
    const radios = form.querySelectorAll('input[type="radio"]');
    const dateInput = form.querySelector('input[name="date"]');

    let isFilled = false;

    // Checks the text and date field
    if (textInput.value.trim() !== '' || dateInput.value !== '') {
        isFilled = true;
    }

    // Checks if a radio button is selected
    radios.forEach(radio => {
        if (radio.checked) {
            isFilled = true;
        }
    });

    // If no field is filled, prevent form submit
    if (!isFilled) {
        displayBubble(event, "❌ Votre recherche est vide !");
    }
});