<?php

namespace Controllers;

require_once 'librairies/autoload.php';

class Comment extends Controller
{
    protected $modelName = \Models\Comment::class;

    public function insert()
    {
        $articleModel = new \Models\Article();

        // Vérification du champ "Pseudo"
        $author = null;
        if (!empty($_POST['author'])) {
            $author = htmlspecialchars($_POST['author']);
        }

        // Vérification du champ "Email"
        $email = null;
        if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            // Sécurisation de l'affichage de l'email
            $email = htmlspecialchars($_POST['email']);
        }

        // Vérification du champ "Contenu"
        $content = null;
        if (!empty($_POST['content'])) {
            // Sécurisation de l'affichage du contenu
            $content = htmlspecialchars($_POST['content']);
        }

        // Vérification du champ "ID"
        $article_id = null;
        if (!empty($_POST['article_id']) && ctype_digit($_POST['article_id'])) {
            $article_id = $_POST['article_id'];
        }

        // Vérification globale du formulaire
        if (!$author || !$email || !$article_id || !$content) {
            die("Erreur : tous les champs du formulaire doivent être complétés.");
        }

        $article = $articleModel->find($article_id);

        // Vérification de l'existence de l'article
        if (!$article) {
            die("Erreur : impossible de trouver l'article N°$article_id dans la base de données.");
        }

        // Insertion du commentaire en BDD
        $this->model->insert($author, $content, $email, $article_id);

        // Redirection vers l'article
        \Http::redirect('/?controller=article&task=show&id=' . $article_id);
    }

    public function delete()
    {
        $loginController = new \Controllers\Login();

        if ($loginController->isLoggedIn()) {
            // Vérification de l'ID en $_GET
            if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
                die("Erreur : l'identifiant n'est pas valide.");
            }

            $id = $_GET['id'];

            // Vérification de l'existence du commentaire
            $commentaire = $this->model->find($id);
            if (!$commentaire) {
                die("Erreur : impossible de trouver le commentaire N°$id.");
            }

            // Suppression du commentaire
            $article_id = $commentaire['article_id'];
            $this->model->delete($id);


            // Redirection vers l'article
            \Http::redirect('/?controller=article&task=show&id=' . $article_id);
        }
        else {
            $loginController->loginForm();
        }
    }
}