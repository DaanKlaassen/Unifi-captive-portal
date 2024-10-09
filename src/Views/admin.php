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
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Admin Pagina</title>

</head>

<body>
<div class="admin-container">
    <div class="sidebar">
        <div class="user">
            <div class="user-icon">
                <img src="img/user.svg" alt="User Icon" class="user-placeholder">
            </div>

            <div class="voor-achternaam-admin">
                <div class="voor-achternaam">
                    Daan <br> Klaassen
                </div>
            </div>
        </div>

        <div class="menu-items">
            <a href="<?php echo $rootURL; ?>/admin">
                <button class="menu-item active">Dashboard</button>
            </a>
            <a href="<?php echo $rootURL; ?>/admin">
                <button class="menu-item">Database</button>
            </a>
            <a href="<?php echo $rootURL; ?>/admin">
                <button class="menu-item">Users</button>
            </a>
            <a href="<?php echo $rootURL; ?>/admin/import">
                <button class="menu-item">Import</button>
            </a>
            <a href="<?php echo $rootURL; ?>/admin/export">
                <button class="menu-item">Export</button>
            </a>
        </div>

        <div class="buttons-container">
            <button class="settings">
                <img src="/img/settingsknop.svg" alt="settings Icon" class="settings-icon">
            </button>
            <button class="exit"><a href="<?php echo $rootURL; ?>/">
                    <img src="/img/log-out.svg" alt="exit Icon" class="exit-icon"></a>
            </button>
        </div>
    </div>
    <div class="admin-section">
        <h1>Dashboard</h1>
    </div>
</div>
<div class="logo">
    <img src="/img/gildedevops-logo.png" alt="GildeDevOps Logo">
</div>
</body>

</html>