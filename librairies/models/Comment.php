<?php

require_once 'librairies/models/Model.php';

class Comment extends Model
{

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
        $commentaires = $query->fetchAll();

        return $commentaires;
    }

    /**
     * Get a comment
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $query = $this->pdo->prepare('SELECT * FROM comments WHERE id = :id');
        $query->execute(['id' => $id]);
        $comment = $query->fetch();
        return $comment;
    }

    /**
     * Delete a comment
     *
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $query = $this->pdo->prepare('DELETE FROM comments WHERE id = :id');
        $query->execute(['id' => $id]);
    }

    /**
     * Create a comment on article
     *
     * @param string $author
     * @param string $content
     * @param string $article_id
     * @return void
     */
    public function insert(string $author, string $content, string $article_id): void
    {
        $query = $this->pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
        $query->execute(compact('author', 'content', 'article_id'));
    }
}