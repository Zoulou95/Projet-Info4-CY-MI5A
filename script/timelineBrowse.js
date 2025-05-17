// timelineBrowse.js : dynamic step changes

document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll('.step');
    const stepCards = document.querySelectorAll('.step_card');
    const prevButton = document.getElementById('previous_step');
    const nextButton = document.getElementById('next_step');
    const stepLine1 = document.querySelector('.step_line_1');
    const stepLine2 = document.querySelector('.step_line_2');
    
    let currentStep = 1;
    const totalSteps = steps.length;

    // Show the active step and its corresponding card
    function showStep(stepNumber) {
        // Convert stepNumber to integer if it's a string
        stepNumber = parseInt(stepNumber);
        currentStep = stepNumber;

        // Remove 'active' class from steps by default
        stepCards.forEach(card => card.classList.remove('active'));
        
        // Update the timeline's active state based on step number
        updateTimelineState(stepNumber);

        // Select the card to be displayed based on the step number
        const activeCard = document.querySelector(`.step_card[data_step="${stepNumber}"]`);
        
        // Add 'active' class to the selected step card
        if (activeCard) {
            activeCard.classList.add('active');
        } else {
            console.error(`Step card ${stepNumber} missing.`);
        }

        // Show/hide navigation buttons based on current step
        updateNavigationButtons();
    }

    // Update the timeline's active state based on current step
    function updateTimelineState(stepNumber) {
        // Reset all steps and lines
        steps.forEach(step => step.classList.remove('active', 'completed'));
        if (stepLine1) stepLine1.classList.remove('active');
        if (stepLine2) stepLine2.classList.remove('active');

        // Mark all previous steps and lines as completed
        for (let i = 1; i <= totalSteps; i++) {
            const stepEl = document.querySelector(`.step[data_step="${i}"]`);
            
            if (i < stepNumber) {
                // Previous steps are marked as completed
                if (stepEl) stepEl.classList.add('completed');
            } else if (i === stepNumber) {
                // Current step is active
                if (stepEl) stepEl.classList.add('active');
            }
        }

        // Activate appropriate lines based on current step
        if (stepNumber >= 2 && stepLine1) {
            stepLine1.classList.add('active');
        }
        if (stepNumber >= 3 && stepLine2) {
            stepLine2.classList.add('active');
        }
    }

    // Update the visibility of navigation buttons
    function updateNavigationButtons() {
        // Hide previous button if on first step
        if (currentStep === 1) {
            prevButton.style.display = 'none';
        } else {
            prevButton.style.display = 'block';
        }

        // Hide next button if on last step
        if (currentStep === totalSteps) {
            nextButton.style.display = 'none';
        } else {
            nextButton.style.display = 'block';
        }
    }

    // Add click events to the new navigation buttons
    prevButton.addEventListener('click', function() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });

    nextButton.addEventListener('click', function() {
        if (currentStep < totalSteps) {
            showStep(currentStep + 1);
        }
    });

    // Show the first step by default
    showStep(1);
});