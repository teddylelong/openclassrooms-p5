<?php

// TODO : Créer les Classes\User, Classes\Comment

namespace Classes;

require_once 'librairies/autoload.php';

use DateTime;

class Article
{
    private $pk_id;
    private $title;
    private $excerpt;
    private $content;
    private $created_at;
    private $author;
    private $updated_at;

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->pk_id = $id;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->pk_id;
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
    public function getTitle(): ?string
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
    public function getExcerpt(): ?string
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
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $createdAt->format('Y-m-d H:i:s');
        $this->created_at = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): ?string
    {
        if (is_string($this->created_at)) {
            $dateTime = new DateTime($this->created_at);
            return $dateTime->format('d\/m\/Y \à H\hi');
        }
        return $this->created_at;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId($authorId): void
    {
        $this->author = $authorId;
    }

    /**
     * @return int
     */
    public function getAuthorId(): ?int
    {
        return $this->author;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $updatedAt->format('Y-m-d H:i:s');
        $this->updated_at = $updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): ?DateTime
    {
        if (is_string($this->updated_at)) {
            $dateTime = new DateTime($this->updated_at);
            $dateTime->format('d-m-Y \à H\hi');
            return $dateTime;
        }
        return $this->updated_at;
    }
}