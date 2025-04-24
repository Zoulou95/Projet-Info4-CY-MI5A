document.addEventListener("DOMContentLoaded", function () {
    const priceText = document.querySelector(".price b");
    const form = document.querySelector("form");

    function getParticipantCount(step) {
        const input = form.querySelector("[name='participants_" + step + "']");
        if (input && input.value) {
            return parseInt(input.value);
        }
        return 0;
    }

    function getPensionCost(value) {
        if (value === "Tout inclus") {
            return 50;
        }
        return 0;
    }

    function getTransportCost(value) {
        if (value === "Vélo") return 30;
        if (value === "Voiture") return 90;
        if (value === "Bâteau") return 100;
        if (value === "Chauffeur") return 300;
        if (value === "Hélicoptère") return 900;
        return 0;
    }

    function getTripDuration(step) {
        const text = form.querySelector(".step-card[data-step='" + step + "'] p");
        if (text) {
            const match = text.innerText.match(/\d+/);
            if (match) {
                return parseInt(match[0]);
            }
        }
        return 0;
    }

    function calculateTotalPrice() {
        let total = 0;

        const baseCell = document.querySelector("td:last-child");
        let basePrice = 0;
        if (baseCell) {
            basePrice = parseInt(baseCell.innerText.replace("€", ""));
        }

        const selectParticipants = form.querySelector("[name='number_of_participants']");
        let numParticipants = 0;
        if (selectParticipants && selectParticipants.value) {
            numParticipants = parseInt(selectParticipants.value);
        }

        total += basePrice * numParticipants;

        const transportSelect = form.querySelector("[name='transports']");
        let transportValue = "";
        if (transportSelect) {
            transportValue = transportSelect.value;
        }

        const transportCost = getTransportCost(transportValue);

        let totalDays = 0;
        totalDays += getTripDuration(1);
        totalDays += getTripDuration(2);
        totalDays += getTripDuration(3);

        total += transportCost * numParticipants * totalDays;

        for (let i=1; i<=3; i++) {
            const stepParticipants = getParticipantCount(i);
            const pensionSelect = form.querySelector("[name='pension_" + i + "']");
            let pensionValue = "";
            if (pensionSelect) {
                pensionValue = pensionSelect.value;
            }
            const pensionCost = getPensionCost(pensionValue);
            const stepDuration = getTripDuration(i);

            total += pensionCost * stepParticipants * stepDuration;
        }

        priceText.innerText = "Prix total : " + total + " €";
    }

    form.addEventListener("change", calculateTotalPrice);
    calculateTotalPrice();
});