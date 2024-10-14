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
        <!-- Content for editing users -->
    </div>

    <div class="logo">
        <img src="../img/gildedevops-logo.png" alt="GildeDevOps Logo">
    </div>

</div>

<script>
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
