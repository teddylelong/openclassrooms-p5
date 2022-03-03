<?php

namespace Models;

require_once "vendor/autoload.php";

use PDO;

class Login extends Model
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
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->getClassName());
        $user = $query->fetch();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['pk_id'];
            return true;
        }

        return false;
    }
}