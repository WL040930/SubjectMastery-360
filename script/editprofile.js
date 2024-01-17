function handleFileInput() {
    var fileInput = document.getElementById('image');
    var previewImage = document.getElementById('previewImage');
    var selectedFile = fileInput.files[0];

    if (selectedFile) {
        var reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result;
        };
        reader.readAsDataURL(selectedFile);
    }
}

function profile_validation() {
    var username = document.getElementById("username").value;
    var first_name = document.getElementById("firstname").value;
    var last_name = document.getElementById("lastname").value;
    var password = document.getElementById("password").value;
    var validate_message = document.getElementsByClassName("validation_message")[0];
    
    var uppercase = /[A-Z]/;
    var lowercase = /[a-z]/;
    var specialcharacter = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    var number = /[0-9]/;
    var length = /.{8,}/;
    var username_length = /.{5,11}/;
    var name_length = /.{1,15}/;

    var passwordRequirements = [
                                uppercase,
                                lowercase,
                                specialcharacter,
                                number,
                                length
                            ];
    
    if (!username.match(username_length) || username.length > 11) {
        validate_message.textContent = "Username must be between 5 and 11 characters long";
        validate_message.style.color = "red";
        return false;
    }

    if (!first_name.match(name_length) || first_name.length > 15) {
        validate_message.textContent = "First name must be between 1 and 15 characters long";
        validate_message.style.color = "red";
        return false;
    }

    if (!last_name.match(name_length) || last_name.length > 15) {
        validate_message.textContent = "Last name must be between 1 and 15 characters long";
        validate_message.style.color = "red";
        return false;
    }

    for (var i = 0; i < passwordRequirements.length; i++) {
        if (!password.match(passwordRequirements[i])) {
            validate_message.textContent = "Password must contain at least one uppercase letter, one lowercase letter, one number, one special character, and be at least 8 characters long";
            validate_message.style.color = "red";
            return false;
        }
    }

    validate_message.textContent = "";
    return true;
}