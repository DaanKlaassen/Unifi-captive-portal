<?php

use App\Config\AppConfig;

$config = new AppConfig();

$rootURL = $config->getRootURL();

$pathnames = explode('/', $_SERVER['REQUEST_URI']);
?>

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
        <?php
        $menuItems = [
            'Dashboard' => '/admin',
            'Gebruikers' => '/admin/users',
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
        <button class="settings">
            <img src="../img/settingsknop.svg" alt="settings Icon" class="settings-icon">
        </button>
        <button class="exit"><a href="<?php echo $rootURL; ?>/">
                <img src="../img/log-out.svg" alt="exit Icon" class="exit-icon"></a>
        </button>
    </div>
</div>