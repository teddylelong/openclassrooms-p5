<?php

namespace Models;

abstract class Model
{
    protected $pdo;
    protected $table;

    public function __construct()
    {
        $this->pdo = \Database::getPdo();
    }

    /**
     * Return an item from database for given ID
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
        $item = $query->fetch();
        return $item;
    }

    /**
     * Delete an item from database
     *
     * @param $id
     * @return void
     */
    public function delete($id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
    }

    /**
     * Return all items from database table
     *
     * @return array
     */
    public function findAll(?string $order = ''): array
    {
        $sql = "SELECT * FROM {$this->table}";

        if ($order) {
            $sql .= ' ORDER BY ' . $order;
        }
        $query = $this->pdo->query($sql);

        $items = $query->fetchAll();
        return $items;
    }
}