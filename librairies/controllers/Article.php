<?php

namespace Controllers;

require_once 'librairies/autoload.php';

class Article extends Controller
{
    protected $modelName = \Models\Article::class;

    /**
     * Get all articles order by date and display it
     *
     * @return void
     */
    public function index()
    {
        // 1. Récupération des articles
        $articles = $this->model->findAll('created_at DESC');

        // 2. Affichage
        $pageTitle = "Accueil";
        \Renderer::render('articles/index', compact('pageTitle', 'articles'));
    }

    public function create()
    {
        $pageTitle = "Rédiger un article";
        \Renderer::render('articles/create', compact('pageTitle'));
    }

    /**
     * Insert a new article
     *
     * @return void
     */
    public function insert(): void
    {
        // Vérification du champ titre
        $title = null;
        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
        }

        // Vérification du champ Extrait
        $excerpt = null;
        if (!empty($_POST['excerpt'])) {
            $excerpt = $_POST['excerpt'];
        }

        // Vérification du champ Contenu
        $content = null;
        if (!empty($_POST['content'])) {
            $content = $_POST['content'];
        }

        // Vérification du champ User ID
        $fk_user_id = null;
        if (!empty($_POST['fk_user_id']) && ctype_digit($_POST['fk_user_id'])) {
            $fk_user_id = $_POST['fk_user_id'];
        }

        // Vérification globale
        if (!$title || !$excerpt || !$content || !$fk_user_id) {
            die("Erreur : tous les champs du formulaire doivent être remplis.");
        }

        // Insertion de l'article dans la base de données
        $this->model->insert($title, $excerpt, $content, 0, $fk_user_id);

        // Redirection vers l'article
        \Http::redirect("/?controller=article&task=show&id="); // TODO : Récupérer l'identifiant de l'article qui vient d'être inséré et l'utiliser en $_GET
    }

    /**
     * Get an article and display it
     *
     * @return void
     */
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
            die("Vous devez préciser un paramètre 'id' dans l'URL.");
        }

        // 3. Récupération de l'article
        $article = $this->model->find($article_id);

        // 4. Récupération des commentaires de l'article en question
        $commentaires = $commentModel->findAllByArticle($article_id);

        // 5. Affichage
        $pageTitle = $article['title'];
        \Renderer::render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));
    }

    /**
     * Delete an article
     *
     * @return void
     */
    public function delete()
    {
        // 1. Vérification du $_GET
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Erreur : l'identifiant de l'article est invalide.");
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
        \Http::redirect('index.php');
    }
}