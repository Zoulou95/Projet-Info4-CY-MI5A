// sortResult.js : sort trip results without page reload

document.addEventListener("DOMContentLoaded", function() {
    // Check if we are on the results page (has trip cards)
    const tripCards = document.querySelectorAll('.card');
    if (tripCards.length === 0) return;

    // Create and add the sorting interface
    createSortingInterface();

    // Initialize sorting listeners
    initSortingListeners();
});

// Create the sorting interface to the page
function createSortingInterface() {
    // Sorting bar container
    const sortingContainer = document.createElement('div');
    sortingContainer.className = 'sorting_container';
    
    // Title
    const sortingTitle = document.createElement('h3');
    sortingTitle.textContent = 'Trier les résultats par:';
    sortingContainer.appendChild(sortingTitle);
    
    // Sorting buttons
    const sortingOptions = [
        { id: 'sort-price-asc', text: 'Prix croissant', field: 'price', order: 'asc' }, // 'asc' = ascending order
        { id: 'sort-price-desc', text: 'Prix décroissant', field: 'price', order: 'desc' },
        { id: 'sort-date-asc', text: 'Date (plus proche)', field: 'date', order: 'asc' },
        { id: 'sort-date-desc', text: 'Date (plus lointaine)', field: 'date', order: 'desc' },
        { id: 'sort-duration-asc', text: 'Durée (courte à longue)', field: 'duration', order: 'asc' },
        { id: 'sort-duration-desc', text: 'Durée (longue à courte)', field: 'duration', order: 'desc' }
    ];
    
    // Buttons container
    const buttonsContainer = document.createElement('div');
    buttonsContainer.className = 'sorting_buttons';
    
    // Add buttons
    sortingOptions.forEach(option => {
        const button = document.createElement('button');
        button.id = option.id;
        button.className = 'sort_button';
        button.textContent = option.text;
        button.dataset.field = option.field;
        button.dataset.order = option.order;
        buttonsContainer.appendChild(button);
    });
    
    sortingContainer.appendChild(buttonsContainer);
    
    // Insert sorting container beetween 'result_text' and 'result_container'
    const resultText = document.querySelector('.result_text');
    if (resultText) {
        resultText.insertAdjacentElement('afterend', sortingContainer);
    }
}

// Initializes the event listeners for sorting buttons
function initSortingListeners() {
    const sortButtons = document.querySelectorAll('.sort_button');
    
    sortButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from buttons
            sortButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get sorting parameters
            const field = this.dataset.field;
            const order = this.dataset.order;
            
            // Sort trip cards
            sortTripCards(field, order);
        });
    });
}

// Filtre cards display with price, date, etc.
function sortTripCards(field, order) {
    const tripCardsContainer = document.querySelector('.result_container');
    if (!tripCardsContainer) return;
    
    const tripCards = Array.from(document.querySelectorAll('.card'));
    
    // Sort trip cards
    tripCards.sort((a, b) => {
        let valueA, valueB;
        
        switch (field) {
            case 'price':
                // Extract price and convert to number
                valueA = extractNumericValue(a.querySelector('.price_value').textContent);
                valueB = extractNumericValue(b.querySelector('.price_value').textContent);
                break;
                
            case 'date':
                // Extract date and convert to Date object
                const dateA = a.querySelector('.date_value').textContent;
                const dateB = b.querySelector('.date_value').textContent;
                valueA = convertFrenchDateToDate(dateA);
                valueB = convertFrenchDateToDate(dateB);
                break;
                
            case 'duration':
                // Extract duration from data attribute
                valueA = parseInt(a.dataset.duration);
                valueB = parseInt(b.dataset.duration);
                break;
                
            case 'steps':
                // Extract number of steps from data attribute
                valueA = parseInt(a.dataset.steps);
                valueB = parseInt(b.dataset.steps);
                break;

            default:
                return 0;
        }
        
        // Compare values based on order
        if (order === 'asc') { // 'asc' = ascending order
            return valueA - valueB;
        } else {
            return valueB - valueA;
        }
    });
    
    // Remove all trip cards
    while (tripCardsContainer.firstChild) {
        tripCardsContainer.removeChild(tripCardsContainer.firstChild);
    }
    
    // Add sorted trip cards
    tripCards.forEach(card => {
        tripCardsContainer.appendChild(card);
    });
    
    // Show sorting animation
    animateSorting();
}

// Extracts numeric value from a string
function extractNumericValue(str) {
    // Removes non-numeric characters, replaces commas with periods and converts to a float
    return parseFloat(str.replace(/[^\d.,]/g, '').replace(',', '.'));
}

// Converts a French date format (DD/MM/YYYY) to a Date object
function convertFrenchDateToDate(dateStr) {
    // Handle different date formats
    if (dateStr.includes('/')) {
        // DD/MM/YYYY format
        const parts = dateStr.split('/');
        return new Date(parts[2], parts[1] - 1, parts[0]);
    } else if (dateStr.includes('-')) {
        // YYYY-MM-DD format
        return new Date(dateStr);
    } else {
        // Return current date if format is not recognized
        return new Date();
    }
}

// Animate the sorting process
function animateSorting() {
    const tripCards = document.querySelectorAll('.card');
    
    // Add animation class to each card
    tripCards.forEach((card, index) => {
        // Delay the animation
        setTimeout(() => {
            card.classList.add('sort_animation');
            
            // Remove animation class after completion
            setTimeout(() => {
                card.classList.remove('sort_animation');
            }, 500);
        }, index * 50);
    });
}