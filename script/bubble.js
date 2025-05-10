// bubble.js : displaying dialog boxes in the event of an error

function displayBubble(event = null, message) {

    // Cancel current event (like form submission) only if passed as argument
    if (event) {
        event.preventDefault();
    }

    const bubble = document.getElementById('bubble');
    bubble.style.display = 'block';

    bubble.textContent = message;
  
    // Display bubble for 4 seconds
    setTimeout(() => bubble.style.display = 'none', 4000);
}