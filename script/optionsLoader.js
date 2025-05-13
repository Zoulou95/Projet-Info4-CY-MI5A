// optionsLoader.js : fill dynamically every <select> tag using fetch

// Fill a <select> tag
function fillSelect(selectName, options) {
    const selectElement = document.querySelector(`select[name="${selectName}"]`);
    if (!selectElement) {
        return;
    }

    selectElement.innerHTML = ''; // Clear existing value

    options.forEach(option => {
        const field = document.createElement('option'); // Create <option> tags
        field.value = option;
        field.textContent = option;
        selectElement.appendChild(field); // Add <option> tags
    });
}

// Load and fill dynamically <select> tag
document.addEventListener('DOMContentLoaded', function () {
    fetch('../data/trip_data.json') // Path to the trip data
        .then(response => response.json())
        .then(data => {

            // Get trip from ID
            const urlParameters = new URLSearchParams(window.location.search);
            const tripId = urlParameters.get('id'); // Get the number in the URL after ?id={number}
            const trip = data.trip.find(t => t.id == tripId); // Find the matching trip in the JSON file

            // Fill hotel selects
            fillSelect('hotel_1', trip.hotel);
            fillSelect('hotel_2', trip.hotel);
            fillSelect('hotel_3', trip.hotel);

            // Fill pensions
            const pensions = ["Demi-pension", "Tout inclus (+50€/pers/jour)", "Déjeuner uniquement", "Diner uniquement"];
            fillSelect('pension_1', pensions);
            fillSelect('pension_2', pensions);
            fillSelect('pension_3', pensions);

            // Fill activities
            fillSelect('activite_1', trip.step_1.activities);
            fillSelect('activite_2', trip.step_2.activities);
            fillSelect('activite_3', trip.step_3.activities);

            // Fill number of participants
            fillSelect('participants_1', [2, 3, 4, 5, 6]);
            fillSelect('participants_2', [2, 3, 4, 5, 6]);
            fillSelect('participants_3', [2, 3, 4, 5, 6]);

            // Display every price by default
            triggerChangeOnAll('.dynamic_input');
        })
        .catch(error => {
            console.error('Error while loading options: ', error);
        });

});

// Trigger all selects to show prices
function triggerChangeOnAll(selector) {
    const elements = document.querySelectorAll(selector);

    for (let i = 0; i < elements.length; i++) {
        elements[i].dispatchEvent(new Event('change')); // Trigger 'change' event to display the corresponding price
    }
}
