<?php

namespace Controllers;

use AccessControl;
use Classes\Comment;
use Http;
use Models\CommentModel;
use Models\LoginModel;
use Notification;
use Renderer;

class LoginController extends Controller
{
    protected LoginModel $loginModel;

    public function __construct()
    {
        parent::__construct();
        $this->loginModel = new LoginModel();
    }

    /**
     * Display the login form. If a user is already logged-in and has admin role, redirect automatically to admin panel.
     *
     * @return void
     */
    public function loginForm(): void
    {
        if (isset($_SESSION['user_id'])) {
            $id = $_SESSION['user_id'];

            if (AccessControl::isUserAdmin($id)) {
                Http::redirect('/login/dashboard/');
            }
        }
        $pageTitle = "Connexion";
        Renderer::render('admin/users/login', compact('pageTitle'));
    }

    /**
     * Login form process
     * Check if email and password provided in login form match with a user in database
     *
     * @return void
     */
    public function process(): void
    {
        // check form data
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

        if($this->loginModel->checkLogin($email, $password)) {
            Notification::set('success', "Bienvenue, {$_SESSION['username']} !");
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
        AccessControl::adminRightsNeeded();

        $commentModel = new CommentModel();
        $commentCount = count($commentModel->findByApproved(Comment::PENDING));

        $pageTitle = "Dashboard";
        Renderer::render('admin/dashboard', compact('pageTitle', 'commentCount'));
    }


    /**
     * Destroy the login $_SESSION, disconnect user and redirect to login form
     *
     * @return void
     */
    public function logout(): void
    {
        unset(
            $_SESSION['user_id'],
            $_SESSION['username']
        );

        Notification::set('success', "Déconnexion effectuée avec succès. À bientôt !");
        Http::redirect('/login/');
    }
}