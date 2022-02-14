<?php

require_once 'librairies/autoload.php';

// On appelle l'action à effectuer (insérer le commentaire) via notre controller Comment
$controller = new \Controllers\Comment();
$controller->insert();