<?php

namespace Models;

use PDO;

require_once 'vendor/autoload.php';

class Comment extends Model
{
    protected $table = 'comments';

    /**
     * Return a comments list for given article ID
     * By default, return only approved comments
     *
     * @param string $articleId
     * @return array
     */
    public function findAllByArticle(int $article_id, string $is_approved = 'approved'): array
    {
        $query = $this->pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id AND is_approved = :is_approved");
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->getClassName());
        $query->execute(compact('article_id', 'is_approved'));
        return $query->fetchAll();
    }

    /**
     * Find all comments by approved status
     * By default, return pending comments
     *
     * @param string $is_approuved
     * @return array
     */
    public function findByApproved($is_approuved = 'pending'): array
    {
        $query = $this->pdo->prepare("SELECT * FROM comments WHERE is_approved = :is_approved");
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->getClassName());
        $query->execute(['is_approved' => $is_approuved]);
        return $query->fetchAll();
    }

    /**
     * Create a comment on a article
     *
     * @param \Classes\Comment $comment
     * @return void
     */
    public function insert(\Classes\Comment $comment): void
    {
        $query = $this->pdo->prepare('INSERT INTO comments SET author = :author, content = :content, email = :email, article_id = :article_id, is_approved = :is_approved');
        $query->execute([
            'author' => $comment->getAuthor(),
            'content' => $comment->getContent(),
            'email' => $comment->getEmail(),
            'article_id' => $comment->getArticleId(),
            'is_approved' => $comment->getIsApproved(),
        ]);
    }

    /**
     * Update the approvement status of a comment
     *
     * @param int $pk_id
     * @param string $is_approved
     * @return void
     */
    public function updateApprovement(int $pk_id, string $is_approved): void
    {
        $query = $this->pdo->prepare('UPDATE comments SET is_approved = :is_approved WHERE pk_id = :pk_id');
        $query->execute(compact('is_approved', 'pk_id'));
    }
}