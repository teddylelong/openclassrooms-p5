<?php

namespace Controllers;

use AccessControl;
use Http;
use Notification;
use Renderer;

require_once 'vendor/autoload.php';

class User extends Controller
{
    protected $modelName = \Models\User::class;

    /**
     * Get all users, ordered by creation date, and display it (User admin role is required)
     *
     * @return void
     */
    public function index()
    {
        if (AccessControl::isUserAdmin()) {
            $users = $this->model->findAll('created_at DESC');

            $pageTitle = "Liste des utilisateurs";
            Renderer::render('admin/users/index', compact('pageTitle', 'users'), true);
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }

    /**
     * Insert a new user in database (User admin role is required)
     *
     * @return void
     */
    public function insert(): void
    {
        if (AccessControl::isUserAdmin()) {
            // Vérification du champ prénom
            $firstname = null;
            if (!empty($_POST['firstname'])) {
                $firstname = $_POST['firstname'];
            }

            // Vérification du champ nom
            $lastname = null;
            if (!empty($_POST['lastname'])) {
                $lastname = $_POST['lastname'];
            }

            // Verification du champ email
            $email = null;
            if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $email = $_POST['email'];
            }

            // Vérification du champ password
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

            // Verification du champ is_admin
            $is_admin = null;
            if ($_POST['is_admin'] === '1' || $_POST['is_admin'] === '0') {
                $is_admin = $_POST['is_admin'];
            }

            if (!$firstname || !$lastname || !$email || is_null($is_admin)) {
                Notification::set('error', "Tous les champs du formulaire doivent être remplis.");
                Http::redirect('/user/create/');
            }
            if (!$password) {
                Notification::set('error', "Les mots de passe saisis ne correspondent pas. Le mot de passe doit contenir au moins 8 caratères.");
                Http::redirect('/user/create/');
            }

            $user = new \Classes\User();
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setIsAdmin($is_admin);


            $this->model->insert($user);

            Notification::set('success', "Nouvel utilisateur créé avec succès !");
            Http::redirect('/user/index/');
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }

    /**
     * Display create a user form (User admin role is required)
     *
     * @return void
     */
    public function create(): void
    {
        if (AccessControl::isUserAdmin()) {
            $pageTitle = "Créer un nouvel utilisateur";
            Renderer::render('admin/users/create', compact('pageTitle'), true);
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }

    /**
     * Delete a user (User admin role is required)
     *
     * @return void
     */
    public function delete()
    {
        if (AccessControl::isUserAdmin()) {
            // 1. Vérification du $_GET
            if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
                Notification::set('error', "L'identifiant de l'utilisateur n'est pas valide.");
                Http::redirect('/user/index/');
            }

            // 2. On vérifie que l'utilisateur ne se supprime pas lui-même...
            if ($_GET['id'] === $_SESSION['user_id']) {
                Notification::set('error', "Vous ne pouvez pas vous supprimer vous-même...");
                Http::redirect('/user/index/');
            }

            $id = $_GET['id'];

            // 2. Vérification de l'existence de l'utilisateur
            $article = $this->model->find($id);
            if (!$article) {
                Notification::set('error', "L'utilisateur est introuvable.");
                Http::redirect('/user/index/');
            }

            // 3. Suppression de l'article
            $this->model->delete($id);

            // 4. Redirection vers la page d'accueil
            Notification::set('success', "L'utilisateur a été supprimé avec succès.");
            Http::redirect('/user/index/');
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }
}