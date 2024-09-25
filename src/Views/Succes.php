<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Verificatie Succesvol</title>

</head>

<body>
    <div class="container" style="display: flex; justify-content: center; flex-direction: column; align-items: center;">
        <h1 class="select-none">Verificatie succesvol</h1>
        <div class="checkmark select-none"> <img src="/img/check.svg" alt=""></div>
        <div class="countdown select-none" id="countdown">Dit venster sluit over 10 seconden</div>
        <div class="manual-close" style="display:none;" id="manual-close">
        <p>Het venster kan niet automatisch worden gesloten. <br> <strong>Sluit dit venster handmatig.</strong></p>
    </div>
    </div>
    <div class="logo">
        <img src="img/gildedevops-logo.png" alt="GildeDevOps Logo">
    </div>
    <script>
        let seconds = 10;
        const countdownElement = document.getElementById('countdown');
        const manualClose = document.getElementById('manual-close');
        const intervalId = setInterval(() => {
            seconds--;
            countdownElement.textContent = `Dit venster sluit over ${seconds} seconden`;
            if (seconds <= 0) {
                clearInterval(intervalId);
                // Try to close the window
                window.open('', '_self', '');
                window.close();

                // If the window wasn't closed, show the manual close message
                if (!window.closed) {
                    manualClose.style.display = 'block';
                    countdownElement.style.display = 'none';
                }
            }
        }, 1000);
    </script>
</body>

</html>
