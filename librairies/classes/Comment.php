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
    public function setId(int $id): self
    {
        $this->pk_id = $id;
        return $this;
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
    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
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
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
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
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
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
    public function setCreatedAt(?DateTime $created_at): self
    {
        $created_at->format('Y-m-d H:i:s');
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        if (is_string($this->created_at)) {
            return new DateTime($this->created_at);
        }
        return $this->created_at;
    }

    /**
     * @param string $is_approved
     */
    public function setIsApproved(string $is_approved): self
    {
        $this->is_approved = $is_approved;
        return $this;
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
    public function setArticleId(int $article_id): self
    {
        $this->article_id = $article_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->article_id;
    }
}