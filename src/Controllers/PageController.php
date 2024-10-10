<?php

namespace App\Controllers;


class PageController
{
    public function index()
    {
        include __DIR__ . '/../Views/index.php';
    }
    public function verify()
    {
        include __DIR__ . '/../Views/verify.php';
    }
    public function success()
    {
        include __DIR__ . '/../Views/success.php';
    }
    public function failed()
    {
        include __DIR__ . '/../Views/failed.php';
    }
    public function limiet()
    {
        include __DIR__ . '/../Views/limiet.php';
    }
    public function admin()
    {
        include __DIR__ . '/../views/admin.php';
    }
    public function export()
    {
        include __DIR__ . '/../views/export.php';
    }
    public function import()
    {
        include __DIR__ . '/../views/import.php';
    }
    public function users()
    {
        include __DIR__ . '/../views/users.php';
    }
}
