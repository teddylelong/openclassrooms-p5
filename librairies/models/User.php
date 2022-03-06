<?php

namespace Models;

require_once 'vendor/autoload.php';

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
}