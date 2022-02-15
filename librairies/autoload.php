<?php

spl_autoload_register(function ($className) {

    $className = str_replace('\\', '/', $className);

    if (file_exists("librairies/$className.php")) {
        require_once "librairies/$className.php";
    }
});