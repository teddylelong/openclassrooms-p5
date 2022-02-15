<?php

namespace Models;

require_once 'librairies/autoload.php';

class Article extends Model
{
    protected $table = 'articles';

    /**
     * Insert a new article in database
     *
     * @param string $title
     * @param string $excerpt
     * @param string $content
     * @param bool $isPublished
     * @param int $authorId
     * @return void
     */
    public function insert(string $title, string $excerpt, string $content, int $is_published = 0, int $fk_user_id): void
    {
        $query = $this->pdo->prepare('INSERT INTO articles SET title = :title, excerpt = :excerpt, content = :content, is_published = :is_published, fk_user_id = :fk_user_id');
        $query->execute(compact('title', 'excerpt', 'content', 'is_published', 'fk_user_id'));
    }
}