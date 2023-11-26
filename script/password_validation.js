function validate_password() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    var validate_message = document.getElementsByClassName("validate-message")[0];

    var uppercase = /[A-Z]/;
    var lowercase = /[a-z]/;
    var specialcharacter = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    var number = /[0-9]/;
    var length = /.{8,}/;

    if (
        password.match(uppercase) &&
        password.match(lowercase) &&
        password.match(specialcharacter) &&
        password.match(number) &&
        password.match(length)
    ) {
        if (password === confirm_password) {
            validate_message.textContent = "";
        } else {
            validate_message.textContent = "Password and Confirm Password must match.";
            validate_message.style.color = "red";
            return false;
        }
    } else {
        validate_message.textContent =
            "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        validate_message.style.color = "red";
        return false;
    }
}