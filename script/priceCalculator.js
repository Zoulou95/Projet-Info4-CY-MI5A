// priceCalculator.js : dynamically calculates trip final price using fetch and saves choices to localStorage

// Function to save user choices to localStorage
// localStorage is an API for storing data locally in the browser
function saveToLocalStorage(data) {
    try {
        localStorage.setItem(`trip_choices_${data.trip_id}`, JSON.stringify(data));
    } catch (e) {
        console.error('Error while saving to localStorage:', e);
    }
}

// Send data to PHP using fetch for price calculation
function sendRequest() {

    // Retrieve values from the form ; ?.value safely gets the value only if the element exists
    const data = {
        flight: document.querySelector('select[name="flight"]')?.value,
        transport: document.querySelector('select[name="transports"]')?.value,
        departure_city: document.querySelector('select[name="departure_city"]')?.value,
        number_of_participants: parseInt(document.querySelector('select[name="number_of_participants"]')?.value || 0),
        participants: [ // Participants for each activity
            parseInt(document.querySelector('select[name="participants_1"]')?.value || 2),
            parseInt(document.querySelector('select[name="participants_2"]')?.value || 2),
            parseInt(document.querySelector('select[name="participants_3"]')?.value || 2)
        ],
        hotel_choices: [
            document.querySelector('select[name="hotel_1"]')?.value,
            document.querySelector('select[name="hotel_2"]')?.value,
            document.querySelector('select[name="hotel_3"]')?.value
        ],
        pension_choices: [
            document.querySelector('select[name="pension_1"]')?.value,
            document.querySelector('select[name="pension_2"]')?.value,
            document.querySelector('select[name="pension_3"]')?.value
        ],
        activity_choices: [
            document.querySelector('select[name="activite_1"]')?.value,
            document.querySelector('select[name="activite_2"]')?.value,
            document.querySelector('select[name="activite_3"]')?.value
        ],

        // Get the id of the trip from the URL (after ?id={number})
        trip_id: new URLSearchParams(window.location.search).get('id')
    };

    // Check if the trip id is present
    if (!data.trip_id) {
        console.error('ERROR: trip ID is missing.');
        return;
    }

    // Save the choices to localStorage
    saveToLocalStorage(data);

    fetch('../includes/price_calculator.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })

    // Handle errors
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error : status: ${res.status}`);
        }
        return res.json();
    })

    .then(response => {
        if (response.error) {
            console.error('ERROR: price calculation failed:', response.error);
            return;
        }

        // Update the total price in the UI
        const totalPriceElement = document.querySelector('.price b');
        if (totalPriceElement) {
            totalPriceElement.textContent = response.total_price + ' €';
        } else {
            console.error('ERROR: price element not found in the DOM.');
        }
    })
    .catch(error => {
        console.error('Price calculation failed:', error);
    });
}

// Trigger calculation on any change
document.querySelectorAll('select').forEach(select => {
    select.addEventListener('change', sendRequest);
});

// Load the page when everything is ready
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(sendRequest, 300); // We put a delay to ensure that all elements are loaded
});