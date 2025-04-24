document.addEventListener("DOMContentLoaded", function() {

    // Extract hotel prices from JSON with fetch
    fetch('../data/trip_data.json')
        .then(response => response.json())
        .then(data => {
            const hotelPrices = data.hotel_price;
            const hotelSelect = document.querySelector('select[name="hotel_1"]');
            const priceDisplay = document.querySelector('.price_display');
  
        // Add event to change hotel selection
        hotelSelect.addEventListener('change', function() {
            const selectedIndex = hotelSelect.selectedIndex;
            const selectedPrice = hotelPrices[selectedIndex];
  
        // Display the price
        priceDisplay.textContent = `${selectedPrice} €`;
        });
    })
    .catch(error => console.error("Error loading 'trip_data.json' file", error));
});