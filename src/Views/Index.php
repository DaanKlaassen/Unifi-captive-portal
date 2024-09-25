<?php
session_start();

unset($_SESSION['form_submitted']);

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>WiFi Login</title>
</head>

<body>
    <div class="container" id="container">
        <h1>Vul je gegevens in om verbinding te maken met het wifi-netwerk.</h1>
        <form id="wifiForm" action="/process-form" method="post" novalidate onsubmit="return validateAndSubmitForm(event);">
            <label for="email" class="emailLabel">E-mailadres</label>
            <div class="email-input">
                <input type="text" id="email" name="email" required>
                <span class="domain">
                    <select name="domain">
                        <option value="student">@student.gildeopleidingen.nl</option>
                        <option value="teacher">@rocgilde.nl</option>
                    </select>
                </span>
            </div>
            <div class="email-error" id="emailError"></div>

            <div class="checkbox-container">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">Ik ga akkoord met de <a href="#" onclick="toggleTerms();">gebruikersvoorwaarden</a>.</label>
            </div>

            <div class="terms-error" id="termsError"></div>

            <div class="attention-message" id="attentionMessage"></div>

            <div class="button-container">
                <button type="submit" class="button connect"><i data-lucide="wifi" class="connect-icon"></i>Verbinden</button>
                <button type="button" class="button admin"><i data-lucide="user" class="admin-icon"></i>Admin login</button>
            </div>

             <!-- Hidden field to capture IP address -->
             <input type="hidden" id="ipAddress" name="ipAddress" value="">
        </form>
    </div>
        <div class="terms-container" id="terms-container">
            <div class="terms-text">
                <h3> <b> Gebruikersvoorwaarden voor het gebruik van Gilde DevOps WiFi-netwerk </b> </br> </h3>

                <p><b>1. Toegang en Authenticatie:</b></p>
                <ul>
                    <li>Alleen leden van Gilde DevOps hebben toegang tot het WiFi-netwerk.</li>
                    <li>Toegang tot het netwerk vereist inloggegevens die door Gilde DevOps worden gefaciliteerd. Deze inloggegevens mogen niet worden gedeeld met derden.</li>
                    <li>Toegang met onbevoegde apparaten is niet toegestaan zonder voorafgaande toestemming van het netwerkbeheer.</li>
                </ul>

                <p><b>2. Beveiliging en Privacy:</b></p>
                <ul>
                    <li>Alle netwerkactiviteit kan worden gemonitord om de veiligheid en integriteit van het netwerk te waarborgen.</li>
                    <li>Gebruikers moeten ervoor zorgen dat persoonlijke en gevoelige bedrijfsgegevens veilig worden overgedragen via beveiligde kanalen (zoals VPN).</li>
                    <li>Gebruik van het WiFi-netwerk betekent akkoord met de verwerking van data voor beveiligings- en prestatiedoeleinden.</li>
                </ul>

                <p><b>3. Acceptabel Gebruik:</b></p>
                <ul>
                    <li>Het WiFi-netwerk mag uitsluitend worden gebruikt voor activiteiten die aansluiten bij de missie en doelen van Gilde DevOps.</li>
                    <li>Illegale activiteiten, zoals het downloaden of verspreiden van auteursrechtelijk beschermd materiaal, zijn ten strengste verboden.</li>
                    <li>Het is niet toegestaan om het netwerk te gebruiken voor activiteiten die de integriteit van het netwerk, de privacy van anderen, of de bedrijfsvoering van Gilde DevOps in gevaar kunnen brengen.</li>
                </ul>

                <p><b>4. Aansprakelijkheid:</b></p>
                <ul>
                    <li>Gilde DevOps is niet verantwoordelijk voor verlies van gegevens, veiligheidsinbreuken, of schade aan persoonlijke apparaten die voortvloeit uit het gebruik van het WiFi-netwerk.</li>
                    <li>Het gebruik van het WiFi-netwerk is op eigen risico. Gebruikers dienen hun eigen apparaten adequaat te beveiligen tegen virussen, malware en andere bedreigingen.</li>
                </ul>

                <p><b>5. Netwerkgebruik:</b></p>
                <ul>
                    <li>Overmatig gebruik van bandbreedte dat de prestaties van het netwerk voor anderen beïnvloedt, is niet toegestaan. Dit omvat het downloaden van grote bestanden, streaming, of ander dataverbruik buiten zakelijke doeleinden.</li>
                    <li>Gebruikers moeten netwerkstoringen of verdachte activiteiten direct melden aan het netwerkbeheer van Gilde DevOps.</li>
                </ul>

                <p><b>6. Software en Apparaten:</b></p>
                <ul>
                    <li>Gebruikers dienen ervoor te zorgen dat hun apparaten up-to-date zijn met de laatste beveiligingspatches en antivirussoftware.</li>
                    <li>Alleen goedgekeurde software mag worden gebruikt in combinatie met het WiFi-netwerk van Gilde DevOps.</li>
                </ul>

                <p><b>7. Schending van de Voorwaarden:</b></p>
                <ul>
                    <li>Overtreding van deze voorwaarden kan leiden tot intrekking van de WiFi-toegang en verdere disciplinaire maatregelen binnen Gilde DevOps.</li>
                    <li>Ernstige inbreuken kunnen leiden tot juridische stappen, afhankelijk van de aard van de overtreding.</li>
                </ul>

                <p>Door verbinding te maken met het WiFi-netwerk van Gilde DevOps, gaat de gebruiker akkoord met deze voorwaarden en begrijpt hij/zij dat het netwerkgebruik wordt gecontroleerd en gereguleerd in overeenstemming met de hierboven beschreven principes.</p>

            </div>
            <i data-lucide="x" onclick="toggleTerms();" class="top-right close-button"></i>
        </div>

        <div class="logo">
            <img src="img/gildedevops-logo.png" alt="GildeDevOps Logo">
        </div>

    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src='/javascript/main.js'></script>
    <script src='/javascript/form-validation.js'></script>
    <script>
        // Capture the user's IP address and set it in the hidden field
        fetch('https://api.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {
                console.log(data.ip);
                document.getElementById('ipAddress').value = data.ip;
            });
    </script>
</body>

</html>
