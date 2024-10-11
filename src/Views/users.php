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

    <?php include 'components/sidebar.php'; ?>

    <div class="users-container">
        <h1>Gebruikers</h1>

        <!-- Search bar -->
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Zoek op naam, email of rol (@rol)">
            <img src="../img/search-icon.svg" alt="search icon">
        </div>

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

        <div class="bewerken" id="bewerken" style="display: none;">
            <h1>Bewerk gebruiker</h1>
            <label for="bewerken-id">ID</label>

            <input type="text" id="bewerken-id" disabled>
            <label for="bewerken-email">Email</label>

            <input type="email" id="bewerken-email">
            <label for="bewerken-naam">Naam</label>
            <input type="text" id="bewerken-naam">
            <label for="bewerken-rol">Rol</label>
            <select id="bewerken-rol">
                <option value="student">student</option>
                <option value="teacher">leraar</option>
                <option value="admin">admin</option>
            </select>
            <label for="bewerken-created-at">Aangemaakt op</label>
            <input type="text" id="bewerken-created-at" disabled>
            <label for="bewerken-updated-at">Bijgewerkt op</label>
            <input type="text" id="bewerken-updated-at" disabled>
            <label for="bewerken-tou">Geaccepteerde TOU</label>
            <input type="text" id="bewerken-tou">
            <label for="bewerken-max-devices">MaxDevices</label>
            <input type="text" id="bewerken-max-devices">
            <label for="bewerken-devices">Devices</label>
            <div id="bewerken-devices">
            </div>
            <div class="button-container">
                <button onclick="updateUser()">Opslaan</button>
                <button onclick="closeBewerken()">Sluiten</button>
            </div>
        </div>

        <div class="logo">
            <img src="../img/gildedevops-logo.png" alt="GildeDevOps Logo">
        </div>

    </div>

    <script>
        const bewerken = document.getElementById('bewerken');
        const bewerkenId = document.getElementById('bewerken-id');
        const bewerkenEmail = document.getElementById('bewerken-email');
        const bewerkenNaam = document.getElementById('bewerken-naam');
        const bewerkenRol = document.getElementById('bewerken-rol');
        const bewerkenCreatedAt = document.getElementById('bewerken-created-at');
        const bewerkenUpdatedAt = document.getElementById('bewerken-updated-at');
        const bewerkenTou = document.getElementById('bewerken-tou');
        const bewerkenMaxDevices = document.getElementById('bewerken-max-devices');
        const bewerkenDevices = document.getElementById('bewerken-devices');
        const bewerkenDevicesid = document.getElementById('bewerken-devices-id');
        const bewerkenDevicesmac = document.getElementById('bewerken-devices-mac');
        const bewerkenDevicesip = document.getElementById('bewerken-devices-ip');

        // Function to filter users based on search input
        function searchUsers() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const tableBody = document.querySelector('table tbody');
            const rows = tableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const username = rows[i].getElementsByTagName('td')[0]; // Gebruikersnaam
                const email = rows[i].getElementsByTagName('td')[1];    // Email
                if (username || email) {
                    const usernameText = username.textContent || username.innerText;
                    const emailText = email.textContent || email.innerText;
                    if (usernameText.toLowerCase().indexOf(filter) > -1 || emailText.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        }

        function closeBewerken() {
            const bewerken = document.getElementById('bewerken');
            bewerken.style.display = 'none';
        }

        function editUser(user) {
            console.log(user);

            console.log(user);
            bewerkenId.value = user.UUID;
            bewerkenEmail.value = user.Email;
            bewerkenNaam.value = user.Name;
            bewerkenRol.value = user.role;
            const createdAtDate = new Date(user.CreatedAt);
            const updatedAtDate = new Date(user.UpdatedAt);

            bewerkenCreatedAt.value = createdAtDate.toLocaleDateString('nl-NL', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            bewerkenUpdatedAt.value = updatedAtDate.toLocaleDateString('nl-NL', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            bewerkenTou.value = user.acceptedTOU;
            bewerkenMaxDevices.value = user.maxDevices;
            bewerkenDevices.value = user.devices.length;
            bewerkenDevices.innerHTML = ''; // Clear existing device inputs

            if (user.devices.length === 0) {
                const noDevicesLabel = document.createElement('label');
                noDevicesLabel.textContent = 'No devices found';
                bewerkenDevices.appendChild(noDevicesLabel);
            }

            for (let i = 0; i < user.devices.length; i++) {
                const device = user.devices[i]; // Define the device variable

                const deviceContainer = document.createElement('div');
                deviceContainer.classList.add('device-container');

                const deviceLabel = document.createElement('label');
                deviceLabel.textContent = `Device ${i + 1}`;
                deviceContainer.appendChild(deviceLabel);

                const deviceIdLabel = document.createElement('label');
                deviceIdLabel.textContent = 'Device ID';
                deviceContainer.appendChild(deviceIdLabel);

                const deviceIdInput = document.createElement('input');
                deviceIdInput.type = 'text';
                deviceIdInput.value = device.id;
                deviceIdInput.disabled = true;
                deviceContainer.appendChild(deviceIdInput);

                const deviceMacLabel = document.createElement('label');
                deviceMacLabel.textContent = 'Device MAC';
                deviceContainer.appendChild(deviceMacLabel);

                const deviceMacInput = document.createElement('input');
                deviceMacInput.type = 'text';
                deviceMacInput.value = device.mac;
                deviceContainer.appendChild(deviceMacInput);

                const deviceIpLabel = document.createElement('label');
                deviceIpLabel.textContent = 'Device IP';
                deviceContainer.appendChild(deviceIpLabel);

                const deviceIpInput = document.createElement('input');
                deviceIpInput.type = 'text';
                deviceIpInput.value = device.ip;
                deviceContainer.appendChild(deviceIpInput);

                bewerkenDevices.appendChild(deviceContainer);
            };

            bewerken.style.display = 'flex';
        }

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
        const rootURL = "<?php echo $rootURL; ?>";
        let allUsers = [];

        // Fetch and store all users
        fetch(`${rootURL}/users`)
            .then(response => response.text()) // Fetch the raw response as text
            .then(text => {
                console.log('Raw response from /users:', text); // Log the raw string response

                try {
                    allUsers = JSON.parse(text); // Parse the stringified JSON into a valid object
                    console.log('Parsed JSON from /users:', allUsers); // Log the parsed JSON
                    renderUserTable(allUsers); // Render the user table initially with all users
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            })
            .catch(error => console.error('Error fetching users:', error));

        // Event listener for the search input
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();
            if (query.startsWith('@')) {
                const roleQuery = query.slice(1); // Remove '@' from the search query
                const filteredUsers = allUsers.filter(user => user.role.toLowerCase().includes(roleQuery));
                renderUserTable(filteredUsers);
            } else {
                const filteredUsers = allUsers.filter(user =>
                    user.Name.toLowerCase().includes(query) || // Search by name
                    user.Email.toLowerCase().includes(query)   // Search by email
                );
                renderUserTable(filteredUsers);
            }
        });
    });

    // Function to render the user table based on filtered users
    function renderUserTable(users) {
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
            <a href="#" onclick='editUser(${JSON.stringify(user)})'>Bewerken</a>
            <a href="#" onclick="deleteUser('${user.Email}')">Verwijderen</a>
        `;
            row.appendChild(actionsCell);

            tableBody.appendChild(row);
        });
    }
</script>
</body>

</html>