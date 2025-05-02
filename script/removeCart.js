// Remove a shopping cart trip visually and in the database (JSON) using AJAX

// Display empty user cart UI
function displayEmptyCartUI() {
    const cartContainer = document.getElementById('cart_container');
    if (cartContainer) {
        cartContainer.innerHTML = `
            <h1 class="cart_title">Votre panier est vide</h1>
            <p class="cart_desc">Retrouvez ici les voyages que vous avez configuré</p>
            <button class="back_to_index_button" onclick="window.location.href='search.php'">
                <span class="back_to_index_text">Cliquez ici pour rechercher un voyage</span>
            </button>
        `;
    }
}

// Deletes an item from the cart, server- and client-side (visual)
function removeCart(cart_id) {

    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else  if (window.ActiveXObject)      {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    // Send the request using AJAX
    xhr.open("POST", "../includes/remove_from_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    // Manage response
    xhr.onload = function() {
        if (xhr.status == 200) {
            var card = document.getElementById('card_' + cart_id);
            if (card) {
                card.remove();
            }

            // If there are no more trips, the empty cart is displayed
            const remaining_cards = document.querySelectorAll('.card');
            if (remaining_cards.length == 0) {
                displayEmptyCartUI();
            }

        } else {
            //displayBubble('Impossible de supprimer ce voyage !');
            console.log("ERROR : trip cancellation failure.");
        }
    };

    // Handle errors
    xhr.onerror = function() {
        //displayBubble('Erreur réseau lors de la suppression.');
        console.log("ERROR : Network error while deleting cart item.");
    };

    // Send data in JSON format
    var data = JSON.stringify({ "cart_id": cart_id });
    xhr.send(data);
}