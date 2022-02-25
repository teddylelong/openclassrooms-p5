<?php

namespace Controllers;

use AccessControl;
use Http;
use Renderer;

require_once 'librairies/autoload.php';

class AdminPanel extends Controller
{
    public function __construct() { }

    /**
     * Display Admin Panel homepage (User admin role is required)
     *
     * @return void
     */
    public function dashboard(): void
    {
        if (AccessControl::isUserAdmin()) {
            $pageTitle = "Dashboard";
            Renderer::render('admin/dashboard', compact('pageTitle'), true);
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }
}