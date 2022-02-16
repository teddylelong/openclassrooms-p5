<?php

namespace Controllers;

require_once 'librairies/autoload.php';

class AdminPanel extends Controller
{
    protected $modelName = \Models\AdminPanel::class;

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