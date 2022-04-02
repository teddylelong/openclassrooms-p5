<?php

namespace Models;

use Entities\Article;
use PDO;

class ArticleModel extends Model
{
    protected $table = 'articles';

    /**
     * Return an article from database for given ID
     *
     * @param int $id
     * @return Article|false
     */
    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT articles.*, users.firstname, users.lastname FROM articles LEFT JOIN users ON articles.fk_user_id = users.pk_id WHERE articles.pk_id = :id");
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Article::class);
        $query->execute(['id' => $id]);
        return $query->fetch();
    }

    /**
     * Return all articles from database table
     *
     * @param string|null $order
     * @return array
     */
    public function findAll(?string $order = ''): array
    {
        $sql = "SELECT articles.*, users.firstname FROM articles LEFT JOIN users ON articles.fk_user_id = users.pk_id";

        if ($order) {
            $sql .= ' ORDER BY ' . $order;
        }
        $query = $this->pdo->query($sql);
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Article::class);
        return $query->fetchAll();
    }

    /**
     * Insert a new article in database
     *
     * @param Article $article
     * @return void
     */
    public function insert(Article $article): void
    {
        $query = $this->pdo->prepare('INSERT INTO articles SET title = :title, excerpt = :excerpt, content = :content, fk_user_id = :fk_user_id');
        $query->execute([
            'title'      => $article->getTitle(),
            'excerpt'    => $article->getExcerpt(),
            'content'    => $article->getContent(),
            'fk_user_id' => $article->getAuthorId()
        ]);
    }

    /**
     * Update an article from Database
     *
     * @param Article $article
     * @return void
     */
    public function update(Article $article): void
    {
        $query = $this->pdo->prepare('UPDATE articles SET title = :title, excerpt = :excerpt, content = :content, fk_user_id = :fk_user_id WHERE pk_id = :pk_id');
        $query->execute([
            'title'      => $article->getTitle(),
            'excerpt'    => $article->getExcerpt(),
            'content'    => $article->getContent(),
            'pk_id'      => $article->getId(),
            'fk_user_id' => $article->getAuthorId()
        ]);
    }
}