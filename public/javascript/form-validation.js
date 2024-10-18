function validateAndSubmitForm(event) {
    event.preventDefault(); // Prevent default form submission initially

    const email = document.getElementById('email').value.trim();
    const emailExtension = document.querySelector('select[name="domain"]').value;
    const termsChecked = document.getElementById('terms').checked;

    console.log("email: ", email);
    console.log("termsChecked: ", termsChecked);
    alert("Email: " + email + "\nTerms Checked: " + termsChecked + "\nEmail Extension: " + emailExtension);

    // Perform your custom validation
    if (validateForm()) {
        // If validation passes, submit the form manually
        document.getElementById('wifiForm').submit();
    }
}

// Custom form validation logic (adjust this based on your needs)
function validateForm() {
    const email = document.getElementById('email').value.trim();
    const termsChecked = document.getElementById('terms').checked;

    if (email === "") {
        alert("Please enter a valid email.");
        return false;
    }

    if (!termsChecked) {
        alert("You must accept the terms and conditions.");
        return false;
    }

    // Additional validation logic can go here
    return true; // Return true if all validation passes
}