<?php

namespace Controllers;

require_once 'librairies/autoload.php';

class Login extends Controller
{
    protected $modelName = \Models\Login::class;

    /**
     * Display the login form. If a user is already logged-in and has admin role, redirect automatically to admin panel.
     *
     * @return void
     */
    public function loginForm(): void
    {
        if (\AccessControl::isUserAdmin()) {
            \Http::redirect('index.php?controller=adminpanel&task=dashboard');
        }
        else {
            $pageTitle = "Connexion";
            \Renderer::render('admin/users/login', compact('pageTitle'), true);
        }

    }

    /**
     * Login form process
     * Check if email and password provided in login form match with a user in database
     *
     * @return void
     */
    public function process(): void
    {
        $email = null;
        if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];
        }

        $password = null;
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
        }

        if (!$email || !$password) {
            die("Tous les champs du formulaire doivent être remplis");
        }

        if($this->model->checkLogin($email, $password)) {
            \Http::redirect('index.php?controller=adminpanel&task=dashboard');
        }
        else {
            \Http::redirect('index.php?controller=login&task=loginform');
        }
    }

    /**
     * Destroy the login $_SESSION, disconnect user and redirect to login form
     *
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user_id']);
        \Http::redirect('index.php?controller=login&task=loginform');
        exit;
    }
}