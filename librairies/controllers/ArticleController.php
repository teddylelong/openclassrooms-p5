<?php

namespace Controllers;

use AccessControl;
use Http;
use Models\CommentModel;
use Notification;
use Renderer;
use Models\ArticleModel;
use Models\UserModel;
use DateTime;
use Classes\Article;

require_once 'vendor/autoload.php';

class ArticleController extends Controller
{
    // Todo : créer constructeur Controller + fonctions par controller
    protected ArticleModel $articleModel;
    protected CommentModel $commentModel;

    public function __construct()
    {
        $this->articleModel = new ArticleModel();
        $this->commentModel = new CommentModel();
    }

    /**
     * Get last articles order by date and display it on homepage
     *
     * @return void
     */
    public function home(): void
    {
        // 1. Récupération des articles
        $articles = $this->articleModel->findAll('articles.created_at DESC LIMIT 0, 4');

        // 2. Affichage
        $pageTitle = "Accueil";
        Renderer::render('articles/home', compact('pageTitle', 'articles'));
    }

    /**
     * Get all articles order by date and display it
     *
     * @return void
     */
    public function index(): void
    {
        // 1. Récupération des articles
        $articles = $this->articleModel->findAll('articles.created_at DESC');

        // 2. Affichage
        $pageTitle = "Le Blog";
        Renderer::render('articles/index', compact('pageTitle', 'articles'));
    }

    /**
     * Get all articles order by date and display it in admin panel (User admin role is required)
     * indexAdmin provides actions (update, delete) in admin panel
     *
     * @return void
     */
    public function indexAdmin(): void
    {
        if (AccessControl::isUserAdmin()) {
            $articles = $this->articleModel->findAll('articles.created_at DESC');

            $pageTitle = "Gérer les articles";
            Renderer::render('admin/articles/index', compact('pageTitle', 'articles'), true);
        }
        else {
            AccessControl::denied();
        }
    }

    /**
     * Display write an article form (User admin role is required)
     *
     * @return void
     */
    public function create(): void
    {
        if (AccessControl::isUserAdmin()) {
            $pageTitle = "Rédiger un article";
            Renderer::render('admin/articles/create', compact('pageTitle'), true);
        }
        else {
            AccessControl::denied();
        }
    }

