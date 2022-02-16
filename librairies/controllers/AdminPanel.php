<?php

namespace Controllers;

require_once 'librairies/autoload.php';

class AdminPanel extends Controller
{
    protected $modelName = \Models\AdminPanel::class;

    public function dashboard(): void
    {
        $pageTitle = "Dashboard";
        \Renderer::render('admin/dashboard', compact('pageTitle'), true);
    }
}