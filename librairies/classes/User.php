<?php

namespace Classes;

require_once 'vendor/autoload.php';

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
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
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
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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
    public function setIsAdmin(int $is_admin): void
    {
        $this->is_admin = $is_admin;
    }

    /**
     * @return int
     */
    public function getIsAdmin(): int
    {
        return $this->is_admin;
    }

    public function setCreatedAt(?DateTime $created_at): void
    {
        $created_at->format('Y-m-d H:i:s');
        $this->created_at = $created_at;
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


}