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
<div class="export-container">

    <?php include 'sidebar.php'; ?>

    <div class="users-container">
        <h1>Gebruikers</h1>
        <table>
            <thead>
            <tr>
                <th>Gebruikersnaam</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Devices</th>
                <th>MaxDevices</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            <!-- Rows will be populated by JavaScript -->
            </tbody>
        </table>
    </div>

    <div class="logo">
        <img src="../img/gildedevops-logo.png" alt="GildeDevOps Logo">
    </div>

</div>

<script>
    function deleteUser(email) {
        const rootURL = "<?php echo $rootURL; ?>";

        // Show a confirmation dialog
        if (confirm('Are you sure you want to delete this user?')) {
            fetch(`${rootURL}/delete-user?id=${email}`, {
                method: 'DELETE'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => console.error('Error deleting user:', error));
        }
    }

    document.addEventListener("DOMContentLoaded", (event) => {
        console.log('DOM fully loaded and parsed');

        const rootURL = "<?php echo $rootURL; ?>";

        fetch(`${rootURL}/users`)
            .then(response => response.text()) // Fetch the raw response as text
            .then(text => {
                console.log('Raw response from /users:', text); // Log the raw string response

                let users;

                try {
                    users = JSON.parse(text); // Parse the stringified JSON into a valid object
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    return;
                }

                console.log('Parsed JSON from /users:', users); // Log the parsed JSON

                if (Array.isArray(users)) {
                    const tableBody = document.querySelector('table tbody');
                    tableBody.innerHTML = ''; // Clear existing rows

                    users.forEach(user => {

                        const row = document.createElement('tr');

                        const usernameCell = document.createElement('td');
                        usernameCell.textContent = user.Name; // Updated key
                        row.appendChild(usernameCell);

                        const emailCell = document.createElement('td');
                        emailCell.textContent = user.Email; // Updated key
                        row.appendChild(emailCell);

                        const roleCell = document.createElement('td');
                        roleCell.textContent = user.role;
                        row.appendChild(roleCell);

                        const devicesCell = document.createElement('td');
                        devicesCell.textContent = user.devices.length;
                        row.appendChild(devicesCell);

                        const maxDevicesCell = document.createElement('td');
                        maxDevicesCell.textContent = user.maxDevices;
                        row.appendChild(maxDevicesCell);

                        const actionsCell = document.createElement('td');
                        actionsCell.innerHTML = `
                        <a href="${rootURL}/edit-user?id=${user.Email}">Bewerken</a>
                        <a href="#" onclick="deleteUser('${user.Email}')">Verwijderen</a>
                    `;
                        row.appendChild(actionsCell);

                        tableBody.appendChild(row);
                    });
                } else {
                    console.error('Expected an array but got:', users);
                }
            })
            .catch(error => console.error('Error fetching users:', error));
    });
</script>
</body>

</html>
