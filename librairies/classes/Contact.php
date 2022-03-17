<?php

namespace Classes;

class Contact
{
    private $pk_id;
    private $firstname;
    private $lastname;
    private $email;
    private $message;
    private $created_at;

    /**
     * @param int $pk_id
     */
    public function setPkId(int $pk_id): self
    {
        $this->pk_id = $pk_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPkId(): int
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
     * @return string
     */
    public function getFirstname(): string
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
     * @param string $message
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): self
    {
        $created_at->format('Y-m-d H:i:s');
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        if (is_string($this->created_at)) {
            $dateTime = new DateTime($this->created_at);
            return $dateTime->format('d\/m\/Y \à H\hi');
        }
        return $this->created_at;
    }

}