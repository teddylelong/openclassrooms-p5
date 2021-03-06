<?php

namespace Controllers;

use Models\RoleModel;
use Models\UserModel;
use Entities\User;
use Session;

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
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('user.index');

        $users = $this->userModel->findAll('created_at DESC');

        $pageTitle = "Liste des utilisateurs";
        $this->renderer->render('admin/users/index', compact('pageTitle', 'users'));
    }

    /**
     * Insert a new user in database (User admin role is required)
     *
     * @return void
     */
    public function insert(): void
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('user.create');

        // Check form data
        $firstname = filter_input(INPUT_POST, 'firstname');
        if (empty($firstname)) {
            $firstname = null;
        }

        $lastname = filter_input(INPUT_POST, 'lastname');
        if (empty($lastname)) {
            $lastname = null;
        }

        $email = filter_input(INPUT_POST, 'email');
        if (empty($email)) {
            $email = null;
        }

        $password = filter_input(INPUT_POST, 'password');
        $passwordRepeat = filter_input(INPUT_POST, 'password_confirmation');

        $role = filter_input(INPUT_POST, 'role');
        if (!$role) {
            $role = null;
        }

        if (!$firstname || !$lastname || !$email || !$password || !$passwordRepeat || !$role) {
            $this->notification->set('error', "Tous les champs du formulaire doivent être remplis.");
            $this->http->redirect('/user/create/');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->notification->set('error', "L'adresse email saisie n'est pas valide.");
            $this->http->redirect('/user/create/');
        }

        $passwordConfirmation = ($password === $passwordRepeat);

        if (!$passwordConfirmation) {
            $this->notification->set('error', "Les mots de passe ne correspondent pas.");
            $this->http->redirect('/user/create/');
        }

        $passwordCondition = (!empty($password) || strlen($password) >= 8);
        if (!$passwordCondition) {
            $this->notification->set('error', "Le mot de passe doit faire au moins 8 caractères.");
            $this->http->redirect('/user/create/');
        }

        if ($passwordCondition && $passwordConfirmation) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        // Check if email is already used by other account
        if ($this->userModel->findByEmail($email)) {
            $this->notification->set('error', "L'adresse email utilisée existe déjà.");
            $this->http->redirect('/user/create/');
        }

        $user = (new User())
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setPassword($password)
            ->setFkRoleId($role);

        $this->userModel->insert($user);

        $this->notification->set('success', "Nouvel utilisateur créé avec succès !");
        $this->http->redirect('/user/index/');
    }

    /**
     * Display create a user form (User admin role is required)
     *
     * @return void
     */
    public function create(): void
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('user.create');

        // Get a roles list and show this in select form
        $roleModel = new RoleModel();
        $roles = $roleModel->findAll();

        $pageTitle = "Créer un nouvel utilisateur";
        $this->renderer->render('admin/users/create', compact('pageTitle', 'roles'));
    }

    /**
     * Delete a user (User admin role is required)
     *
     * @return void
     */
    public function delete()
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('user.delete');

        // Check $_GET params
        $user_id = filter_input(INPUT_GET, 'id');

        if (empty($user_id) || !ctype_digit($user_id)) {
            $this->notification->set('error', "L'identifiant de l'utilisateur n'est pas valide.");
            $this->http->redirect('/user/index/');
        }

        // Check if user is not deleting himself
        $session = new Session();
        if ($user_id == $session->get('user_id')) {
            $this->notification->set('error', "Vous ne pouvez pas vous supprimer vous-même...");
            $this->http->redirect('/user/index/');
        }

        $user = $this->userModel->find($user_id);
        if (!$user) {
            $this->notification->set('error', "L'utilisateur est introuvable.");
            $this->http->redirect('/user/index/');
        }

        $this->userModel->delete($user_id);

        $this->notification->set('success', "L'utilisateur a été supprimé avec succès.");
        $this->http->redirect('/user/index/');
    }
}