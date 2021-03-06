<?php

namespace Controllers;

use Dto\PostDto;
use Entities\User;
use Models\CommentModel;
use Models\ArticleModel;
use Models\UserModel;
use DateTime;
use Entities\Article;
use Session;

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
     * Get all articles order by date and display it
     *
     * @return void
     */
    public function index(): void
    {
        $articles = $this->articleModel->findAll('articles.created_at DESC');

        $userModel = new UserModel();

        foreach ($articles as $article) {
            $user = $userModel->find($article->getAuthorId());

            if (!$user) {
                $user = new User();
            }

            $posts[] = new PostDto($article, $user);
        }

        $pageTitle = "Le Blog";
        $this->renderer->render('articles/index', compact('pageTitle', 'posts'));
    }

    /**
     * Get all articles order by date and display it in admin panel (User admin role is required)
     * indexAdmin provides actions (update, delete) in admin panel
     *
     * @return void
     */
    public function indexAdmin(): void
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('article.index');

        $articles = $this->articleModel->findAll('articles.created_at DESC');

        $userModel = new UserModel();

        foreach ($articles as $article) {
            $user = $userModel->find($article->getAuthorId());

            if (!$user) {
                $user = new User();
            }

            $posts[] = new PostDto($article, $user);
        }

        $pageTitle = "Gérer les articles";
        $this->renderer->render('admin/articles/index', compact('pageTitle', 'posts'));
    }

    /**
     * Display write an article form (User admin role is required)
     *
     * @return void
     */
    public function create(): void
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('article.create');

        $pageTitle = "Rédiger un article";
        $this->renderer->render('admin/articles/create', compact('pageTitle'));
    }

    /**
     * Display the article update form (User admin role is required)
     *
     * @return void
     */
    public function modify(): void
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('article.update');

        //Check $_GET params
        $article_id = filter_input(INPUT_GET, 'id');
        if (empty($article_id) || !ctype_digit($article_id)) {
            $this->http->error404();
        }

        $article = $this->articleModel->find($article_id);

        if (!$article) {
            $this->http->error404();
        }

        // Find article author
        $userModel = new UserModel();
        $user = $userModel->find($article->getAuthorId());

        if (!$user) {
            $user = new User();
        }

        // Instantiate DTO Post
        $post = new PostDto($article, $user);

        // Get users list and show authors names
        $users = (new UserModel())->findAll();

        $pageTitle = "Modifier un article";
        $this->renderer->render('admin/articles/modify', compact('article_id', 'post', 'pageTitle', 'users'));
    }

    /**
     * Update a article (User admin role is required)
     * Check data from update article form
     *
     * @return void
     */
    public function update(): void
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('article.update');

        // Form data checking
        $title = filter_input(INPUT_POST, 'title');
        if (empty($title)) {
            $title = null;
        }

        $excerpt = filter_input(INPUT_POST, 'excerpt');
        if (empty($excerpt)) {
            $excerpt = null;
        }

        $content = filter_input(INPUT_POST, 'content');
        if (empty($content)) {
            $content = null;
        }

        $pk_id = filter_input(INPUT_POST, 'id');
        if (empty($pk_id) || !ctype_digit($pk_id)) {
            $pk_id = null;
        }

        $authorId = filter_input(INPUT_POST, 'author');
        if (empty($authorId) || !ctype_digit($authorId)) {
            $authorId = null;
        }

        if (!$title || !$excerpt || !$content || !$authorId) {
            $this->notification->set('error', "Tous les champs du formulaire doivent être remplis.");
            $this->http->redirect('/article/showadmin/'.$pk_id.'/');
        }

        $article = (new Article())
            ->setTitle($title)
            ->setExcerpt($excerpt)
            ->setContent($content)
            ->setId($pk_id)
            ->setAuthorId($authorId);

        $this->articleModel->update($article);

        $this->notification->set('success', "Les modifications de l'article ont bien été enregistrées.");
        $this->http->redirect("/article/indexadmin/");
    }

    /**
     * Insert a new article (User admin role is required)
     * Check data from create a article form
     *
     * @return void
     */
    public function insert(): void
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('article.create');

        // Form data checking
        $title = filter_input(INPUT_POST, 'title');
        if (empty($title)) {
            $title = null;
        }

        $excerpt = filter_input(INPUT_POST, 'excerpt');
        if (empty($excerpt)) {
            $excerpt = null;
        }

        $content = filter_input(INPUT_POST, 'content');
        if (empty($content)) {
            $content = null;
        }

        $session = new Session();
        $fk_user_id = $session->get('user_id');
        if (empty($fk_user_id)) {
            $fk_user_id = null;
        }

        if (!$title || !$excerpt || !$content || !$fk_user_id) {
            $this->notification->set('error', "Tous les champs du formulaire doivent être remplis.");
            $this->http->redirect('/article/create/');
        }

        $article = (new Article())
            ->setTitle($title)
            ->setExcerpt($excerpt)
            ->setContent($content)
            ->setCreatedAt(new DateTime('NOW'))
            ->setAuthorId($fk_user_id);

        $this->articleModel->insert($article);

        $this->notification->set('success', "Article ajouté avec succès !");
        $this->http->redirect("/article/indexadmin/");
    }

    /**
     * Get an article and display it
     *
     * @return void
     */
    public function show(): void
    {
        $article_id = filter_input(INPUT_GET, 'id');

        // Check $_GET params
        if (empty($article_id) && !ctype_digit($article_id)) {
            $this->http->error404();
        }

        $article = $this->articleModel->find($article_id);

        if (!$article) {
            $this->http->error404();
        }

        // Find article comments
        $commentaires = $this->commentModel->findAllByArticle($article_id);

        // Find author
        $userModel = new UserModel();
        $user = $userModel->find($article->getAuthorId());

        if (!$user) {
            $user = new User();
        }

        // Instantiate DTO Post
        $post = new PostDto($article, $user, $commentaires);

        $pageTitle = $post->getTitle();
        $this->renderer->render('articles/show', compact('pageTitle', 'post'));
    }

    /**
     * Get an article and display it to admin panel (User admin role is required)
     * showAdmin provides actions in admin panel (delete a comment)
     *
     * @return void
     */
    public function showAdmin(): void
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('article.index');

        $article_id = filter_input(INPUT_GET, 'id');;

        if (empty($article_id) || !ctype_digit($article_id)) {
            $this->http->error404();
        }

        $article = $this->articleModel->find($article_id);

        if (!$article) {
            $this->http->error404();
        }

        $commentaires = $this->commentModel->findAllByArticle($article_id);

        // Find author
        $userModel = new UserModel();
        $user = $userModel->find($article->getAuthorId());

        if (!$user) {
            $user = new User();
        }

        // Instantiate DTO Post
        $post = new PostDto($article, $user, $commentaires);

        $pageTitle = $article->getTitle();
        $this->renderer->render('admin/articles/show', compact('pageTitle', 'post'));
    }

    /**
     * Delete an article (User admin role is required)
     *
     * @return void
     */
    public function delete(): void
    {
        $this->accessControl->hasRole([self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        $this->accessControl->hasPermission('article.delete');

        // Check $_GET params
        $article_id = filter_input(INPUT_GET, 'id');
        if (empty($article_id) || !ctype_digit($article_id)) {
            $this->notification->set('error', "L'identifiant de l'article n'est pas valide.");
            $this->http->redirect('/article/indexadmin/');
        }

        $article = $this->articleModel->find($article_id);

        if (!$article) {
            $this->notification->set('error', "L'article est introuvable.");
            $this->http->redirect('/article/indexadmin');
        }

        $this->articleModel->delete($article_id);

        $this->notification->set('success', "Suppression de l'article effectuée avec succès !");
        $this->http->redirect('/article/indexadmin/');
    }
}