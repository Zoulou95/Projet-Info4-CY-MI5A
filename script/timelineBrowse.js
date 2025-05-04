// timelineBrowse.js : dynamic step changes

document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll('.step');
    const stepCards = document.querySelectorAll('.step_card');

    function showStep(stepNumber) {

        stepCards.forEach(card => card.classList.remove('active'));
        steps.forEach(step => step.classList.remove('active'));


        const activeCard = document.querySelector(`.step_card[data_step="${stepNumber}"]`);
        const activeStep = document.querySelector(`.step[data_step="${stepNumber}"]`);
        
        if (activeCard && activeStep) {
            activeCard.classList.add('active');
            activeStep.classList.add('active');
        } else {
            console.warn(`Step ${stepNumber} introuvable.`);
        }
    }

    steps.forEach(step => {
        step.addEventListener('click', function () {
            const stepNumber = step.getAttribute('data_step');
            showStep(stepNumber);
        });
    });

    showStep(1);
});