const inputs = document.querySelectorAll('.code-inputs input');

// Handle individual input and backspace
inputs.forEach((input, index) => {
	input.addEventListener('input', function () {
		if (this.value.length === 1 && index < inputs.length - 1) {
			inputs[index + 1].focus();
		}
	});

	// Listen for backspace
	input.addEventListener('keydown', function (e) {
		if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
			inputs[index - 1].focus();
		}
	});
});

// Handle paste event
inputs[0].addEventListener('paste', function (e) {
	const pasteData = e.clipboardData.getData('text');
	const trimmedPasteData = pasteData.trim();
	if (trimmedPasteData.length === inputs.length) {
		inputs.forEach((input, index) => {
			input.value = trimmedPasteData[index] || '';
			if (index < inputs.length - 1 && input.value) {
				inputs[index + 1].focus();
			}
		});
	}
	e.preventDefault();
});

// Timer functionality for resend link
const resendLink = document.getElementById('resend-link');
const errorMessage = document.getElementById('error-message');
const successMessage = document.getElementById('success-message');
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

resendLink.addEventListener('click', function (event) {
	event.preventDefault();
	fetch('/resend-code', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
		},
	})
		.then((response) => response.json())
		.then((data) => {
			if (data.success) {
				successMessage.style.display = 'block';
				successMessage.textContent = 'Verification code resent successfully.';

				setTimeout(() => {
					successMessage.style.display = 'none';
					successMessage.textContent = '';
				}, 3000);

				timer = 60;
				updateTimer();
			} else {
				errorMessage.style.display = 'block';
				errorMessage.textContent =
					'Failed to resend verification code. Please try again later.';

				setTimeout(() => {
					errorMessage.style.display = 'none';
					errorMessage.textContent = '';
				}, 3000);
			}
		})
		.catch((error) => {
			console.error('Error:', error);
			alert('An error occurred while resending the verification code.');
		});
});

updateTimer();
