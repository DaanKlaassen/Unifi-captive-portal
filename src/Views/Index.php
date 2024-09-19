<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>WiFi Login</title>
</head>

<body>
    <div class="container">
        <h1>Vul je gegevens in om verbinding te maken met het wifi-netwerk.</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="email" class="emailLabel">E-mailadres</label>
            <div class="email-input">
                <input type="text" id="email" name="email" required>
                <span class="domain">@student.gildeopleidingen.nl</span>
            </div>

            <div class="checkbox-container">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">Ik ga akkoord met de <a href="#">gebruikersvoorwaarden</a>.</label>
            </div>

            <div class="button-container">
                <button type="submit" class="button connect"><i data-lucide="wifi" class="connect-icon"></i>Verbinden</button>
                <button type="button" class="button admin"><i data-lucide="user" class="admin-icon"></i>Admin login</button>
            </div>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"] . "@student.gildeopleidingen.nl";
        $password = $_POST["password"];

        // Here you would typically validate the input and authenticate the user
        // For demonstration purposes, we'll just echo the received data
        echo "<script>alert('Ontvangen gegevens: Email - $email, Wachtwoord - $password');</script>";
    }
    ?>
    <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons();
  </script>
</body>

</html>