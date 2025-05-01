// bubble.js : function for displaying dialog boxes in the event of an error

function displayBubble(event = null, message) {

    // Cancels current event only if passed as argument
    if (event) {
        event.preventDefault();
    }

    const bubble = document.getElementById('bubble');
    bubble.style.display = 'block';

    bubble.textContent = message;
  
    setTimeout(() => bubble.style.display = 'none', 4000);
}