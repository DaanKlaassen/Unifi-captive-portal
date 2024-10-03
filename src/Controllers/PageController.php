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
    public function succes()
    {
        include __DIR__ . '/../Views/succes.php';
    }
    public function failed()
    {
        include __DIR__ . '/../Views/failed.php';
    }
    public function limiet()
    {
        include __DIR__ . '/../Views/limiet.php';
    }
    public function styling()
    {
        header('Content-Type: text/css');
        readfile(__DIR__ . '/../public/css/style.css');
    }
    public function adminPagina()
    {
        include __DIR__ . '/../views/AdminPagina.php';
    }
}
