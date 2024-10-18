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
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <title>Admin Pagina</title>

</head>

<body>
    <div class="admin-container">

        <?php include 'components/sidebar.php'; ?>

        <div class="admin-section">
            <h1>Dashboard</h1>
        </div>
    </div>
    <div class="logo">
        <img src="/img/gildedevops-logo.png" alt="GildeDevOps Logo">
    </div>
</body>

</html>