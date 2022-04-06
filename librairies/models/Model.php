<?php

namespace Models;

use Database;
use PDO;

abstract class Model
{
    protected PDO $pdo;
    protected $table;

    public function __construct()
    {
        $this->pdo = (new Database())->getPdo();
    }

    /**
     * Return an item from database for given ID
     *
     * @param int $pk_id
     * @return mixed
     */
    public function find(int $pk_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->table WHERE pk_id = :id");
        $query->execute(['id' => $pk_id]);
        return $query->fetch();
    }

    /**
     * Delete an item from database
     *
     * @param $pk_id
     * @return void
     */
    public function delete($pk_id): void
    {
        $query = $this->pdo->prepare("DELETE FROM $this->table WHERE pk_id = :id");
        $query->execute(['id' => $pk_id]);
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

        return $query->fetchAll();
    }
}