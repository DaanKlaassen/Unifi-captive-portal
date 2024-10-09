<?php

use App\Config\AppConfig;

$config = new AppConfig();

$rootURL = $config->getRootURL();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <title>Admin Pagina</title>

</head>

<body>
    <div class="export-container">
        <div class="sidebar">
            <div class="user">
                <div class="user-icon">
                    <img src="../img/user.svg" alt="User Icon" class="user-placeholder">
                </div>

                <div class="voor-achternaam-admin">
                    <div class="voor-achternaam">
                        Daan <br> Klaassen
                    </div>
                </div>
            </div>

            <div class="menu-items">
                <button class="menu-item">Dashboard</button>
                <button class="menu-item">Database</button>
                <button class="menu-item">Users</button>
                <button class="menu-item">Import</button>
                <a href="<?php echo $rootURL; ?>/admin/export">
                    <button class="menu-item active">Export</button>
                </a>
            </div>

            <div class="buttons-container">
                <button class="settings">
                    <img src="../img/settingsknop.svg" alt="settings Icon" class="settings-icon">
                </button>
                <button class="exit"> <a href="<?php echo $rootURL; ?>/">
                        <img src="../img/log-out.svg" alt="exit Icon" class="exit-icon"></a>
                </button>
            </div>
        </div>

        <div class="export-section">
            <h1>Exporteer de database naar een CSV bestand</h1>
            <form id="exportForm">
                <label>
                    <input type="checkbox" name="users" value="true"> Users
                </label>
                <label>
                    <input type="checkbox" name="roles" value="true"> Roles
                </label>
                <label>
                    <input type="checkbox" name="userDevices" value="true"> User Devices
                </label>
                <button type="submit" id="exportButton" class="export-button">Exporteer</button>
            </form>
        </div>
    </div>
    <div class="logo">
        <img src="../img/gildedevops-logo.png" alt="GildeDevOps Logo">
    </div>

    <script>
        const exportButton = document.getElementById("exportButton");
        document.getElementById('exportForm').addEventListener('submit', function(event) {
            event.preventDefault();
            exportButton.disabled = true;

            const formData = new FormData(this);
            const data = {
                users: formData.get('users') || false,
                roles: formData.get('roles') || false,
                userDevices: formData.get('userDevices') || false
            };

            fetch('<?php echo $rootURL; ?>/export-csv', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    for (const [listName, csvDataArray] of Object.entries(data)) {
                        const csvData = csvDataArray.join('\n');
                        const blob = new Blob([csvData], {
                            type: 'text/csv'
                        });
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = `export${listName}.csv`;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    }
                    exportButton.disabled = false;
                })
                .catch(error => {
                    exportButton.disabled = false;
                    console.error('Error:', error)
                });
        });
    </script>
</body>

</html>