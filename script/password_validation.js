function validate_password() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    var validate_message = document.getElementsByClassName("validate-message")[0];
    var username = document.getElementById("username").value;

    var uppercase = /[A-Z]/;
    var lowercase = /[a-z]/;
    var specialcharacter = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    var number = /[0-9]/;
    var length = /.{8,}/;
    var username_length = /.{5,11}/;
    var not_null = /.{1,}/


    if (username.match(username_length)) {
        if (
            password.match(uppercase) &&
            password.match(lowercase) &&
            password.match(specialcharacter) &&
            password.match(number) &&
            password.match(length)
            ) {
                if (password == confirm_password) {
                    validate_message.textContent = "";
                }
                else {
                    validate_message.textContent = "Passwords do not match";
                    validate_message.style.color = "red"; 
                    return false;
            }  
        } else {
            validate_message.textContent = "Password must contain at least one uppercase letter, one lowercase letter, one number and one special character";
            validate_message.style.color = "red";
            return false;
        }
    } else {
        validate_message.textContent = "Username must be between 5 and 11 characters long";
        validate_message.style.color = "red";
        return false;
    }
}