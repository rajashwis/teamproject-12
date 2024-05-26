document.addEventListener('DOMContentLoaded', function () {
    const minusBtns = document.querySelectorAll('.minus-btn');
    const plusBtns = document.querySelectorAll('.plus-btn');
    const quantityInputs = document.querySelectorAll('.quantity');

    // Decrease quantity when minus button is clicked
    minusBtns.forEach((btn, index) => {
        btn.addEventListener('click', function () {
            let currentValue = parseInt(quantityInputs[index].value);
            if (currentValue > 1) {
                quantityInputs[index].value = currentValue - 1;
            }
        });
    });

    // Increase quantity when plus button is clicked
    plusBtns.forEach((btn, index) => {
        btn.addEventListener('click', function () {
            let currentValue = parseInt(quantityInputs[index].value);
            quantityInputs[index].value = currentValue + 1;
        });
    });
});
