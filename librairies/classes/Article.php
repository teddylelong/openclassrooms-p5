<?php

namespace Classes;

require_once 'vendor/autoload.php';

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
    public function setAuthorId(int $authorId): void
    {
        $this->fk_user_id = $authorId;
    }

    /**
     * @return int
     */
    public function getAuthorId(): ?int
    {
        return $this->fk_user_id;
    }

    /**
     * @return string
     */
    public function getAuthorName(): string
    {
        // TODO : (mentor) Bonne façon de faire pour récupérer le nom de l'autheur et l'afficher ?
        if (!is_null($this->getAuthorId())) {
            $userModel = new \Models\User();
            $user = $userModel->find($this->getAuthorId());
            if ($user) {
                return $user->getFirstname();
            }
            return 'Anonyme';
        }
        return 'Anonyme';
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
    public function getUpdatedAt(): ?string
    {
        // TODO : Bonne façon de print la date de modif ?
        if (!$this->updated_at) {
            return null;
        }
        if (is_string($this->updated_at)) {
            $dateTime = new DateTime($this->updated_at);
            return '- Dernière modification le ' . $dateTime->format('d\/m\/Y \à H\hi');
        }
        return $this->updated_at;
    }
}