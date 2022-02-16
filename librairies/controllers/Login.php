<?php

namespace Controllers;

require_once 'librairies/autoload.php';

class Login extends Controller
{
    protected $modelName = \Models\Login::class;
    protected $adminController;

    public function __construct()
    {
        parent::__construct();
        $this->adminController = new \Controllers\AdminPanel();
    }

    /**
     * display the login form
     *
     * @return void
     */
    public function loginForm(): void
    {
        if($this->isLoggedIn()) {
            $this->adminController->dashboard();
        }
        else {
            $pageTitle = "Connexion";
            \Renderer::render('admin/users/login', compact('pageTitle'), true);
        }
    }

    /**
     * Login form process
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
            $this->adminController->dashboard();
        }
        else {
            $this->loginForm();
        }
    }

    /**
     * Check if a login $_SESSION exists
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        if (isset($_SESSION['user'])) {
            return true;
        }
        return false;
    }

    /**
     * Destroy the login $_SESSION and disconnect User
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
        $this->loginForm();
        exit;
    }
}