    /**
     * Display the article update form (User admin role is required)
     *
     * @return void
     */
    public function modify(): void
    {
        if (AccessControl::isUserAdmin()) {
            $article_id = null;

            if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
                $article_id = $_GET['id'];
            }

            if (!$article_id) {
                Http::error404();
            }

            $article = $this->articleModel->find($article_id);

            if (!$article) {
                Http::error404();
            }

            $users = (new UserModel())->findAll();

            $pageTitle = "Modifier un article";
            Renderer::render('admin/articles/modify', compact('article_id', 'article', 'pageTitle', 'users'), true);
        }
        else {
            AccessControl::denied();
        }
    }

    /**
     * Update a article (User admin role is required)
     * Check data from update article form
     *
     * @return void
     */
    public function update(): void
    {
        if (AccessControl::isUserAdmin()) {

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

            // Verification du champ ID article
            $pk_id = null;
            if (!empty($_POST['id']) && ctype_digit($_POST['id'])) {
                $pk_id = $_POST['id'];
            }

            // Verification du champ auteur
            $authorId = null;
            if (!empty($_POST['author']) && ctype_digit($_POST['author'])) {
                $authorId = $_POST['author'];
            }

            // Vérification globale
            if (!$title || !$excerpt || !$content || !$authorId) {
                Notification::set('error', "Tous les champs du formulaire doivent être remplis.");
                Http::redirect('/article/showadmin/'.$pk_id.'/');
            }

            // On créé un nouvel objet \Classes\Article
            $article = (new Article())
                ->setTitle($title)
                ->setExcerpt($excerpt)
                ->setContent($content)
                ->setId($pk_id)
                ->setAuthorId($authorId);

            // Insertion de l'article dans la base de données
            $this->articleModel->update($article);

            // Redirection vers la liste des articles
            Notification::set('success', "Les modifications de l'article ont bien été enregistrées.");
            Http::redirect("/article/indexadmin/");
        }
        else {
            AccessControl::denied();
        }

    }

    /**
     * Insert a new article (User admin role is required)
     * Check data from create a article form
     *
     * @return void
     */
    public function insert(): void
    {
        if (AccessControl::isUserAdmin()) {
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

            // Vérification du user ID
            $fk_user_id = null;
            if (!empty($_SESSION['user_id'])) {
                $fk_user_id = $_SESSION['user_id'];
            }

            // Vérification globale
            if (!$title || !$excerpt || !$content || !$fk_user_id) {
                Notification::set('error', "Tous les champs du formulaire doivent être remplis.");
                Http::redirect('/article/create/');
            }

            // On créé un nouvel objet \Classes\Article
            $article = (new Article())
                ->setTitle($title)
                ->setExcerpt($excerpt)
                ->setContent($content)
                ->setCreatedAt(new DateTime('NOW'))
                ->setAuthorId($fk_user_id);

            // Insertion de l'article dans la base de données
            $this->articleModel->insert($article);

            // Redirection vers la liste des articles
            Notification::set('success', "Article ajouté avec succès !");
            Http::redirect("/article/indexadmin/");
        }
        else {
            AccessControl::denied();
        }
    }

    /**
     * Get an article and display it
     *
     * @return void
     */
    public function show(): void
    {
        // 1. Récupération du param "id" et vérification de celui-ci
        $article_id = null;

        // 2. Vérification du $_GET
        if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
            $article_id = $_GET['id'];
        }

        if (!$article_id) {
            Notification::set('error', "Vous devez préciser un paramètre 'id' dans l'URL.");
            Http::redirect('/article/index/');
        }

        // 3. Récupération de l'article
        $article = $this->articleModel->find($article_id);

        if (!$article) {
            Http::error404();
        }

        // 4. Récupération des commentaires de l'article en question
        $commentaires = $this->commentModel->findAllByArticle($article_id);

        // 5. Affichage
        $pageTitle = $article->getTitle();
        Renderer::render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));
    }

    /**
     * Get an article and display it to admin panel (User admin role is required)
     * showAdmin provides actions in admin panel (delete a comment)
     *
     * @return void
     */
    public function showAdmin(): void
    {
        if (AccessControl::isUserAdmin()) {

            // 1. Récupération du param "id" et vérification de celui-ci
            $article_id = null;

            // 2. Vérification du $_GET
            if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
                $article_id = $_GET['id'];
            }

            if (!$article_id) {
                Http::error404();
            }

            // 3. Récupération de l'article
            $article = $this->articleModel->find($article_id);

            // 4. Récupération des commentaires de l'article en question
            $commentaires = $this->commentModel->findAllByArticle($article_id);

            // 5. Affichage
            $pageTitle = $article->getTitle();
            Renderer::render('admin/articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'), true);
        }
        else {
            AccessControl::denied();
        }
    }

    /**
     * Delete an article (User admin role is required)
     *
     * @return void
     */
    public function delete(): void
    {
        if (AccessControl::isUserAdmin()) {
            // 1. Vérification du $_GET
            if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
                Notification::set('error', "L'identifiant de l'article n'est pas valide.");
                Http::redirect('/article/indexadmin/');
            }

            $id = $_GET['id'];

            // 2. Vérification de l'existence de l'article
            $article = $this->articleModel->find($id);
            if (!$article) {
                Notification::set('error', "L'article est introuvable.");
                Http::redirect('/article/indexadmin');
            }

            // 3. Suppression de l'article
            $this->articleModel->delete($id);

            // 4. Redirection vers la liste des articles
            Notification::set('success', "Suppression de l'article effectuée avec succès !");
            Http::redirect('/article/indexadmin/');
        }
        else {
            AccessControl::denied();
        }
    }
}