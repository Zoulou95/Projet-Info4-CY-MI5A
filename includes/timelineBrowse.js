// timelineBrowse.js : script to browse a timeline and select steps when choosing a trip

document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.step');
    const boards = document.querySelectorAll('.steps_board');

    // Function to hide all boards
    function hideAllBoards() {
        boards.forEach(board => {
            board.style.display = 'none';
        });
    }

    // Function to show the board corresponding to the step
    function showBoard(stepNumber) {
        hideAllBoards();
        const boardToShow = document.querySelector(`.steps_board:nth-of-type(${stepNumber})`);
        boardToShow.style.display = 'block';
    }

    // Function to handle the activation of a step
    function activateStep(step) {
        steps.forEach(s => s.classList.remove('active'));
        step.classList.add('active');
    }

    // By default, display the board for step 1
    hideAllBoards();
    showBoard(1);

    // Add a click event to each circle of the timeline
    steps.forEach((step, index) => {
        step.addEventListener('click', function () {
            showBoard(index + 1);
            activateStep(step);
        });
    });
});
