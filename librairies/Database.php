<?php

class Database
{

    private const HOST      = 'localhost';
    private const DBNAME    = 'oc_p5_blog';
    private const CHARSET   = 'utf8mb4';
    private const USERNAME  = 'root';
    private const PASSWORD  = '';
    private static $instance = null;
    private static bool $debug = true;

    /**
     * Return database connexion
     *
     * @return PDO
     */
    public static function getPdo(): PDO
    {
        $args = [];
        if (self::$debug) {
            $args = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
        }

        if (self::$instance === null) {
            $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME . ';charset=' . self::CHARSET;

            self::$instance = new PDO($dsn, self::USERNAME, self::PASSWORD, $args);
        }

        return self::$instance;
    }
}






