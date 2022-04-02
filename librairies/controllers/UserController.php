<?php

namespace Controllers;

use Http;
use Models\UserModel;
use Notification;
use Renderer;
use Entities\User;

class UserController extends Controller
{
    protected UserModel $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    /**
     * Get all users, ordered by creation date, and display it (User admin role is required)
     *
     * @return void
     */
    public function index()
    {
        $this->accessControl::adminRightsNeeded();

        $users = $this->userModel->findAll('created_at DESC');

        $pageTitle = "Liste des utilisateurs";
        Renderer::render('admin/users/index', compact('pageTitle', 'users'));
    }

    /**
     * Insert a new user in database (User admin role is required)
     *
     * @return void
     */
    public function insert(): void
    {
        $this->accessControl::adminRightsNeeded();

        // Check form data
        $firstname = null;
        if (!empty($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
        }

        $lastname = null;
        if (!empty($_POST['lastname'])) {
            $lastname = $_POST['lastname'];
        }

        $email = null;
        if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];
        }

        $password = null;
        $passwordConfirmation = ($_POST['password'] === $_POST['password_confirmation']);
        if (!$passwordConfirmation) {
            Notification::set('error', "Les mots de passe ne correspondent pas.");
            Http::redirect('/user/create/');
        }

        $passwordCondition = (!empty($_POST['password']) && strlen($_POST['password']) >= 8);
        if (!$passwordCondition) {
            Notification::set('error', "Le mot de passe doit faire au moins 8 caractères.");
            Http::redirect('/user/create/');
        }

        if ($passwordCondition && $passwordConfirmation) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $is_admin = null;
        if ($_POST['is_admin'] === '1' || $_POST['is_admin'] === '0') {
            $is_admin = $_POST['is_admin'];
        }

        if (!$firstname || !$lastname || !$email || !$password || is_null($is_admin)) {
            Notification::set('error', "Tous les champs du formulaire doivent être remplis.");
            Http::redirect('/user/create/');
        }

        // Check if email is already used by other account
        if ($this->userModel->findByEmail($email)) {
            Notification::set('error', "L'adresse email utilisée existe déjà.");
            Http::redirect('/user/create/');
        }

        $user = (new User())
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setPassword($password)
            ->setIsAdmin($is_admin);

        $this->userModel->insert($user);

        Notification::set('success', "Nouvel utilisateur créé avec succès !");
        Http::redirect('/user/index/');
    }

    /**
     * Display create a user form (User admin role is required)
     *
     * @return void
     */
    public function create(): void
    {
        $this->accessControl::adminRightsNeeded();

        $pageTitle = "Créer un nouvel utilisateur";
        Renderer::render('admin/users/create', compact('pageTitle'));
    }

    /**
     * Delete a user (User admin role is required)
     *
     * @return void
     */
    public function delete()
    {
        $this->accessControl::adminRightsNeeded();

        // Check $_GET params
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            Notification::set('error', "L'identifiant de l'utilisateur n'est pas valide.");
            Http::redirect('/user/index/');
        }

        // Check if user is not deleting himself
        if ($_GET['id'] == $_SESSION['user_id']) {
            Notification::set('error', "Vous ne pouvez pas vous supprimer vous-même...");
            Http::redirect('/user/index/');
        }

        $id = $_GET['id'];

        $user = $this->userModel->find($id);
        if (!$user) {
            Notification::set('error', "L'utilisateur est introuvable.");
            Http::redirect('/user/index/');
        }

        $this->userModel->delete($id);

        Notification::set('success', "L'utilisateur a été supprimé avec succès.");
        Http::redirect('/user/index/');
    }
}