<?php

use App\Config\AppConfig;

$config = new AppConfig();

$rootURL = $config->getRootURL();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Admin Pagina</title>

</head>

<body>
<div class="import-container">

    <?php include 'components/sidebar.php'; ?>

    <div class="import-main-section">
        <div class="import-section">
            <h1>Maak een gebruiker aan</h1>
            <form id="createUserForm" class="createUserForm">
                <label for="fullname" class="export-label"> Volledige naam
                </label>
                <input type="text" name="fullname" class="import-file">
                <label for="email" class="export-label"> Email
                </label>
                <input type="email" name="email" class="import-file">
                <label for="role" class="export-label"> Rol
                </label>
                <select name="role" class="import-file">
                    <option value="user">User</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                </select>
                <label for="maxDevices" class="export-label"> MaxDevices
                </label>
                <input type="number" min="0" value="0" name="maxDevices" class="import-file">
                <div id="createUser-info" class="import-info"></div>
                <button type="submit" id="createUserButton" class="import-button">Maak gebruiker aan</button>
            </form>
        </div>
    </div>
</div>
<div class="logo">
    <img src="../img/gildedevops-logo.png" alt="GildeDevOps Logo">
</div>

<script>

</script>
</body>

</html>