// timelineBrowse.js : dynamic step changes

document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll('.step');
    const stepCards = document.querySelectorAll('.step_card');

    // Function to show the active step and its corresponding card
    function showStep(stepNumber) {

        // Remove 'active' class from all steps by default
        stepCards.forEach(card => card.classList.remove('active'));
        steps.forEach(step => step.classList.remove('active'));

        // Select the card to be displayed based on the step number
        const activeCard = document.querySelector(`.step_card[data_step="${stepNumber}"]`);
        const activeStep = document.querySelector(`.step[data_step="${stepNumber}"]`);
        
        // Add 'active' class to the selected step
        if (activeCard && activeStep) {
            activeCard.classList.add('active');
            activeStep.classList.add('active');
        } else {
            console.error(`Step ${stepNumber} missing.`);
        }
    }

    // Add click event to each step
    steps.forEach(step => {
        step.addEventListener('click', function () {
            const stepNumber = step.getAttribute('data_step');
            showStep(stepNumber);
        });
    });

    // Show the first step by default
    showStep(1);
});