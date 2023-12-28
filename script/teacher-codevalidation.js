function validateCode() {
    var code = document.getElementById("code").value;
    var validation_message = document.getElementById("validation-message");

    if (!/^\d{7}$/.test(code)) {
        validation_message.textContent = "Invalid code. Please enter a 7-digit number.";
        validation_message.style.color = "red";
        return false;
    } else {
        validation_message.textContent = ""; // Clear any previous error messages
        return true;
    }
}
