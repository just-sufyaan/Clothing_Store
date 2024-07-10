// Function to validate the registration and login forms
function validateForm() {
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // Validate username
    if (username.trim() === "") {
        alert("Please enter a username.");
        return false;
    }

    // Validate email
    if (email.trim() === "") {
        alert("Please enter an email address.");
        return false;
    }

    // Validate password
    if (password.trim() === "") {
        alert("Please enter a password.");
        return false;
    }

    return true;
}
