<?php

namespace Controllers;

require_once 'librairies/autoload.php';

class User extends Controller
{
    protected $modelName = \Models\User::class;

    /**
     * Get all articles order by date and display it
     *
     * @return void
     */
    public function index()
    {
        $users = $this->model->findAll('created_at DESC');

        $pageTitle = "Liste des utilisateurs";
        \Renderer::render('admin/users/index', compact('pageTitle', 'users'), true);
    }

    /**
     * Insert a new user in database
     *
     * @return void
     */
    public function insert(): void
    {
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
        $passwordCondition = !empty($_POST['password']) && strlen($_POST['password']) >= 8;
        $passwordConfirmation = $_POST['password'] === $_POST['password_confirmation'];
        if ($passwordCondition && $passwordConfirmation) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        // Verification du champ is_admin
        $is_admin = null;
        if ($_POST['is_admin'] === '1' || $_POST['is_admin'] === '0') {
            $is_admin = $_POST['is_admin'];
        }

        if (!$firstname || !$lastname || !$email || !$password || is_null($is_admin)) {
            die("Erreur : tous les champs du formulaire doivent être remplis.");
        }

        $this->model->insert($firstname, $lastname, $email, $password, $is_admin);

        // TODO : redirection

    }

    /**
     * Display create a user form
     * @return void
     */
    public function create(): void
    {
        $pageTitle = "Créer un nouvel utilisateur";
        \Renderer::render('admin/users/create', compact('pageTitle'), true);
    }

    /**
     * Delete a user
     *
     * @return void
     */
    public function delete()
    {
        // 1. Vérification du $_GET
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Erreur : l'identifiant de l'utilisateur est invalide.");
        }

        $id = $_GET['id'];

        // 2. Vérification de l'existence de l'article
        $article = $this->model->find($id);
        if (!$article) {
            die("Erreur : impossible de trouver l'utilisateur $id.");
        }

        // 3. Suppression de l'article
        $this->model->delete($id);

        // 4. Redirection vers la page d'accueil
        \Http::redirect('index.php?controller=user&task=index');
    }
}