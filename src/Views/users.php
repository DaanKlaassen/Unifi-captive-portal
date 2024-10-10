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
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)) : ?>
                        <tr>
                            <td colspan="4">Geen gebruikers gevonden</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?php echo $user->username; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td><?php echo $user->role; ?></td>
                                <td>
                                    <a href="<?php echo $rootURL; ?>/edit-user?id=<?php echo $user->id; ?>">Bewerken</a>
                                    <a href="<?php echo $rootURL; ?>/delete-user?id=<?php echo $user->id; ?>">Verwijderen</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="logo">
            <img src="../img/gildedevops-logo.png" alt="GildeDevOps Logo">
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            console.log('DOM fully loaded and parsed');

            const users = <?php echo json_encode($users); ?>;
            console.log(users); // Additional check if users are coming through

            const table = document.querySelector('table tbody');
            table.innerHTML = '';
            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.role}</td>
                    <td>
                        <a href="<?php echo $rootURL; ?>/edit-user?id=${user.id}">Bewerken</a>
                        <a href="<?php echo $rootURL; ?>/delete-user?id=${user.id}">Verwijderen</a>
                    </td>
                `;
                table.appendChild(row);
            });
        });
    </script>
</body>

</html>