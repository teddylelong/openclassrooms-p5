<?php

namespace Models;

require_once "librairies/autoload.php";

class Login extends Model
{
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

        $user = $query->fetch();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['pk_id'];
            return true;
        }

        return false;
    }
}