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
            $author = $_POST['author'];
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
        if (!$author || !$article_id || !$content) {
            die("Erreur : tous les champs du formulaire doivent être complétés.");
        }

        $article = $articleModel->find($article_id);

        // Vérification de l'existence de l'article
        if (!$article) {
            die("Ho ! L'article $article_id n'existe pas boloss !");
        }

        // Insertion du commentaire en BDD
        $this->model->insert($author, $content, $article_id);

        // Redirection vers l'article
        \Http::redirect('article.php?id=' . $article_id);
    }

    public function delete()
    {
        // Vérification de l'ID en $_GET
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ! Fallait préciser le paramètre id en GET !");
        }

        $id = $_GET['id'];

        // Vérification de l'existence du commentaire
        $commentaire = $this->model->find($id);
        if (!$commentaire) {
            die("Aucun commentaire n'a l'identifiant $id !");
        }

        // Suppression du commentaire
        $article_id = $commentaire['article_id'];
        $this->model->delete($id);


        // Redirection vers l'article
        \Http::redirect('article.php?id=' . $article_id);
    }
}