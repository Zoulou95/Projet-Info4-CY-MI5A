// optionsLoader.js : fill dynamically <select> tag using fetch and localStorage

/* Retrieve informations from 'trip_data.json' or localStorage */

// Fill dynamically a <select> tag
function fillSelect(selectName, options, savedValue = null) {
    const selectElement = document.querySelector(`select[name="${selectName}"]`);
    if (!selectElement) {
        return;
    }

    selectElement.innerHTML = ''; // Clear existing value

    options.forEach(option => {
        const field = document.createElement('option'); // Create <option> tags
        field.value = option;
        field.textContent = option;
        
        // If we have a saved value, select it
        if (savedValue !== null && savedValue == option) {
            field.selected = true;
        }
        
        selectElement.appendChild(field); // Add <option> tags
    });
}

// Function to get saved choices from localStorage
function getSavedChoices(tripId) {
    const savedData = localStorage.getItem(`trip_choices_${tripId}`);
    if (savedData) {
        try {
            return JSON.parse(savedData);
        } catch (e) {
            console.error('Error parsing saved choices:', e);
            // Clear the corrupted data from localStorage
            localStorage.removeItem(`trip_choices_${tripId}`);
        }
    }
    return null;
}

// Load and fill dynamically <select> tag
document.addEventListener('DOMContentLoaded', function () {
    // Get the id of the trip from the URL (after ?id={number})
    const urlParameters = new URLSearchParams(window.location.search);
    const tripId = urlParameters.get('id');
    
    if (!tripId) {
        console.error('No trip ID found in URL');
        return;
    }
    
    // Check if there are saved choices in localStorage
    const savedChoices = getSavedChoices(tripId);
    
    // Load JSON data for options
    fetch('../data/trip_data.json')
        .then(response => response.json())
        .then(data => {
            const trip = data.trip.find(t => t.id == tripId);
            if (!trip) {
                console.error('Trip not found in JSON data');
                return;
            }
            
            // If we have saved choices, use them to select options
            if (savedChoices) {
                console.log('Loading saved choices from localStorage:', savedChoices);
                
                // Fill hotel
                fillSelect('hotel_1', trip.hotel, savedChoices.hotel_choices[0]);
                fillSelect('hotel_2', trip.hotel, savedChoices.hotel_choices[1]);
                fillSelect('hotel_3', trip.hotel, savedChoices.hotel_choices[2]);
                
                // Fill pension
                const pensions = ["Demi-pension", "Tout inclus", "Déjeuner uniquement", "Diner uniquement"];
                fillSelect('pension_1', pensions, savedChoices.pension_choices[0]);
                fillSelect('pension_2', pensions, savedChoices.pension_choices[1]);
                fillSelect('pension_3', pensions, savedChoices.pension_choices[2]);
                
                // Fill activities
                fillSelect('activite_1', trip.step_1.activities, savedChoices.activity_choices[0]);
                fillSelect('activite_2', trip.step_2.activities, savedChoices.activity_choices[1]);
                fillSelect('activite_3', trip.step_3.activities, savedChoices.activity_choices[2]);
                
                // Fill number of participants
                fillSelect('participants_1', [2, 3, 4, 5, 6], savedChoices.participants[0]);
                fillSelect('participants_2', [2, 3, 4, 5, 6], savedChoices.participants[1]);
                fillSelect('participants_3', [2, 3, 4, 5, 6], savedChoices.participants[2]);
                
                // Set the main number of participants
                const participantsSelect = document.querySelector('select[name="number_of_participants"]');
                if (participantsSelect && savedChoices.number_of_participants) {
                    participantsSelect.value = savedChoices.number_of_participants;
                }
                
                // Set flight
                const flightSelect = document.querySelector('select[name="flight"]');
                if (flightSelect && savedChoices.flight) {
                    flightSelect.value = savedChoices.flight;
                }
                
                // Set transport
                const transportSelect = document.querySelector('select[name="transports"]');
                if (transportSelect && savedChoices.transport) {
                    transportSelect.value = savedChoices.transport;
                }
                
                // Set departure city
                const departureCitySelect = document.querySelector('select[name="departure_city"]');
                if (departureCitySelect && savedChoices.departure_city) {
                    departureCitySelect.value = savedChoices.departure_city;
                }
            } else {
                // If no saved choices, fill with default values
                
                // Fill hotel
                fillSelect('hotel_1', trip.hotel);
                fillSelect('hotel_2', trip.hotel);
                fillSelect('hotel_3', trip.hotel);
                
                // Fill pension
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
            }
            
            // Display prices beside selects using loaded trip data
            hotelPrices = trip.hotel_price;
            activitiesPrices = {
                step_1: trip.step_1.activities_price,
                step_2: trip.step_2.activities_price,
                step_3: trip.step_3.activities_price
            };
            basePrice = trip.price_per_person;
            
            // Trigger prices display
            triggerChange('.dynamic_input');
            
            updatePrices();
        })
        .catch(error => {
            console.error('Error while loading options: ', error);
        });
});

// Trigger all selects to show the corresponding prices
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

// Retrieve all <select> tag and dynamic elements

const dynamicInputs = document.querySelectorAll('.dynamic_input');
const totalPriceElement = document.querySelector('.price b');

const participantsSelect = document.querySelector('select[name="number_of_participants"]');
const flightSelect = document.querySelector('select[name="flight"]');
const transportSelect = document.querySelector('select[name="transports"]');
const departureCitySelect = document.querySelector('select[name="departure_city"]');

// Listen to changes on every <select> tag

dynamicInputs.forEach(input => input.addEventListener('change', updatePrices));

participantsSelect?.addEventListener('change', updatePrices);

flightSelect?.addEventListener('change', updatePrices);

transportSelect?.addEventListener('change', updatePrices);

departureCitySelect?.addEventListener('change', updatePrices);

// Listen changes on numbers of participants of each step
document.querySelectorAll('select[name^="participants_"]').forEach(select => {
    select.addEventListener('change', updatePrices);
});

// Update the individual prices next to each selection
function updatePrices() {
    dynamicInputs.forEach(input => {
        const priceType = input.getAttribute('data_price');
        const stepNumber = input.closest('.step_card')?.getAttribute('data_step');
        const priceDisplay = input.closest('.field_row')?.querySelector('.price_display');

        let price = 0;

        // Hotel
        if (priceType === 'hotel') {

            // In the json, prices are stored in an array. Each iteration of the price array corresponds to the iteration of the hotel array
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