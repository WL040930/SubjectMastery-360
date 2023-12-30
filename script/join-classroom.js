function moveToNext(currentInput) {
    if (currentInput.value.length === currentInput.maxLength) {
        const nextInput = currentInput.nextElementSibling;
        if (nextInput) {
            nextInput.focus();
        }
    }
}

function validateForm() {
    var validation_message = document.getElementById('validation-message');
    validation_message.textContent = "";

    for (let i = 1; i <= 7; i++) {
        const digit = document.getElementById('digit' + i).value;

        if (!(/^\d$/.test(digit))) {
            validation_message.textContent = "Only Digit Number is allowed";
            validation_message.style.color = "red";
            return false;
        }
    }

    return true;
}