lucide.createIcons();

        window.onload = function() {
            document.getElementById("terms-container").style.display = "none"; // Hide terms on load
        };

        function toggleTerms() {
            const termsContainer = document.getElementById("terms-container");
            const container = document.getElementById("container");
            if (termsContainer.style.display === "none") {
                termsContainer.style.display = "block";
                container.style.display = "none";
            } else {
                termsContainer.style.display = "none";
                container.style.display = "block";
            }
        }

        // Custom form validation and error message display
        document.getElementById('wifiForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting

            // Get the email input and terms checkbox
            const email = document.getElementById('email').value.trim();
            const termsChecked = document.getElementById('terms').checked;
            const emailError = document.getElementById('emailError');
            const termsError = document.getElementById('termsError');
            const attentionMessage = document.getElementById('attentionMessage');

            // Clear previous errors
            emailError.style.display = 'none';
            emailError.innerHTML = '';
            termsError.style.display = 'none';
            termsError.innerHTML = '';
            attentionMessage.style.display = 'none';

            let errors = false;

            // Validate email
            if (!email) {
                emailError.style.display = 'block';
                emailError.innerHTML = 'Vul een geldig e-mailadres in.';
                errors = true;
            }

            // Validate terms checkbox
            if (!termsChecked) {
                termsError.style.display = 'block';
                termsError.innerHTML = 'Je moet akkoord gaan met de gebruikersvoorwaarden.';
                errors = true;
            }

            // Display general attention message if there are errors
            if (errors) {
                attentionMessage.style.display = 'block';
            } else {
                // No errors, submit the form (or handle success)
                this.submit();
            }
        });