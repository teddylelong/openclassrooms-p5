<?php

namespace Models;

require_once 'vendor/autoload.php';

use PDO;

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
    public function insert(\Classes\User $user): void
    {
        $query = $this->pdo->prepare("INSERT INTO $this->table SET firstname = :firstname, lastname = :lastname, email = :email, password = :password, is_admin = :is_admin");
        $query->execute([
            'firstname' => $user->getFirstname(),
            'lastname'  => $user->getLastname(),
            'email'     => $user->getEmail(),
            'password'  => $user->getPassword(),
            'is_admin'  => $user->getIsAdmin(),
        ]);
    }

    /**
     * Find a User by email address.
     * Return User object on success, false on failure
     *
     * @param string $email
     * @return \Classes\User|False
     */
    public function findByEmail(string $email)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = :email");
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->getClassName());
        $query->execute(['email' => $email]);
        return $query->fetch();
    }
}