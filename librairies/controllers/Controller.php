<?php

namespace Controllers;

use AccessControl;

// Todo : Instancier AccessControl dans le constructeur
// Todo : Créer un controller pour les pages statiques (à propos, mentions légales, etc.)

abstract class Controller
{
    protected $accessControl;

    public function __construct()
    {
        $this->accessControl = new AccessControl();
    }
}