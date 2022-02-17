<?php

namespace Controllers;

require_once 'librairies/autoload.php';

class AdminPanel extends Controller
{
    protected $modelName = \Models\AdminPanel::class;
    protected $loginController;

    /**
     * Display Admin Panel
     *
     * @return void
     */
    public function dashboard(): void
    {
        $loginController = new \Controllers\Login();

        if ($loginController->isLoggedIn()) {
            $pageTitle = "Dashboard";
            \Renderer::render('admin/dashboard', compact('pageTitle'), true);
        }
        else {
            $loginController->loginForm();
        }
    }
}