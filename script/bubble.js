function displayBubble(event, message) {

    event.preventDefault();

    const bubble = document.getElementById('bubble');
    bubble.style.display = 'block';

    bubble.textContent = message;
  
    setTimeout(() => bubble.style.display = 'none', 4000);
}

function showBubble(message) {

    const bubble = document.getElementById('bubble');
    bubble.style.display = 'block';

    bubble.textContent = message;
  
    setTimeout(() => bubble.style.display = 'none', 4000);
}