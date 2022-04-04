<?php

namespace Models;

use PDO;
use Entities\User;
use Session;

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
        $query = $this->pdo->prepare("SELECT pk_id, firstname, password FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class);
        $user = $query->fetch();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->getPassword())) {
            $session = new Session();
            $session->create('user_id', $user->getId());
            $session->create('username', $user->getFirstname());
            return true;
        }

        return false;
    }
}