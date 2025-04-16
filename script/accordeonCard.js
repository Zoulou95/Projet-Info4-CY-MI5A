// ee

let currentStep = 1;
    const steps = document.querySelectorAll('.step');

    function showStep(stepIndex) {
        steps.forEach(step => step.style.display = 'none');
        document.getElementById(`step-${stepIndex}`).style.display = 'block';
    }

    function nextStep(stepIndex) {
        currentStep++;
        if (currentStep > steps.length) {
            alert('Toutes les étapes sont complètes !');
        } else {
            showStep(currentStep);
        }
    }

    // Initialisation: Affiche la première étape au chargement
    showStep(currentStep);