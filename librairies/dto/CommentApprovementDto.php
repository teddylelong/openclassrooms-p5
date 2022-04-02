<?php

namespace Dto;

use Entities\Article;
use Entities\Comment;
use DateTime;

/**
 * DTO for comments approvement list in admin interface
 */
class CommentApprovementDto
{
    private $comment_id;
    private $pseudo;
    private $email;
    private $content;
    private $created_at;
    private $article_title;
    private $article_id;
    private $approvement;

    public function __construct(Comment $comment, Article $article)
    {
        $this->setId($comment->getId());
        $this->setPseudo($comment->getAuthor());
        $this->setEmail($comment->getEmail());
        $this->setContent($comment->getContent());
        $this->setCreatedAt($comment->getCreatedAt());
        $this->setArticleTitle($article->getTitle());
        $this->setArticleId($comment->getArticleId());
        $this->setApprovement($comment->getIsApproved());
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->comment_id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->comment_id;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo(string $pseudo): void
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
     * @param string $article_title
     */
    public function setArticleTitle(string $article_title): void
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

    /**
     * @param string $approvement
     */
    public function setApprovement(string $approvement): void
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

