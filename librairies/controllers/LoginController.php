<?php

namespace Controllers;

use AccessControl;
use Http;
use Notification;
use Renderer;

require_once 'vendor/autoload.php';

class LoginController extends Controller
{
    protected $modelName = \Models\LoginModel::class;

    /**
     * Display the login form. If a user is already logged-in and has admin role, redirect automatically to admin panel.
     *
     * @return void
     */
    public function loginForm(): void
    {
        if (AccessControl::isUserAdmin()) {
            Http::redirect('/login/dashboard/');
        }
        else {
            $pageTitle = "Connexion";
            Renderer::render('admin/users/login', compact('pageTitle'));
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
            Notification::set('error', "Tous les champs du formulaire doivent être remplis.");
            Http::redirect('/login/');
        }

        if($this->model->checkLogin($email, $password)) {
            Notification::set('success', "Bienvenue !");
            Http::redirect('/login/dashboard/');
        }
        else {
            Notification::set('error', "L'adresse email ou le mot de passe est incorrect.");
            Http::redirect('/login/');
        }
    }

    /**
     * Display Admin Panel homepage (User admin role is required)
     *
     * @return void
     */
    public function dashboard(): void
    {
        if (AccessControl::isUserAdmin()) {
            $pageTitle = "Dashboard";
            Renderer::render('admin/dashboard', compact('pageTitle'));
        }
        else {
            Http::redirect('/login/');
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
        Notification::set('success', "Déconnexion effectuée avec succès. À bientôt !");
        Http::redirect('/login/');
        exit;
    }
}