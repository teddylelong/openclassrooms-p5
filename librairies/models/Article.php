<?php

namespace Models;

require_once 'vendor/autoload.php';

class Article extends Model
{
    protected $table = 'articles';

    /**
     * Insert a new article in database
     *
     * @param string $title
     * @param string $excerpt
     * @param string $content
     * @param int $is_published
     * @param int $fk_user_id
     * @return void
     */
    public function insert(\Classes\Article $article): void
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
     * @param string $title
     * @param string $excerpt
     * @param string $content
     * @param int $is_published
     * @param int $pk_id
     * @return void
     */
    public function update(\Classes\Article $article): void
    {
        $query = $this->pdo->prepare('UPDATE articles SET title = :title, excerpt = :excerpt, content = :content WHERE pk_id = :pk_id');
        $query->execute([
            'title'   => $article->getTitle(),
            'excerpt' => $article->getExcerpt(),
            'content' => $article->getContent(),
            'pk_id'   => $article->getId()
        ]);
    }
}