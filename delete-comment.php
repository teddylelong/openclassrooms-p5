<?php

require_once 'librairies/autoload.php';

// On appelle l'action à effectuer (supprimer le commentaire) via notre controller Comment
$controller = new \Controllers\Comment();
$controller->delete();