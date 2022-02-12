<?php

require_once 'librairies/database.php';

class Model
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = getPdo();
    }
}