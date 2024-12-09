const selector = document.getElementById("lottery-selector");
const resultContainer = document.getElementById("lottery-result");
const lotteryName = document.getElementById("lottery-name");
const lotteryResult = document.getElementById("lottery-result-value");

selector.addEventListener("change", (event) => {
    const selectedOption = event.target.selectedOptions[0];

    if (selectedOption) {
        const name = selectedOption.textContent;
        const result = selectedOption.dataset.result;

        lotteryName.textContent = name;
        lotteryResult.textContent = result == null ? result : "No hay numero ganador";

        resultContainer.classList.remove("d-none");
    }
});