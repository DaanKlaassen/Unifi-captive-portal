<?php
use App\Config\AppConfig;

$config = new AppConfig();

$rootURL = $config->getRootURL();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <title>Verificatie Gefaald</title>

</head>

<body>
    <div class="container" style="display: flex; justify-content: center; flex-direction: column; align-items: center;">
        <h1 class="select-none">Verificatie niet succesvol</h1>
        <div class="checkmark select-none"> <img src="/img/failed.svg" alt=""></div>
        <div class="countdown select-none" id="countdown">Je word terug gestuurd over 10 seconden</div>
        <div class="manual-close" style="display:none;" id="manual-close">
            <p>Het venster kan niet automatisch worden omgeleid. <br> <strong>Klik <a href="/" class='link'>hier</a> om
                    terug te gaan naar de home pagina.</strong></p>
        </div>
    </div>
    <div class="logo">
        <img src="/img/gildedevops-logo.png" alt="GildeDevOps Logo">
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
                // Try to redirect the user
                window.location.href = '/';

                // If the window wasn't redirected, show the manual redirect message
                if (window.location.href.includes('<?php echo $rootURL; ?>/failed')) {
                    manualRedirect.style.display = 'block';
                    countdownElement.style.display = 'none';
                }
            }
        }, 1000);
    </script>
</body>

</html>