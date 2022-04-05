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
use Session;

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
            $session = new Session();
            $userModel = new UserModel();
            $user = $userModel->find($session->get('user_id'));

            $author = $user->getFirstname() . " (admin)";
            $email = $user->getEmail();
        }

        $content = filter_input(INPUT_POST, 'content');
        if (empty($content)) {
            $content = null;
        }

        $article_id = filter_input(INPUT_POST, 'article_id');
        if (empty($article_id)) {
            $article_id = null;
        }

        if (!$author || !$email || !$article_id || !$content) {
            $this->notification->set('error', "Tous les champs doivent être remplis.");
            if ($ifAdmin) {
                $this->http->redirect('/article/showadmin/'.$article_id.'/');
            }
            $this->http->redirect('/article/show/'.$article_id.'/');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->notification->set('error', "L'adresse e-mail saisie n'est pas valide.");
            $this->http->redirect('/article/show/'.$article_id.'/');
        }

        $article = $this->articleModel->find($article_id);

        if (!$article) {
            $this->http->error404();
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

        $this->notification->set('success', "Merci pour votre commentaire ! Il est en attente de modération et sera traité dans les plus brefs délais.");
        $this->http->redirect('/article/show/' . $comment->getArticleId() . '/');
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

        $this->notification->set('success', "Le commentaire a été publié avec succès.");
        $this->http->redirect('/article/showadmin/' . $comment->getArticleId() . '/');
    }

    /**
     * Display a list of comments by approvement status (User admin role is required)
     *
     * @return void
     */
    public function indexByApprovement(): void
    {
        $this->accessControl::adminRightsNeeded();

        $comments = $this->commentModel->findAll();

        foreach ($comments as $comment) {
            $article = $this->articleModel->find($comment->getArticleId());
            $commentApprovement[] = new CommentApprovementDto($comment, $article);
        }

        // No comments finded : generate empty array for Twig filters
        if (empty($comments)) {
            $commentApprovement = [];
        }

        $pageTitle = "Gestion des commentaires";
        $this->renderer->render('admin/comments/approvement',compact('commentApprovement', 'pageTitle'));
    }

    /**
     * Precheck $_GET values for approve or disapprove a comment
     *
     * @return int
     */
    public function checkApprovement(): int
    {
        $comment_id = filter_input(INPUT_GET, 'id');
        if (!isset($comment_id) && !ctype_digit($comment_id)) {
            $comment_id = null;
        }
        if (!$comment_id) {
            $this->notification->set('error', "L'identifiant du commentaire n'est pas valide.");
        }

        $comment = $this->commentModel->find($comment_id);
        if (!$comment) {
            $this->notification->set('error', "Le commentaire est introuvable. Veuillez réessayer.");
            $this->http->redirect('admin/comment/indexbyapprovement');
        }
        return $comment_id;
    }

    /**
     * Approve a comment (User admin role is required)
     *
     * @return void
     */
    public function approve(): void
    {
        $this->accessControl::adminRightsNeeded();

        $comment_id = $this->checkApprovement();
        $this->commentModel->updateApprovement($comment_id, Comment::APPROVED);
        $this->notification->set('success', "Le commentaire à été approuvé. Il est désormais visible publiquement.");
        $this->http->redirect('/comment/indexbyapprovement/');
    }

    /**
     * Disapprove a comment (User admin role is required)
     *
     * @return void
     */
    public function disapprove(): void
    {
        $this->accessControl::adminRightsNeeded();

        $comment_id = $this->checkApprovement();
        $this->commentModel->updateApprovement($comment_id, Comment::DISAPPROVED);
        $this->notification->set('success', "Le commentaire a été refusé. Il ne sera pas visible sur le site.");
        $this->http->redirect('/comment/indexbyapprovement/');
    }

    /**
     * Set comment approvement to pending (User admin role is required)
     *
     * @return void
     */
    public function pending(): void
    {
        $this->accessControl::adminRightsNeeded();

        $comment_id = $this->checkApprovement();
        $this->commentModel->updateApprovement($comment_id, Comment::PENDING);
        $this->notification->set('success', "Le commentaire est à nouveau en attente. Il n'est pas visible sur le site.");
        $this->http->redirect('/comment/indexbyapprovement/');
    }

    /**
     * Delete a comment (User admin role is required)
     *
     * @return void
     */
    public function delete()
    {
        $this->accessControl::adminRightsNeeded();

        $comment_id = filter_input(INPUT_GET, 'id');
        if (empty($comment_id) || !ctype_digit($comment_id)) {
            $this->notification->set('error', "L'identifiant du commentaire n'est pas valide.");
            $this->http->redirect('/article/indexadmin/');
        }

        $commentaire = $this->commentModel->find($comment_id);

        if (!$commentaire) {
            $this->notification->set('error', "Le commentaire est introuvable.");
            $this->http->redirect('/article/indexadmin/');
        }

        $this->commentModel->delete($comment_id);

        $this->notification->set('success', "Le commentaire a été supprimé avec succès.");
        $this->http->redirect('/article/showadmin/' . $commentaire->getArticleId() . '/');
    }
}