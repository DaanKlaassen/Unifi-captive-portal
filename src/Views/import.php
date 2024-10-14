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
            <h1>Importeer de database via een CSV bestand</h1>
            <form id="importForm">
                <label for="file" class="export-label" style="display: none;"> Import file
                </label>
                <input type="file" accept=".csv" name="file" value="true" class="import-file">
                <div id="import-info" class="import-info"></div>
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
    const importInfo = document.getElementById("import-info");

    document.getElementById('importForm').addEventListener('submit', async function (event) {
        event.preventDefault();
        importButton.disabled = true;

        await new Promise(resolve => setTimeout(resolve, 0));

        const formData = new FormData(this);
        const data = {
            file: formData.get('file') || false,
        };

        const fileInput = formData.get('file');
        if (fileInput && fileInput.name.endsWith('.csv')) {
            const reader = new FileReader();
            reader.onload = async function (event) {
                const csvData = event.target.result;
                const lines = csvData.split('\r\n');
                const result = [];
                const headers = lines[0].split(',').map(header => header.trim());

                for (let i = 1; i < lines.length; i++) {
                    const obj = {};
                    const currentline = lines[i].split(',');

                    for (let j = 0; j < headers.length; j++) {
                        obj[headers[j]] = currentline[j] ? currentline[j].trim() : '';
                    }
                    result.push(obj);
                }

                try {
                    const p = document.createElement('p');
                    p.textContent = 'Importing data...';
                    importInfo.appendChild(p);
                } catch (error) {
                    console.error('Error:', error);
                }

                try {
                    const response = await fetch('<?php echo $rootURL; ?>/import-csv', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(result)
                    });

                    const responseText = await response.text();

                    let data;
                    try {
                        const jsonData = JSON.parse(responseText);
                        data = JSON.parse(jsonData.message);
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        debugger;
                    }

                    if (response.status === 200) {
                        if (data.success) {
                            // Check if success is an array
                            let successMessages = Array.isArray(data.success) ? data.success : [data.success];
                            let parsed = JSON.parse(successMessages);

                            // Create <p> elements for each success message
                            for (const message of parsed) {
                                const p = document.createElement('p');
                                p.textContent = message;
                                importInfo.appendChild(p);
                                await new Promise(resolve => setTimeout(resolve, 0));
                                importInfo.scrollTop = importInfo.scrollHeight;
                            }
                        }
                    } else {
                        if (data) {
                            let successMessages = [];
                            let errorMessages = [];

                            // Check if data.error is an array, otherwise make it an array
                            if (Array.isArray(data.error)) {
                                errorMessages = JSON.parse(data.error);
                            } else if (data.error) {
                                errorMessages = [data.error];
                            }

                            // Check if data.success is an array, otherwise make it an array
                            if (Array.isArray(data.success)) {
                                successMessages = JSON.parse(data.success);
                            } else if (data.success) {
                                successMessages = [data.success];
                            }

                            // Create <p> elements for success and error messages
                            for (const message of successMessages) {
                                const p = document.createElement('p');
                                p.textContent = message;
                                importInfo.appendChild(p);
                                await new Promise(resolve => setTimeout(resolve, 0));
                                importInfo.scrollTop = importInfo.scrollHeight;
                            }

                            for (const message of errorMessages) {
                                const p = document.createElement('p');
                                p.textContent = message;
                                importInfo.appendChild(p);
                                await new Promise(resolve => setTimeout(resolve, 0));
                                importInfo.scrollTop = importInfo.scrollHeight;
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    importButton.disabled = false;
                }
            };
            reader.readAsText(fileInput);
        } else {
            importButton.disabled = false;

            const p = document.createElement('p');
            p.textContent = 'Please upload a valid CSV file.';
            importInfo.appendChild(p);
            await new Promise(resolve => setTimeout(resolve, 0));
            importInfo.scrollTop = importInfo.scrollHeight;

        }
    });

</script>
</body>

</html>