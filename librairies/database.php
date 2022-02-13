<?php

define('HOST', 'localhost');
define('DBNAME', 'blogpoo');
define('CHARSET', 'utf8');
define('USERNAME', 'root');
define('PASSWORD', '');

/**
 * Return database connexion
 *
 * @return PDO
 */

function getPdo(): PDO
{
    $dsn = 'mysql:host='.HOST.';dbname='.DBNAME.';charset='.CHARSET;

    $pdo = new PDO($dsn, USERNAME, PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    return $pdo;
}





