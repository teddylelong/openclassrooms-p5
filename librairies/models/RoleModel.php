<?php

namespace Models;

use Entities\Role;
use PDO;

class RoleModel extends Model
{
    protected $table = 'role';

    /**
     * find a role in database
     *
     * @param int $role_id
     * @return void
     */
    public function find(int $role_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE pk_id = :id");
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Role::class);
        $query->execute(['id' => $role_id]);
        return $query->fetch();
    }

    /**
     * find all roles in database
     *
     * @param string|null $order
     * @return void
     */
    public function findAll(?string $order = ''): array
    {
        $sql = "SELECT * FROM $this->table";

        if ($order) {
            $sql .= ' ORDER BY ' . $order;
        }
        $query = $this->pdo->query($sql);
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Role::class);
        return $query->fetchAll();
    }
}