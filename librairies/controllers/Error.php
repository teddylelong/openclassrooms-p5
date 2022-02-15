<?php

namespace Controllers;

require_once 'librairies/autoload.php';

class Error
{
    public static function show404(): void
    {
        $pageTitle = "Erreur 404 - Page non-trouvée";
        \Renderer::render('errors/404', compact('pageTitle'));
    }
}