// optionsLoader.js : fill dynamically every <select> tag using fetch

/* Retrieve informations from 'trip_data.json' file */

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
    fetch('../data/trip_data.json')
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
            const pensions = ["Demi-pension", "Tout inclus", "Déjeuner uniquement", "Diner uniquement"];
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

            // Display prices beside selects using loaded trip data
            hotelPrices = trip.hotel_price;
            activitiesPrices = {
                step_1: trip.step_1.activities_price,
                step_2: trip.step_2.activities_price,
                step_3: trip.step_3.activities_price
            };
            basePrice = trip.price_per_person;

            // Trigger display of prices
            triggerChange('.dynamic_input');

            // Call once after loading to show prices immediately
            updatePrices();
        })
        .catch(error => {
            console.error('Error while loading options: ', error);
        });
});

// Trigger all selects to show prices
function triggerChange(selector) {
    const elements = document.querySelectorAll(selector);
    elements.forEach(el => el.dispatchEvent(new Event('change'))); // Trigger 'change' event to display the corresponding price
}

/* Display features */

// Define global variables to hold dynamic data (filled after fetch)
let hotelPrices = [];
let activitiesPrices = {};
let basePrice = 0;

// Price of different options
const flightPrices = {
    "Classe Économique": 800,
    "Classe Confort": 1200,
    "Classe Affaires": 1400,
    "Première Classe": 2000
};

const transportPrices = {
    "Aucun": 0,
    "Vélo": 30,
    "Voiture": 90,
    "Bâteau": 100,
    "Chauffeur": 300,
    "Hélicoptère": 900
};

// Retrieve all dynamic elements
const dynamicInputs = document.querySelectorAll('.dynamic_input');
const totalPriceElement = document.querySelector('.price b');

const participantsSelect = document.querySelector('select[name="number_of_participants"]');
const flightSelect = document.querySelector('select[name="flight"]');
const transportSelect = document.querySelector('select[name="transports"]');

// Listen to changes

dynamicInputs.forEach(input => input.addEventListener('change', updatePrices));

participantsSelect?.addEventListener('change', updatePrices);

flightSelect?.addEventListener('change', updatePrices);

transportSelect?.addEventListener('change', updatePrices);

document.querySelectorAll('select[name^="participants_"]').forEach(select => {
    select.addEventListener('change', updatePrices);
});

// Update the individual prices next to each selection
function updatePrices() {
    dynamicInputs.forEach(input => {
        const priceType = input.getAttribute('data_price');
        const stepNumber = input.closest('.step_card')?.getAttribute('data_step');
        const priceDisplay = input.closest('.field_row')?.querySelector('.price_display');

        if (!priceDisplay) return;

        let price = 0;

        // Hotel
        if (priceType === 'hotel') {
            const hotelIndex = Array.from(input.options).findIndex(option => option.selected);
            price = hotelPrices[hotelIndex];
            priceDisplay.textContent = `${price} €`;
        }

        // Activity
        else if (priceType === 'activity') {
            const activityIndex = Array.from(input.options).findIndex(option => option.selected);
            const stepPrices = activitiesPrices[`step_${stepNumber}`];
            if (stepPrices) {
                price = stepPrices[activityIndex];
            }
            priceDisplay.textContent = `${price} €`;
        }

        // Pension
        else if (priceType === 'pension') {
            const pensionValue = input.value;
            if (pensionValue === "Tout inclus") {
                priceDisplay.textContent = "50 €";
            } else {
                priceDisplay.textContent = "Compris";
            }
        }
    });
}