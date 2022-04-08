<?php

namespace Controllers;

use Entities\Comment;
use Models\CommentModel;
use Models\LoginModel;
use Session;

class LoginController extends Controller
{
    protected LoginModel $loginModel;
    protected Session $session;

    public function __construct()
    {
        parent::__construct();
        $this->loginModel = new LoginModel();
        $this->session = new Session();
    }

    /**
     * Display the login form. If a user is already logged-in and has admin role, redirect automatically to admin panel.
     *
     * @return void
     */
    public function loginForm(): void
    {
        if ($this->session->get('user_id')) {
            $user_id = $this->session->get('user_id');

            if ($this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR])) {
                $this->http->redirect('/login/dashboard/');
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
            $this->notification->set('error', "Tous les champs du formulaire doivent être remplis.");
            $this->http->redirect('/login/');
        }

        if($this->loginModel->checkLogin($email, $password)) {
            $this->notification->set('success', "Bienvenue, {$_SESSION['username']} !");
            $this->http->redirect('/login/dashboard/');
        }
        $this->notification->set('error', "L'adresse email ou le mot de passe est incorrect.");
        $this->http->redirect('/login/');

    }

    /**
     * Display Admin Panel homepage (User admin role is required)
     *
     * @return void
     */
    public function dashboard(): void
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);

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
        $this->session->destroy('user_id');
        $this->session->destroy('username');

        $this->notification->set('success', "Déconnexion effectuée avec succès. À bientôt !");
        $this->http->redirect('/login/');
    }
}