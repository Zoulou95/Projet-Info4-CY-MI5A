// picture_upload.js :

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
            } else {
                // Display the right amount of item in the cart, in the header

                const cartDisplay = document.getElementById('cart_display');
                if (cartDisplay) {
                    cartDisplay.innerHTML = ` Panier (` + remaining_cards.length + `) 🛒 `;
                }

                updateTotal();
            }

        } else {
            console.log("ERROR : trip cancellation failure.");
        }
    };

    // Handle errors
    xhr.onerror = function() {
        console.log("ERROR : Network error while deleting cart item.");
    };

    // Send data in JSON format to remove_from_cart.php
    var data = JSON.stringify({ "cart_id": cart_id });
    xhr.send(data);
}

