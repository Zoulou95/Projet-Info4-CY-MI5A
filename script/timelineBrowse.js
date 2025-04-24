document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll('.step');
    const stepCards = document.querySelectorAll('.step-card');

    function showStep(stepNumber) {

        stepCards.forEach(card => card.classList.remove('active'));
        steps.forEach(step => step.classList.remove('active'));


        const activeCard = document.querySelector(`.step-card[data-step="${stepNumber}"]`);
        const activeStep = document.querySelector(`.step[data-step="${stepNumber}"]`);
        
        if (activeCard && activeStep) {
            activeCard.classList.add('active');
            activeStep.classList.add('active');
        } else {
            console.warn(`Step ${stepNumber} introuvable.`);
        }
    }

    steps.forEach(step => {
        step.addEventListener('click', function () {
            const stepNumber = step.getAttribute('data-step');
            showStep(stepNumber);
        });
    });

    showStep(1);
});