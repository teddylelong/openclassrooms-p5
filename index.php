<?php

require_once 'librairies/autoload.php';

// On appelle l'action à effectuer (Afficher tous les articles) via notre controller Article
$controller = new \Controllers\Article();
$controller->index();
