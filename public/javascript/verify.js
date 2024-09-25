const inputs = document.querySelectorAll('.code-inputs input');

        // Handle individual input and backspace
        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            // Listen for backspace
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        // Handle paste event
        inputs[0].addEventListener('paste', function(e) {
            const pasteData = e.clipboardData.getData('text');
            if (pasteData.length === inputs.length) {
                // Spread the pasted characters into the input fields
                inputs.forEach((input, index) => {
                    input.value = pasteData[index] || '';  // Fill input fields with pasted data
                    if (index < inputs.length - 1 && input.value) {
                        inputs[index + 1].focus();  // Move to the next field
                    }
                });
            }
            e.preventDefault();  // Prevent the default paste behavior
        });

        // Timer functionality for resend link
        const resendLink = document.getElementById('resend-link');
        const timerSpan = document.getElementById('timer');
        let timer = 6;

        function updateTimer() {
            if (timer > 0) {
                timerSpan.textContent = `over ${timer} seconden`;
                resendLink.style.pointerEvents = 'none';
                resendLink.style.opacity = '0.5';
                timer--;
                setTimeout(updateTimer, 1000);
            } else {
                timerSpan.textContent = '';
                resendLink.style.pointerEvents = 'auto';
                resendLink.style.opacity = '1';
            }
        }

        resendLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (timer === 0) {
                timer = 10;
                this.style.pointerEvents = 'none';
                this.style.opacity = '0.5';
                updateTimer();
                // Here you would typically call a PHP script to resend the code
                // For example: fetch('resend_code.php').then(...)
            }
        });

        updateTimer();