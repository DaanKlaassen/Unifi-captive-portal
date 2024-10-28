<?php

use App\Config\AppConfig;

$config = new AppConfig();

$rootURL = $config->getRootURL();

$pathnames = explode('/', $_SERVER['REQUEST_URI']);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
;
?>

<div class="sidebar" id="sidebar">
    <button class="collapse-button" id="collapse-button"> <img src="/../img/move-horizontal.svg" alt="Collapse"> </button>

    <div class="user">
        <div class="user-icon">
            <img src="/../img/user.svg" alt="User Icon" class="user-placeholder">
        </div>

        <div class="voor-achternaam-admin">
            <div class="voor-achternaam">
                <?php echo $_SESSION['fullname'] ?? 'admin' ?>
            </div>
        </div>
    </div>

    <div class="menu-items">
        <?php
        $menuItems = [
            'Dashboard' => '/admin',
            'Gebruikers' => '/admin/users',
            'Create User' => '/admin/create-user',
            'Import' => '/admin/import',
            'Export' => '/admin/export'
        ];

        $currentPath = '/' . implode('/', array_slice($pathnames, 1, 3));

        foreach ($menuItems as $name => $path) {
            $activeClass = ($currentPath === $path) ? 'active' : '';
            echo '<a href="' . $rootURL . $path . '">
                    <button class="menu-item ' . $activeClass . '">' . $name . '</button>
                  </a>';
        }
        ?>
    </div>

    <div class="buttons-container">
        <button class="exit">
            <a href="<?php echo $rootURL; ?>/">
                <img src="/../img/log-out.svg" alt="exit Icon" class="exit-icon">
            </a>
        </button>
    </div>
</div>

<script>
    document.getElementById('collapse-button').addEventListener('click', function () {
        const collapseButton = document.getElementById('collapse-button');
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('collapsed'); // Toggle the 'collapsed' class
        collapseButton.innerHTML = sidebar.classList.contains('collapsed') 
            ? '<img src="/../img/move-horizontal-zwart.svg" alt="Expand">'
            : '<img src="/../img/move-horizontal.svg" alt="Collapse">';
        collapseButton.style.transform = 'translateX(200px);'; // Move the button
    });
</script>