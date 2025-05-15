// priceCalculator.js : dynamically calculates trip final price (client side)

document.addEventListener('DOMContentLoaded', function() {

    // Retrieve JSON data provided by PHP   
    const basePrice = tripData.price_per_person;
    const hotelPrices = tripData.hotel_price;
    const activitiesPrices = {
        step_1: tripData.step_1.activities_price,
        step_2: tripData.step_2.activities_price,
        step_3: tripData.step_3.activities_price
    };

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
    
    // Initialize prices displayed
    updateAllPrices();
    
    dynamicInputs.forEach(input => {
        input.addEventListener('change', updateAllPrices);
    });
    
    participantsSelect.addEventListener('change', updateAllPrices);
    flightSelect.addEventListener('change', updateAllPrices);
    transportSelect.addEventListener('change', updateAllPrices);
    
    document.querySelectorAll('select[name^="participants_"]').forEach(select => {
        select.addEventListener('change', updateAllPrices);
    });

    // Main price update function
    function updateAllPrices() {

        updateIndividualPrices();
        
        const totalPrice = calculateTotalPrice();
        
        // Display total price
        totalPriceElement.textContent = `Prix total : ${totalPrice.toLocaleString()} €`;
    }
    
    // Update the individual prices next to each selection
    function updateIndividualPrices() {
        dynamicInputs.forEach((input, index) => {
            const priceType = input.getAttribute('data_price');
            const stepNumber = input.closest('.step_card')?.getAttribute('data_step');
            const priceDisplay = input.closest('.field_row').querySelector('.price_display');
            
            if (priceDisplay) {
                let price = 0;

                // Hotel
                // We find the index corresponding to the hotel chosen for the user (0, 1, 2) in the json, to find its corresponding price
                if (priceType === 'hotel') {
                    const hotelIndex = Array.from(input.options).findIndex(option => option.selected);
                    price = hotelPrices[hotelIndex];
                    priceDisplay.textContent = `${price} €`;
                } 

                // Activity
                else if (priceType === 'activity') {
                    const activityIndex = Array.from(input.options).findIndex(option => option.selected);
                    if (stepNumber && activitiesPrices[`step_${stepNumber}`]) {
                        price = activitiesPrices[`step_${stepNumber}`][activityIndex];
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
            }
        });
    }
    
    // Calculate the total price of the trip
    function calculateTotalPrice() {
        const nbParticipants = parseInt(participantsSelect.value);
        const flightPrice = flightPrices[flightSelect.value];
        const transportPrice = transportPrices[transportSelect.value];
        const tripDuration = tripData.dates.length;
        
        // Service charge per person
        let totalPrice = basePrice * nbParticipants;
        
        // Flight price
        totalPrice += flightPrice * nbParticipants;
        
        // Transportation costs (per day)
        totalPrice += transportPrice * nbParticipants * tripDuration;
        
        // Calculate the price of hotels and activities for each stage
        for (let i=1; i<=3; i++) {
            const stepDuration = tripData[`step_${i}`].dates.duration;
            const stepParticipants = parseInt(document.querySelector(`select[name="participants_${i}"]`).value);
            
            // Hotel
            // We find the index corresponding to the hotel chosen for the user (0, 1, 2) in the json, to find its corresponding price
            const hotelSelect = document.querySelector(`select[name="hotel_${i}"]`);
            const hotelIndex = Array.from(hotelSelect.options).findIndex(option => option.selected);
            const hotelPrice = hotelPrices[hotelIndex];
            totalPrice += hotelPrice * stepParticipants * stepDuration;
            
            // Pension
            const pensionSelect = document.querySelector(`select[name="pension_${i}"]`);
            const pensionValue = pensionSelect.value;
            if (pensionValue === "Tout inclus") {
                totalPrice += 50 * stepParticipants * stepDuration;
            }
            
            // Activity
            const activitySelect = document.querySelector(`select[name="activite_${i}"]`);
            const activityIndex = Array.from(activitySelect.options).findIndex(option => option.selected);
            const activityPrice = activitiesPrices[`step_${i}`][activityIndex];
            totalPrice += activityPrice * stepParticipants;
        }

        // Apply VIP discount if the user is VIP
        if (typeof isVIP !== "undefined" && isVIP === true) {
            totalPrice *= 0.9;
        }

        return totalPrice;
    }
});