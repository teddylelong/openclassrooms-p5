<?php

namespace Controllers;

use Dto\CommentApprovementDto;
use Http;
use Notification;
use Renderer;
use Entities\Comment;
use Models\CommentModel;
use Models\ArticleModel;
use Models\UserModel;

class CommentController extends Controller
{
    private CommentModel $commentModel;
    private ArticleModel $articleModel;

    public function __construct()
    {
        parent::__construct();
        $this->commentModel = new CommentModel();
        $this->articleModel = new ArticleModel();
    }
    /**
     * Check a comment before insert
     *
     * @param bool $ifAdmin
     * @return Comment|null
     */
    public function checkInsert(bool $ifAdmin = false) : ?Comment
    {
        // Check form data
        $author = filter_input(INPUT_POST, 'author');
        if (empty($author)) {
            $author = null;
        }

        $email = filter_input(INPUT_POST, 'email');
        if (empty($email)) {
            $email = null;
        }

        if ($ifAdmin) {
            $userModel = new UserModel();
            $user = $userModel->find($_SESSION['user_id']);

            $author = $user->getFirstname() . " (admin)";
            $email = $user->getEmail();
        }

        $content = filter_input(INPUT_POST, 'content');
        if (empty($content)) {
            $content = null;
        }

        $article_id = filter_input(INPUT_POST, 'article_id');
        if (empty($article_id && !ctype_digit($article_id))) {
            $article_id = null;
        }

        if (!$author || !$email || !$article_id || !$content) {
            Notification::set('error', "Tous les champs doivent être remplis.");
            if ($ifAdmin) {
                Http::redirect('/article/showadmin/'.$article_id.'/');
            }
            Http::redirect('/article/show/'.$article_id.'/');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Notification::set('error', "L'adresse e-mail saisie n'est pas valide.");
            Http::redirect('/article/show/'.$article_id.'/');
        }

        $article = $this->articleModel->find($article_id);

        if (!$article) {
            Http::error404();
        }

        $comment = (new Comment())
            ->setAuthor($author)
            ->setEmail($email)
            ->setContent($content)
            ->setArticleId($article_id)
            ->setIsApproved(Comment::PENDING);
        if ($ifAdmin) {
            $comment->setIsApproved(Comment::APPROVED);
        }

        return $comment;
    }

    /**
     * Insert a comment form process
     *
     * @return void
     */
    public function insert()
    {
        $comment = $this->checkInsert();

        $this->commentModel->insert($comment);

        Notification::set('success', "Merci pour votre commentaire ! Il est en attente de modération et sera traité dans les plus brefs délais.");
        Http::redirect('/article/show/' . $comment->getArticleId() . '/');
    }

    /**
     * Insert a comment form process from Admin Panel (User admin role is required)
     * Author & email fiels are already filled
     *
     * @return void
     */
    public function insertAdmin()
    {
        $this->accessControl::adminRightsNeeded();

        $comment = $this->checkInsert(true);

        $this->commentModel->insert($comment);

        Notification::set('success', "Le commentaire a été publié avec succès.");
        Http::redirect('/article/showadmin/' . $comment->getArticleId() . '/');
    }

    /**
     * Display a list of comments by approvement status (User admin role is required)
     *
     * @param string $is_approved
     * @return void
     */
    public function indexByApprovement(string $is_approved = Comment::PENDING): void
    {
        $this->accessControl::adminRightsNeeded();

        $comments = $this->commentModel->findAll();

        foreach ($comments as $comment) {
            $article = $this->articleModel->find($comment->getArticleId());
            $commentApprovement[] = new CommentApprovementDto($comment, $article);
        }

        $pageTitle = "Gestion des commentaires";
        Renderer::render('admin/comments/approvement',compact('commentApprovement', 'pageTitle'));
    }

    /**
     * Precheck $_GET values for approve or disapprove a comment
     *
     * @return int
     */
    public function checkApprovement(): int
    {
        $id = filter_input(INPUT_GET, 'id');
        if (!isset($id) && !ctype_digit($id)) {
            $id = null;
        }
        if (!$id) {
            Notification::set('error', "L'identifiant du commentaire n'est pas valide.");
        }

        $comment = $this->commentModel->find($id);
        if (!$comment) {
            Notification::set('error', "Le commentaire est introuvable. Veuillez réessayer.");
            Http::redirect('admin/comment/indexbyapprovement');
        }
        return $id;
    }

    /**
     * Approve a comment (User admin role is required)
     *
     * @return void
     */
    public function approve(): void
    {
        $this->accessControl::adminRightsNeeded();

        $id = $this->checkApprovement();
        $this->commentModel->updateApprovement($id, Comment::APPROVED);
        Notification::set('success', "Le commentaire à été approuvé. Il est désormais visible publiquement.");
        Http::redirect('/comment/indexbyapprovement/');
    }

    /**
     * Disapprove a comment (User admin role is required)
     *
     * @return void
     */
    public function disapprove(): void
    {
        $this->accessControl::adminRightsNeeded();

        $id = $this->checkApprovement();
        $this->commentModel->updateApprovement($id, Comment::DISAPPROVED);
        Notification::set('success', "Le commentaire a été refusé. Il ne sera pas visible sur le site.");
        Http::redirect('/comment/indexbyapprovement/');
    }

    /**
     * Set comment approvement to pending (User admin role is required)
     *
     * @return void
     */
    public function pending(): void
    {
        $this->accessControl::adminRightsNeeded();

        $id = $this->checkApprovement();
        $this->commentModel->updateApprovement($id, Comment::PENDING);
        Notification::set('success', "Le commentaire est à nouveau en attente. Il n'est pas visible sur le site.");
        Http::redirect('/comment/indexbyapprovement/');
    }

    /**
     * Delete a comment (User admin role is required)
     *
     * @return void
     */
    public function delete()
    {
        $this->accessControl::adminRightsNeeded();

        $id = filter_input(INPUT_GET, 'id');
        if (empty($id) || !ctype_digit($id)) {
            Notification::set('error', "L'identifiant du commentaire n'est pas valide.");
            Http::redirect('/article/indexadmin/');
        }

        $commentaire = $this->commentModel->find($id);

        if (!$commentaire) {
            Notification::set('error', "Le commentaire est introuvable.");
            Http::redirect('/article/indexadmin/');
        }

        $this->commentModel->delete($id);

        Notification::set('success', "Le commentaire a été supprimé avec succès.");
        Http::redirect('/article/showadmin/' . $commentaire->getArticleId() . '/');
    }
}