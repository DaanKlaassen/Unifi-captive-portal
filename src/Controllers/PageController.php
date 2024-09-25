<?php

namespace App\Controllers;
use Doctrine\ORM\EntityManagerInterface;

class PageController
{
    public function index()
    {
        include __DIR__ . '/../views/Index.php';
    }
}
