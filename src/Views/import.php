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
    <div class="import-container">
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
                <a href="<?php echo $rootURL; ?>/admin">
                    <button class="menu-item">Dashboard</button>
                </a>
                <a href="<?php echo $rootURL; ?>/admin">
                    <button class="menu-item">Database</button>
                </a>
                <a href="<?php echo $rootURL; ?>/admin">
                    <button class="menu-item">Users</button>
                </a>
                <a href="<?php echo $rootURL; ?>/admin/import">
                    <button class="menu-item active">Import</button>
                </a>
                <a href="<?php echo $rootURL; ?>/admin/export">
                    <button class="menu-item">Export</button>
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
        <div class="import-main-section">
            <div class="import-section">
                <h1>Importeer de database via een CSV bestand</h1>
                <form id="importForm">
                    <label class="export-label">
                        <input type="file" name="file" value="true" class="import-file"> Import file
                    </label>
                    <button type="submit" id="importButton" class="import-button">Importeer</button>
                </form>
            </div>
        </div>
    </div>
    <div class="logo">
        <img src="../img/gildedevops-logo.png" alt="GildeDevOps Logo">
    </div>

    <script>
        const importButton = document.getElementById("importButton");
        document.getElementById('importForm').addEventListener('submit', function(event) {
            event.preventDefault();
            importButton.disabled = true;

            const formData = new FormData(this);
            const data = {
                file: formData.get('file') || false,
            };
            console.log(data)

            const fileInput = formData.get('file');
            if (fileInput && fileInput.name.endsWith('.csv')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const csvData = event.target.result;
                    const lines = csvData.split('\n');
                    const result = [];
                    const headers = lines[0].split(',');

                    for (let i = 1; i < lines.length; i++) {
                        const obj = {};
                        const currentline = lines[i].split(',');

                        for (let j = 0; j < headers.length; j++) {
                            obj[headers[j]] = currentline[j];
                        }
                        result.push(obj);
                    }
                    console.log(result)
                    fetch('<?php echo $rootURL; ?>/import-csv', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(result)
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("imported csv data")
                            importButton.disabled = false;
                        })
                        .catch(error => {
                            importButton.disabled = false;
                            console.error('Error:', error)
                        });
                };
                reader.readAsText(fileInput);
            } else {
                alert('Please upload a valid CSV file.');
                importButton.disabled = false;
            }
        });
    </script>
</body>

</html>