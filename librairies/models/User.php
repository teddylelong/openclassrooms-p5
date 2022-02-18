<?php

namespace Models;

require_once 'librairies/autoload.php';

class User extends Model
{
    protected $table = 'users';

    /**
     * Insert a new user in database
     *
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @param int $is_admin
     * @return void
     */
    public function insert(string $firstname, string $lastname, string $email, string $password, int $is_admin = 0): void
    {
        $query = $this->pdo->prepare("INSERT INTO $this->table SET firstname = :firstname, lastname = :lastname, email = :email, password = :password, is_admin = :is_admin");
        $query->execute(compact('firstname', 'lastname', 'email', 'password', 'is_admin'));
    }
}