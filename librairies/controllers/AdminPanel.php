<?php

namespace Controllers;

use AccessControl;
use Http;
use Notification;
use Renderer;

require_once 'vendor/autoload.php';

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
            Http::redirect('/login/');
        }
    }
}