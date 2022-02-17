<?php

namespace Controllers;

require_once 'librairies/autoload.php';

class AdminPanel extends Controller
{
    public function __construct() {}

    /**
     * Display Admin Panel
     *
     * @return void
     */
    public function dashboard(): void
    {
            $pageTitle = "Dashboard";
            \Renderer::render('admin/dashboard', compact('pageTitle'), true);
    }
}