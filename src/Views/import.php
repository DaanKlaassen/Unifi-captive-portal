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

        <?php include 'sidebar.php'; ?>

        <div class="import-main-section">
            <div class="import-section">
                <h1>Importeer de database via een CSV bestand</h1>
                <form id="importForm">
                    <label for="file" class="export-label" style="display: none;"> Import file
                    </label>
                    <input type="file" accept=".csv" name="file" value="true" class="import-file">
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
            console.log(data);

            const fileInput = formData.get('file');
            if (fileInput && fileInput.name.endsWith('.csv')) {
                const reader = new FileReader();
                reader.onload = async function(event) {
                    const csvData = event.target.result;
                    const lines = csvData.split('\r\n');
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
                    console.log(result);
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
                            data = JSON.parse(responseText); // Parse the JSON response
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                        }

                        if (response.status === 200) {
                            console.log(data); // Log the JSON response
                            if (data.message) {
                                alert(data.message);
                            }
                        } else {
                            if (data && data.message) {
                                const errorMessages = JSON.parse(data.message.match(/\[.*\]/)[0]);
                                alert("An error occurred while importing data:\n" + errorMessages.join('\n'));
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
                alert('Please upload a valid CSV file.');
                importButton.disabled = false;
            }
        });
    </script>
</body>

</html>