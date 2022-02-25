<?php

namespace Controllers;

use AccessControl;
use Http;
use Notification;
use Renderer;

require_once 'librairies/autoload.php';

class Comment extends Controller
{
    protected $modelName = \Models\Comment::class;

    /**
     * Check a comment before insert
     *
     * @param bool $ifAdmin
     * @return array|void
     */
    public function checkInsert(bool $ifAdmin = false)
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

        // Si l'utilisateur est admin, on rempli les champs automatiquement
        if ($ifAdmin) {
            $userModel = new \Models\User();
            $user = $userModel->find($_SESSION['user_id']);

            $author = $user['firstname'] . " (admin)";
            $email = $user['email'];
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
            Notification::set('error', "Tous les champs doivent être remplis.");
            Http::redirect('/article/show/'.$article_id.'/');
        }

        $article = $articleModel->find($article_id);

        // Vérification de l'existence de l'article
        if (!$article) {
            Http::error404();
        }
        return compact('author', 'email', 'article_id', 'content');
    }

    /**
     * Insert a comment form process
     *
     * @return void
     */
    public function insert()
    {
        extract($this->checkInsert());

        // Insertion du commentaire en BDD
        $this->model->insert($author, $content, $email, $article_id, 'pending');

        // Redirection vers l'article
        Notification::set('success', "Merci pour votre commentaire ! Il est en attente de modération et sera traité dans les plus brefs délais.");
        Http::redirect('/article/show/' . $article_id . '/');
    }

    /**
     * Insert a comment form process from Admin Panel (User admin role is required)
     * Author & email fiels are already filled
     *
     * @return void
     */
    public function insertAdmin()
    {
        if (AccessControl::isUserAdmin()) {

            extract($this->checkInsert(true));

            // Insertion du commentaire en BDD
            $this->model->insert($author, $content, $email, $article_id, 'approved');

            // Redirection vers l'article
            Notification::set('success', "Le commentaire a été publié avec succès.");
            Http::redirect('/article/showadmin/' . $article_id . '/');
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }

    /**
     * Display a list of comments by approvement status (User admin role is required)
     *
     * @param string $is_approved
     * @return void
     */
    public function indexByApprovement(string $is_approved = 'pending'): void
    {
        if (AccessControl::isUserAdmin()) {
            $comments = $this->model->findByApproved($is_approved);

            $pageTitle = "Commentaires en attente de modération";
            Renderer::render('admin/comments/approvement',compact('comments', 'pageTitle'),true);
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }

    /**
     * Precheck $_GET values for approve or disapprove a comment
     *
     * @return int
     */
    public function checkApprovement(): int
    {
        // Vérification de l'ID en $_GET
        $id = null;
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            $id = $_GET['id'];
        }
        if (!$id) {
            Notification::set('error', "L'identifiant du commentaire n'est pas valide.");
        }

        // Vérification de l'existence du commentaire
        $comment = $this->model->find($id);
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
        if (AccessControl::isUserAdmin()) {
            $id = $this->checkApprovement();
            $this->model->updateApprovement($id, 'approved');
            Notification::set('success', "Le commentaire à été approuvé. Il est désormais visible publiquement.");
            Http::redirect('/comment/indexbyapprovement/');
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }

    /**
     * Disapprove a comment (User admin role is required)
     *
     * @return void
     */
    public function disapprove(): void
    {
        if (AccessControl::isUserAdmin()) {
            $id = $this->checkApprovement();
            $this->model->updateApprovement($id, 'disapproved');
            Notification::set('success', "Le commentaire a été refusé. Il ne sera pas visible sur le site.");
            Http::redirect('/comment/indexbyapprovement/');
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }

    /**
     * Delete a comment (User admin role is required)
     *
     * @return void
     */
    public function delete()
    {
        if (AccessControl::isUserAdmin()) {
            // Vérification de l'ID en $_GET
            if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
                Notification::set('error', "L'identifiant du commentaire n'est pas valide.");
                Http::redirect('/article/indexadmin/');
            }

            $id = $_GET['id'];

            // Vérification de l'existence du commentaire
            $commentaire = $this->model->find($id);
            if (!$commentaire) {
                Notification::set('error', "Le commentaire est introuvable.");
                Http::redirect('/article/indexadmin/');
            }

            // Suppression du commentaire
            $this->model->delete($id);

            // Redirection vers l'article
            $article_id = $commentaire['article_id'];
            Notification::set('success', "Le commentaire a été supprimé avec succès.");
            Http::redirect('/article/showadmin/' . $article_id . '/');
        }
        else {
            Notification::set('error', "Vous n'avez pas les autorisations requises pour accéder à cette page.");
            Http::redirect('/login/');
        }
    }
}