<?php

namespace Classes;

use DateTime;

/**
 * DTO for comments approvement list in admin interface
 */
class CommentApprovement
{
    private $id;
    private $pseudo;
    private $email;
    private $content;
    private $created_at;
    private $article_title;
    private $approvement;

    public function __construct(Comment $comment, Article $article)
    {
        $this->setId($comment->getId());
        $this->setPseudo($comment->getAuthor());
        $this->setEmail($comment->getEmail());
        $this->setContent($comment->getContent());
        $this->setCreatedAt($comment->getCreatedAt());
        $this->setArticleTitle($article->getTitle());
        $this->setApprovement($comment->getIsApproved());
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
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
    public function setContent($content): void
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
    public function setCreatedAt($created_at): void
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
     * @param string $article_title
     */
    public function setArticleTitle($article_title): void
    {
        $this->article_title = $article_title;
    }

    /**
     * @return string
     */
    public function getArticleTitle(): string
    {
        return $this->article_title;
    }

    /**
     * @param string $approvement
     */
    public function setApprovement($approvement): void
    {
        $this->approvement = $approvement;
    }

    /**
     * @return string
     */
    public function getApprovement(): string
    {
        return $this->approvement;
    }
}

