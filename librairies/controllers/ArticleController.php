<?php

namespace Controllers;

use Http;
use Models\CommentModel;
use Notification;
use Renderer;
use Models\ArticleModel;
use Models\UserModel;
use DateTime;
use Classes\Article;

class ArticleController extends Controller
{
    protected ArticleModel $articleModel;
    protected CommentModel $commentModel;

    public function __construct()
    {
        parent::__construct();
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
        $articles = $this->articleModel->findAll('articles.created_at DESC LIMIT 0, 4');

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
        $articles = $this->articleModel->findAll('articles.created_at DESC');

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
        $this->accessControl::adminRightsNeeded();

        $articles = $this->articleModel->findAll('articles.created_at DESC');

        $pageTitle = "Gérer les articles";
        Renderer::render('admin/articles/index', compact('pageTitle', 'articles'));
    }

    /**
     * Display write an article form (User admin role is required)
     *
     * @return void
     */
    public function create(): void
    {
        $this->accessControl::adminRightsNeeded();

        $pageTitle = "Rédiger un article";
        Renderer::render('admin/articles/create', compact('pageTitle'));
    }

    /**
     * Display the article update form (User admin role is required)
     *
     * @return void
     */
    public function modify(): void
    {
        $this->accessControl::adminRightsNeeded();

        //Check $_GET params
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

        // Get users list and show authors names
        $users = (new UserModel())->findAll();

        $pageTitle = "Modifier un article";
        Renderer::render('admin/articles/modify', compact('article_id', 'article', 'pageTitle', 'users'));
    }

    /**
     * Update a article (User admin role is required)
     * Check data from update article form
     *
     * @return void
     */
    public function update(): void
    {
        $this->accessControl::adminRightsNeeded();

        // Form data checking
        $title = null;
        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
        }

        $excerpt = null;
        if (!empty($_POST['excerpt'])) {
            $excerpt = $_POST['excerpt'];
        }

        $content = null;
        if (!empty($_POST['content'])) {
            $content = $_POST['content'];
        }

        $pk_id = null;
        if (!empty($_POST['id']) && ctype_digit($_POST['id'])) {
            $pk_id = $_POST['id'];
        }

        $authorId = null;
        if (!empty($_POST['author']) && ctype_digit($_POST['author'])) {
            $authorId = $_POST['author'];
        }

        if (!$title || !$excerpt || !$content || !$authorId) {
            Notification::set('error', "Tous les champs du formulaire doivent être remplis.");
            Http::redirect('/article/showadmin/'.$pk_id.'/');
        }

        $article = (new Article())
            ->setTitle($title)
            ->setExcerpt($excerpt)
            ->setContent($content)
            ->setId($pk_id)
            ->setAuthorId($authorId);

        $this->articleModel->update($article);

        Notification::set('success', "Les modifications de l'article ont bien été enregistrées.");
        Http::redirect("/article/indexadmin/");
    }

    /**
     * Insert a new article (User admin role is required)
     * Check data from create a article form
     *
     * @return void
     */
    public function insert(): void
    {
        $this->accessControl::adminRightsNeeded();

        // Form data checking
        $title = null;
        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
        }

        $excerpt = null;
        if (!empty($_POST['excerpt'])) {
            $excerpt = $_POST['excerpt'];
        }

        $content = null;
        if (!empty($_POST['content'])) {
            $content = $_POST['content'];
        }

        $fk_user_id = null;
        if (!empty($_SESSION['user_id'])) {
            $fk_user_id = $_SESSION['user_id'];
        }

        if (!$title || !$excerpt || !$content || !$fk_user_id) {
            Notification::set('error', "Tous les champs du formulaire doivent être remplis.");
            Http::redirect('/article/create/');
        }

        $article = (new Article())
            ->setTitle($title)
            ->setExcerpt($excerpt)
            ->setContent($content)
            ->setCreatedAt(new DateTime('NOW'))
            ->setAuthorId($fk_user_id);

        $this->articleModel->insert($article);

        Notification::set('success', "Article ajouté avec succès !");
        Http::redirect("/article/indexadmin/");
    }

    /**
     * Get an article and display it
     *
     * @return void
     */
    public function show(): void
    {
        $article_id = null;

        // Check $_GET params
        if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
            $article_id = $_GET['id'];
        }

        if (!$article_id) {
            Notification::set('error', "Vous devez préciser un paramètre 'id' dans l'URL.");
            Http::redirect('/article/index/');
        }

        $article = $this->articleModel->find($article_id);

        if (!$article) {
            Http::error404();
        }

        // Find article comments
        $commentaires = $this->commentModel->findAllByArticle($article_id);

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
        $this->accessControl::adminRightsNeeded();

        $article_id = null;

        if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
            $article_id = $_GET['id'];
        }

        if (!$article_id) {
            Http::error404();
        }

        $article = $this->articleModel->find($article_id);

        $commentaires = $this->commentModel->findAllByArticle($article_id);

        $pageTitle = $article->getTitle();
        Renderer::render('admin/articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));
    }

    /**
     * Delete an article (User admin role is required)
     *
     * @return void
     */
    public function delete(): void
    {
        $this->accessControl::adminRightsNeeded();

        // Check $_GET params
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            Notification::set('error', "L'identifiant de l'article n'est pas valide.");
            Http::redirect('/article/indexadmin/');
        }

        $id = $_GET['id'];

        $article = $this->articleModel->find($id);
        if (!$article) {
            Notification::set('error', "L'article est introuvable.");
            Http::redirect('/article/indexadmin');
        }

        $this->articleModel->delete($id);

        Notification::set('success', "Suppression de l'article effectuée avec succès !");
        Http::redirect('/article/indexadmin/');
    }
}