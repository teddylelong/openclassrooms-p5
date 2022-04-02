<?php

namespace Models;

use PDO;
use Entities\Comment;

class CommentModel extends Model
{
    protected $table = 'comments';

    /**
     * Return a comment from database for given ID
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE pk_id = :id");
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Comment::class);
        $query->execute(['id' => $id]);
        return $query->fetch();
    }

    /**
     * Return all comments from database
     * @return array
     */
    public function findAll($order = null): array
    {
        $sql = "SELECT * FROM $this->table";

        $query = $this->pdo->query($sql);
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Comment::class);

        return $query->fetchAll();
    }

    /**
     * Return a comments list for given article ID
     * By default, return only approved comments
     *
     * @param int $article_id
     * @param string $is_approved
     * @return array
     */
    public function findAllByArticle(int $article_id, string $is_approved = 'approved'): array
    {
        $query = $this->pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id AND is_approved = :is_approved");
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Comment::class);
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
        $query = $this->pdo->prepare("SELECT comments.*, articles.title FROM comments LEFT JOIN articles on comments.article_id = articles.pk_id WHERE is_approved = :is_approved");
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Comment::class);
        $query->execute(['is_approved' => $is_approuved]);
        return $query->fetchAll();
    }

    /**
     * Create a comment on a article
     *
     * @param Comment $comment
     * @return void
     */
    public function insert(Comment $comment): void
    {
        $query = $this->pdo->prepare('INSERT INTO comments SET author = :author, content = :content, email = :email, article_id = :article_id, is_approved = :is_approved');
        $query->execute([
            'author'      => $comment->getAuthor(),
            'content'     => $comment->getContent(),
            'email'       => $comment->getEmail(),
            'article_id'  => $comment->getArticleId(),
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