const amountInput = document.getElementById("loanAmount");
const buttons = document.querySelectorAll(".btn-select");

buttons.forEach((button) => {
    button.addEventListener("click", function (e) {
        e.preventDefault();
        buttons.forEach((btn) => btn.classList.remove("selected"));
        this.classList.add("selected");
        const amount = this.dataset.amount;
        amountInput.value = Number(amount).toLocaleString("en-IN");
    });
});

amountInput.addEventListener("input", () => {
    buttons.forEach((btn) => btn.classList.remove("selected"));
});


document.getElementById("loanAmount").addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, "");
});
