// priceCalculator.js : dynamically calculates trip prices

document.addEventListener('DOMContentLoaded', function() {
    // Retrieve JSON data provided by PHP   
    const basePrice = tripData.price_per_person || 0;
    const hotelPrices = tripData.hotel_price || [0, 0, 0];
    const activitiesPrices = {
        step_1: tripData.step_1.activities_price || [0, 0, 0],
        step_2: tripData.step_2.activities_price || [0, 0, 0],
        step_3: tripData.step_3.activities_price || [0, 0, 0]
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

    const pensionPrices = {
        "Demi-pension": 0,
        "Tout inclus": 50,
        "Déjeuner uniquement": 0,
        "Diner uniquement": 0
    };

    // Retrieve all dynamic elements
    const dynamicInputs = document.querySelectorAll('.dynamic_input');
    const priceDisplays = document.querySelectorAll('.price_display');
    const totalPriceElement = document.querySelector('.price b');
    
    const participantsSelect = document.querySelector('select[name="number_of_participants"]');
    const flightSelect = document.querySelector('select[name="flight"]');
    const transportSelect = document.querySelector('select[name="transports"]');
    
    // Initialize prices displayed on loading
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
        
        totalPriceElement.textContent = `Prix total : ${totalPrice.toLocaleString()} €`;
    }
    
    // Update the individual prices next to each selection
    function updateIndividualPrices() {
        dynamicInputs.forEach((input, index) => {
            const priceType = input.getAttribute('data_price');
            const stepNumber = input.closest('.step_card')?.getAttribute('data-step');
            const priceDisplay = input.closest('.field_row').querySelector('.price_display');
            
            if (priceDisplay) {
                let price = 0;
                
                if (priceType === 'hotel') {
                    const hotelIndex = Array.from(input.options).findIndex(option => option.selected);
                    price = hotelPrices[hotelIndex] || 0;
                    priceDisplay.textContent = `${price} €`;
                } 
                else if (priceType === 'activity') {
                    const activityIndex = Array.from(input.options).findIndex(option => option.selected);
                    if (stepNumber && activitiesPrices[`step_${stepNumber}`]) {
                        price = activitiesPrices[`step_${stepNumber}`][activityIndex] || 0;
                    }
                    priceDisplay.textContent = `${price} €`;
                }
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
        const nbParticipants = parseInt(participantsSelect.value) || 2;
        const flightPrice = flightPrices[flightSelect.value] || 800;
        const transportPrice = transportPrices[transportSelect.value] || 0;
        
        // Service charge
        let totalPrice = basePrice * nbParticipants;
        
        // Flight price
        totalPrice += flightPrice * nbParticipants;
        
        // Transportation costs (per day)
        const tripDuration = tripData.dates.length || 7;
        if (transportPrice > 0) {
            totalPrice += transportPrice * nbParticipants * tripDuration;
        }
        
        // Calculate the price of hotels and activities for each stage
        for (let step = 1; step <= 3; step++) {
            const stepDuration = tripData[`step_${step}`].dates.duration || 1;
            const stepParticipants = parseInt(document.querySelector(`select[name="participants_${step}"]`).value) || 2;
            
            // Hotel
            const hotelSelect = document.querySelector(`select[name="hotel_${step}"]`);
            const hotelIndex = Array.from(hotelSelect.options).findIndex(option => option.selected);
            const hotelPrice = hotelPrices[hotelIndex] || 0;
            totalPrice += hotelPrice * stepParticipants * stepDuration;
            
            // Pension
            const pensionSelect = document.querySelector(`select[name="pension_${step}"]`);
            const pensionValue = pensionSelect.value;
            if (pensionValue === "Tout inclus") {
                totalPrice += 50 * stepParticipants * stepDuration;
            }
            
            // Activity
            const activitySelect = document.querySelector(`select[name="activite_${step}"]`);
            const activityIndex = Array.from(activitySelect.options).findIndex(option => option.selected);
            const activityPrice = activitiesPrices[`step_${step}`][activityIndex] || 0;
            totalPrice += activityPrice * stepParticipants;
        }
        
        return totalPrice;
    }
});