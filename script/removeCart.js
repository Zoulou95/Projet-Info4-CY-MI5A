// removeCart.js : remove a shopping cart trip visually and in the database (JSON) using AJAX

// Dynamically generate a new control key for the paymenet
function updateControl(montant) {
    const transactionId = document.getElementById('transaction').value;
    const vendeur = 'MI-5_A';

    // Regenerate control value with md5
    const controlValue = md5(apiKey + "#" + transactionId + "#" + montant + "#" + vendeur + "#" + retourUrl + "#");

    // Update the control field in the form
    const controlInput = document.getElementById('control');
    controlInput.value = controlValue;
}

// Dynamically display the total price to be paid for the trips in the cart
function updateTotal() {
    const cards = document.querySelectorAll('.card[data-price]');
    let total = 0;
    let fidelity = 0;

    // Calculate the final price and final fidelity points number
    for (let i=0; i<cards.length; i++) {
        let card = cards[i];
    
        let price = parseFloat(card.dataset.price);
        let points = parseFloat(card.dataset.fidelite);
    
        if (!isNaN(price)) {
            total += price;
            fidelity += points;
        }
    }

    updateControl(total);

    // Update total price display (client side)
    const priceDisplay = document.getElementById('price_display');
    if(priceDisplay) {
        priceDisplay.innerHTML = `${total} € (` + parseInt(fidelity) + ` points de fidelité)`;
    }

    // Update total price for payment (server-side)
    const montantInput = document.getElementById('montant');
    if(montantInput) {
        montantInput.value = total;
    }
}

// Display empty user cart UI
function displayEmptyCartUI() {
    const cartContainer = document.getElementById('cart_container');
    if (cartContainer) {
        cartContainer.innerHTML = `
            <h1 class="cart_title">Votre panier est vide</h1>
            <p class="cart_desc">Retrouvez ici les voyages que vous avez configuré</p>
            <button class="empty_cart_button" onclick="window.location.href='search.php'">
                <span class="back_to_index_text">Cliquez ici pour rechercher un voyage</span>
            </button>
        `;
    }

    // Display empty cart in the header
    const cartDisplay = document.getElementById('cart_display');
    if (cartDisplay) {
        cartDisplay.innerHTML = ` Panier 🛒`;
    }
}

// Deletes an item from the cart, server and client-side
function removeCart(cart_id) {

    // Create and configure AJAX request
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else  if (window.ActiveXObject)      {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xhr.open("POST", "../includes/remove_from_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8"); // Required to transfer JSON

    // Handle server response
    xhr.onload = function() {
        // Check if the request was successful
        if (xhr.status == 200) {
            var card = document.getElementById('card_' + cart_id);
            if (card) {
                card.remove();
            }

            // If there are no more trips, the empty cart is displayed
            const remaining_cards = document.querySelectorAll('.card');
            if (remaining_cards.length == 0) {
                displayEmptyCartUI();
            } else {
                // Display the right amount of item in the cart, in the header

                const cartDisplay = document.getElementById('cart_display');
                if (cartDisplay) {
                    cartDisplay.innerHTML = ` Panier (` + remaining_cards.length + `) 🛒 `;
                }

                updateTotal();
            }

        } else {
            // Handle HTTP error
            console.log("ERROR : trip cancellation failure.");
            displayBubble("⚠️ Impossible de supprimer le voyage");
        }
    };

    // Handle errors
    xhr.onerror = function() {
        console.log("ERROR : Network error while deleting cart item.");
        displayBubble("⚠️ Connexion au serveur impossible");
    };

    // Send data in JSON format to remove_from_cart.php
    var data = JSON.stringify({ "cart_id": cart_id });
    xhr.send(data);
}