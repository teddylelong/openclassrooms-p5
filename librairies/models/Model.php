<?php

namespace Models;

use Database;
use PDO;
use ReflectionClass;

abstract class Model
{
    protected PDO $pdo;
    protected $table;

    public function __construct()
    {
        $this->pdo = Database::getPdo();
    }

    /**
     * Return an item from database for given ID
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE pk_id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch();
    }

    /**
     * Delete an item from database
     *
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $query = $this->pdo->prepare("DELETE FROM $this->table WHERE pk_id = :id");
        $query->execute(['id' => $id]);
    }

    /**
     * Return all items from database table
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
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->getClassName());

        return $query->fetchAll();
    }
}