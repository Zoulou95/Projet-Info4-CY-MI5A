// sort_results.js - Script to sort trip results without page reload

document.addEventListener("DOMContentLoaded", function() {
    // Check if we're on the results page (has trip cards)
    const tripCards = document.querySelectorAll('.card');
    if (tripCards.length === 0) return;

    // Create and add the sorting interface
    createSortingInterface();

    // Initialize sorting listeners
    initSortingListeners();
});

/**
 * Creates and adds the sorting interface to the page
 */
function createSortingInterface() {
    // Create the sorting bar container
    const sortingContainer = document.createElement('div');
    sortingContainer.className = 'sorting_container';
    
    // Add title
    const sortingTitle = document.createElement('h3');
    sortingTitle.textContent = 'Trier les résultats par:';
    sortingContainer.appendChild(sortingTitle);
    
    // Create sorting buttons
    const sortingOptions = [
        { id: 'sort-price-asc', text: 'Prix croissant', field: 'price', order: 'asc' },
        { id: 'sort-price-desc', text: 'Prix décroissant', field: 'price', order: 'desc' },
        { id: 'sort-date-asc', text: 'Date (plus proche)', field: 'date', order: 'asc' },
        { id: 'sort-date-desc', text: 'Date (plus lointaine)', field: 'date', order: 'desc' },
        { id: 'sort-duration-asc', text: 'Durée (courte à longue)', field: 'duration', order: 'asc' },
        { id: 'sort-duration-desc', text: 'Durée (longue à courte)', field: 'duration', order: 'desc' },
        { id: 'sort-steps-asc', text: 'Nombre d\'étapes (croissant)', field: 'steps', order: 'asc' },
        { id: 'sort-steps-desc', text: 'Nombre d\'étapes (décroissant)', field: 'steps', order: 'desc' }
    ];
    
    // Create buttons container
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
    
    // Insert sorting container after the result_text heading and before the trip_cards_container
    const resultText = document.querySelector('.result_text');
    if (resultText) {
        resultText.insertAdjacentElement('afterend', sortingContainer);
    }
}

/**
 * Initializes the event listeners for sorting buttons
 */
function initSortingListeners() {
    const sortButtons = document.querySelectorAll('.sort_button');
    
    sortButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
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

/**
 * Sorts the trip cards based on the selected criteria
 * @param {string} field - The field to sort by (price, date, duration, steps)
 * @param {string} order - The sort order (asc or desc)
 */
function sortTripCards(field, order) {
    const tripCardsContainer = document.querySelector('.trip_cards_container');
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
        if (order === 'asc') {
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

/**
 * Extracts numeric value from a string
 * @param {string} str - The string containing a numeric value
 * @returns {number} - The extracted numeric value
 */
function extractNumericValue(str) {
    // Remove non-numeric characters and convert to number
    return parseFloat(str.replace(/[^\d.,]/g, '').replace(',', '.'));
}

/**
 * Converts a French date format (DD/MM/YYYY) to a Date object
 * @param {string} dateStr - Date string in format DD/MM/YYYY
 * @returns {Date} - Date object
 */
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

/**
 * Animates the sorting process
 */
function animateSorting() {
    const tripCards = document.querySelectorAll('.card');
    
    // Add animation class to each card
    tripCards.forEach((card, index) => {
        // Delay the animation for each card
        setTimeout(() => {
            card.classList.add('sort_animation');
            
            // Remove animation class after it completes
            setTimeout(() => {
                card.classList.remove('sort_animation');
            }, 500);
        }, index * 50);
    });
}