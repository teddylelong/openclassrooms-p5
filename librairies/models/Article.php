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
    public function insert(string $title, string $excerpt, string $content, int $fk_user_id): void
    {
        $query = $this->pdo->prepare('INSERT INTO articles SET title = :title, excerpt = :excerpt, content = :content, fk_user_id = :fk_user_id');
        $query->execute(compact('title', 'excerpt', 'content', 'fk_user_id'));
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
    public function update(string $title, string $excerpt, string $content, int $pk_id): void
    {
        $query = $this->pdo->prepare('UPDATE articles SET title = :title, excerpt = :excerpt, content = :content WHERE pk_id = :pk_id');
        $query->execute(compact('title', 'excerpt', 'content', 'pk_id'));
    }
}