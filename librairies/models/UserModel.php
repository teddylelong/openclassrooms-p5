<?php

namespace Models;

use PDO;
use Entities\User;

class UserModel extends Model
{
    protected $table = 'users';

    /**
     * Return a user from database for given ID
     *
     * @param int $user_id
     * @return mixed
     */
    public function find(int $user_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE pk_id = :id");
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class);
        $query->execute(['id' => $user_id]);
        return $query->fetch();
    }

    /**
     * Return all users from database
     *
     * @param string|null $order
     * @return array
     */
    public function findAll(?string $order = ''): array
    {
        $sql = "SELECT * FROM $this->table";

        if ($order) {
            $sql .= ' ORDER BY ' . $order;
        }
        $query = $this->pdo->query($sql);
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class);

        return $query->fetchAll();
    }

    /**
     * Insert a new user in database
     *
     * @param User $user
     * @return void
     */
    public function insert(User $user): void
    {
        $query = $this->pdo->prepare("INSERT INTO users SET firstname = :firstname, lastname = :lastname, email = :email, password = :password, fk_role_id = :fk_role_id");
        $query->execute([
            'firstname'   => $user->getFirstname(),
            'lastname'    => $user->getLastname(),
            'email'       => $user->getEmail(),
            'password'    => $user->getPassword(),
            'fk_role_id'  => $user->getFkRoleId(),
        ]);
    }

    /**
     * Find a User by email address.
     * Return User object on success, false on failure
     *
     * @param string $email
     * @return User|false
     */
    public function findByEmail(string $email)
    {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class);
        $query->execute(['email' => $email]);
        return $query->fetch();
    }
}