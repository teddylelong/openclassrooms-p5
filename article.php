<?php

require_once 'librairies/autoload.php';

// On appelle l'action à effectuer (afficher l'article) via notre controller Article
$controller = new \Controllers\Article();
$controller->show();
