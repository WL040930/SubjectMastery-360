// validation-mark.js
function validate_mark() {
    var mark = document.getElementById("mark").value;
    var validationMessage = document.getElementById("validation-message");

    if (!/^\d+$/.test(mark)) {
        validationMessage.textContent = "Please enter only digit numbers for Marks";
        validationMessage.style.color = "red"; // Set the color to red for error message
        return false;
    } else {
        validationMessage.textContent = ""; // Clear the validation message
        return true;
    }
}
