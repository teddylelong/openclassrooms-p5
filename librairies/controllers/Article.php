<?php

namespace Controllers;

require_once 'librairies/functions.php';
require_once 'librairies/models/Article.php';
require_once 'librairies/models/Comment.php';
require_once 'librairies/controllers/Controller.php';

class Article extends Controller
{
    protected $modelName = \Models\Article::class;

    public function index()
    {
        // 1. Récupération des articles
        $articles = $this->model->findAll('created_at DESC');

        // 2. Affichage
        $pageTitle = "Accueil";
        render('articles/index', compact('pageTitle', 'articles'));
    }

    public function show()
    {
        $commentModel = new \Models\Comment();

        // 1. Récupération du param "id" et vérification de celui-ci
        $article_id = null;

        // 2. Vérification du $_GET
        if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
            $article_id = $_GET['id'];
        }

        if (!$article_id) {
            die("Vous devez préciser un paramètre `id` dans l'URL !");
        }

        // 3. Récupération de l'article
        $article = $this->model->find($article_id);

        // 4. Récupération des commentaires de l'article en question
        $commentaires = $commentModel->findAllByArticle($article_id);

        // 5. Affichage
        $pageTitle = $article['title'];
        render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));
    }

    public function delete()
    {
        // 1. Vérification du $_GET
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ?! Tu n'as pas précisé l'id de l'article !");
        }

        $id = $_GET['id'];

        // 2. Vérification de l'existence de l'article
        $article = $this->model->find($id);
        if (!$article) {
            die("Erreur : impossible de trouver l'article $id.");
        }

        // 3. Suppression de l'article
        $this->model->delete($id);

        // 4. Redirection vers la page d'accueil
        redirect('index.php');
    }
}