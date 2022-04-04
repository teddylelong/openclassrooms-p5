<?php

namespace Controllers;

use Entities\Comment;
use Http;
use Models\CommentModel;
use Models\LoginModel;
use Notification;
use Renderer;
use Session;

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
        if (Session::get('user_id')) {
            $user_id = Session::get('user_id');

            if ($this->accessControl::isUserAdmin($user_id)) {
                Http::redirect('/login/dashboard/');
            }
        }
        $pageTitle = "Connexion";
        $this->renderer->render('admin/users/login', compact('pageTitle'));
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
        $email = filter_input(INPUT_POST, 'email');
        if (empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = null;
        }

        $password = filter_input(INPUT_POST, 'password');
        if (empty($password)) {
            $password = null;
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
        $this->accessControl::adminRightsNeeded();

        $commentModel = new CommentModel();
        $commentCount = count($commentModel->findByApproved(Comment::PENDING));

        $pageTitle = "Dashboard";
        $this->renderer->render('admin/dashboard', compact('pageTitle', 'commentCount'));
    }


    /**
     * Destroy the login $_SESSION, disconnect user and redirect to login form
     *
     * @return void
     */
    public function logout(): void
    {
        Session::destroy('user_id');
        Session::destroy('username');

        Notification::set('success', "Déconnexion effectuée avec succès. À bientôt !");
        Http::redirect('/login/');
    }
}