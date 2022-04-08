<?php

namespace Dto;

use Entities\Article;
use Entities\User;
use DateTime;

/**
 * DTO for Article, Comment and User (author)
 */
class PostDto
{
    private $article_id;
    private $title;
    private $excerpt;
    private $content;
    private $created_at;
    private $updated_at;
    private $author_id;
    private $author_firstname;
    private $comments;

    public const UNKNOW_USER = 'Anonyme';

    public function __construct(Article $article, User $author, array $comments = [])
    {
        $this->setPkId($article->getId());
        $this->setTitle($article->getTitle());
        $this->setExcerpt($article->getExcerpt());
        $this->setContent($article->getContent());
        $this->setCreatedAt($article->getCreatedAt());
        $this->setUpdatedAt($article->getUpdatedAt());
        $this->setAuthorId($article->getAuthorId());
        $this->setAuthorFirstname($author->getFirstname());
        $this->setComments($comments);
    }

    /**
     * @param int $pk_id
     */
    public function setPkId(int $pk_id): void
    {
        $this->article_id = $pk_id;
    }

    /**
     * @return int
     */
    public function getPkId(): int
    {
        return $this->article_id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $excerpt
     */
    public function setExcerpt(string $excerpt): void
    {
        $this->excerpt = $excerpt;
    }

    /**
     * @return string
     */
    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param DateTime $created_at
     */
    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $updated_at
     */
    public function setUpdatedAt(?DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param int $author_id
     */
    public function setAuthorId(int $author_id): void
    {
        $this->author_id = $author_id;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * @param string|null $firstname
     */
    public function setAuthorFirstname(?string $firstname)
    {
        if ($firstname === null) {
            $this->author_firstname = self::UNKNOW_USER;
        }
        if ($firstname !== null) {
            $this->author_firstname = $firstname;
        }
    }

    /**
     * @return string
     */
    public function getAuthorFirstname(): string
    {
        return $this->author_firstname;
    }

    /**
     * @param array $comments
     */
    public function setComments(?array $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }
}