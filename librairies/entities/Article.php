<?php

namespace Entities;

use DateTime;

class Article
{
    private $pk_id;
    private $title;
    private $excerpt;
    private $content;
    private $created_at;
    private $fk_user_id;
    private $updated_at;

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
    public function getId(): ?int
    {
        return $this->pk_id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
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
    public function setExcerpt(string $excerpt): self
    {
        $this->excerpt = $excerpt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExcerpt(): ?string
    {
        return $this->excerpt;
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
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $createdAt->format('Y-m-d H:i:s');
        $this->created_at = $createdAt;
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
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): self
    {
        $this->fk_user_id = $authorId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId(): ?int
    {
        return $this->fk_user_id;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $updatedAt->format('Y-m-d H:i:s');
        $this->updated_at = $updatedAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?Datetime
    {
        if (is_string($this->updated_at)) {
            return new DateTime($this->updated_at);
        }
        return $this->updated_at;
    }
}