// profilteUpdate.js : update user's personal profile using AJAX

document.getElementById("profile_form").addEventListener("submit", function (event) {
    // Prevent default submission by clicking on the submit button
    event.preventDefault();

    // Get the form element and create FormData object
    const form = document.getElementById("profile_form");
    const formData = new FormData(form);

    // Vérifiez si un fichier est sélectionné et si oui, ajoutez-le au FormData
    const fileInput = document.getElementById('profile_picture_input');
    if (fileInput.files.length > 0) {
        formData.append('profile_picture', fileInput.files[0]); // Ajoutez le fichier au FormData
    }

    // Create and configure AJAX request
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else  if (window.ActiveXObject)      {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xhr.open("POST", "../includes/profile_update.php", true);

    // Handle server response
    xhr.onload = function () {
        // Check if the request was successful
        if (xhr.status === 200) {

            const profilePicImg = document.querySelectorAll(".user_img, .user_img_nav");
            if (profilePicImg) {
                // Refresh profile picture on the screen by adding a timestamp parameter
                profilePicImg.forEach(img => {
                    img.src = img.src.split("?")[0] + "?t=" + new Date().getTime();
                });
            }
            
        } else {
            // Handle HTTP error
            alert("Error: Update failed. Please try again.");
        }
    };

    // Handle errors
    xhr.onerror = function () {
        alert("Network error: Connection to server failed.");
    };

    // Send the form data
    xhr.send(formData);
});