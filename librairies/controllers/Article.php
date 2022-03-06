<?php

namespace Controllers;

use AccessControl;
use Http;
use Notification;
use Renderer;
use Classes;
use Models;
use DateTime;

require_once 'vendor/autoload.php';

// TODO : Alias ou rename class
class Article extends Controller
{
    protected $modelName = Models\Article::class;

    /**
     * Get all articles order by date and display it
     *
     * @return void
     */
    public function index(): void
    {
        // 1. Récupération des articles
        $articles = $this->model->findAll('articles.created_at DESC');

        // 2. Affichage
        $pageTitle = "Accueil";
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
            $articles = $this->model->findAll('articles.created_at DESC');

            $pageTitle = "Gérer les articles";
            Renderer::render('admin/articles/index', compact('pageTitle', 'articles'), true);
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
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
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
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

            $article = $this->model->find($article_id);

            if (!$article) {
                Http::error404();
            }

            $pageTitle = "Modifier un article";
            Renderer::render('admin/articles/modify', compact('article_id', 'article', 'pageTitle'), true);
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
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

            // Vérification globale
            if (!$title || !$excerpt || !$content) {
                Notification::set('error', "Tous les champs du formulaire doivent être remplis.");
                Http::redirect('/article/showadmin/'.$pk_id.'/');
            }

            // On créé un nouvel objet \Classes\Article
            $article = new Classes\Article();
            $article->setTitle($title);
            $article->setExcerpt($excerpt);
            $article->setContent($content);
            $article->setId($pk_id);

            // Insertion de l'article dans la base de données
            $this->model->update($article);

            // Redirection vers la liste des articles
            Notification::set('success', "Les modifications de l'article ont bien été enregistrées.");
            Http::redirect("/article/indexadmin/");
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
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
            $article = new Classes\Article();
            $article->setTitle($title);
            $article->setExcerpt($excerpt);
            $article->setContent($content);
            $article->setCreatedAt(new DateTime('NOW'));
            $article->setAuthorId($fk_user_id);

            // Ne fonctionne pas :
            /*$article = (new Classes\Article())
                ->setTitle($title)
                ->setExcerpt($excerpt)
                ->setContent($content)
                ->setCreatedAt(new DateTime('NOW'))
                ->setAuthorId($fk_user_id);*/

            // Insertion de l'article dans la base de données
            $this->model->insert($article);

            // Redirection vers la liste des articles
            Notification::set('success', "Article ajouté avec succès !");
            Http::redirect("/article/indexadmin/");
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
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
            Notification::set('error', "Vous devez préciser un paramètre 'id' dans l'URL.");
            Http::redirect('/article/index/');
        }

        // 3. Récupération de l'article
        $article = $this->model->find($article_id);

        if (!$article) {
            Http::error404();
        }

        // 4. Récupération des commentaires de l'article en question
        $commentaires = $commentModel->findAllByArticle($article_id);

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
    public function showAdmin()
    {
        if (AccessControl::isUserAdmin()) {
            $commentModel = new \Models\Comment();

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
            $article = $this->model->find($article_id);

            // 4. Récupération des commentaires de l'article en question
            $commentaires = $commentModel->findAllByArticle($article_id);

            // 5. Affichage
            $pageTitle = $article->getTitle();
            Renderer::render('admin/articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'), true);
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }

    /**
     * Delete an article (User admin role is required)
     *
     * @return void
     */
    public function delete()
    {
        if (AccessControl::isUserAdmin()) {
            // 1. Vérification du $_GET
            if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
                Notification::set('error', "L'identifiant de l'article n'est pas valide.");
                Http::redirect('/article/indexadmin/');
            }

            $id = $_GET['id'];

            // 2. Vérification de l'existence de l'article
            $article = $this->model->find($id);
            if (!$article) {
                Notification::set('error', "L'article est introuvable.");
                Http::redirect('/article/indexadmin');
            }

            // 3. Suppression de l'article
            $this->model->delete($id);

            // 4. Redirection vers la liste des articles
            Notification::set('success', "Suppression de l'article effectuée avec succès !");
            Http::redirect('/article/indexadmin/');
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }
}