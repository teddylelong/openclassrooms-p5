<?php

class Database
{

    const HOST      = 'localhost';
    const DBNAME    = 'blogpoo';
    const CHARSET   = 'utf8';
    const USERNAME  = 'root';
    const PASSWORD  = '';

    private static $instance = null;
    /**
     * Return database connexion
     *
     * @return PDO
     */

    public static function getPdo(): PDO
    {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME . ';charset=' . self::CHARSET;

            self::$instance = new PDO($dsn, self::USERNAME, self::PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        return self::$instance;
    }
}






