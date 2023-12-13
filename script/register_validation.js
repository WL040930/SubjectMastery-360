function register_validation() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    var validate_message = document.getElementsByClassName("validate-message")[0];
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var first_name = document.getElementById("first_name").value;
    var last_name = document.getElementById("last_name").value;

    var uppercase = /[A-Z]/;
    var lowercase = /[a-z]/;
    var specialcharacter = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    var number = /[0-9]/;
    var length = /.{8,}/;
    var username_length = /.{5,11}/;  // Updated the range
    var name_length = /.{1,15}/;

    if (!username.match(username_length)) {
        validate_message.textContent = "Username must be between 5 and 11 characters long";
        validate_message.style.color = "red";
        return false;
    }

    if (!first_name.match(name_length)) {
        validate_message.textContent = "First name must be between 1 and 15 characters long";
        validate_message.style.color = "red";
        return false;
    }

    if (!last_name.match(name_length)) {
        validate_message.textContent = "Last name must be between 1 and 15 characters long";
        validate_message.style.color = "red";
        return false;
    }

    var passwordRequirements = [
        uppercase,
        lowercase,
        specialcharacter,
        number,
        length
    ];

    for (var i = 0; i < passwordRequirements.length; i++) {
        if (!password.match(passwordRequirements[i])) {
            validate_message.textContent = "Password must contain at least one uppercase letter, one lowercase letter, one number, one special character, and be at least 8 characters long";
            validate_message.style.color = "red";
            return false;
        }
    }

    if (password !== confirm_password) {
        validate_message.textContent = "Passwords do not match";
        validate_message.style.color = "red";
        return false;
    }

    validate_message.textContent = "";
    return true;
}

// add validate email