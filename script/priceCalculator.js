// priceCalculator.js : dynamically calculates trip final price using fetch

function sendRequest() {
    // Get values from the form
    const data = {
        flight: document.querySelector('select[name="flight"]').value,
        transport: document.querySelector('select[name="transports"]').value,
        number_of_participants: parseInt(document.querySelector('select[name="number_of_participants"]').value),
        participants: [ // For each activity
            parseInt(document.querySelector('select[name="participants_1"]')?.value || 1),
            parseInt(document.querySelector('select[name="participants_2"]')?.value || 1),
            parseInt(document.querySelector('select[name="participants_3"]')?.value || 1)
        ],
        hotel_choices: [
            document.querySelector('select[name="hotel_1"]').value,
            document.querySelector('select[name="hotel_2"]').value,
            document.querySelector('select[name="hotel_3"]').value
        ],
        pension_choices: [
            document.querySelector('select[name="pension_1"]').value,
            document.querySelector('select[name="pension_2"]').value,
            document.querySelector('select[name="pension_3"]').value
        ],
        activity_choices: [
            document.querySelector('select[name="activite_1"]').value,
            document.querySelector('select[name="activite_2"]').value,
            document.querySelector('select[name="activite_3"]').value
        ],
        trip_id: new URLSearchParams(window.location.search).get('id')
    };

    // Check if all required values are present
    if (!data.trip_id) {
        console.error('Trip ID is missing');
        return;
    }

    // Add error handling for missing form elements
    if (!data.number_of_participants) {
        console.warn('Number of participants not found, defaulting to 1');
        data.number_of_participants = 1;
    }

    // Send data to PHP using fetch
    fetch('../includes/price_calculator.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! Status: ${res.status}`);
        }
        return res.json();
    })
    .then(response => {
        if (response.error) {
            console.error('Price calculation failed:', response.error);
            return;
        }
        // Update the total price in the UI
        const totalPriceElement = document.querySelector('.price b');
        if (totalPriceElement) {
            totalPriceElement.textContent = response.total_price + ' €';
        } else {
            console.error('Price element not found in the DOM');
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

// Call on page load once everything is ready
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(sendRequest, 100); // Small delay to ensure all elements are properly loaded
});