<?php
session_start();

if (!$_SESSION['form_submitted']) {
    header('Location: /');
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Verificatiecode invoeren</title>
</head>
<body>
    <div class="container">
        <h1>Verificatiecode invoeren</h1>
        <p>Voer de 6-cijferige code in die we naar uw e-mail hebben gestuurd</p>
                    <form method="POST" action="/verify-code">
                        <div class="code-inputs">
                            <?php
            for ($i = 0; $i < 6; $i++) {
                echo "<input type='text' name='verification_code[]' maxlength='1' required>";
                if ($i === 2) {
                    echo "<span class='separator'>-</span>";
                }
            }
            ?>
            </div>
            <div class="resend">
                Code <a href="#" id="resend-link">opnieuw versturen</a> <span id="timer"></span>
            </div>
            <div id="error-message" style="display: none;"></div>
            <div id="success-message" style="display: none;"></div>
            <button type="submit" class="verify-btn"> Verifiëren</button>
        </form>
        <div class="go-back">
                <a href="/"> Ga Terug </a>
    </div>
    </div>

    <div class="logo">
            <img src="img/gildedevops-logo.png" alt="GildeDevOps Logo">
        </div>

    <script src='/javascript/verify.js'></script>
</body>
</html>
