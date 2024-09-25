function validateAndSubmitForm(event) {
    event.preventDefault();

    alert("Form submission intercepted!");

    const email = document.getElementById('email').value.trim();
    const emailExtension = document.querySelector('select[name="domain"]').value;
    const termsChecked = document.getElementById('terms').checked;
    
    console.log("email: ", email);
    console.log("termsChecked: ", termsChecked);

    alert("Email: " + email + "\nTerms Checked: " + termsChecked + "\nEmail Extension: " + emailExtension);

    return validateForm();
}