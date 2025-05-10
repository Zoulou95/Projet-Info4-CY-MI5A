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
document.getElementById("signin_form").addEventListener("submit", function (event) {
    // Prevent default submission by clicking on the submit button
    event.preventDefault();

    // Submit form
    this.submit();
});