function validateAndSubmitForm(event) {
    event.preventDefault(); // Prevent default form submission initially

    // Perform your custom validation
    if (validateForm()) {
        // If validation passes, submit the form manually
        document.getElementById('wifiForm').submit();
    }
}

// Custom form validation logic (adjust this based on your needs)
function validateForm() {

    const loading = document.getElementById('loading');
    loading.style.display = 'block';
    loading.textContent = 'Loading';

    let dotCount = 0;
    const maxDots = 3;
    const loadingInterval = setInterval(() => {
        dotCount = (dotCount + 1) % (maxDots + 1);
        loading.textContent = 'Loading' + '.'.repeat(dotCount);
    }, 500);

// Clear the interval when form submission is complete
    document.getElementById('wifiForm').addEventListener('submit', () => {
        clearInterval(loadingInterval);
        loading.style.display = 'none';
    });

    return true;
}