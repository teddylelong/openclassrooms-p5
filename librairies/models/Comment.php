<?php

namespace Models;

require_once 'librairies/autoload.php';

class Comment extends Model
{
    protected $table = 'comments';

    /**
     * Return a comments list for given article ID
     *
     * @param int $articleId
     * @return array
     */
    public function findAllByArticle(int $articleId): array
    {
        $query = $this->pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id");
        $query->execute(['article_id' => $articleId]);
        return $query->fetchAll();
    }

    /**
     * Create a comment on a article
     *
     * @param string $author
     * @param string $content
     * @param string $email
     * @param string $article_id
     * @return void
     */
    public function insert(string $author, string $content, string $email, string $article_id): void
    {
        $query = $this->pdo->prepare('INSERT INTO comments SET author = :author, content = :content, email = :email, article_id = :article_id, created_at = NOW()');
        $query->execute(compact('author', 'content', 'email', 'article_id'));
    }
}