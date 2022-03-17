<?php

namespace Models;

use PDO;
use Classes\User;

class LoginModel extends Model
{
    protected $table = 'users';
    /**
     * Find a user in database & check if email and provided password matches
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function checkLogin(string $email, string $password): bool
    {
        $query = $this->pdo->prepare("SELECT pk_id, password FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class);
        $user = $query->fetch();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->getPassword())) {
            $_SESSION['user_id'] = $user->getId();
            return true;
        }

        return false;
    }
}