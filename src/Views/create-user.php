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
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
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
                    <option value="student">student</option>
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
    <img src="/img/gildedevops-logo.png" alt="GildeDevOps Logo">
</div>

<script>
    const createUserButton = document.getElementById("createUserButton");
    const createUserInfo = document.getElementById("createUser-info");

    document.getElementById('createUserForm').addEventListener('submit', async function (event) {
        event.preventDefault();
        createUserButton.disabled = true;

        await new Promise(resolve => setTimeout(resolve, 0));

        const formData = new FormData(this);
        const data = {
            fullname: formData.get('fullname') || false,
            email: formData.get('email') || false,
            role: formData.get('role') || false,
            maxDevices: formData.get('maxDevices') || false,
        };

        const p = document.createElement('p');
        p.className = 'info';
        p.textContent = 'Gebruiker aan het aanmaken...';
        createUserInfo.appendChild(p);

        const response = await fetch('<?php echo $rootURL; ?>/create-user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const responseData = await response.json();

        if (responseData.status === 'success') {
            const p = document.createElement('p');
            p.className = 'success';
            p.textContent = responseData.message;
            createUserInfo.appendChild(p);
        } else {
            const p = document.createElement('p');
            p.className = 'error';
            p.textContent = responseData.message;
            createUserInfo.appendChild(p);
        }

        createUserButton.disabled = false;
    });
</script>
</body>

</html>