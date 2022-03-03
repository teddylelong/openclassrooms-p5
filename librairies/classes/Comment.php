<?php

namespace Classes;

require_once 'vendor/autoload.php';

use DateTime;

class Comment
{
    private $pk_id;
    private $author;
    private $email;
    private $content;
    private $created_at;
    private $is_approved;
    private $article_id;

    const PENDING     = 'pending';
    const APPROVED    = 'approved';
    const DISAPPROVED = 'disapproved';

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->pk_id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->pk_id;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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
     * @param mixed $created_at
     */
    public function setCreatedAt(?DateTime $created_at): void
    {
        $created_at->format('Y-m-d H:i:s');
        $this->created_at = $created_at;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): string
    {
        if (is_string($this->created_at)) {
            $dateTime = new DateTime($this->created_at);
            return $dateTime->format('d\/m\/Y \à H\hi');
        }
        return $this->created_at;
    }

    /**
     * @param string $is_approved
     */
    public function setIsApproved(string $is_approved): void
    {
        $this->is_approved = $is_approved;
    }

    /**
     * @return string
     */
    public function getIsApproved(): string
    {
        return $this->is_approved;
    }

    /**
     * @param int $article_id
     */
    public function setArticleId(int $article_id): void
    {
        $this->article_id = $article_id;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->article_id;
    }
}