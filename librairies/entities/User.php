<?php

namespace Entities;

use DateTime;

class User
{
    private $pk_id;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $is_admin;
    private $created_at;
    private $fk_role_id;

    /**
     * @param int $user_id
     */
    public function setId(int $user_id): self
    {
        $this->pk_id = $user_id;
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
     * @param string $firstname
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
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
     * @param string $password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param int $is_admin
     */
    public function setIsAdmin(int $is_admin): self
    {
        $this->is_admin = $is_admin;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsAdmin(): int
    {
        return $this->is_admin;
    }

    public function setCreatedAt(?DateTime $created_at): self
    {
        $created_at->format('Y-m-d H:i:s');
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string|null DateTime
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
     * @param int $fk_role_id
     */
    public function setFkRoleId(int $fk_role_id): self
    {
        $this->fk_role_id = $fk_role_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getFkRoleId(): int
    {
        return $this->fk_role_id;
    }
}