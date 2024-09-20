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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">             
            <label for="email" class="emailLabel">E-mailadres</label>             
            <div class="email-input">                 
                <input type="text" id="email" name="email" required>                 
                <span class="domain">@student.gildeopleidingen.nl</span>             
            </div>             
            <div class="checkbox-container">                 
                <input type="checkbox" id="terms" name="terms" required>                 
                <label for="terms">Ik ga akkoord met de <a href="#" onclick="toggleTerms();">gebruikersvoorwaarden</a>.</label>             
            </div>             

            <div class="error">
                DOE HIER ERROR DING

            </div>

            <div class="button-container">                 
                <button type="submit" class="button connect"><i data-lucide="wifi" class="connect-icon"></i>Verbinden</button>                 
                <button type="button" class="button admin"><i data-lucide="user" class="admin-icon"></i>Admin login</button>             
            </div>         
        </form>     
    </div>      

    <div class="terms-container" id="terms-container">         
        <h2>Gebruikersvoorwaarden</h2>         
        <p>Door verbinding te maken met het wifi-netwerk ga je akkoord met de gebruikersvoorwaarden.</p>     
        <i data-lucide="x" onclick="toggleTerms();"  class="top-right close-button"></i>
    </div>      


    <div class="logo">
        <img src="img/gildedevops-logo.png" alt="GildeDevOps Logo">
    </div>



    <?php     
    if ($_SERVER["REQUEST_METHOD"] == "POST") {         
        $email = htmlspecialchars($_POST["email"]) . "@student.gildeopleidingen.nl";         
        $password = htmlspecialchars($_POST["password"]);          
        
        // Validation would typically go here

        echo "<script>alert('Ontvangen gegevens: Email - $email, Wachtwoord - $password');</script>";     
    }     
    ?>     

    <!-- Place the script at the end of the body -->
    <script src="https://unpkg.com/lucide@latest"></script>     
    <script>         
        lucide.createIcons();         

        function toggleTerms() {
            const termsContainer = document.getElementById("terms-container");
            const container = document.getElementById("container");
            if (termsContainer.style.display === "none") {
                termsContainer.style.display = "flex";
                container.style.display = "none";
            } else {
                termsContainer.style.display = "none";
                container.style.display = "block";
            }
        }
    </script> 
</body>  
</html>